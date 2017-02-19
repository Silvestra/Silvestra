<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Tests\Mock\Model;

use Tadcka\Component\Tree\Model\NodeTranslation;
use Tadcka\Component\Tree\Model\NodeTranslationInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 7/21/14 12:07 AM
 */
class MockNodeTranslation extends NodeTranslation
{
    /**
     * Set id.
     *
     * @param int $id
     *
     * @return NodeTranslationInterface
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
