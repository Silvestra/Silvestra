<?php

/*
 * This file is part of the Evispa package.
 *
 * (c) Evispa <info@evispa.lt>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Paginator;

/**
 * @author Tadas Gliaubicas <tadas@evispa.lt>
 *
 * @since 15.3.26 14.16
 */
class Pagination implements \Iterator
{

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $perPage;

    /**
     * @var int
     */
    private $pageCount;

    /**
     * @var int
     */
    private $totalCount;


    /**
     * @var int
     */
    private $page;

    /**
     * Constructor.
     *
     * @param int $currentPage
     * @param int $perPage
     * @param int $totalCount
     */
    public function __construct($currentPage, $perPage, $totalCount)
    {
        $this->currentPage = $currentPage;
        $this->perPage = $perPage;
        $this->totalCount = $totalCount;

        $this->pageCount = intval(ceil($totalCount/ $perPage));
    }


    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return array(
            'active' => $this->currentPage === $this->page,
            'first' => 1 === $this->page,
            'last' => $this->totalCount === $this->page,
            'page' => $this->page,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->page++;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->page;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->pageCount >= $this->page;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->page = 1;
    }

    /**
     * Get pagination current page.
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Get pagination per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Get pagination offset.
     *
     * @return int
     */
    public function getOffset()
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    /**
     * Get pagination page count.
     *
     * @return int
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * Get pagination total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }
}
