/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function MediaImageUpload($imageWidget, $config) {
    var $imageUploadFile = $imageWidget.find(':input[type=file]:first');
    var $imageUpload = $imageWidget.find('div.image:first');


    this.getImageUploadFile = function () {
        return $imageUploadFile;
    };

    this.click = function () {
        $imageUploadFile.click();
    };

    $imageUploadFile.fileupload({
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)($config.acceptFileTypes)$/i,
        maxFileSize: $config.maxFileSize,
        previewMaxWidth: 150,
        previewMaxHeight: 150,
        previewCrop: true,

        processalways: function (e, data) {
            var $file = data.files[data.index];

            if ($file.preview) {
                $imageUpload.html($file.preview);
                $imageWidget.removeClass('hidden');
            }

            var $loadingImage = getLoadingImage($file, function ($image) {
                $imageWidget.trigger('media.pre_upload.image', [$image]);
            });

            if (!$loadingImage) {
                alert('Your browser does not support the URL or FileReader API.');
            }
        }
    });

    var getLoadingImage = function ($file, $callback) {
        var $options = {
            maxWidth: $config.maxWidth,
            maxHeight: $config.maxHeight,
            canvas: true
        };

        return loadImage($file, $callback, $options);
    };
}

function MediaImageUploadCropper($image, $config) {
    var $cropperCoordinates = [$config.minWidth, $config.minHeight, $config.maxWidth, $config.maxHeight];

    $image.Jcrop({
        trueSize: [$image[0].width, $image[0].height],
        setSelect: $cropperCoordinates,
        bgColor: 'white',
        onSelect: cropper,
        onRelease: cropper
    });

    this.getCropperCoordinates = function () {
        return $cropperCoordinates;
    };

    var cropper = function ($coordinates) {
        $cropperCoordinates = $coordinates;
        console.log($cropperCoordinates);
    };
}