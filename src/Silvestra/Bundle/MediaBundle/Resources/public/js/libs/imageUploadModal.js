/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function MediaImageUploadModal($modal, $settings) {
    var $dialog = $modal.find('.modal-dialog:first');
    var $dropzone = $modal.find('.drop-zone:first');
    var $input = document.getElementById('file-upload');
    var $uploadButton = $modal.find('.image-upload-button:first');
    var $uploadCropButton = $modal.find('#image-upload-crop:first');
    var $cropperCoord = $settings.cropper_coordinates;
    var $files;
    var $image;

    FileAPI.event.on($input, 'change', function ($event) {
        $files = FileAPI.getFiles($event);

        if (validateFileType($files[0].type)) {
            $image = getImage($files[0]);

            $image.get(function ($error, $img) {
                $dropzone.html($img);
                setDialogWidth($img.width + 36);

                if ($settings.cropper_enabled) {
                    initCropper($dropzone.find('img:first, canvas:first'), $settings.cropper_coordinates);
                }
            });
        } else {
            $files = null;
        }
    });


    $uploadCropButton.on('click', function ($event) {
        $event.preventDefault();

        if ($image) {
            var $config = {
                mime_types: $settings.mime_types,
                max_file_size: $settings.max_file_size,
                max_width: $settings.max_width,
                max_height: $settings.max_height,
                min_height: $settings.min_height,
                min_width: $settings.min_width,
                resize_strategy: $settings.resize_strategy,
                cropper_enabled: $settings.cropper_enabled,
                cropper_coordinates: $cropperCoord
            };


            var xhr = FileAPI.upload({
                url: Routing.generate('silvestra_media_uploader_upload'),
                data: { config: $config },
                files: { image: $image },
                progress: function ($event, $file, $xhr, $options){
                    $modal.find('.progress-bar:first').css('width', parseInt($event.loaded / $event.total * 100, 10) + '%');
                },
                complete: function (err, xhr) {
                    if (!err) {
                        var result = xhr.responseText;
                        // ...
                    }
                }
            });
        }
    });


    $uploadButton.click(function ($event) {
        $event.preventDefault();
        $input.click();
    });

    this.show = function ($imageWidget) {
        $modal.modal('show');
    };

    var setDialogWidth = function ($width) {
        $dialog.css('width', $width + 'px');
    };

    var getImage = function ($file) {
        var $image = FileAPI.Image($file);

        FileAPI.getInfo($file, function ($error, $info) {
            if ($settings.max_width < $info.width) {
                var $height = $settings.max_height < $info.height ? $settings.max_height : $info.height;

                $image.resize($settings.max_width, $height, $settings.resize_strategy);
            } else if ($settings.max_height < $info.height) {
                var $width = $settings.max_width < $info.width ? $settings.max_width : $info.width;

                $image.resize($width, $settings.max_height, $settings.resize_strategy);
            }
        });

        return $image;
    };

    var initCropper = function ($image, $initCoord) {
        $initCoord = [$initCoord.x1, $initCoord.y1, $initCoord.x2, $initCoord.y2];

        $image.Jcrop({
            trueSize: [$image[0].width, $image[0].height],
            setSelect: $initCoord,
            bgColor: 'white',
            onSelect: function ($coord) {
                $cropperCoord = $coord;
            },
            onRelease: function ($coord) {
                $cropperCoord = $coord;
            }
        });
    };

    var validateFileType = function ($type) {
        var $key;
        var $types = $settings.mime_types;

        for ($key in $types) {
            if ($types.hasOwnProperty($key) && $type == $types[$key]) {
                return true;
            }
        }

        return false;
    };
}
