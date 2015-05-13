/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function MediaImageModal() {
    var $modal;

    var $config;
    var $cropperCoordinates = {};
    var $filename;
    var $currentImageWidget;
    var $uploadToken;

    this.show = function ($imageWidget) {
        $config = $imageWidget.data('config');
        $filename = $imageWidget.find('.silvestra-image-filename:first').val();
        $uploadToken = $imageWidget.data('token');
        $currentImageWidget = $imageWidget;

        $.ajax({
            url: Routing.generate('silvestra_media.image_modal'),
            type: 'GET',
            data: { filename: $filename },
            success: function ($response) {
                $modal = $($response);
                init();

                $modal.modal('show');
            },
            error: function ($request, $status, $error) {
                console.log($request.responseText);
            }
        });

    };

    var init = function () {
        var $dropzone = $modal.find('.dropzone:first');
        var $input =  $modal.find('#file-upload:first');
        var $uploadButton = $modal.find('.image-upload-button:first');
        var $uploadCropButton = $modal.find('#image-upload-crop:first')

        $cropperCoordinates = $dropzone.data('coordinates');
        if (!$cropperCoordinates.length) {
            $cropperCoordinates = $config.cropper_coordinates;
        }

        FileAPI.event.on($input[0], 'change', function ($event) {
            var $files = FileAPI.getFiles($event);

            if (validateFileType($files[0].type)) {
                FileAPI.getInfo($files[0], function ($error, $info) {
                    var $imageHeight = $config.max_height < $info.height ? $config.max_height : $info.height;
                    var $imageWidth = $config.max_width < $info.width ? $config.max_width : $info.width;

                    FileAPI.upload({
                        url: Routing.generate('silvestra_media.image_uploader_upload'),
                        data: { config: $config, token: $uploadToken },
                        files: { image: $files[0] },
                        imageTransform: {
                            maxWidth: $imageWidth,
                            maxHeight: $imageHeight,
                            strategy: $config.resize_strategy
                        },
                        progress: function ($event, $file, $xhr, $options) {
                            $modal.find('.progress-bar:first').css('width', parseInt($event.loaded / $event.total * 100, 10) + '%');
                        },
                        complete: function ($error, $xhr) {
                            if (!$error) {
                                var $response = jQuery.parseJSON($xhr.response);
                                if (!$response.errors) {
                                    var $image = new Image();
                                    $image.src = $response.original_path;
                                    $filename = $response.filename;

                                    $dropzone.html($image);
                                    $image.onload = function() {
                                        setDialogWidth(this.width + 36);

                                        if ($config.cropper_enabled) {
                                            initCropper($dropzone.find('img:first'));
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            }
        });


        $uploadCropButton.on('click', function ($event) {
            $event.preventDefault();

            if ($filename && $config.cropper_enabled) {
                $dropzone.fadeTo(300, 0.4);
                $.ajax({
                    url: Routing.generate('silvestra_media.image_cropper_crop'),
                    type: 'POST',
                    data: { coordinates: $cropperCoordinates, filename: $filename },
                    success: function ($response) {
                        $currentImageWidget.find('img:first').attr('src', $response.thumbnail_path);
                        $currentImageWidget.find('.silvestra-image-filename:first').val($filename);
                        $currentImageWidget.find('.remove-image:first').show();
                        $modal.modal('hide');

                        $dropzone.fadeTo(0, 1);
                    },
                    error: function ($request, $status, $error) {
                        console.log($request.responseText);
                        $dropzone.fadeTo(0, 1);
                    }
                });
            }
        });

        $uploadButton.click(function ($event) {
            $event.preventDefault();
            $input.click();
        });
    };

    var setDialogWidth = function ($width) {
        $modal.find('.modal-dialog:first').css('width', $width + 'px');
    };

    var initCropper = function ($image) {
        var $initCoordinates = [
            $config.cropper_coordinates.x1,
            $config.cropper_coordinates.y1,
            $config.cropper_coordinates.x2,
            $config.cropper_coordinates.y2
        ];

        $image.Jcrop({
            trueSize: [$image[0].width, $image[0].height],
            setSelect: $initCoordinates,
            bgColor: 'white',
            onSelect: setCropperCordinates,
            onRelease: setCropperCordinates
        });
    };

    var setCropperCordinates = function ($coordinates) {
        $cropperCoordinates.x1 = $coordinates['x'];
        $cropperCoordinates.y1 = $coordinates['y'];
        $cropperCoordinates.x2 = $coordinates['x2'];
        $cropperCoordinates.y2 = $coordinates['y2'];
    };

    var validateFileType = function ($type) {
        var $key;
        var $types = $config.mime_types;

        for ($key in $types) {
            if ($types.hasOwnProperty($key) && $type == $types[$key]) {
                return true;
            }
        }

        return false;
    };
}
