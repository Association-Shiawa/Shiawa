import Cropper from 'cropperjs'

$(document).ready(function(){
    let $inputFile = $('#upload-file');
    let $avatarCropping = $('#avatar-cropping');
    let route = $inputFile.closest("form").attr('action');
    let $modal = $('#modal-avatar');
    $modal.modal({
        dismissible: true
    });

    let cropper;

    $inputFile.change(function(e){
        let files = e.target.files;
        if (files && files[0]) {
            let f = files[0];
            let reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    // Render thumbnail.
                    console.log(theFile.name);
                    $avatarCropping.attr('src', e.target.result);
                    $avatarCropping.attr('title', theFile.name);
                    $avatarCropping.attr('alt', theFile.name);
                    crop();
                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }

        $modal.modal('open');
    });

    function crop(){
        let avatar = document.getElementById('avatar-cropping');
        cropper = new Cropper(avatar,{
            aspectRatio: 1,
            ready: function () {
                // Do something here
                // ...

                // And then
                //this.cropper.crop();
            }
        });

        $('#crop').on('click', function (e) {
            e.preventDefault();
            cropper.getCroppedCanvas({
                width: 300,
                height: 300
            }).toBlob(function (blob) {
                cropper.destroy();
                console.log(blob);
                let formData = new FormData();
                formData.append('avatar_avatar', blob);

                $('img.avatar').each(function () {
                    $(this).attr('src', window.URL.createObjectURL(blob));
                });
                $.ajax(route, {
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        console.log(res);
                        console.log('Upload success');
                    },
                    error: function (res) {
                        console.log(res);
                        console.log('Upload error');
                    }
                });
            });
        })
    }
});

