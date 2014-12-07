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
        var $imageWidget = $(this);
        var $imageUploadModal = new MediaImageModal();

        $imageWidget.on('click', '.image', function () {
            $imageUploadModal.show($imageWidget);
        });

        $imageWidget.on('click', '.remove-image', function() {
            $imageWidget.find('.silvestra-image-filename:first').val('');
            $(this).hide();
            $imageWidget.find('img:first').attr('src', $imageWidget.data('noimage'));
        });
    });
};