<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\AdminBundle\Twig;

use Silvestra\Component\Admin\Templating\AdminMenuHelperInterface;
use Symfony\Component\Templating\Helper\Helper as TemplatingHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.12.11 17.03
 */
class AdminMenuHelper extends TemplatingHelper implements AdminMenuHelperInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * Constructor.
     *
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function render($name, array $menu)
    {
        return $this->twig->render($name, array('menu' => $menu));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_admin_menu';
    }
}
