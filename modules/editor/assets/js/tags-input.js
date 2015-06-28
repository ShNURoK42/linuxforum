yii.tagsinput = (function ($) {
    var css = {
    };
    var $tagInput = $('#createform-tags');
    var pub = {
        isActive: true,
        init: function () {
            var usernames = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '/ajax/tag?query=%QUERY',
                    wildcard: '%QUERY',
                    transform: function(response) {
                        return response;
                    },
                    filter: function (usernames) {
                        return $.map(usernames, function (name) {
                            var tags = $tagInput.tagsinput('items');

                            for (var i = 0, length = tags.length; i < length; i++) {
                                if (i in tags) {
                                    if (tags[i] == name) {
                                        return null;
                                    }
                                }
                            }

                            return name;
                        });
                    }
                }
            });
            usernames.initialize();
            $tagInput.tagsinput({
                maxTags: 5,
                maxChars: 64,
                trimValue: true,
                freeInput: false,
                typeaheadjs: {
                    name: 'usernames',
                    limit: 10,
                    source: usernames,
                    templates: {
                        empty: ['Пусто'].join('\n'),
                        suggestion: function(value){
                            return '<div>' + value + '</div>';
                        }
                    }
                }
            });
        }
    };
    return pub;
})(jQuery);