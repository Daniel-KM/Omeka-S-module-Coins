<?php

require __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../../../bootstrap.php';

//make sure error reporting is on for testing
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Install a fresh database.
\Omeka\Test\DbTestCase::dropSchema();
\Omeka\Test\DbTestCase::installSchema();

$application = \Omeka\Test\DbTestCase::getApplication();
$serviceLocator = $application->getServiceManager();
$auth = $serviceLocator->get('Omeka\AuthenticationService');
$adapter = $auth->getAdapter();
$adapter->setIdentity('admin@example.com');
$adapter->setCredential('root');
$auth->authenticate();

$moduleManager = $serviceLocator->get('Omeka\ModuleManager');
$module = $moduleManager->getModule('Coins');
if ($module->getState() !== \Omeka\Module\Manager::STATE_ACTIVE) {
    $moduleManager->install($module);
}
