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
use Tadcka\Component\Routing\Model\RouteInterface;
use Tadcka\Component\Tree\Model\Manager\NodeTranslationManager as BaseNodeTranslationManager;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\Model\NodeTranslationInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.6.29 20.49
 */
class NodeTranslationManager extends BaseNodeTranslationManager
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
    public function findTranslationByNodeAndLang(NodeInterface $node, $lang)
    {
        return $this->repository->findOneBy(array('node' => $node, 'lang' => $lang));
    }

    /**
     * {@inheritdoc}
     */
    public function findManyTranslationsByNode(NodeInterface $node)
    {
        return $this->repository->findBy(array('node' => $node));
    }

    /**
     * {@inheritdoc}
     */
    public function findTranslationByRoute(RouteInterface $route)
    {
        return $this->repository->findOneBy(array('route' => $route));
    }

    /**
     * {@inheritdoc}
     */
    public function findNodeAllChildrenTranslationsByLang(NodeInterface $node, $lang)
    {
        $qb = $this->repository->createQueryBuilder('t');

        $qb->innerJoin('t.node', 'n');
        $qb->andWhere($qb->expr()->eq('t.lang', ':locale'));
        $qb->setParameter('locale', $lang);

        $qb->andWhere($qb->expr()->eq('n.root', ':root'))
            ->setParameter('root', $node->getRoot());

        $qb->andWhere($qb->expr()->gte('n.left', ':left'))
            ->setParameter('left', $node->getLeft());

        $qb->andWhere($qb->expr()->lte('n.right', ':right'))
            ->setParameter('right', $node->getRight());

        $qb->select('t');

        return $qb->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function add(NodeTranslationInterface $translation, $save = false)
    {
        $this->em->persist($translation);
        if (true === $save) {
            $this->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove(NodeTranslationInterface $translation, $save = false)
    {
        $this->em->remove($translation);
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
        $this->em->remove($this->getClass());
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}
