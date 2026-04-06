<?php declare(strict_types=1);

namespace CoinsTest\Controller\Admin;

use CoinsTest\CoinsTestTrait;
use Omeka\Test\AbstractHttpControllerTestCase;

/**
 * Tests for COinS on admin item pages.
 */
class ItemControllerTest extends AbstractHttpControllerTestCase
{
    use CoinsTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->loginAdmin();
        $this->createSite();
        $this->createItems(3);
    }

    public function tearDown(): void
    {
        $this->cleanupResources();
        $this->logout();
        parent::tearDown();
    }

    public function testShowActionContainsCoins(): void
    {
        $this->dispatch($this->items[0]->adminUrl('show'));

        $this->assertResponseStatusCode(200);
        $this->assertQueryCount('span.Z3988', 1);
        $this->assertXpathQueryContentRegex(
            '//span[@class="Z3988"]/@title',
            '/Test\+item\+0/'
        );
    }

    public function testBrowseActionContainsCoins(): void
    {
        $this->dispatch('/admin/item');

        $this->assertResponseStatusCode(200);
        $this->assertQueryCount('span.Z3988', count($this->items));
    }
}
