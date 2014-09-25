/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function MediaImageUploadModal() {
    var $modal = $('div.image-upload-modal');
    var $modalDialog = $modal.find('.modal-dialog:first');
    var $imageUploadButton = $modal.find('span.image-upload-button:first');
    var $fileUpload = $modal.find('input#file-upload:first');

    var $dropZone = $modal.find('div.drop-zone:first');
    var $dropZoneContent = $dropZone.html();

    var $progressBar = $modal.find('.progress-bar:first');
    var $cropButton = $modal.find('a#image-upload-crop:first');

    var $imageUploadCropper = new MediaImageUploadCropper();

    var $modalDialogWidth;
    var $settings;
    var $imageWidget;

    $modal.on('hidden.bs.modal', function () {
        resetModal();
    });

    this.show = function (imageWidget, settings) {
        $imageWidget = imageWidget;
        $settings = settings;
        $modalDialogWidth = $modalDialog.width();

        $imageUploadButton.on('click', function () {
//            $('#ImgForm').each(function(){
//                this.reset();
//            });
//            if ($fileUpload.val()) {
////                console.log($fileUpload.data);
////                $fileUpload.fileupload('destroy');
//                $fileUpload.empty();
//                $fileUpload.remove();
////                $fileUpload.prop('disabled', true);
//                $fileUpload.detach();
//                $fileUpload.triggerHandler('remove');
//                $fileUpload.val('');
//                $fileUpload.removeData();
//                //$temp.fileInput.context = [];
//            }

            //$fileUpload.replaceWith($fileUpload.val('').clone(true));
            $fileUpload.click();
        });

        //initFileUpload($settings);

        $('#test-file-upload').on('change', function () {
            console.log('esu');
        });

        $modal.modal('show');
    };



    var initFileUpload = function ($settings) {
        $fileUpload.fileupload({
            autoUpload: false,
            url: Routing.generate('silvestra_media_uploader_upload'),
            dataType: 'json',
            formData: {'config': JSON.stringify($settings) },
            dropZone: $dropZone,
//            sequentialUploads: true,
            multiple: false,
            replaceFileInput: true,
            acceptFileTypes: /(\.|\/)($settings.uploaderConfig.acceptFileTypes)$/i,
            maxFileSize: $settings.uploaderConfig.maxFileSize, // 5 MB
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator && navigator.userAgent),
            imageMaxWidth: $settings.uploaderConfig.maxWidth,
            imageMaxHeight: $settings.uploaderConfig.maxHeight
        });

        $fileUpload.on('fileuploadchange',function (e, data) {

        }).on('fileuploadadd',function (e, data) {
            $cropButton.click(function () {
                data.submit();
            });
        }).on('fileuploaddone',function (e, data) {
            if (data.result[0].errors.length) {
                console.log(data.result[0]);
            } else {
                loadImage(data.result[0].file, function($image) {
                    $imageWidget.find('div.image:first').html($image);
                }, {minHeight: 150, maxHeight: 150, canvas: true});
                $imageWidget.show();
                $modal.modal('hide');
                resetModal();
            }
        }).on('fileuploadprocessalways',function (e, data) {
            var $file = data.files[data.index];
            var $image = getImage($file, function ($image) {
                $dropZone.html($image);

                var $canvasImage = $dropZone.find('img:first, canvas:first');

                if ($settings.cropperEnabled) {
                    $imageUploadCropper.init($canvasImage, $settings.cropperConfig);
                }
                setModalDialogWidth($canvasImage[0].width + 36);
            });

            if (!$image) {
                $dropZone.html('<p>' + $dropZone.data('not_support_url_or_file_reader') + '</p>');
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $progressBar.css('width', progress + '%');
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    };

    var getImage = function ($file, $callback) {
        return loadImage($file, $callback, {canvas: true});
    };

    var setModalDialogWidth = function ($width) {
        $modalDialog.css('width', $width + 'px');
    };

    var resetDropZone = function () {
        $dropZone.html($dropZoneContent);
    };

    var resetModalDialogWidth = function () {
        setModalDialogWidth($modalDialogWidth);
    };

    var resetModal = function () {
        $fileUpload.fileupload('destroy');
        $imageUploadButton.unbind();
        resetDropZone();
        resetModalDialogWidth();
        $progressBar.css('width', '0%');
    };
}

function MediaImageUploadCropper() {
    var $coordinates = [0, 0, 0, 0];

    this.init = function ($image, $cropperConfig) {
        $coordinates = [$cropperConfig.x1, $cropperConfig.y1, $cropperConfig.x2, $cropperConfig.y2];

        $image.Jcrop({
            trueSize: [$image[0].width, $image[0].height],
            setSelect: $coordinates,
            bgColor: 'white',
            onSelect: cropper,
            onRelease: cropper
        });
    };

    this.getCoordinates = function () {
        return $coordinates;
    };

    var cropper = function ($coord) {
        $coordinates = $coord;
    };
}
