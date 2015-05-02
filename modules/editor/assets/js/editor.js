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

                $this.on('click', '.js-btn-texticon-bold', function (event) {
                    event.preventDefault();
                    markUp(1);
                });
                $this.on('click', '.js-btn-texticon-italic', function (event) {
                    event.preventDefault();
                    markUp(2);
                });
                $this.on('click', '.js-btn-texticon-link', function (event) {
                    event.preventDefault();
                    markUp(5);
                });

                $(document).on('keydown', function(event) {
                    if ((event.keyCode == 10 || event.keyCode == 13) && event.ctrlKey) {
                        event.preventDefault();
                        $this.find('#postform').submit();
                    }
                });

                $(document).on('ready', function(event) {
                    var id = $('.topic-discussion').attr('id');
                    $.ajax({
                        url: '/editor/mention',
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
            $this.find('.editor-texticon-panel').show();
            $this.find('.post-formbox-preview').hide();
        },

        preview: function() {
            var $this = this,
                message = $this.find('textarea').val();

            $this.find('.js-post-write-tab').removeClass('selected');
            $this.find('.js-post-preview-tab').addClass('selected');
            $this.find('textarea').hide();
            $this.find('.editor-texticon-panel').hide();
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

    var isEmpty = function (value, trim) {
        return value === null || value === undefined || value == []
            || value === '' || trim && $.trim(value) === '';
    };

    var isNumber = function (n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    };

    var getBlockMarkUp = function (txt, begin, end) {
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
    };

    var getMarkUp = function (txt, begin, end) {
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
    };

    var markUp = function (btn) {
        var el = $('#postform-message');
        el.focus();
        var txt = str = el.extractSelectedText(),
            len = txt.length,
            tip = '';

        // Bold
        if (btn == 1) {
            tip = '**Полужирный текст**';
            if (txt.length > 0) {
                if (str == tip) {
                    str = '';
                } else {
                    str = getBlockMarkUp(txt, '**', '**');
                }
            } else {
                str = tip;
            }
        }
        // Italic
        else if (btn == 2) {
            tip = '**Курсивный текст**';
            if (txt.length > 0) {
                if (str == tip) {
                    str = '';
                } else {
                    str = getBlockMarkUp(txt, '*', '*');
                }
            } else {
                str = tip;
            }
        }
        // Paragraph
        else if (btn == 3) {
            str = (txt.length > 0) ? getMarkUp(txt, '\n', '\n') : '\n(paragraph text here)\n';
        }
        // New Line
        else if (btn == 4) {
            str = getBlockMarkUp(txt, '', '  ');
        }
        // Header
        else if (btn > 100) {
            n = btn - 100;
            var pad = "#".repeat(n);
            str = getMarkUp(txt, pad + " ", " " + pad);
        }
        // Hyperlink
        else if (btn == 5) {
            link = prompt('Вставьте гиперссылку', 'http://');
            str = (link != null && link != '' && link != 'http://') ? '[' + txt + '](' + link + ')' : txt
        }
        // Image
        else if (btn == 6) {
            link = prompt('Insert Image Hyperlink', 'http://');
            str = (link != null && link != '' && link != 'http://') ? '![' + txt + '](' + link + ' "enter image title here")' : txt
        }
        // Add Indent
        else if (btn == 7) {
            var str = txt,
                ind = '  ';
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
        }
        // Remove Indent
        else if (btn == 8) {
            var str = txt,
                ind = '  ';
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
        }
        // Unordered List
        else if (btn == 9) {
            str = getBlockMarkUp(txt, "- ", "");
        }
        // Ordered List
        else if (btn == 10) {
            start = prompt('Enter starting number', 1);
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
        }
        // Definition List
        else if (btn == 11) {
            if (txt.indexOf('\n') > 0) {
                var list = [],
                    i = 1;
                list = txt.split('\n');
                $.each(list, function (k, v) {
                    tag = (i % 2 == 0) ? ':    ' : '';
                    list[k] = getMarkUp(v, tag, '');
                    i++
                });
                str = list.join('\n')
            } else {
                str = txt + "\n:    \n"
            }
        }
        // Footnote
        else if (btn == 12) {
            title = 'Enter footnote ';
            notes = '';
            if (txt.indexOf('\n') < 0) {
                notes = '[^1]: ' + title + '1\n';
                str = getMarkUp(txt, '', title + '[^1]') + "\n" + notes;
            } else {
                var list = [],
                    i = 1;
                list = txt.split('\n');
                $.each(list, function (k, v) {
                    id = '[^' + i + ']';
                    list[k] = getMarkUp(v, '', id + '  ');
                    notes = notes + id + ': ' + title + i + '\n';
                    i++
                });
                str = list.join('\n') + "  \n\n" + notes
            }
        }
        // Blockquote
        else if (btn == 13) {
            str = getBlockMarkUp(txt, "> ", "  ");
        }
        // Inline Code
        else if (btn == 14) {
            str = getMarkUp(txt, "`", "`");
        }
        // Code Block
        else if (btn == 15) {
            lang = prompt('Enter code language (e.g. html)', '');
            if (isEmpty(lang, true)) {
                lang = '';
            }
            str = getMarkUp(txt, "~~~" + lang + " \n", "\n~~~  \n");
        }
        // Horizontal Line
        else if (btn == 16) {
            str = getMarkUp(txt, '', '\n- - -');
        }
        if (!isEmpty(str)) {
            el.replaceSelectedText(str, "select")
        }
    };
})(window.jQuery);
