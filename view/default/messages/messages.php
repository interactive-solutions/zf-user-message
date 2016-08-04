<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

use Zend\Stdlib\ArrayUtils;

$messages = ArrayUtils::iteratorToArray($this->paginator);

$result = [];

$result['data'] = array_map(function($message) {
    return $this->renderResource('messages/message', ['message' => $message]);
}, $messages);

$result['meta'] = $this->renderPaginator($this->paginator);

return $result;
