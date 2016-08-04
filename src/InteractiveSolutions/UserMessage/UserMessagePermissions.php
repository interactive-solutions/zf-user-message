<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage;


final class UserMessagePermissions
{
    const SEND_MESSAGE     = 'interactive-solutions:user-message:send-message';
    const GET_ALL_MESSAGES = 'interactive-solutions:user-message:get-all-messages';
    const GET_MESSAGE      = 'interactive-solutions:user-message:get-message';

    const START_CONVERSATION    = 'interactive-solutions:user-message:start-conversation';
    const GET_ALL_CONVERSATIONS = 'interactive-solutions:user-message:get-all-conversations';
    const GET_CONVERSATION      = 'interactive-solutions:user-message:get-conversation';
    const ADD_PARTICIPANT       = 'interactive-solutions:user-message:add-participant';
    const REMOVE_PARTICIPANT    = 'interactive-solutions:user-message:remove-participant';

    const START_NAMED_CONVERSATION    = 'interactive-solutions:user-message:start-named';
    const UPDATE_NAMED_CONVERSATION   = 'interactive-solutions:user-message:update-named';
    const GET_NAMED_CONVERSATION      = 'interactive-solutions:user-message:get-named';
    const GET_ALL_NAMED_CONVERSATIONS = 'interactive-solutions:user-message:get-all-named';
}
