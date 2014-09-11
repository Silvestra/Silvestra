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

    this.show = function () {
        $modal.modal('show');
    };
}
