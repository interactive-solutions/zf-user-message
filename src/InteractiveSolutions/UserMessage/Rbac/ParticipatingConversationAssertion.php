<?php
/**
 * @author    Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
namespace InteractiveSolutions\UserMessage\Rbac;

use Doctrine\Common\Collections\ArrayCollection;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use ZfcRbac\Assertion\AssertionInterface;
use ZfcRbac\Exception\InvalidArgumentException;
use ZfcRbac\Service\AuthorizationService;

/**
 * Class ParticipatingConversationAssertion
 */
class ParticipatingConversationAssertion implements AssertionInterface
{
    /**
     * @param AuthorizationService $authorizationService
     * @param AbstractConversationEntity   $context
     *
     * @return bool
     */
    public function assert(AuthorizationService $authorizationService, $context = null)
    {
        if (!$context instanceof AbstractConversationEntity) {
            throw new InvalidArgumentException();
        }

        /* @var MessageUserInterface $user */
        $user = $authorizationService->getIdentity();

        /* @var ArrayCollection $participants */
        $participants = $context->getParticipants();
        if ($participants->contains($user)) {
            return true;
        }

        return $authorizationService->isGranted('administrator');
    }
}
