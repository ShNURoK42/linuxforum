yii.common = (function ($) {
    'use strict';

    var $dropdown = $('.js-dropdown');
    var $toggleLink = $('.js-dropdown-toggle');
    var $menu = $('.js-dropdown-menu');
    var $closeBtn = $('.js-dropdown-menu__close');

    var pub = {
        isActive: true,
        init: function () {

            $dropdown.find('#search-highlight').keyup(function (e) {
                console.log($dropdown.find('#search-highlight').val().toLowerCase());
            });


            // Open on click
            $toggleLink.off('click').on('click', function (e) {
                var $this = $(this);
                var $dropdown = $this.closest('.js-dropdown');

                $this.addClass('dropdown-toggle__link-active');


                $('#search-highlight').hideseek({
                    nodata: 'No results found'
                });


                if ($dropdown.find($menu).hasClass('dropdown-menu-visible')) {
                    $menu.removeClass('dropdown-menu-visible');
                } else {
                    $menu.removeClass('dropdown-menu-visible');
                    $dropdown.find($menu).addClass('dropdown-menu-visible');
                }

                $dropdown.find('#search-highlight').focus();

                return false;
            });

            $closeBtn.on('click', function (e) {
                $(this).closest($menu).removeClass('dropdown-menu-visible');

                return false;
            });

            // Close if outside click
            $(document).off('click').on('click', function (e) {
                var $target = $(e.target);
                console.log($target);
                if ($target.is($menu) || $target.closest($menu).length) {
                    return;
                }
                $menu.removeClass('dropdown-menu-visible');
            });
        }
    };
    return pub;
})(jQuery);