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
        var $addImageButton = $gallery.find('a#add-image-button:first');

        $gallery.data('index', $gallery.find(':input').length);

        $gallery.on('click', $addImageButton, function () {
            $imageUploadModal.show($gallery);
        });
    });
};
