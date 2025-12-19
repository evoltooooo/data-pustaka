$(function () {
    const suggestUrl = window.searchConfig?.suggestUrl;
    const historyUrl = window.searchConfig?.historyUrl;
    const historyClearUrl = window.searchConfig?.historyClearUrl;
    const historyDeleteBaseUrl = window.searchConfig?.historyDeleteBaseUrl;
    const csrfToken = window.searchConfig?.csrfToken;

    if (!suggestUrl || !historyUrl) {
        console.error('searchConfig URL not found');
        return;
    }

    // 1. Saat ngetik → ambil saran dari server
    $('#searchInput').on('keyup', function () {
        let q = $(this).val();

        if (q.length < 2) {
            $('#searchSuggest').empty();
            return;
        }

        $.get(suggestUrl, { q: q }, function (data) {
            let html = '';

            if (!data || data.length === 0) {
                html = `<div class="list-group-item"><small>Tidak ada hasil</small></div>`;
            } else {
                data.forEach(function (item) {
                    html += `
                        <button type="button"
                                class="list-group-item list-group-item-action suggest-item"
                                data-name="${item.judul}"
                                data-id="${item.idBuku}">
                            ${item.judul}
                        </button>
                    `;
                });

            }

            $('#searchSuggest').html(html).show();
            $('#searchHistory').hide();
        });
    });

    $('#searchSuggest').on('click', '.suggest-item', function () {
        const id = $(this).data('id');

        if (!id) {
            let text = $(this).data('name');
            $('#searchInput').val(text);
            $('#searchSuggest').empty();
            $('#searchForm').submit();
            return;
        }

        const baseUrl = window.searchConfig?.detailBaseUrl || '/koleksi/detail/';
        window.location.href = baseUrl + id;
    });


    $('#searchInput').on('focus', function () {
        $.get(historyUrl, function (data) {
            if (!data || !data.length) {
                $('#searchHistory').hide();
                return;
            }

            let html = '';

            data.forEach(function (item) {
                html += `
                    <button type="button"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center history-item"
                            data-id="${item.id}">
                        <span class="history-text flex-grow-1 text-left">
                            ${item.keyword}
                        </span>
                        <span class="history-delete ml-3"
                              data-id="${item.id}">
                            &times;
                        </span>
                    </button>
                `;
            });

            html += `
                <button type="button"
                        class="list-group-item list-group-item-action text-center text-danger"
                        id="clearHistoryBtn">
                    Hapus riwayat pencarian
                </button>
            `;

            $('#searchHistory').html(html).show();
            $('#searchSuggest').hide();
        });
    });

    $('#searchHistory').on('click', '.history-item', function (e) {
        if ($(e.target).closest('.history-delete').length) {
            return;
        }

        const text = $(this).find('.history-text').text().trim();
        $('#searchInput').val(text);
        $('#searchHistory').hide();
    });

    $('#searchHistory').on('click', '.history-delete', function (e) {
        e.stopPropagation();

        if (!historyDeleteBaseUrl) return;

        const id = $(this).data('id');

        $.ajax({
            url: historyDeleteBaseUrl + '/' + id,
            method: 'POST',
            data: {
                _method: 'DELETE',
                _token: csrfToken
            },
            success: function () {
                $(`.history-item[data-id="${id}"]`).remove();

                if (!$('#searchHistory .history-item').length) {
                    $('#searchHistory').hide();
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    });

    $('#searchHistory').on('click', '#clearHistoryBtn', function (e) {
        e.stopPropagation();

        if (!historyClearUrl) return;

        if (!confirm('Hapus semua riwayat pencarian?')) {
            return;
        }

        $.ajax({
            url: historyClearUrl,
            method: 'POST',
            data: {
                _method: 'DELETE',
                _token: csrfToken
            },
            success: function () {
                $('#searchHistory').empty().hide();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#search-wrapper').length) {
            $('#searchSuggest').empty();
            $('#searchHistory').hide();
        }
    });
});
