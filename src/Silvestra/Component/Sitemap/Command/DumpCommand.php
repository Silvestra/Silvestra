<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Command;

use Silvestra\Component\Sitemap\Dumper\SitemapDumper;
use Silvestra\Component\Sitemap\Dumper\SitemapIndexDumper;
use Silvestra\Component\Sitemap\Entry\SitemapEntry;
use Silvestra\Component\Sitemap\Helper\ProfileHelper;
use Silvestra\Component\Sitemap\Profile\ProfileRegistry;
use Silvestra\Component\Sitemap\Profile\SitemapIndexProfile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 8:53 PM
 */
class DumpCommand extends Command
{
    /**
     * @var ProfileHelper
     */
    private $helper;

    /**
     * @var ProfileRegistry
     */
    private $registry;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var SitemapDumper
     */
    private $sitemapDumper;

    /**
     * @var SitemapIndexDumper
     */
    private $sitemapIndexDumper;

    /**
     * Constructor.
     *
     * @param ProfileHelper $helper
     * @param ProfileRegistry $registry
     * @param RouterInterface $router
     * @param SitemapDumper $sitemapDumper
     * @param SitemapIndexDumper $sitemapIndexDumper
     */
    public function __construct(
        ProfileHelper $helper,
        ProfileRegistry $registry,
        RouterInterface $router,
        SitemapDumper $sitemapDumper,
        SitemapIndexDumper $sitemapIndexDumper
    ) {
        $this->helper = $helper;
        $this->registry = $registry;
        $this->router = $router;
        $this->sitemapDumper = $sitemapDumper;
        $this->sitemapIndexDumper = $sitemapIndexDumper;

        parent::__construct();
    }


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('silvestra:sitemap:dump')
            ->setDescription('Dumps your sitemap(s) to the filesystem (defaults to web/)')
            ->addArgument('host', InputArgument::REQUIRED, 'The full hostname for your website (ie http://www.google.com).')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setHost($input->getArgument('host'));

        $entries = array();
        $now = new \DateTime();

        foreach ($this->registry->getProfiles() as $profile) {
            $this->sitemapDumper->dump($profile);
            $entries[] = new SitemapEntry($this->helper->getSitemapUrl($profile), $now);
        }

        $sitemapIndexProfile = new SitemapIndexProfile($entries);
        $this->sitemapIndexDumper->dump($sitemapIndexProfile);

        $output->writeln(
            '<header>[Sitemap]</header> <body>Sitemap ' .
            $sitemapIndexProfile->getName() .
            ' built in . ' . $this->helper->getSitemapPath($sitemapIndexProfile) . ' </body>'
        );
    }

    private function setHost($host)
    {
        if (1 !== preg_match('#^(https?)://([\w\.-]+)#', $host, $matches)) {
            throw new \InvalidArgumentException(sprintf('The host "%s" is invalid.', $host));
        }

        $context = $this->router->getContext();
        $context->setScheme($matches[1]);
        $context->setHost($matches[2]);
    }
}
