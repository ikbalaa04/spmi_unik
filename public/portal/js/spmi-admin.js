(function ($) {
    'use strict';

    $(function () {
        $('.container-fluid > .row').each(function () {
            var $row = $(this);
            var $actionColumn = $row.children('.col-2');
            var $mainColumn = $row.children('.col').first();

            if (!$actionColumn.length || !$mainColumn.length) {
                return;
            }

            var $actionTitle = $actionColumn.find('.card-title').first();

            if ($.trim($actionTitle.text()).toLowerCase() !== 'aksi') {
                return;
            }

            var $mainCard = $mainColumn.children('.card').first();
            var $header = $mainCard.children('.card-header').first();
            var $actions = $actionColumn.find('.card-body').children('button, a');

            if (!$mainCard.length || !$header.length || !$actions.length) {
                return;
            }

            var $actionWrap = $('<div class="admin-list-actions"></div>');

            $actions.each(function () {
                $(this)
                    .removeClass('float-right btn-sm')
                    .addClass('admin-list-primary-action')
                    .appendTo($actionWrap);
            });

            $header.addClass('admin-list-card-header').append($actionWrap);
            $mainCard.addClass('admin-list-card');
            $mainColumn.addClass('admin-list-main').removeClass('col').addClass('col-12');
            $row.addClass('admin-list-layout');
            $actionColumn.remove();
        });

        $('table#dataTable').each(function () {
            $(this)
                .addClass('admin-modern-table')
                .closest('.card')
                .addClass('admin-list-card');
        });
    });
})(jQuery);
