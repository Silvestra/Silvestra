<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Provider;

use Silvestra\Component\Banner\Model\Manager\BannerZoneManagerInterface;
use Silvestra\Component\Banner\Registry\BannerZoneConfig;
use Silvestra\Component\Banner\Registry\BannerZoneRegistry;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/5/14 10:42 PM
 */
class BannerZoneProvider implements BannerZoneProviderInterface
{
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
     * @param BannerZoneManagerInterface $manager
     * @param BannerZoneRegistry $registry
     * @param TranslatorInterface $translator
     */
    public function __construct(
        BannerZoneManagerInterface $manager,
        BannerZoneRegistry $registry,
        TranslatorInterface $translator
    ) {
        $this->manager = $manager;
        $this->registry = $registry;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigChoices($slug)
    {
        $existingSlugs = $this->manager->findExistingSlugs();
        $list = array();

        foreach ($this->registry->getConfigs() as $config) {
            if (($slug && ($slug === $config->getSlug())) || !in_array($config->getSlug(), $existingSlugs)) {
                $list[$config->getSlug()] = $this->getConfigName($config);
            }
        }

        return $list;
    }


    /**
     * Get banner zone config name.
     *
     * @param BannerZoneConfig $config
     *
     * @return string
     */
    private function getConfigName(BannerZoneConfig $config)
    {
        $name = $config->getName();

        if ($domain = $config->getTranslationDomain()) {
            $name = $this->translator->trans($name, array(), $domain);
        }

        return $name;
    }
}
