(function ($) {
    $.fn.postPreview = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.postPreview');
            return false;
        }
    };

    var methods = {
        init: function () {
            return this.each(function () {
                var $this = $(this);

                $this.on('click', '.js-post-preview-tab', function (event) {
                    event.preventDefault();

                    methods.preview.apply($this);
                });

                $this.on('click', '.js-post-write-tab', function (event) {
                    event.preventDefault();

                    methods.write.apply($this);
                });
            });
        },

        write: function() {
            var $this = this;
            $this.find('.js-post-preview-tab').removeClass('selected');
            $this.find('.js-post-write-tab').addClass('selected');
            $this.find('textarea').show();
            $this.find('.post-formbox-preview').hide();
        },

        preview: function() {
            var $this = this,
                message = $this.find('textarea').val();

            $this.find('.js-post-write-tab').removeClass('selected');
            $this.find('.js-post-preview-tab').addClass('selected');
            $this.find('textarea').hide();
            $this.find('.post-formbox-preview').show().html('Загрузка предпросмотра...');

            $.ajax({
                url: '/post/preview',
                type: 'POST',
                dataType: 'json',
                data: {message: message},
                cache: false,
                success: function (data) {
                    $this.find('.post-formbox-preview').show().html(data);
                }
            });
        }
    };
})(window.jQuery);