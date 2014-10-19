<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Text\Model\Manager;

use Silvestra\Component\Text\Model\TextInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
interface TextManagerInterface
{
    /**
     * Find text by slug and locale.
     *
     * @param string $slug
     * @param string $locale
     *
     * @return null|TextInterface
     */
    public function findTextBySlugAndLocale($slug, $locale);

    /**
     * Create text.
     *
     * @return TextInterface
     */
    public function create();

    /**
     * Save text.
     *
     * @param TextInterface $text
     * @param bool $save
     */
    public function add(TextInterface $text, $save = false);

    /**
     * Remove text.
     *
     * @param TextInterface $text
     * @param bool $save
     */
    public function remove(TextInterface $text, $save = false);

    /**
     * Save persisted layer.
     */
    public function save();

    /**
     * Clear persisted layer.
     */
    public function clear();

    /**
     * Get class text model.
     *
     * @return string
     */
    public function getClass();
}
