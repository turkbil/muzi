<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2011 Fabien Potencier <fabien.potencier@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Stores Messages in memory.
 *
 * @yazilim Swift
 * @web adresi
@web adresi
@web adresi  Fabien Potencier
 */
class Swift_MemorySpool implements Swift_Spool
{
    protected $messages = array();

    /**
     * Tests if this Transport mechanism has started.
     *
     * @return boolean
     */
    public function isStarted()
    {
        return true;
    }

    /**
     * Starts this Transport mechanism.
     */
    public function start()
    {
    }

    /**
     * Stops this Transport mechanism.
     */
    public function stop()
    {
    }

    /**
     * Stores a message in the queue.
     *
     * @param Swift_Mime_Message $message The message to store
     *
     * @return boolean Whether the operation has succeeded
     */
    public function queueMessage(Swift_Mime_Message $message)
    {
        $this->messages[] = $message;

        return true;
    }

    /**
     * Sends messages using the given transport instance.
     *
     * @param Swift_Transport $transport        A transport instance
     * @param string[]        $failedRecipients An array of failures by-reference
     *
     * @return integer The number of sent emails
     */
    public function flushQueue(Swift_Transport $transport, &$failedRecipients = null)
    {
        if (!$this->messages) {
            return 0;
        }

        if (!$transport->isStarted()) {
            $transport->start();
        }

        $count = 0;
        while ($message = array_pop($this->messages)) {
            $count += $transport->send($message, $failedRecipients);
        }

        return $count;
    }
}
