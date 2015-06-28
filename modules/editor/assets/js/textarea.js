yii.textarea = (function ($) {
    var css = {
        postlist: '.js-postlist',
        textarea: '.js-editor-textarea',
        buttonSubmit: '.js-btn-submit'
    };
    var pub = {
        isActive: true,
        init: function () {
            $(document).on('keydown', function(event) {
                if ((event.keyCode == 10 || event.keyCode == 13) && event.ctrlKey) {
                    event.preventDefault();
                    return $(css.buttonSubmit).trigger('submit');
                }
            });
            initMention();
        }
    };
    function initMention() {
        var cachequeryMentions = [];
        var itemsMentions;
        var id = $(css.postlist).attr('data-topic-id');
        console.log(id);
        $(css.textarea).atwho({
            at: "@",
            callbacks: {
                remoteFilter: function (query, render_view) {
                    var thisVal = query,
                        self = $(this);
                    if (!self.data('active')) {
                        self.data('active', true);
                        itemsMentions = cachequeryMentions[thisVal];
                        if (typeof itemsMentions == "object"){
                            render_view(itemsMentions);
                        } else {
                            if (self.xhr) {
                                self.xhr.abort();
                            }
                            self.xhr = $.getJSON("/editor/mention", {
                                id: id,
                                query: query
                            }, function(data) {
                                cachequeryMentions[thisVal] = data;
                                render_view(data);
                            });
                        }
                        self.data('active', false);
                    }
                }
            }
        });
    }
    return pub;
})(jQuery);