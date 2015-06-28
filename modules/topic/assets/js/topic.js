yii.topic = (function ($) {
    var css = {
        editor: '.js-editor',
        discussion: '.js-postlist',
        createSubmit: '.js-topic-create-submit',
        errorSummary: '.error-summary'
    };
    var $discussion = $(css.discussion);
    var $editor = $(css.editor);
    var pub = {
        isActive: true,
        init: function () {
            $editor.on('click', css.createSubmit, function () {
                var $btn = $(this);
                var $form = $btn.closest('form');
                var topic = $discussion.attr('data-topic-id');
                var page = $discussion.attr('data-topic-page');
                var message = $form.find('textarea').val();
                $(css.createSubmit).addClass('disabled');
                $.ajax({
                    url: '/post/create',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        topic_id: topic,
                        message: message
                    },
                    success: function(data) {
                        $(css.createSubmit).removeClass('disabled');
                        if (!$.isEmptyObject(data['errors'])) {
                            var $summary = $form.find(css.errorSummary);
                            var $ul = $summary.find('ul').empty();
                            if ($summary.length && data['errors']) {
                                $.each(data['errors'], function (index, element) {
                                    $ul.append('<li>' + element + '</li>');
                                });
                            }
                            $summary.toggle($ul.find('li').length > 0);
                            $form.find('textarea').focus();
                            return false;
                        } else {
                            if (data['page'] != page) {
                                var url = 'http://' + window.location.hostname + '/post/' + data['post_id'] + '#post' + data['post_id'];
                                if (url) {
                                    window.location = url;
                                }
                                return false;
                            } else {
                                $form.find('textarea').val('');
                                $form.find(css.errorSummary).hide();
                                var $post = $(data['post']).hide();
                                $discussion.append($post);
                                $post.show(300);
                            }
                        }
                    }
                });
                return false;
            });
        }
    };
    return pub;
})(jQuery);