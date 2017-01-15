<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadcka <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\Text\NodeBundle\Doctrine\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Silvestra\Bundle\Text\NodeBundle\Model\Manager\TextNodeManager as BaseTextNodeManager;
use Silvestra\Bundle\Text\NodeBundle\Model\TextNodeInterface;
use Tadcka\Component\Tree\Model\NodeInterface;

class TextNodeManager extends BaseTextNodeManager
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
    public function findTextByNode(NodeInterface $node)
    {
        $textNode = $this->findTextNodeByNode($node);

        if (null === $textNode) {
            return null;
        }

        return $textNode->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function findTextNodeByNode(NodeInterface $node)
    {
        $qb = $this->repository->createQueryBuilder('tn');

        $qb
            ->select('tn, t, tr')
            ->innerJoin('tn.text', 't')
            ->leftJoin('t.translations', 'tr')
            ->where($qb->expr()->eq('tn.node', ':node'))
            ->setParameter('node', $node);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function add(TextNodeInterface $textNode, $save = false)
    {
        $this->em->persist($textNode);
        if (true === $save) {
            $this->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove(TextNodeInterface $textNode, $save = false)
    {
        $this->em->remove($textNode);
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
