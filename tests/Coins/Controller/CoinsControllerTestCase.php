<?php

namespace Coins\Test\Controller;

use Omeka\Test\AbstractHttpControllerTestCase;

abstract class CoinsControllerTestCase extends AbstractHttpControllerTestCase
{
    protected $items;
    protected $site;

    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsAdmin();

        $api = $this->getApplication()->getServiceManager()->get('Omeka\ApiManager');

        $response = $api->create('sites', [
            'o:title' => 'Test site',
            'o:slug' => 'test',
            'o:theme' => 'default',
        ]);
        $this->site = $response->getContent();

        for ($i = 0; $i < 10; $i++) {
            $response = $api->create('items', [
                'dcterms:title' => [
                    [
                        'type' => 'literal',
                        'property_id' => 1,
                        '@value' => sprintf('Test item %d', $i),
                    ],
                ],
                'o:site' => [ $this->site->id() ],
            ]);
            $this->items[] = $response->getContent();
        }
    }

    public function tearDown(): void
    {
        $api = $this->getApplication()->getServiceManager()->get('Omeka\ApiManager');

        foreach ($this->items as $item) {
            $api->delete('items', $item->id());
        }
        $api->delete('sites', $this->site->id());
    }

    protected function loginAsAdmin()
    {
        $this->login('admin@example.com', 'root');
    }

    protected function login($email, $password)
    {
        $serviceLocator = $this->getApplication()->getServiceManager();
        $auth = $serviceLocator->get('Omeka\AuthenticationService');
        $adapter = $auth->getAdapter();
        $adapter->setIdentity($email);
        $adapter->setCredential($password);
        $auth->authenticate();
        $serviceLocator->get('Omeka\Settings\User')->setTargetId($auth->getIdentity()->getId());
    }
}
