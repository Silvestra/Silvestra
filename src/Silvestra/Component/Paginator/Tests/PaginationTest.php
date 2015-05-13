<?php

/*
 * This file is part of the Evispa package.
 *
 * (c) Evispa <info@evispa.lt>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Paginator\Tests;

use PHPUnit_Framework_TestCase as TestCase;
use Silvestra\Component\Paginator\Pagination;

/**
 * @author Tadas Gliaubicas <tadas@evispa.lt>
 *
 * @since 15.3.26 14.29
 */
class PaginationTest extends TestCase
{
    public function testPagination_WithFirstPage()
    {
        $pagination = new Pagination(1, 1, 5);
        foreach ($pagination as $page) {
            if (1 === $page['page']) {
                $this->assertTrue($page['active']);
                $this->assertTrue($page['first']);
                $this->assertFalse($page['last']);
            }
        }

        $this->assertEquals(0, $pagination->getOffset());
    }

    public function testPagination_WithMiddlePage()
    {
        $pagination = new Pagination(3, 1, 5);
        foreach ($pagination as $page) {
            if (3 === $page['page']) {
                $this->assertTrue($page['active']);
                $this->assertFalse($page['first']);
                $this->assertFalse($page['last']);
            }
        }

        $this->assertEquals(2, $pagination->getOffset());
    }

    public function testPagination_WithLastPage()
    {
        $pagination = new Pagination(5, 1, 5);
        foreach ($pagination as $page) {
            if (5 === $page['page']) {
                $this->assertTrue($page['active']);
                $this->assertFalse($page['first']);
                $this->assertTrue($page['last']);
            }
        }

        $this->assertEquals(4, $pagination->getOffset());
    }
}
