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
                var $this = $(this);

                $this.on('click', '.js-preview-tab', function (e) {
                    e.preventDefault();
                    methods.preview.apply($this);
                });

                $this.on('click', '.js-write-tab', function (e) {
                    e.preventDefault();
                    methods.write.apply($this);
                });
            });
        },

        data: function () {
            return this.data('post');
        },

        write: function() {
            var $this = this;
            $this.find('.js-preview-tab').removeClass('selected');
            $this.find('.js-write-tab').addClass('selected');
            $this.find('.field-postform-message').show();
            $this.find('.bblinks').show();
            $this.find('.post-preview').hide();
        },

        preview: function() {
            var $this = this,
                text = $('textarea').val();

            $.ajax({
                url: '/post/preview',
                type: 'POST',
                dataType: 'json',
                data: {text: text},
                cache: false,
                success: function (data) {
                    console.log(data);
                    $this.find('.js-write-tab').removeClass('selected');
                    $this.find('.js-preview-tab').addClass('selected');
                    $this.find('.field-postform-message').hide();
                    $this.find('.bblinks').hide();

                    $this.find('.post-preview').show().html(data);
                }
            });
        }
    };
})(window.jQuery);
