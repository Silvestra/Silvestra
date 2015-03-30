<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Dumper;

use Silvestra\Component\Sitemap\Entry\SitemapEntry;
use Silvestra\Component\Sitemap\Entry\UrlEntryInterface;
use Silvestra\Component\Sitemap\Exception\DumperException;
use Silvestra\Component\Sitemap\Helper\ProfileHelper;
use Silvestra\Component\Sitemap\Profile\ProfileInterface;
use Silvestra\Component\Sitemap\Profile\ProfileRegistry;
use Silvestra\Component\Sitemap\Render\RenderInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 8:42 PM
 */
class SitemapDumper implements DumperInterface
{

    const NAME = 'sitemap.xml';

    /**
     * @var ProfileHelper
     */
    private $helper;

    /**
     * @var int
     */
    private $maxPerSitemap;

    /**
     * @var ProfileRegistry
     */
    private $registry;

    /**
     * @var RenderInterface
     */
    private $render;

    /**
     * Constructor.
     *
     * @param ProfileHelper $helper
     * @param int $maxPerSitemap
     * @param ProfileRegistry $registry
     * @param RenderInterface $render
     */
    public function __construct(
        ProfileHelper $helper,
        $maxPerSitemap,
        ProfileRegistry $registry,
        RenderInterface $render
    ) {
        $this->maxPerSitemap = $maxPerSitemap;
        $this->helper = $helper;
        $this->registry = $registry;
        $this->render = $render;
    }

    /**
     * {@inheritdoc}
     */
    public function dump()
    {
        $sitemapEntries = array();

        foreach ($this->registry->getProfiles() as $profile) {
            $sitemapEntries = array_merge($sitemapEntries, $this->getSitemapEntries($profile));
        }

        $this->writeFile(
            $this->helper->getFilePath(self::NAME),
            $this->render->renderSitemapIndex($sitemapEntries)
        );
    }


    /**
     * Get sitemap entries.
     *
     * @param ProfileInterface $profile
     *
     * @return array|SitemapEntry[]
     */
    private function getSitemapEntries(ProfileInterface $profile)
    {
        $now = new \DateTime();
        $urlEntries = $profile->getUrlEntries();
        $numberOfSitemap = $this->getNumberOfSitemap($urlEntries);

        if (1 === $numberOfSitemap) {
            $this->writeFile(
                $this->helper->getFilePath($this->getFilename($profile)),
                $this->render->renderSitemap($urlEntries)
            );

            return array(new SitemapEntry($this->helper->getFileUrl($this->getFilename($profile)), $now));
        }


        $sitemapEntries = array();

        for ($number = 0; $number < $numberOfSitemap; $number++) {
            $filename = $this->getFilename($profile, $number);
            $entries = array_slice($urlEntries, $number * $this->maxPerSitemap, $this->maxPerSitemap);

            $this->writeFile($this->helper->getFilePath($filename), $this->render->renderSitemap($entries));

            $sitemapEntries[] = new SitemapEntry($this->helper->getFileUrl($filename), $now);
        }

        return $sitemapEntries;
    }

    /**
     * Get number of sitemap.
     *
     * @param array|UrlEntryInterface[] $urlEntries
     *
     * @return int
     */
    private function getNumberOfSitemap(array $urlEntries)
    {
        $total = count($urlEntries);

        if ($total <= $this->maxPerSitemap) {
            return 1;
        }

        return intval(ceil($total / $this->maxPerSitemap));
    }

    /**
     * Get filename.
     *
     * @param ProfileInterface $profile
     * @param null|int $number
     *
     * @return string
     */
    private function getFilename(ProfileInterface $profile, $number = null)
    {
        if (null === $number) {
            return $profile->getName() . '.xml';
        }

        return $profile->getName() . '-' . $number . '.xml';
    }

    /**
     * Write file.
     *
     * @param string $path
     * @param string $data
     *
     * @throws DumperException
     */
    private function writeFile($path, $data)
    {
        if (false === @file_put_contents($path, $data)) {
            throw new DumperException(sprintf('Unable to write file "%s"', $path));
        }
    }
}
