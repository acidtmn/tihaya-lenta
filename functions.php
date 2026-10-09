<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* Каждый подключаемый модуль отвечает только за одну область поведения темы. */
$tl_theme_modules = array(
    'setup',
    'enqueue',
    'customizer',
    'options',
    'query-functions',
    'template-tags',
    'accessibility',
);

foreach ( $tl_theme_modules as $tl_theme_module ) {
    require_once get_template_directory() . '/inc/' . $tl_theme_module . '.php';
}
