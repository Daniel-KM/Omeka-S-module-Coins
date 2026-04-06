<?php declare(strict_types=1);

namespace CoinsTest\View\Helper;

use Coins\View\Helper\Coins;
use CoinsTest\CoinsTestTrait;
use Omeka\Test\AbstractHttpControllerTestCase;

/**
 * Tests for Coins View Helper.
 */
class CoinsTest extends AbstractHttpControllerTestCase
{
    use CoinsTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->loginAdmin();
        $this->createSite();
        $this->createItems(2);
    }

    public function tearDown(): void
    {
        $this->cleanupResources();
        $this->logout();
        parent::tearDown();
    }

    public function testHelperClassExists(): void
    {
        $this->assertTrue(class_exists(Coins::class));
    }

    public function testHelperReturnsSingleSpan(): void
    {
        $viewHelperManager = $this->getService('ViewHelperManager');
        $helper = $viewHelperManager->get('coins');

        $result = $helper($this->items[0]);

        $this->assertStringContainsString('<span class="Z3988"', $result);
        $this->assertStringContainsString('ctx_ver=Z39.88-2004', $result);
        $this->assertStringContainsString('Test+item+0', $result);
    }

    public function testHelperReturnsMultipleSpans(): void
    {
        $viewHelperManager = $this->getService('ViewHelperManager');
        $helper = $viewHelperManager->get('coins');

        $result = $helper($this->items);

        $this->assertEquals(2, substr_count($result, '<span class="Z3988"'));
        $this->assertStringContainsString('Test+item+0', $result);
        $this->assertStringContainsString('Test+item+1', $result);
    }

    public function testHelperContainsRequiredFields(): void
    {
        $viewHelperManager = $this->getService('ViewHelperManager');
        $helper = $viewHelperManager->get('coins');

        $result = $helper($this->items[0]);

        $this->assertStringContainsString('rft_val_fmt=', $result);
        $this->assertStringContainsString('rfr_id=', $result);
        $this->assertStringContainsString('rft.title=', $result);
        $this->assertStringContainsString('rft.identifier=', $result);
    }

    public function testHelperOutputIsValidHtml(): void
    {
        $viewHelperManager = $this->getService('ViewHelperManager');
        $helper = $viewHelperManager->get('coins');

        $result = $helper($this->items[0]);

        $this->assertStringStartsWith('<span ', $result);
        $this->assertStringEndsWith('</span>', $result);
    }
}
