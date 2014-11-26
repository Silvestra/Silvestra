/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function MediaImageUploadModal($modal) {
    var $dialog = $modal.find('.modal-dialog:first');
    var $dropzone = $modal.find('.drop-zone:first');
    var $input = document.getElementById('file-upload');
    var $uploadButton = $modal.find('.image-upload-button:first');
    var $uploadCropButton = $modal.find('#image-upload-crop:first');

    var $config;
    var $filename;
    var $uploadToken;

    FileAPI.event.on($input, 'change', function ($event) {
        var $files = FileAPI.getFiles($event);

        if (validateFileType($files[0].type)) {
            FileAPI.getInfo($files[0], function ($error, $info) {
                var $imageHeight = $config.max_height < $info.height ? $config.max_height : $info.height;
                var $imageWidth = $config.max_width < $info.width ? $config.max_width : $info.width;

                FileAPI.upload({
                    url: Routing.generate('silvestra_media_image_uploader_upload'),
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
        console.log($config.cropper_coordinates);
    });


    $uploadButton.click(function ($event) {
        $event.preventDefault();
        $input.click();
    });

    this.show = function ($imageWidget) {
        $config = $imageWidget.data('config');
        $uploadToken = $imageWidget.data('token');

        $modal.modal('show');
    };

    var setDialogWidth = function ($width) {
        $dialog.css('width', $width + 'px');
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
        $config.cropper_coordinates.x1 = $coordinates['x'];
        $config.cropper_coordinates.y1 = $coordinates['y'];
        $config.cropper_coordinates.x2 = $coordinates['x2'];
        $config.cropper_coordinates.y2 = $coordinates['y2'];
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
