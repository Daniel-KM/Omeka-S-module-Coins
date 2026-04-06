<?php declare(strict_types=1);

namespace CoinsTest;

use Omeka\Api\Representation\ItemRepresentation;
use Omeka\Api\Representation\SiteRepresentation;

trait CoinsTestTrait
{
    /**
     * @var ItemRepresentation[]
     */
    protected array $items = [];

    /**
     * @var SiteRepresentation|null
     */
    protected ?SiteRepresentation $site = null;

    protected function loginAdmin(): void
    {
        $services = $this->getApplication()->getServiceManager();
        $auth = $services->get('Omeka\AuthenticationService');
        if ($auth->hasIdentity()) {
            return;
        }
        $adapter = $auth->getAdapter();
        $adapter->setIdentity('admin@example.com');
        $adapter->setCredential('root');
        $auth->authenticate();
    }

    protected function logout(): void
    {
        $services = $this->getApplication()->getServiceManager();
        $auth = $services->get('Omeka\AuthenticationService');
        $auth->clearIdentity();
    }

    protected function api(): \Omeka\Api\Manager
    {
        return $this->getApplication()->getServiceManager()
            ->get('Omeka\ApiManager');
    }

    protected function getService(string $name)
    {
        return $this->getApplication()->getServiceManager()
            ->get($name);
    }

    protected function createSite(): SiteRepresentation
    {
        $response = $this->api()->create('sites', [
            'o:title' => 'Test site',
            'o:slug' => 'test',
            'o:theme' => 'default',
        ]);
        $this->site = $response->getContent();
        return $this->site;
    }

    protected function createItems(int $count = 10): array
    {
        for ($i = 0; $i < $count; $i++) {
            $response = $this->api()->create('items', [
                'dcterms:title' => [
                    [
                        'type' => 'literal',
                        'property_id' => 1,
                        '@value' => sprintf('Test item %d', $i),
                    ],
                ],
                'o:site' => $this->site
                    ? [$this->site->id()]
                    : [],
            ]);
            $this->items[] = $response->getContent();
        }
        return $this->items;
    }

    protected function cleanupResources(): void
    {
        foreach ($this->items as $item) {
            try {
                $this->api()->delete('items', $item->id());
            } catch (\Exception $e) {
            }
        }
        $this->items = [];

        if ($this->site) {
            try {
                $this->api()->delete('sites', $this->site->id());
            } catch (\Exception $e) {
            }
            $this->site = null;
        }
    }
}
