/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$.fn.mediaGallery = function () {
    var $self = $(this);

    $self.each(function () {
        var $gallery = $(this);
        var $addImageButton = $gallery.find('.add-image-button:first');
        var $imageUploadModal = new MediaImageModal();

        $addImageButton.click(function () {
            var $imageWidget = addImageWidget($gallery);
            $imageUploadModal.show($imageWidget);
        });

//        $gallery.on('click', '.silvestra-media-image > .image', function() {
//            $imageUploadModal.show($(this).closest('.silvestra-media-image'), $settings);
//        });
//
//        $gallery.on('click', '.remove-image', function() {
//            removeImageWidget($(this).closest('div.silvestra-media-image'));
//        });
    });

    var addImageWidget = function ($gallery) {
        var $index = $gallery.data('index');
        var $newImageWidget = $($gallery.data('prototype').replace(/__name__/g, $index));

        $gallery.data('index', $index + 1);
        $gallery.find('div.images:first').prepend($newImageWidget);

        return $newImageWidget;
    };

    var removeImageWidget = function ($imageWidget) {
        $imageWidget.remove();
    };
};
