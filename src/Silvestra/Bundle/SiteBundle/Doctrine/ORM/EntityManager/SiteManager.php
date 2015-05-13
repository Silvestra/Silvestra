<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SiteBundle\Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Silvestra\Component\Site\Model\SiteInterface;
use Silvestra\Component\Site\Model\Manager\SiteManager as BaseSiteManager;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class SiteManager extends BaseSiteManager
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor.
     *
     * @param EntityManager $em
     * @param string $class
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($class);
        $this->class = $em->getClassMetadata($class)->name;
    }

    /**
     * {@inheritdoc}
     */
    public function find()
    {
        $qb = $this->repository->createQueryBuilder('s');

        $qb->leftJoin('s.seoMetadata', 'sm');
        $qb->setMaxResults(1);
        $qb->select('s, sm');

        $q = $qb->getQuery();
        $q->useResultCache(true, 3600, SiteInterface::SITE);

        return $q->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function add(SiteInterface $site, $save = false)
    {
        $this->em->persist($site);
        if (true === $save) {
            $this->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove(SiteInterface $site, $save = false)
    {
        $this->em->remove($site);
        if (true === $save) {
            $this->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->em->clear($this->getClass());
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}
