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

        $imageWidget.on('change', fileHandler);

        $uploadButton.on('click', function () {
            $imageUploadFile.click();
        });

        $currentImageFile = $imageUploadFile && $imageUploadFile[0].files && $imageUploadFile[0].files[0];
        if ($currentImageFile) {
            console.log($currentImageFile);
            loadModalImage($currentImageFile, $currentSettings.uploaderConfig);
        }

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
        } else {
            $currentImageWidget.remove();
        }

        $modal.modal('hide');
    });

    $dropZone.on('media.pre_upload.image', function ($event, $file) {
        var $uploaderConfig = $currentSettings.uploaderConfig;

        loadModalImage($file, $uploaderConfig);
    });

    var loadModalImage = function ($file, $uploaderConfig) {
        loadImage.parseMetaData($file, function ($data) {
            if (!$data.imageHead) {
                $dropZone.html('<p>' + $dropZone.data('loading_image_file_failed') + '</p>');

                return;
            }

            if ($data.exif) {
                $uploaderConfig.orientation = $data.exif.get('Orientation');
            }
            $imageUpload.init($file, $uploaderConfig);

            var $image = $imageUpload.getImage(function ($image) {
                if (!$imageUpload.isImage($image)) {
                    $dropZone.html('<p>' + $dropZone.data('loading_image_file_failed') + '</p>');
                } else {
                    $dropZone.html($image);

                    var $canvasImage = $dropZone.find('img, canvas');

                    if ($currentSettings.cropperEnabled) {
                        $imageUploadCropper.init($canvasImage, $currentSettings.cropperConfig);
                    }

                    setModalDialogWidth($canvasImage[0].width + 34);
                }
            });

            if (!$image) {
                $dropZone.html('<p>' + $dropZone.data('not_support_url_or_file_reader') + '</p>');
            }
        });
    }

    var fileHandler = function ($event) {
        $event.preventDefault();
        $event = $event.originalEvent;
        var $target = $event.dataTransfer || $event.target;
        var $file = $target && $target.files && $target.files[0];
        console.log($file);
        if (!$file) {
            return;
        }

        $dropZone.trigger('media.pre_upload.image', [$file]);
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

    $dropZone
        .on('dragover',function ($event) {
            $event.preventDefault();
            $event = $event.originalEvent;
            $event.dataTransfer.dropEffect = 'copy';
        }).on('drop', fileHandler);

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

    var cropper = function ($coordinates) {
        console.log($coordinates);
    };
}
