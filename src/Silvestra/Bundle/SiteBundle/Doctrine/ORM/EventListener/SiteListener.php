<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SiteBundle\Doctrine\ORM\EventListener;

use Doctrine\ORM\EntityManager;
use Silvestra\Component\Site\Model\SiteInterface;
use Silvestra\Component\Site\SiteEvent;
use Silvestra\Component\Site\SiteEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/18/15 10:50 PM
 */
class SiteListener implements EventSubscriberInterface
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(SiteEvents::EDIT_SUCCESS => 'deleteDoctrineCache');
    }

    /**
     * Delete doctrine cache.
     *
     * @param SiteEvent $event
     */
    public function deleteDoctrineCache(SiteEvent $event)
    {
        if ($cacheImpl = $this->em->getConfiguration()->getResultCacheImpl()) {
            $cacheImpl->delete(SiteInterface::SITE);
        }
    }
}
