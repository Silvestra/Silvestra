<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Tests\Mock\Model\Manager;

use Tadcka\Component\Routing\Model\RouteInterface;
use Tadcka\Component\Tree\Model\Manager\NodeTranslationManager;
use Tadcka\Component\Tree\Model\NodeTranslationInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.7.19 17.43
 */
class MockNodeTranslationManager extends NodeTranslationManager
{
    /**
     * @var array|NodeTranslationInterface[]
     */
    private $translations = array();

    /**
     * {@inheritdoc}
     */
    public function findByNodeId($nodeId, $lang)
    {
        // TODO: Implement findByNodeId() method.
    }

    /**
     * {@inheritdoc}
     */
    public function findManyByNodeId($nodeId)
    {
        // TODO: Implement findManyByNodeId() method.
    }

    /**
     * {@inheritdoc}
     */
    public function findByRoute(RouteInterface $route)
    {
        foreach ($this->translations as $translation) {
            if ((null !== $translation->getRoute()) && ($route->getId() === $translation->getRoute()->getId())) {
                return $translation;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function add(NodeTranslationInterface $translation, $save = false)
    {
        $this->translations[] = $translation;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(NodeTranslationInterface $translation, $save = false)
    {
        // TODO: Implement delete() method.
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        // TODO: Implement save() method.
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        // TODO: Implement clear() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return  'Silvestra\Bundle\NodeBundle\Tests\Mock\Model\MockNodeTranslation';
    }
}
