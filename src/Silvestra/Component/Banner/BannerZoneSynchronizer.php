<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner;

use Silvestra\Component\Banner\Event\BannerEvents;
use Silvestra\Component\Banner\Event\BannerZoneEvent;
use Silvestra\Component\Banner\Model\BannerZoneInterface;
use Silvestra\Component\Banner\Model\Manager\BannerZoneManagerInterface;
use Silvestra\Component\Banner\Registry\BannerZoneConfig;
use Silvestra\Component\Banner\Registry\BannerZoneRegistry;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/31/15 11:12 PM
 */
class BannerZoneSynchronizer
{

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var BannerZoneManagerInterface
     */
    private $manager;

    /**
     * @var BannerZoneRegistry
     */
    private $registry;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param BannerZoneManagerInterface $manager
     * @param BannerZoneRegistry $registry
     * @param TranslatorInterface $translator
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        BannerZoneManagerInterface $manager,
        BannerZoneRegistry $registry,
        TranslatorInterface $translator
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->manager = $manager;
        $this->registry = $registry;
        $this->translator = $translator;
    }

    /**
     * Synchronize system banner zones.
     *
     * @param string $locale
     */
    public function synchronize($locale)
    {
        $existingSystemZones = $this->manager->findSystemSlugs();

        $newZones = array();
        foreach ($this->registry->getConfigs() as $config) {
            if (false === in_array($config->getSlug(), $existingSystemZones)) {
                $zone = $this->createZone($config);
                $this->eventDispatcher->dispatch(BannerEvents::CREATE, new BannerZoneEvent($zone, $locale));

                $newZones[] = $zone;
            }
        }

        if (0 < count($newZones)) {
            $this->manager->save();
        }
    }

    /**
     * Create banner zone.
     *
     * @param BannerZoneConfig $config
     *
     * @return BannerZoneInterface
     */
    private function createZone(BannerZoneConfig $config)
    {
        list($width, $height) = $config->getSize();
        $zone = $this->manager->create();
        $name = $config->getName();

        if ($config->getTranslationDomain()) {
            $name = $this->translator->trans($name, array(), $config->getTranslationDomain());
        }
        $zone->setName($name);
        $zone->setCode($config->getSlug());
        $zone->setSlug($config->getSlug());
        $zone->setWidth($width);
        $zone->setHeight($height);
        $zone->setSystem(true);

        $this->manager->add($zone);

        return $zone;
    }
}
