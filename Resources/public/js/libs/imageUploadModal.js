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
    var $modalDialogWidth;

    this.show = function ($gallery) {
        $modal.modal('show');
        $modalDialogWidth = $modalDialog.width();

        $uploadButton.on('click', function () {
            var $imageForm = $(addImageForm($gallery));
            var $imageUploadFile = $imageForm.find(':input[type=file]:first');

            $imageUploadFile.click();

            $imageUploadFile.fileupload({
                dataType: 'json',
                autoUpload: false,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                maxFileSize: 5000000,
                previewMaxWidth: 300,
                previewMaxHeight: 300,
                previewCrop: false,

                processalways: function (e, data) {
                    var $file = data.files[data.index];
                    var coordinates;
                    var loadingImage = loadImage(
                        $file,
                        function (image) {
                            $dropZone.html(image);

                            var imageCanvas = $dropZone.find('img, canvas');

                            imageCanvas.Jcrop({
                                trueSize: [imageCanvas[0].width, imageCanvas[0].height],
                                setSelect: [40, 40, imageCanvas[0].width - 40, imageCanvas[0].height - 40],
                                onSelect: function (coords) {
                                    coordinates = coords;
                                },
                                onRelease: function () {
                                    coordinates = null;
                                }
                            });

                            setModalDialogWidth(imageCanvas[0].width + 34);
                        },
                        {
                            maxWidth: $dropZone.width(),
                            maxHeight: $(window).height() - 300,
                            canvas: true
                        } // Options
                    );

                    if (!loadingImage) {
                        $dropZone.html('<span>Your browser does not support the URL or FileReader API.</span>');
                    }
                }
            });
        });
    };


    this.getUploadButton = function () {
        return $uploadButton;
    };

    $modal.on('hidden.bs.modal', function () {
        $uploadButton.unbind();
        resetDropZone();
        resetModalWidth();
    });

    var addImageForm = function ($gallery) {
        var $index = $gallery.data('index');
        var $newImageForm = $gallery.data('prototype').replace(/__name__/g, $index);

        $gallery.data('index', $index + 1);
        $gallery.find('div.images:first').prepend($newImageForm);

        return $newImageForm;
    };

    var setModalDialogWidth = function ($width) {
        $modalDialog.css('width', $width + 'px');
    };

    var resetDropZone = function () {
        $dropZone.html('');
    };

    var resetModalWidth = function () {
        setModalDialogWidth($modalDialogWidth);
    };
}
