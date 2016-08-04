<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Entity;

/**
 * @TODO, Probably rename. And maybe not use getId
 *
 * Interface MessageUserInterface
 */
interface MessageUserInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * Allows the implementer to set an array with the data to expose.
     *
     * @return array
     */
    public function getMessageMeta();
}
