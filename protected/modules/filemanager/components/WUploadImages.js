/**
 * {{id}}
 * {Всякая хрень}
 */
(function($){

//    $(window).load(function() {

        var list = $('#{{id}}_list'),
            uploader = new plupload.Uploader({
            runtimes: 'html5,flash',
            browse_button: '{{id}}_browse',
            flash_swf_url: '{{asset_path}}/plupload/plupload.flash.swf',
            //multi_selection: false,
            //max_file_number: 1,
            url: '{{url}}'

        });
       uploader.bind('FileUploaded', function(up, files, response) {

            var r = $.parseJSON(response.response);

            if ( typeof r.file != 'undefined' ) {

                $('<div />', {
                    class: 'item',
                })
                .append(
                    $('<img />', {
                        src: '{{show_url}}?filename=' + r.file
                    }))
                .append(
                    $('<input />', {
                        type: 'hidden',
                        name: '{{input_name}}[]',
                        value: r.file
                    }))
                .appendTo(list);
            }

        });

        uploader.bind('QueueChanged', function(up) {
            uploader.start();
        });

        uploader.bind('UploadComplete', function(up, files) {
            up.refresh();
        });

        /*
        uploader.bind('Init', function(up) {
        });
        uploader.bind('FilesAdded', function(up, files) {
            console.log('Queued files: ' + uploader.files.length);
        });
        uploader.bind('UploadFile', function(up, files) {
        });
        */


        uploader.init();

        // Старт загрузки
        $('#{{id}}_upload').click(function(){

        });

//    });

})(jQuery);