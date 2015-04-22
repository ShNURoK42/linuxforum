(function ($) {
    $.fn.post = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.post');
            return false;
        }
    };

    var methods = {
        init: function () {
            return this.each(function () {
                var $post = $(this);

                $post.on('click', '.js-post-update-pencil', function (e) {
                    e.preventDefault();
                    var $this = $(this);

                    $this.closest('.post-content').find('.post-update').show();
                    $this.closest('.post-content').find('.post-message').hide();
                    $this.hide();
                });

                $post.on('click', '.js-post-update-button', function (e) {
                    e.preventDefault();

                    var $this = $(this).closest('.post');

                    methods.update.apply($this);
                });

                $post.on('click', '.js-post-cancel-button', function (e) {
                    e.preventDefault();
                    var $this = $(this);

                    $this.closest('.post-content').find('.post-update').hide();
                    $this.closest('.post-content').find('.js-post-update-pencil').show();
                    $this.closest('.post-content').find('.post-message').show();
                });
            });
        },

        update: function() {
            var $this = this;
                var text = $(this).find('.post-update-message').val();
                var id = $(this).attr("id");

            console.log(id);

            $.ajax({
                url: '/post/update',
                type: 'POST',
                dataType: 'json',
                data: {text: text, id: id},
                cache: false,
                success: function (data) {
                    console.log(data);

                    $this.find('.post-update').hide();
                    $this.find('.js-post-update-pencil').show();
                    $this.find('.post-message').show().html(data);
                }
            });
        }
    };
})(window.jQuery);
