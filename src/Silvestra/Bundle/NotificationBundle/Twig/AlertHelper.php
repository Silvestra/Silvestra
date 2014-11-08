<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NotificationBundle\Twig;

use Silvestra\Component\Notification\Templating\AlertHelperInterface;
use Symfony\Component\Templating\Helper\Helper as TemplatingHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/8/14 12:36 PM
 */
class AlertHelper extends TemplatingHelper implements AlertHelperInterface
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
    public function render($template, array $context = array())
    {
        return $this->twig->render($template, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_alert';
    }
}
