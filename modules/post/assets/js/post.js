yii.post = (function ($) {
    var css = {
        postlist: '.js-postlist',
        post: '.js-post',
        postUpdate: '.js-post-update',
        postMessage: '.js-post-message',
        updateButton: '.js-post-update-button',
        deleteButton: '.js-post-delete-button',
        updateSubmit: '.js-post-update-submit',
        cancelSubmit: '.js-post-cancel-submit',
        errorSummary: '.error-summary'
    };
    var $postlist = $(css.postlist);
    var pub = {
        isActive: true,
        init: function () {
            $postlist.on('click', css.updateButton, function () {
                var $post = $(this).closest(css.post);
                $post.find('textarea').focus();
                $post.find(css.postUpdate).show();
                $post.find(css.updateButton).hide();
                $post.find(css.deleteButton).hide();
                $post.find(css.postMessage).hide();
                return false;
            });
            $postlist.on('click', css.updateSubmit, function () {
                var $post = $(this).closest(css.post);
                $(this).addClass('disabled');
                updatePost($post);
                return false;
            });
            $postlist.on('click', css.cancelSubmit, function () {
                var $post = $(this).closest(css.post);
                $post.find(css.postUpdate).hide();
                $post.find(css.updateButton).show();
                $post.find(css.deleteButton).show();
                $post.find(css.postMessage).show();
                return false;
            });
        }
    };
    function updatePost($post) {
        var $form = $post.find('form');
        var data = {};
        data[yii.getCsrfParam()] = yii.getCsrfToken();
        data['post_id'] = $post.attr('data-post-id');
        data['message'] = $post.find('textarea').val();
        $.ajax({
            url: '/post/update',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                $(css.updateSubmit).removeClass('disabled');
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
                    $post.find(css.postUpdate).hide();
                    $post.find(css.updateButton).show();
                    $post.find(css.deleteButton).show();
                    $post.find(css.postMessage).show().html(data);
                }
            }
        });
    }
    return pub;
})(jQuery);