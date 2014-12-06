/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$.fn.mediaImage = function () {
    var $self = $(this);

    $self.each(function () {
        var $image = $(this);
        console.log($image);
        var $imageUploadModal = new MediaImageModal();

        $image.click(function () {
            $imageUploadModal.show($image);
        });

//        $gallery.on('click', '.silvestra-media-image > .image', function() {
//            $imageUploadModal.show($(this).closest('.silvestra-media-image'), $settings);
//        });
//
//        $gallery.on('click', '.remove-image', function() {
//            removeImageWidget($(this).closest('div.silvestra-media-image'));
//        });
    });

    var removeImageWidget = function ($imageWidget) {
        $imageWidget.remove();
    };
};