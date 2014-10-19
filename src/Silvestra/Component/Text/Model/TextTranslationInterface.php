<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Text\Model;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
interface TextTranslationInterface
{
    /**
     * Set language.
     *
     * @param string $lang
     *
     * @return TextTranslationInterface
     */
    public function setLang($lang);

    /**
     * Get language.
     *
     * @return string
     */
    public function getLang();

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return TextTranslationInterface
     */
    public function setTitle($title);

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return TextTranslationInterface
     */
    public function setContent($content);

    /**
     * @return string
     */
    public function getContent();

    /**
     * Set text.
     *
     * @param TextInterface $text
     *
     * @return TextTranslationInterface
     */
    public function setText(TextInterface $text);

    /**
     * Get text.
     *
     * @return TextInterface
     */
    public function getText();
}
