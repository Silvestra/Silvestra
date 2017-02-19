<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Frontend\Message;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since  14.7.19 14.36
 */
class Messages
{
    const SUCCESS = 'success';

    const ERROR = 'danger';

    const INFO = 'info';

    const WARNING = 'warning';

    private $messages = array();

    /**
     * Add success message.
     *
     * @param string $message
     */
    public function addSuccess($message)
    {
        $this->messages[self::SUCCESS][] = $message;
    }

    /**
     * Add error message.
     *
     * @param string $message
     */
    public function addError($message)
    {
        $this->messages[self::ERROR][] = $message;
    }

    /**
     * Add info message.
     *
     * @param string $message
     */
    public function addInfo($message)
    {
        $this->messages[self::SUCCESS][] = $message;
    }

    /**
     * Add warning.
     *
     * @param string $message
     */
    public function addWarning($message)
    {
        $this->messages[self::WARNING][] = $message;
    }

    /**
     * Set messages.
     *
     * @param array $messages
     *
     * @return Messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get messages.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
