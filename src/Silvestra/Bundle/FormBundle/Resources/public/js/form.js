/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$(document).ready(function () {
    $(document).on('click', '.silvestra-key-value > .silvestra-add', function (e) {
        e.preventDefault();
        silvestraAddKeyValueRow($(this).closest('.silvestra-key-value'));
    });

    $(document).on('click', '.silvestra-key-value .silvestra-delete', function (e) {
        e.preventDefault();
        $(this).closest('.silvestra-row').remove();
    });

    $('.silvestra-tag').tagging();
});


function silvestraAddKeyValueRow($collectionHolder) {
    var $prototype = $collectionHolder.data('prototype');
    var $index = parseInt($collectionHolder.data('index'));
    var $newForm = $prototype.replace(/__name__/g, $index);

    $collectionHolder.data('index', $index + 1);
    $collectionHolder.append($newForm);
}