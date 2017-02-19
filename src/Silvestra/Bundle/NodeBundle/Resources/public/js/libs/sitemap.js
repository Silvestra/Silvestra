/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$.fn.sitemap = function () {
    var $currentNode = null;
    var $currentNodeId = null;

    var $content = new SitemapContent();
    var $tree = new SitemapTree();

    /**
     * Triggered when an node is clicked or intercated with by the user. Load content.
     */
    $tree.getJsTree().on('activate_node.jstree', function ($event, $data) {
        if (!$currentNode || $data.node && (($currentNodeId !== $data.node.id))) {
            $currentNode = $data.node;
            $currentNodeId = $currentNode.id;

            loadContent($currentNodeId, function () {});
        }
    });

    /**
     * Load current toolbar content.
     */
    $content.getContent().on('click', 'div.tadcka-sitemap-toolbar a.load', function ($event) {
        $event.preventDefault();
        $content.load($(this).attr('href'), $content.getContent().find('div.sub-content:first'), function () {});
    });

    /**
     * Load current tab content.
     */
    $content.getContent().on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
        var $currentTabTarget = $(e.target);
        var $tabContent = $($currentTabTarget.attr('href'));

        if ($tabContent.is(':empty')) {
            $content.load($currentTabTarget.data('href'), $tabContent, function () {
                $tabContent.find('.silvestra-tag').tagging();
            });
        }

        $content.cleanMessages();
    });

    /**
     * Submit form.
     */
    $content.getContent().on('submit', 'form', function ($event) {
        $event.preventDefault();

        var $form = $(this);
        var $button = $form.find('button:first');

        $button.attr('disabled', 'disabled');
        if ($content.getContent().find('.tab-content:first').length) {
            var $tabContent = $content.getActiveTab();

            $content.submit($form.attr('action'), $form, $tabContent, function () {
                var $parent = $tree.getParent($currentNode);

                if ('#' !== $parent) {
                    $tree.refreshNode($parent);
                } else {
                    $tree.renameNode($currentNode);
                }
                $button.attr('disabled', '');
                $tabContent.find('.silvestra-tag').tagging();
            });
        } else {
            $content.submit($form.attr('action'), $form, $content.getContent(), function ($response) {
                if ($response.node_id) {
                    $currentNodeId = $response.node_id;
                    var $url = Routing.generate('silvestra_node_node_content', {_format: 'json', nodeId: $currentNodeId});

                    $tree.refreshNode($currentNode);
                    $content.load($url, $content.getContent(), function () {
                        $tree.openNode($currentNode);
                        $tree.deselectNode($currentNode);

                        $content.loadFirstTab(function () {
                            if ($response.messages) {
                                $content.getContent().find('.messages:first').html($response.messages);
                            }
                        });
                    });
                }

                $button.attr('disabled', '');
            });
        }
    });

    /**
     * Delete node.
     */
    $content.getContent().on('click', 'a#tadcka-tree-node-delete-confirm', function ($event) {
        $event.preventDefault();
        $content.deleteNode($(this).attr('href'), function () {
            var $parent = $tree.getParent($currentNode);

            $tree.refreshNode($parent);
        });
    });

    /**
     * Cancel delete.
     */
    $content.getContent().on('click', 'a#tadcka-tree-node-delete-cancel', function() {
        loadContent($currentNodeId, function () {
            $tree.selectNode($currentNode);
        });
    });

    /**
     * Triggered when a node is refreshed. Select current node.
     */
    $tree.getJsTree().on('refresh_node.jstree', function ($event, $data) {
        $tree.selectNode($currentNodeId);
    });

    /**
     * Load content.
     *
     * @param {Number} $nodeId
     * @param {Function} $callback
     */
    var loadContent = function ($nodeId, $callback) {
        var $url = Routing.generate('silvestra_node_node_content', {_format: 'json', nodeId: $nodeId});

        $content.load($url, $content.getContent(), function () {
            $content.loadFirstTab($callback);
        });
    };
};
