<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage;

use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature;

class Module implements Feature\AutoloaderProviderInterface, Feature\ConfigProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            StandardAutoloader::class => [
                StandardAutoloader::LOAD_NS => [
                    __NAMESPACE__ => __DIR__ . '/src/Is/UserMessage',
                ],
            ],
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
