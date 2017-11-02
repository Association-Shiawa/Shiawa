$(document).ready(function(){
    var tagsName = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/myAssoAdmin/?action=autocomplete&entity=Tag&query=%QUERY',
            wildcard: '%QUERY',
            filter: function(list) {
                console.log(list);
                return $.map(list.results, function(tag) {
                    console.log(tag);
                    return {
                        id: tag.id,
                        name: tag.text
                    };
                });
            }
        }
    });
    tagsName.initialize();

    $('[id$=_tags]').tagsinput({
        typeaheadjs: [{
            highights: true
        }, {
            name: 'tagsName',
            display: 'name',
            value: 'name',
            source: tagsName
        }],
        freeInput: true
    });
});