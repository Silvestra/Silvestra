/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function MediaImageUploadModal($widget) {
    var $modal = $widget.find('.image-upload-modal:first');

    this.show = function ($imageWidget, $settings) {
        $modal.modal('show');
    };
}
