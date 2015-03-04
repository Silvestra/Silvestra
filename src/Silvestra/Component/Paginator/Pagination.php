<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Paginator;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 15.3.4 15.57
 */
class Pagination
{

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $totalCount;

    /**
     * @var int
     */
    private $numItemsPerPage;
    /**
     * @var int
     */
    private $offset = 0;

    /**
     * @var int
     */
    private $itemsInPage = 0;

    /**
     * @var int
     */
    private $pageCount = 1;

    /**
     * Constructor.
     *
     * @param int $currentPage
     * @param int $numItemsPerPage
     * @param int $totalCount
     */
    public function __construct($currentPage, $numItemsPerPage, $totalCount)
    {
        $this->currentPage = $currentPage;
        $this->numItemsPerPage = $numItemsPerPage;
        $this->totalCount = $totalCount;

        $this->init();
    }
    /**
     * Initialize.
     */
    private function init()
    {
        if (0 !== $this->totalCount) {
            $leftItems = $this->totalCount % $this->numItemsPerPage;

            if (1 > $this->currentPage) {
                $this->currentPage = 1;
            }
            $this->offset = ($this->currentPage - 1) * $this->numItemsPerPage;
            if ($this->currentPage === $this->getPageCount() && $leftItems > 0) {
                $this->itemsInPage = $leftItems;
            } else {
                $this->itemsInPage = $this->numItemsPerPage;
            }
        }
    }
    /**
     * Get total items.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }
    /**
     * Get items per page.
     *
     * @return int
     */
    public function getNumItemsPerPage()
    {
        return $this->numItemsPerPage;
    }
    /**
     * Get current page.
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }
    /**
     * Get page count.
     *
     * @return int
     */
    public function getPageCount()
    {
        return intval(ceil($this->totalCount / $this->numItemsPerPage));
    }
    /**
     * Get items in page.
     *
     * @return int
     */
    public function getItemsInPage()
    {
        return $this->itemsInPage;
    }
    /**
     * Get first item offset.
     *
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }
    /**
     * Is this page last.
     *
     * @return bool
     */
    public function isLastPage()
    {
        return (int)$this->currentPage === (int)$this->pageCount;
    }
    /**
     * Is this page first.
     *
     * @return bool
     */
    public function isFirstPage()
    {
        return (int)$this->currentPage === 1;
    }
}
