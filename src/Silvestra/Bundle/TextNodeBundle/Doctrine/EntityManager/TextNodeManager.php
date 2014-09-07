<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadcka <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\TextNodeBundle\Doctrine\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Tadcka\Bundle\SitemapBundle\Model\NodeInterface;
use Silvestra\Bundle\TextNodeBundle\Model\TextNodeInterface;
use Silvestra\Bundle\TextNodeBundle\Model\Manager\TextNodeManager as BaseTextNodeManager;

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
    public function findTextNodeByNode(NodeInterface $node)
    {
        return $this->repository->findOneBy(array('node' => $node));
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
