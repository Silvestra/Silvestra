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
use Silvestra\Component\Sitemap\Exception\DumperException;
use Silvestra\Component\Sitemap\Helper\ProfileHelper;
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
     * @param ProfileRegistry $registry
     * @param RenderInterface $render
     */
    public function __construct(ProfileHelper $helper, ProfileRegistry $registry, RenderInterface $render)
    {
        $this->helper = $helper;
        $this->registry = $registry;
        $this->render = $render;
    }

    /**
     * {@inheritdoc}
     */
    public function dump()
    {
        $entries = array();
        $now = new \DateTime();

        foreach ($this->registry->getProfiles() as $profile) {
            $this->writeFile(
                $this->helper->getFilePath($profile->getName()),
                $this->render->renderSitemap($profile->getUrlEntries())
            );

            $entries[] = new SitemapEntry($this->helper->getFileUrl($profile->getName()), $now);
        }

        $this->writeFile(
            $this->helper->getFilePath(self::NAME),
            $this->render->renderSitemapIndex($entries)
        );
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
