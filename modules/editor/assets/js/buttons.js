yii.buttons = (function ($) {
    var css = {
        panel: '.js-editor-buttons',
        preview: '.js-editor-preview'
    };
    var pub = {
        isActive: true,
        init: function () {
            $('.btn.btn-sm').on('click', function (e) {
                e.preventDefault();
                var $btn = $(this);
                var btnName = $btn.data('editor-btn-panel');
                var $textarea = $btn.closest('form').find('textarea');
                if (btnName == 'preview') {
                    preview($btn, $textarea);
                }
                if (btnName != 'preview' && !$btn.hasClass('disabled')) {
                    markUp(btnName, $textarea);
                }
            });
        }
    };
    function preview(btn, textarea) {
        console.log(btnName);
        var message = textarea.val();
        var $form = textarea.closest('form');
        var $preview = $form.find(css.preview);
        if (btn.hasClass('selected')) {
            $('.btn-group > .btn.btn-sm').each(function(){
                var btn = $(this);
                btn.removeClass('disabled');
            });
            btn.removeClass('selected');
            $preview.hide();
            textarea.show().focus();
        } else {
            $('.btn-group > .btn.btn-sm').each(function(){
                var btn = $(this);
                if (btn.attr('data-editor-btn-panel') == 'preview') {
                    return true;
                }
                btn.addClass('disabled');
            });
            btn.addClass('selected');
            textarea.hide();
            $form.find('.error-summary').hide();
            $preview.show().html('Загрузка предпросмотра...');
            $.ajax({
                url: '/post/preview',
                type: 'POST',
                dataType: 'json',
                data: {message: message},
                cache: false,
                success: function (data) {
                    $preview.html(data);
                }
            });
        }
    }
    function markUp(btn, textarea) {
        textarea.focus();
        var txt = str = textarea.extractSelectedText();
        var len = txt.length;
        var tip = '';
        if (btn == 'bold') {
            tip = '**Полужирный текст**';
            if (len > 0) {
                if (str == tip) {
                    str = '';
                } else {
                    str = getBlockMarkUp(txt, '**', '**');
                }
            } else {
                str = tip;
            }
        } else if (btn == 'italic') {
            tip = '*Курсивный текст*';
            if (len > 0) {
                if (str == tip) {
                    str = '';
                } else {
                    str = getBlockMarkUp(txt, '*', '*');
                }
            } else {
                str = tip;
            }
        } else if (btn == 'strike') {
            tip = '~~Зачеркнутый текст~~';
            if (len > 0) {
                if (str == tip) {
                    str = '';
                } else {
                    str = getBlockMarkUp(txt, '~~', '~~');
                }
            } else {
                str = tip;
            }
        } else if (btn == 'link') {
            var link = prompt('Вставьте гиперссылку', 'http://');
            if (len == 0) {
                txt = prompt('Название гиперссылки', 'Гиперссылка');
            }
            str = (link != null && link != '' && link != 'http://') ? '[' + txt + '](' + link + ')' : txt;
        } else if (btn == 'image') {
            link = prompt('Вставка картинки', 'http://');
            str = (link != null && link != '' && link != 'http://') ? '![' + txt + '](' + link + ' "название картинки")' : txt;
        } else if (btn == 'indent') {
            var ind = '  ';
            if (str.indexOf('\n') < 0) {
                str = ind + str
            } else {
                var list = [];
                list = txt.split('\n');
                $.each(list, function (k, v) {
                    list[k] = ind + v
                });
                str = list.join('\n')
            }
        } else if (btn == 'unindent') {
            var ind = '  ';
            if (str.indexOf('\n') < 0 && str.substr(0, 2) == ind) {
                str = str.slice(2)
            } else {
                var list = [];
                list = txt.split('\n');
                $.each(list, function (k, v) {
                    list[k] = v;
                    if (v.substr(0, 2) == ind) {
                        list[k] = v.slice(2)
                    }
                });
                str = list.join('\n')
            }
        } else if (btn == 'list-bulleted') {
            str = getBlockMarkUp(txt, "- ", "");
        } else if (btn == 'list-numbered') {
            start = prompt('Введите начальное число', 1);
            if (start != null && start != '') {
                if (!isNumber(start)) {
                    start = 1
                }
                if (txt.indexOf('\n') < 0) {
                    str = getMarkUp(txt, start + '. ', '');
                } else {
                    var list = [],
                        i = start;
                    list = txt.split('\n');
                    $.each(list, function (k, v) {
                        list[k] = getMarkUp(v, i + '. ', '');
                        i++
                    });
                    str = list.join('\n')
                }
            }
        } else if (btn == 'quote') { // Blockquote
            str = getBlockMarkUp(txt, "> ", "  ");
        } else if (btn == 'code') { // Code Block
            str = getMarkUp(txt, "~~~\n", "\n~~~  \n");
        }
        if (!isEmpty(str)) {
            textarea.replaceSelectedText(str, "select")
        }
    }
    function isEmpty(value, trim) {
        return value === null || value === undefined || value == []
            || value === '' || trim && $.trim(value) === '';
    }
    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
    function getBlockMarkUp (txt, begin, end) {
        var string = txt;
        if (string.indexOf('\n') < 0) {
            string = getMarkUp(txt, begin, end);
        } else {
            var list = [];
            list = txt.split('\n');
            $.each(list, function (k) {
                list[k] = getMarkUp(this.replace(new RegExp("[\s]+$"), ""), begin, end + '  ')
            });
            string = list.join('\n');
        }
        return string;
    }
    function getMarkUp(txt, begin, end) {
        var m = begin.length,
            n = end.length;
        var string = txt;
        if (m > 0) {
            string = (string.slice(0, m) == begin) ? string.slice(m) : begin + string;
        }
        if (n > 0) {
            string = (string.slice(-n) == end) ? string.slice(0, -n) : string + end;
        }
        return string;
    }
    return pub;
})(jQuery);
