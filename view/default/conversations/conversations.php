<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

use Zend\Stdlib\ArrayUtils;

$conversations = ArrayUtils::iteratorToArray($this->paginator);

$result = [];

$result['data'] = array_map(function($conversation) {
    return $this->renderResource('conversations/conversation', ['conversation' => $conversation]);
}, $conversations);

$result['meta'] = $this->renderPaginator($this->paginator);

return $result;
