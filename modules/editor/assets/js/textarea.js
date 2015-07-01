yii.textarea = (function ($) {
    var css = {
        postlist: '.js-postlist',
        textarea: '.js-editor-textarea',
        buttonSubmit: '.js-btn-submit'
    };

    $(document).on('keydown', function(event) {
        if ((event.keyCode == 10 || event.keyCode == 13) && event.ctrlKey) {
            event.preventDefault();
            var $focused = $(':focus');
            return $focused.closest('form').find('button[type="submit"]').trigger('click');
        }
    });

    var pub = {
        isActive: true,
        init: function () {
            $(css.postlist).on('mouseup', function(e) {
                var username = $(e.target).closest('.js-post').find('.post-header-user a').text();
                var text = $('.js-editor textarea').val();
                var theSelection = '';
                if (window.getSelection) {
                    theSelection = window.getSelection().toString();
                } else if (document.getSelection) {
                    theSelection = document.getSelection();
                } else if (document.selection) {
                    theSelection = document.selection.createRange().text;
                }

                $("#addQuote").remove();
                if (theSelection != false && e.which == 1 && username != false) {
                    $("body").append('<div id="addQuote" style="left: ' + (e.pageX - 15) + 'px; top: ' + (e.pageY - 50) + 'px;"><span class="fa fa-comments"></span></div>');
                    $("#addQuote").on('click', function (event) {
                        var arr = theSelection.split(/\r?\n/);
                        var result = '';
                        $.each(arr, function(i, val) {
                            result = result + ">" + val + "\n";
                        });
                        $(css.textarea).val(text + "@" + username + "\n" + result + "\n").focus();
                        $(this).animate({height:'0', opacity:'0'}, 350, function () {
                            $(this).remove();
                        });
                    });
                }
            });
            initMention();
        }
    };
    function initMention() {
        var cachequeryMentions = [];
        var itemsMentions;
        var id = $(css.postlist).attr('data-topic-id');
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