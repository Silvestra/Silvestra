/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$.fn.mediaGallery = function () {
    var $gallery = $(this);
    var $imageUploadModal = new MediaImageUploadModal();
    var $addImageButton = $('a#add-image-button');

    $gallery.data('index', $gallery.find(':input').length);

    $gallery.on('click', $addImageButton, function () {
        $imageUploadModal.show();
    });

    $imageUploadModal.getUploadButton().on('click', function () {
        var $imageForm = $(addImageForm());
        var $imageInput = $imageForm.find(':input[type=file]:first');

        console.log($imageInput);
    });

    function addImageForm() {
        var $prototype = $gallery.data('prototype');
        var $index = $gallery.data('index');
        var $newImageForm = $prototype.replace(/__name__/g, $index);

        $gallery.data('index', $index + 1);
        $gallery.find('div.images:first').prepend($newImageForm);

        return $newImageForm;
    }
};
