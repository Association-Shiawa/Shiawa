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

    // if(typeof(CKEDITOR) !== 'undefined' ) {
    //     for (var instance in CKEDITOR.instances) {
    //         instance = CKEDITOR.instances[instance];
            // console.log(instance.config);
            // instance.config.contentsCss.push(cssArticle);
            // instance.config.contentsCss = [cssArticle];
    //     }
    // }

});

$(document).ready(function(){
    CKFinder.config( { connectorPath: '/ckfinder/connector' } );
    CKFinder.setupCKEditor(  );
});


function formatIframe (content) {
    var m = false;
    content = content.replace(/(.+video-container.+)?<iframe.+<\/iframe>/g, function (x) {
        if(x.search("video-container") == -1){
             x = "<div class='video-container'>"+ x + "</div>";
            console.log('modifié', x);
            m = true;
        }else{
            console.log('pas modifié', x);
        }
        return x;
    });

    if(m) {
        console.log(content);
    }

    return content;
}