/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function SitemapTree() {
    var $tree = $('div#tadcka-sitemap-tree');

    var $jsTree = $tree
        .jstree({
            'core': {
                'check_callback' : true,
                'data': {
                    'url': function ($node) {
                        return $node.id === '#'
                            ? Routing.generate('silvestra_node_tree_node_root', {_format: 'json'})
                            : Routing.generate('silvestra_node_tree_node_children', {_format: 'json', nodeId: $node.id});
                    }
                }
            }
        });

    /**
     * Get jsTree.
     *
     * @returns {Object}
     */
    this.getJsTree = function () {
        return $jsTree;
    };

    /**
     * Deselect node.
     *
     * @param {Object} $node
     */
    this.deselectNode = function ($node) {
        $tree.jstree(true).deselect_node($node, true);
    };

    /**
     * Open node.
     *
     * @param {Object} $node
     */
    this.openNode = function ($node) {
        $tree.jstree(true).open_node($node);
    };

    /**
     * Get parent.
     *
     * @param {Object} $node
     */
    this.getParent = function ($node) {
        return $tree.jstree(true).get_parent($node)
    };

    /**
     * Refresh node.
     *
     * @param {Object} $node
     */
    this.refreshNode = function ($node) {
        $tree.jstree(true).refresh_node($node);
    };

    /**
     * Rename node.
     *
     * @param {Object} $node
     */
    this.renameNode = function ($node) {
        getNode($node, function($response) {
            $tree.jstree(true).rename_node($node, $response.text);
        });
    };

    /**
     * Select node.
     *
     * @param {Object} $node
     */
    this.selectNode = function ($node) {
        $tree.jstree(true).select_node($node, true, false);
    };

    /**
     * Get node.
     *
     * @param {Object} $node
     * @param {Function} $callback
     */
    var getNode = function ($node, $callback) {
        if ($node && $node.id) {
            $.ajax({
                url: Routing.generate('silvestra_node_tree_node', {_format: 'json', nodeId: $node.id}),
                type: 'GET',
                success: function ($response) {
                    $callback($response);
                },
                error: function ($request, $status, $error) {
                    console.log($request.responseText);
                }
            });
        }
    };
}
