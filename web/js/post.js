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
                var $form = $('#quickpostform'),
                    $post = $('.post');

                $form.on('click', '.js-preview-tab', function (e) {
                    e.preventDefault();
                    methods.preview.apply($form);
                });

                $form.on('click', '.js-write-tab', function (e) {
                    e.preventDefault();
                    methods.write.apply($form);
                });

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
        },

        write: function() {
            var $this = this;
            $this.find('.js-preview-tab').removeClass('selected');
            $this.find('.js-write-tab').addClass('selected');
            $this.find('.field-postform-message').show();
            $this.find('.post-preview').hide();
        },

        preview: function() {
            var $this = this,
                text = $('.create-post-message textarea').val();

            $.ajax({
                url: '/post/preview',
                type: 'POST',
                dataType: 'json',
                data: {text: text},
                cache: false,
                success: function (data) {
                    $this.find('.js-write-tab').removeClass('selected');
                    $this.find('.js-preview-tab').addClass('selected');
                    $this.find('.field-postform-message').hide();

                    $this.find('.post-preview').show().html(data);
                }
            });
        }
    };
})(window.jQuery);
