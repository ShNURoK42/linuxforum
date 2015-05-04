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

                $this.on('click', '.js-btn-texticon-bold', function (event) {
                    event.preventDefault();
                    markUp(1);
                });
                $this.on('click', '.js-btn-texticon-italic', function (event) {
                    event.preventDefault();
                    markUp(2);
                });
                $this.on('click', '.js-btn-texticon-strike', function (event) {
                    event.preventDefault();
                    markUp(3);
                });
                $this.on('click', '.js-btn-texticon-link', function (event) {
                    event.preventDefault();
                    markUp(5);
                });
                $this.on('click', '.js-btn-texticon-img', function (event) {
                    event.preventDefault();
                    markUp(6);
                });
                $this.on('click', '.js-btn-texticon-indent', function (event) {
                    event.preventDefault();
                    markUp(7);
                });
                $this.on('click', '.js-btn-texticon-unindent', function (event) {
                    event.preventDefault();
                    markUp(8);
                });
                $this.on('click', '.js-btn-texticon-bulleted', function (event) {
                    event.preventDefault();
                    markUp(9);
                });
                $this.on('click', '.js-btn-texticon-numbered', function (event) {
                    event.preventDefault();
                    markUp(10);
                });
                $this.on('click', '.js-btn-texticon-quote', function (event) {
                    event.preventDefault();
                    markUp(13);
                });
                $this.on('click', '.js-btn-texticon-blockcode', function (event) {
                    event.preventDefault();
                    markUp(15);
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

                $this.on('click', '.js-editor-preview', function (event) {
                    event.preventDefault();

                    methods.preview.apply($this);
                });
            });
        },

        preview: function() {
            var $this = this,
                message = $this.find('textarea').val();

            if ($this.find('.js-editor-preview').hasClass('selected')) {
                $this.find('.js-editor-preview').removeClass('selected');
                $this.find('.js-btn-texticon-bold').removeClass('disabled');
                $this.find('.js-btn-texticon-italic').removeClass('disabled');
                $this.find('.js-btn-texticon-strike').removeClass('disabled');
                $this.find('.js-btn-texticon-link').removeClass('disabled');
                $this.find('.js-btn-texticon-img').removeClass('disabled');
                $this.find('.js-btn-texticon-indent').removeClass('disabled');
                $this.find('.js-btn-texticon-unindent').removeClass('disabled');
                $this.find('.js-btn-texticon-bulleted').removeClass('disabled');
                $this.find('.js-btn-texticon-numbered').removeClass('disabled');
                $this.find('.js-btn-texticon-quote').removeClass('disabled');
                $this.find('.js-btn-texticon-blockcode').removeClass('disabled');
                $this.find('textarea').show();
                $this.find('.editor-texticon-panel').show();
                $this.find('.editor-preview').hide();
                $this.find('textarea').focus();
            } else {
                $this.find('.js-editor-preview').addClass('selected');
                $this.find('.js-btn-texticon-bold').addClass('disabled');
                $this.find('.js-btn-texticon-italic').addClass('disabled');
                $this.find('.js-btn-texticon-strike').addClass('disabled');
                $this.find('.js-btn-texticon-link').addClass('disabled');
                $this.find('.js-btn-texticon-img').addClass('disabled');
                $this.find('.js-btn-texticon-indent').addClass('disabled');
                $this.find('.js-btn-texticon-unindent').addClass('disabled');
                $this.find('.js-btn-texticon-bulleted').addClass('disabled');
                $this.find('.js-btn-texticon-numbered').addClass('disabled');
                $this.find('.js-btn-texticon-quote').addClass('disabled');
                $this.find('.js-btn-texticon-blockcode').addClass('disabled');
                $this.find('.error-summary').hide();
                $this.find('textarea').hide();
                $this.find('.editor-texticon-panel').hide();
                $this.find('.editor-preview').show().html('Загрузка предпросмотра...');

                $.ajax({
                    url: '/post/preview',
                    type: 'POST',
                    dataType: 'json',
                    data: {message: message},
                    cache: false,
                    success: function (data) {
                        $this.find('.editor-preview').show().html(data);
                    }
                });
            }
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
            if (len > 0) {
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
        }
        // Paragraph
        else if (btn == 3) {
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
        }
        // Hyperlink
        else if (btn == 5) {
            var link = prompt('Вставьте гиперссылку', 'http://');
            if (len == 0) {
                txt = prompt('Название гиперссылки', 'Гиперссылка');
            }
            str = (link != null && link != '' && link != 'http://') ? '[' + txt + '](' + link + ')' : txt;
        }
        // Image
        else if (btn == 6) {
            link = prompt('Вставка картинки', 'http://');
            str = (link != null && link != '' && link != 'http://') ? '![' + txt + '](' + link + ' "название картинки")' : txt;
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
        }
        // Blockquote
        else if (btn == 13) {
            str = getBlockMarkUp(txt, "> ", "  ");
        }
        // Code Block
        else if (btn == 15) {
            str = getMarkUp(txt, "~~~\n", "\n~~~  \n");
        }
        if (!isEmpty(str)) {
            el.replaceSelectedText(str, "select")
        }
    };
})(window.jQuery);
