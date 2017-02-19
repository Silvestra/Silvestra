<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Doctrine\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Tadcka\Component\Tree\Model\Manager\TreeManager as BaseTreeManager;
use Tadcka\Component\Tree\Model\TreeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/6/14 11:02 AM
 */
class TreeManager extends BaseTreeManager
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
    public function findTreeBySlug($slug)
    {
        return $this->repository->findOneBy(array('slug' => $slug));
    }

    /**
     * {@inheritdoc}
     */
    public function findManyTreeBySlugs(array $slugs)
    {
        return $this->repository->findBy(array('slug' => $slugs));
    }

    /**
     * {@inheritdoc}
     */
    public function add(TreeInterface $tree, $save = false)
    {
        $this->em->persist($tree);
        if (true === $save) {
            $this->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove(TreeInterface $tree, $save = false)
    {
        $this->em->remove($tree);
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
        return $this->em->clear($this->getClass());
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}
