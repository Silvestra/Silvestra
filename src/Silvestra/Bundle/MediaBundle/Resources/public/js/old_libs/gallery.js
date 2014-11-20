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
    var $imageUploadModal = new MediaImageUploadModal();

    $self.each(function () {
        var $gallery = $(this);
        var $addImageButton = $gallery.find('a.add-image-button:first');
        var $settings = $gallery.data('settings');

        $gallery.data('index', $gallery.find(':input').length);

        $addImageButton.click(function () {
            $imageUploadModal.show(addImageWidget($gallery), $settings);
        });

        $gallery.on('click', 'div.silvestra-media-image > .image', function() {

            $imageUploadModal.show($(this).closest('div.silvestra-media-image'), $settings);
        });

        $gallery.on('click', 'span.remove-image', function() {
            removeImageWidget($(this).closest('div.silvestra-media-image'));
        });
    });

    var addImageWidget = function ($gallery) {
        var $index = $gallery.data('index');
        var $newImageWidget = $($gallery.data('prototype').replace(/__name__/g, $index));

        $newImageWidget.hide();
        $gallery.data('index', $index + 1);
        $gallery.find('div.images:first').prepend($newImageWidget);

        return $newImageWidget;
    };

    var removeImageWidget = function ($imageWidget) {
        $imageWidget.remove();
    };
};
