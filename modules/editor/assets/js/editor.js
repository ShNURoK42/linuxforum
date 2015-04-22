(function ($) {
    $.fn.editor = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.editor');
            return false;
        }
    };

    var methods = {
        init: function () {
            return this.each(function () {
                var $this = $(this);

                $(document).on('keydown', function(event) {
                    if ((event.keyCode == 10 || event.keyCode == 13) && event.ctrlKey) {
                        event.preventDefault();
                        $this.find('#postform').submit();
                    }
                });

                $(document).on('ready', function(event) {
                    var id = $('.topic-discussion').attr('id');
                    var data = $.ajax({
                        url: '/post/mention',
                        type: 'POST',
                        dataType: 'json',
                        data: {id: id},
                        success: function (data) {
                            console.log(data);

                            $('#postform-message').atwho({
                                displayTimeout: 300,
                                highlightFirst: true,
                                delay: null,
                                at: "@",
                                data: data
                            });
                        }
                    });
                });

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
