<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\AdminBundle\Twig\Extension;

use Silvestra\Component\Admin\Menu\AdminMenuBuilder;
use Silvestra\Component\Admin\Templating\AdminMenuHelperInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.12.11 17.16
 */
class AdminMenuExtension extends \Twig_Extension
{
    /**
     * @var AdminMenuBuilder
     */
    private $builder;

    /**
     * @var AdminMenuHelperInterface
     */
    private $helper;

    /**
     * Constructor.
     *
     * @param AdminMenuBuilder $builder
     * @param AdminMenuHelperInterface $helper
     */
    public function __construct(AdminMenuBuilder $builder, AdminMenuHelperInterface $helper)
    {
        $this->builder = $builder;
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'silvestra_admin_menu_render',
                array($this, 'render'),
                array('is_safe' => array('html'))
            )
        );
    }

    /**
     * Render admin menu.
     *
     * @param null|string $template
     *
     * @return string
     */
    public function render($template = null)
    {
        if (null === $template) {
            $template = 'SilvestraAdminBundle:Menu:vertical_admin_menu.html.twig';
        }

        return $this->helper->render($template, $this->builder->build());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_admin_menu';
    }
}
 