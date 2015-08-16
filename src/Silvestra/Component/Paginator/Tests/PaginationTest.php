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
            if (1 === $page) {
                $this->assertTrue($pagination->isActivePage());
            } else {
                $this->assertFalse($pagination->isActivePage());
            }
        }

        $this->assertEquals(0, $pagination->getOffset());
        $this->assertTrue($pagination->isFirstPage());
        $this->assertFalse($pagination->isLastPage());
    }

    public function testPagination_WithMiddlePage()
    {
        $pagination = new Pagination(3, 1, 5);
        foreach ($pagination as $page) {
            if (3 === $page) {
                $this->assertTrue($pagination->isActivePage());
            } else {
                $this->assertFalse($pagination->isActivePage());
            }
        }

        $this->assertEquals(2, $pagination->getOffset());
        $this->assertFalse($pagination->isFirstPage());
        $this->assertFalse($pagination->isLastPage());
    }

    public function testPagination_WithLastPage()
    {
        $pagination = new Pagination(5, 1, 5);
        foreach ($pagination as $page) {
            if (5 === $page) {
                $this->assertTrue($pagination->isActivePage());
            } else {
                $this->assertFalse($pagination->isActivePage());
            }
        }

        $this->assertEquals(4, $pagination->getOffset());
        $this->assertFalse($pagination->isFirstPage());
        $this->assertTrue($pagination->isLastPage());
    }

    public function testPagination_WithTooMuchCurrentPage()
    {
        $pagination = new Pagination(3, 2, 4);

        $this->assertEquals(2, $pagination->getCurrentPage());
    }

    public function testPagination_WithZeroTotalCount()
    {
        $pagination = new Pagination(1, 2, 0);

        $this->assertEquals(1, $pagination->getCurrentPage());
        $this->assertEquals(0, $pagination->getOffset());
    }

    public function testPagination_WithNegativeCurrentPage()
    {
        $pagination = new Pagination(-2, 2, 0);

        $this->assertEquals(1, $pagination->getCurrentPage());
        $this->assertEquals(0, $pagination->getOffset());
    }
}
