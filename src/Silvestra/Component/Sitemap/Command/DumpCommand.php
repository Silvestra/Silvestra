<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Command;

use Silvestra\Component\Sitemap\Dumper\SitemapFileDumper;
use Silvestra\Component\Sitemap\Helper\ProfileHelper;
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
     * @var SitemapFileDumper
     */
    private $dumper;

    /**
     * @var ProfileHelper
     */
    private $helper;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * Constructor.
     *
     * @param SitemapFileDumper $dumper
     * @param ProfileHelper $helper
     * @param RouterInterface $router
     */
    public function __construct(SitemapFileDumper $dumper, ProfileHelper $helper, RouterInterface $router)
    {
        parent::__construct();

        $this->dumper = $dumper;
        $this->helper = $helper;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('silvestra:sitemap:dump')
            ->setDescription('Dumps your sitemap(s) to the filesystem (defaults to web/)')
            ->addArgument(
                'host',
                InputArgument::REQUIRED,
                'The full hostname for your website (ie http://www.google.com).'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setHost($input->getArgument('host'));

        $this->dumper->dump();

        $output->writeln(sprintf('Finished dump sitemap'));
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
