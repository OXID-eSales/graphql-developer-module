<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\Developer\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Event\AbstractShopAwareEventSubscriber;
use OxidEsales\GraphQL\Base\Event\BeforeAuthorization;
use OxidEsales\GraphQL\Base\Service\Authentication;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeveloperAuthorizationEventSubscriber extends AbstractShopAwareEventSubscriber
{
    public function handleDeveloperAuthorization(BeforeAuthorization $event) {

        $token = $event->getToken();
        if ($token->getClaim(Authentication::CLAIM_GROUP) == DeveloperAuthentication::DEVELOPER_GROUP) {
            $event->setAuthorized(true);
            $event->stopPropagation();
        }
        return $event;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [BeforeAuthorization::NAME => 'handleDeveloperAuthorization'];
    }
}
