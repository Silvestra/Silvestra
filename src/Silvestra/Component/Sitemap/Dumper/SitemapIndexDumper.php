<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Dumper;

use Silvestra\Component\Sitemap\Exception\DumperException;
use Silvestra\Component\Sitemap\Helper\ProfileHelper;
use Silvestra\Component\Sitemap\Profile\ProfileInterface;
use Silvestra\Component\Sitemap\Render\RenderInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 8:14 PM
 */
class SitemapIndexDumper implements DumperInterface
{

    /**
     * @var ProfileHelper
     */
    private $helper;

    /**
     * @var RenderInterface
     */
    private $render;

    /**
     * Constructor.
     *
     * @param ProfileHelper $helper
     * @param RenderInterface $render
     */
    public function __construct(ProfileHelper $helper, RenderInterface $render)
    {
        $this->helper = $helper;
        $this->render = $render;
    }

    /**
     * {@inheritdoc}
     */
    public function dump(ProfileInterface $profile)
    {
        $data = $this->render->renderSitemapIndex($profile->getEntries());
        $path = $this->helper->getSitemapPath($profile);

        if (false === @file_put_contents($path, $data)) {
            throw new DumperException(sprintf('Unable to write file "%s"', $path));
        }
    }
}
