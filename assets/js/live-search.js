(function () {
    'use strict';

    const panel = document.querySelector('[data-search-panel]');

    if (!panel || !window.tlLiveSearchData) {
        return;
    }

    const input = panel.querySelector('[data-live-search-input]');
    const results = panel.querySelector('[data-live-search-results]');
    let requestController = null;
    let debounceTimer = null;

    if (!input || !results) {
        return;
    }

    /* Статусы сообщаются текстом, чтобы поиск оставался понятным без визуальных подсказок. */
    const showStatus = function (message) {
        results.replaceChildren();
        const status = document.createElement('p');
        status.className = 'nbs-live-search-status';
        status.textContent = message;
        results.append(status);
    };

    /* Результаты создаются DOM-методами, поэтому заголовки записей не могут внедрить HTML. */
    const renderItems = function (items) {
        results.replaceChildren();

        if (!items.length) {
            showStatus(window.tlLiveSearchData.emptyLabel);
            return;
        }

        const list = document.createElement('ul');
        list.className = 'nbs-live-search-list';

        items.forEach(function (item) {
            const listItem = document.createElement('li');
            const link = document.createElement('a');
            const type = document.createElement('span');

            link.href = item.url;
            link.textContent = item.title;
            type.textContent = item.subtype === 'page'
                ? window.tlLiveSearchData.pageLabel
                : window.tlLiveSearchData.postLabel;
            listItem.append(link, type);
            list.append(listItem);
        });

        results.append(list);
    };

    /* Предыдущий HTTP-запрос отменяется, чтобы запоздавший ответ не заменил более свежую выдачу. */
    const search = async function (query) {
        if (requestController) {
            requestController.abort();
        }

        requestController = new AbortController();
        showStatus(window.tlLiveSearchData.loadingLabel);

        try {
            const url = new URL(window.tlLiveSearchData.endpoint);
            url.searchParams.set('search', query);
            url.searchParams.set('per_page', '6');
            url.searchParams.set('subtype', 'post,page');

            const response = await fetch(url, {
                headers: { Accept: 'application/json' },
                signal: requestController.signal,
            });

            if (!response.ok) {
                throw new Error('Live search request failed');
            }

            renderItems(await response.json());
        } catch (error) {
            if (error.name !== 'AbortError') {
                showStatus(window.tlLiveSearchData.errorLabel);
            }
        }
    };

    /* Небольшая задержка сокращает количество запросов при быстром наборе текста. */
    input.addEventListener('input', function () {
        const query = input.value.trim();
        window.clearTimeout(debounceTimer);
        if (requestController) requestController.abort();

        if (query.length < 2) {
            results.replaceChildren();
            return;
        }

        debounceTimer = window.setTimeout(function () {
            search(query);
        }, 240);
    });
}());
