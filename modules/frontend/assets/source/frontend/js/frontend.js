yii.topic = (function ($) {
    var pub = {
        isActive: true,
        init: function () {
            $('.js-subnavbar-search__input').keypress(function (e) {
                if (e.which == 13) {
                    e.preventDefault();
                    alert($(this).closest('.subnavbar-search').attr('class'));
                    //$('form#login').submit();
                }
            });
        }
    };
    return pub;
})(jQuery);