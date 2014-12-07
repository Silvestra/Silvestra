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
    var $uploadButton = $modal.find('span.image-upload-button:first');
    var $dropZone = $modal.find('div.drop-zone:first');
    var $dropZoneContent = $dropZone.html();
    var $cropButton = $modal.find('a#image-upload-crop:first');
    var $imageUploadCropper = new MediaImageUploadCropper();
    var $imageUpload = new MediaImageUpload();
    var $modalDialogWidth;
    var $currentSettings;
    var $currentImageWidget;
    var $currentImageFile;

    this.show = function ($imageWidget, $settings) {
        var $imageUploadFile = $imageWidget.find(':input[type=file]:first');

        $modalDialogWidth = $modalDialog.width();
        $currentSettings = $settings;
        $currentImageWidget = $imageWidget;
        $imageUpload.reset();

        $imageWidget.on('change', handleFileSelect);

        $uploadButton.on('click', function () {
            $imageUploadFile.click();
        });

        $modal.modal('show');
    };

    $cropButton.click(function () {
        if ($imageUpload.isLoaded()) {
            var $thumbnail = $imageUpload.getThumbnail(function ($image) {
                if ($imageUpload.isImage($image)) {
                    $currentImageWidget.find('div.image:first').html($image);
                    $currentImageWidget.removeClass('hidden');
                }
            });

            $currentImageWidget.find(':input[type=hidden]:first').val(JSON.stringify($imageUploadCropper.getCoordinates()));
        } else {
            $currentImageWidget.remove();
        }

        $modal.modal('hide');
    });

    $dropZone.on('media.pre_upload.image', function ($event, $file) {
        loadModalImage($file, $currentSettings.uploaderConfig);
    });

    var loadModalImage = function ($file, $uploaderConfig) {
//        loadImage.parseMetaData($file, function ($data) {
//            if (!$data.imageHead) {
//                $dropZone.html('<p>' + $dropZone.data('loading_image_file_failed') + '</p>');
//
//                return;
//            }
//
//            if ($data.exif) {
//                $uploaderConfig.orientation = $data.exif.get('Orientation');
//            }
        $imageUpload.init($file, $uploaderConfig);

        var fileUrl = window.URL.createObjectURL($file);
        console.log(fileUrl);

        var $image = $imageUpload.getImage(function ($image) {
            console.log($image);
            if (!$imageUpload.isImage($image)) {
                $dropZone.html('<p>' + $dropZone.data('loading_image_file_failed') + '</p>');
            } else {
                console.log($imageUpload.getScaledImage($image));

                var $scaledImage = $imageUpload.getScaledImage($image);
                $dropZone.html($scaledImage);

                var $canvasImage = $dropZone.find('img, canvas');

                if ($scaledImage.toBlob) {
                    $scaledImage.toBlob(
                        function ($blob) {

                            var $formData = new FormData();
                            $formData.append('files', $blob, $file.name);
                            $formData.append('config', JSON.stringify($uploaderConfig));

                            sendRequest($formData, function ($response) {
                               console.log($response);
                            });
                        },
                        $file.type
                    );
                    console.log('esu');
                }

                if ($currentSettings.cropperEnabled) {
                    $imageUploadCropper.init($canvasImage, $currentSettings.cropperConfig);
                }

                setModalDialogWidth($canvasImage[0].width + 36);
            }
        });

        if (!$image) {
            $dropZone.html('<p>' + $dropZone.data('not_support_url_or_file_reader') + '</p>');
        }
//        });
    }

    var sendRequest = function ($formData, $callback) {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState === 4) {
                $callback(request.response);
            }
        }
        request.open('POST', Routing.generate('silvestra_media_uploader_upload'));
        request.responseType = 'json';
        request.send($formData);
    };

    var handleFileSelect = function ($event) {
        $event.stopPropagation();
        $event.preventDefault();
        $event = $event.originalEvent;
        var $target = $event.dataTransfer || $event.target;
        var $file = $target && $target.files && $target.files[0];

        if (!$file) {
            return;
        }

        $dropZone.trigger('media.pre_upload.image', [$file]);
    };

    var handleDragOver = function ($event) {
        $event.stopPropagation();
        $event.preventDefault();
        $event = $event.originalEvent;
        $event.dataTransfer.dropEffect = 'copy';
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

    $dropZone.on('dragover', handleDragOver);
    $dropZone.on('drop', handleFileSelect);

    $modal.on('hidden.bs.modal', function () {
        $uploadButton.unbind();
        resetDropZone();
        resetModalDialogWidth();
        if (!$imageUpload.isLoaded()) {
            $currentImageWidget.remove();
        }
    });
}

function MediaImageUpload() {
    var $currentFile;
    var $currentConfig;
    var $isLoaded = false;

    this.init = function ($file, $config) {
        $currentFile = $file;
        $currentConfig = $config;
    };

    this.reset = function () {
        $currentFile = null;
        $currentConfig = null;
        $isLoaded = false;
    };

    this.getScaledImage = function ($image) {
        return loadImage.scale(
            $image, // img or canvas element
            {orientation: $currentConfig.orientation, maxWidth: $currentConfig.maxWidth, maxHeight: $currentConfig.maxHeight}
        );
    };


    this.getImage = function ($callback) {
        $isLoaded = true;

        return getLoadingImage(
            $callback,
            {orientation: $currentConfig.orientation, maxWidth: $currentConfig.maxWidth, maxHeight: $currentConfig.maxHeight}
        )
    };

    this.getThumbnail = function ($callback) {
        return getLoadingImage(
            $callback,
            {orientation: $currentConfig.orientation, maxWidth: 150, maxHeight: 150, crop: true}
        );
    };

    this.isImage = function ($image) {
        return $image.src || $image instanceof HTMLCanvasElement;
    }

    this.isLoaded = function () {
        return $isLoaded;
    }

    var getLoadingImage = function ($callback, $options) {
        $options.canvas = true;
//        $options.crop = true;
//        $options.noRevoke = false;

        return loadImage($currentFile, $callback, $options);
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
