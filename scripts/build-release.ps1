param(
    [string]$OutputDirectory = (Join-Path $PSScriptRoot '..\dist')
)

# Собираем установочную тему отдельно от документации и инструментов разработки.
$ErrorActionPreference = 'Stop'
$themeDirectory = [IO.Path]::GetFullPath((Join-Path $PSScriptRoot '..'))
$releaseDirectory = [IO.Path]::GetFullPath($OutputDirectory)
$style = [IO.File]::ReadAllText((Join-Path $themeDirectory 'style.css'))
$version = [regex]::Match($style, '(?m)^Version:\s*(\S+)').Groups[1].Value
if ($version -notmatch '^\d+\.\d+\.\d+$') { throw 'Не найдена версия темы.' }
$required = @('style.css', 'functions.php', 'index.php', 'screenshot.png', 'readme.txt', 'LICENSE', 'languages/tihaya-lenta.pot')
foreach ($name in $required) {
    if (-not (Test-Path -LiteralPath (Join-Path $themeDirectory $name) -PathType Leaf)) { throw "Нет обязательного файла: $name" }
}

# Используем только каталоги ресурсов и корневые файлы установленной темы.
$rootFiles = Get-ChildItem -LiteralPath $themeDirectory -File | Where-Object {
    $_.Extension -in @('.php', '.css', '.json', '.txt', '.png') -or $_.Name -eq 'LICENSE'
}
$resourceFiles = foreach ($directory in @('assets', 'inc', 'languages', 'template-parts')) {
    Get-ChildItem -LiteralPath (Join-Path $themeDirectory $directory) -File -Recurse
}
$files = @(@($rootFiles) + @($resourceFiles) | Sort-Object FullName)
foreach ($file in $files) {
    if ($file.Name -ne 'LICENSE' -and $file.Extension -notin @('.php', '.css', '.js', '.json', '.txt', '.png', '.pot', '.po', '.mo')) {
        throw "Лишний файл в ресурсах темы: $($file.Name)"
    }
}
[IO.Directory]::CreateDirectory($releaseDirectory) | Out-Null
$archiveName = "tihaya-lenta-$version.zip"
$archivePath = Join-Path $releaseDirectory $archiveName
Add-Type -AssemblyName System.IO.Compression
$archiveStream = [IO.File]::Open($archivePath, [IO.FileMode]::Create)
$zip = [IO.Compression.ZipArchive]::new($archiveStream, [IO.Compression.ZipArchiveMode]::Create)
try {
    foreach ($file in $files) {
        $relative = [IO.Path]::GetRelativePath($themeDirectory, $file.FullName).Replace([IO.Path]::DirectorySeparatorChar, '/')
        $entry = $zip.CreateEntry('tihaya-lenta/' + $relative, [IO.Compression.CompressionLevel]::Optimal)
        $entry.LastWriteTime = [DateTimeOffset]$file.LastWriteTime
        $inputStream = $file.OpenRead()
        $outputStream = $entry.Open()
        try { $inputStream.CopyTo($outputStream) } finally { $inputStream.Dispose(); $outputStream.Dispose() }
    }
} finally { $zip.Dispose(); $archiveStream.Dispose() }

# Контрольная сумма и манифест сопровождают ZIP при публикации релиза.
$hash = (Get-FileHash -LiteralPath $archivePath -Algorithm SHA256).Hash.ToLowerInvariant()
[IO.File]::WriteAllText((Join-Path $releaseDirectory ($archiveName + '.sha256')), "$hash  $archiveName`n", [Text.UTF8Encoding]::new($false))
$manifest = [ordered]@{
    name = 'Тихая лента'; version = $version; author = 'Кирилл Александров'; authorUrl = 'https://kodalexandrova.ru';
    license = 'GPL-2.0-or-later'; priceRub = 0; wordpressMinimum = '6.6'; phpMinimum = '8.2';
    archive = $archiveName; bytes = (Get-Item -LiteralPath $archivePath).Length; sha256 = $hash; files = $files.Count;
    screenshots = @('home-desktop.png', 'home-mobile.png', 'article-desktop.png', 'article-mobile.png', 'settings-desktop.png')
}
[IO.File]::WriteAllText((Join-Path $releaseDirectory 'release-manifest.json'), ($manifest | ConvertTo-Json -Depth 4), [Text.UTF8Encoding]::new($false))
$manifest | ConvertTo-Json -Compress
