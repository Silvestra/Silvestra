<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Admin\Menu\Event;

use Silvestra\Component\Admin\Admin;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.12.11 18.23
 */
abstract class AdminMenuSubscriber implements EventSubscriberInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     * @param TranslatorInterface $translator
     */
    public function __construct(RouterInterface $router, TranslatorInterface $translator)
    {
        $this->router = $router;
        $this->translator = $translator;
    }

    /**
     * Build admin menu.
     *
     * @param AdminMenuEventInterface $event
     */
    abstract public function build(AdminMenuEventInterface $event);

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(Admin::MENU => 'build');
    }

    /**
     * Generate route.
     *
     * @param string $name
     * @param array $parameters
     *
     * @return string
     */
    protected function generateRoute($name, $parameters = array())
    {
        return $this->router->generate($name, $parameters);
    }

    /**
     * Translate title.
     *
     * @param string $id
     * @param array $parameters
     * @param null|string $domain
     *
     * @return string
     */
    protected function translateTitle($id, array $parameters = array(), $domain = null)
    {
        return $this->translator->trans($id, $parameters, $domain);
    }
}
