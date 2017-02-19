/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function SitemapContent() {
    var $content = $('div#tadcka-sitemap-content');

    /**
     * Clean content messages.
     */
    this.cleanMessages = function () {
        $content.find('.messages:first').html('');
    };

    /**
     * Delete node.
     *
     * @param {String} $url
     * @param {Function} $callback
     */
    this.deleteNode = function ($url, $callback) {
        $.ajax({
            url: $url,
            type: 'DELETE',
            success: function ($response) {
                if (isObject($response)) {
                    refresh($response);
                } else {
                    $content.html($response);
                }

                $callback($response);

                fadeOff();
            },
            error: function ($request, $status, $error) {
                $content.html($request.responseText);
                fadeOff();
            }
        });
    };

    /**
     * Get active tab.
     *
     * @returns {HTMLElement}
     */
    this.getActiveTab = function () {
        return $(getActiveTabTarget().attr('href'));
    };

    /**
     * Get sitemap content.
     *
     * @returns {HTMLElement}
     */
    this.getContent = function () {
        return $content;
    };

    /**
     * Load content.
     *
     * @param {String} $url
     * @param {HTMLElement} $content
     * @param {Function} $callback
     */
    this.load = function ($url, $content, $callback) {
        fadeOn();

        $.ajax({
            url: $url,
            type: 'GET',
            success: function ($response) {
                if (isObject($response)) {
                    refresh($response);
                } else {
                    $content.html($response);
                }
                $callback($response);

                fadeOff();
            },
            error: function ($request, $status, $error) {
                $content.html($request.responseText);
                fadeOff();
            }
        });
    };

    /**
     * Load first tab content.
     *
     * @param {Function} $callback
     */
    this.loadFirstTab = function ($callback) {
        var $activeTabTarget = getActiveTabTarget();

        this.load($activeTabTarget.data('href'), $($activeTabTarget.attr('href')), $callback);
    };

    /**
     * Submit form.
     *
     * @param {String} $url
     * @param {Array} $data
     * @param {HTMLElement} $content
     * @param {Function} $callback
     */
    this.submit = function ($url, $data, $content, $callback) {
        var formData = new FormData($data[0]);

        fadeOn();
        $.ajax({
            url: $url,
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            success: function ($response) {
                if (isObject($response)) {
                    refresh($response);
                } else {
                    $content.html($response);
                }
                $callback($response);

                fadeOff();
            },
            error: function ($request, $status, $error) {
                $content.html($request.responseText);
                fadeOff();
            }
        });
    };

    /**
     * Fade on.
     */
    var fadeOn = function () {
        $content.fadeTo(300, 0.4);
    };

    /**
     * Fade off.
     */
    var fadeOff = function () {
        $content.fadeTo(0, 1);
    };

    /**
     * Get active tab target.
     *
     * @returns {HTMLElement}
     */
    var getActiveTabTarget = function () {
        return $content.find('.nav-tabs li.active a:first');
    };

    /**
     * Check if is object.
     *
     * @param $object
     *
     * @returns {boolean}
     */
    var isObject = function ($object) {
        return (typeof $object == 'object');
    };

    /**
     * Refresh content.
     *
     * @param {object} $response
     */
    var refresh = function ($response) {
        if ($response.content) {
            $content.html($response.content);
        }

        if ($response.messages) {
            $content.find('.messages:first').html($response.messages);
        } else {
            $content.find('.messages:first').html('');
        }

        if ($response.sub_content) {
            $content.find('.sub-content:first').html($response.sub_content);
        }

        if ($response.tab) {
            $content.find('.tab-content.active.in:first').html($response.tab);
        }

        if ($response.toolbar) {
            $content.find('.tadcka-sitemap-toolbar:first').replaceWith($response.toolbar);
        }
    };
}
