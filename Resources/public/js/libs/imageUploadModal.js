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
    var $uploadButton = $modal.find('a.image-upload-button:first');
    var $progressBar = $modal.find('div.progress-bar:first');

    this.show = function () {
        $modal.modal('show');
    };

    this.getUploadButton = function () {
        return $uploadButton;
    };

    this.getProgressBar = function () {
        return $progressBar;
    };
}
