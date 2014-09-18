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

    this.show = function ($imageWidget, $settings) {
        $modal.modal('show');
        $modalDialogWidth = $modalDialog.width();

        $uploadButton.on('click', function () {
            var $image = new MediaImageUpload($imageWidget, $settings.uploaderConfig);

            $image.click();

            $imageWidget.on('media.pre_upload.image', function($event, $image) {
                $dropZone.html($image);

                var $canvasImage = $dropZone.find('img, canvas');

                if ($settings.cropperEnabled) {
                    var $cropper = new MediaImageUploadCropper($canvasImage, $settings.cropperConfig);
                }

                setModalDialogWidth($canvasImage[0].width + 34);
            });
        });
    };


    this.getUploadButton = function () {
        return $uploadButton;
    };

    $modal.on('hidden.bs.modal', function () {
        $uploadButton.unbind();
        resetDropZone();
        resetModalDialogWidth();
    });

    var setModalDialogWidth = function ($width) {
        $modalDialog.css('width', $width + 'px');
    };

    var resetDropZone = function () {
        $dropZone.html('');
    };

    var resetModalDialogWidth = function () {
        setModalDialogWidth($modalDialogWidth);
    };
}
