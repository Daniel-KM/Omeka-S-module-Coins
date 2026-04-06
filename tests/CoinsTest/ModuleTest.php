<?php declare(strict_types=1);

namespace CoinsTest;

use Coins\Module;
use Omeka\Test\AbstractHttpControllerTestCase;

/**
 * Tests for Coins Module.
 */
class ModuleTest extends AbstractHttpControllerTestCase
{
    use CoinsTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->loginAdmin();
    }

    public function tearDown(): void
    {
        $this->logout();
        parent::tearDown();
    }

    public function testModuleIsInstalled(): void
    {
        $moduleManager = $this->getService('Omeka\ModuleManager');
        $module = $moduleManager->getModule('Coins');

        $this->assertNotNull($module);
        $this->assertEquals(
            \Omeka\Module\Manager::STATE_ACTIVE,
            $module->getState()
        );
    }

    public function testModuleClassExists(): void
    {
        $this->assertTrue(class_exists(Module::class));
    }

    public function testModuleConfigHasViewHelpers(): void
    {
        $module = new Module();
        $config = $module->getConfig();

        $this->assertArrayHasKey('view_helpers', $config);
        $this->assertArrayHasKey('invokables', $config['view_helpers']);
        $this->assertArrayHasKey('coins', $config['view_helpers']['invokables']);
    }

    public function testViewHelperIsRegistered(): void
    {
        $viewHelperManager = $this->getService('ViewHelperManager');
        $this->assertTrue($viewHelperManager->has('coins'));
    }
}
