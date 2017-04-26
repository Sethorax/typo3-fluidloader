<?php

namespace Sethorax\Fluidloader\Tests\Unit;

use Nimut\TestingFramework\TestCase\UnitTestCase;
use Sethorax\Fluidloader\Service\TemplateLoaderService;

class TemplateLoaderServiceTest extends UnitTestCase
{
    protected $backupGlobals;

    public function setUp()
    {
        $this->backupGlobals = $GLOBALS;

        shell_exec('mkdir -p ./.Build/Web/fileadmin');
        shell_exec('cp -R ./Tests/Fixtures/Files/. ./.Build/Web/fileadmin');
    }

    public function tearDown()
    {
        $GLOBALS = $this->backupGlobals;

        shell_exec('rm -rf ./.Build/Web/fileadmin');
    }

    /**
     * @test
     */
    public function getAvailableTemplates()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['fluidloader'] = serialize([
            'templateRootPath' => 'fileadmin/CorrectFiles',
            'layoutRootPath' => '',
            'partialRootPath' => ''
        ]);

        $tls = new TemplateLoaderService();
        $items = $tls->getAvailableTemplates();

        $this->assertEquals(count($items), 2);
    }

    /**
     * @test
     */
    public function getTemplatesWithNoRootPaths()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['fluidloader'] = serialize([
            'templateRootPath' => '',
            'layoutRootPath' => '',
            'partialRootPath' => ''
        ]);

        $tls = new TemplateLoaderService();
        $items = $tls->getAvailableTemplates();

        $this->assertEquals($items, []);
    }

    /**
     * @test
     */
    public function getTemplatesWithNoContent()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['fluidloader'] = serialize([
            'templateRootPath' => 'fileadmin/EmptyFiles',
            'layoutRootPath' => '',
            'partialRootPath' => ''
        ]);

        $tls = new TemplateLoaderService();
        $items = $tls->getAvailableTemplates();

        $this->assertEquals($items, []);
    }

    /**
     * @test
     */
    public function getTemplatesWithMixedContent()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['fluidloader'] = serialize([
            'templateRootPath' => 'fileadmin/MixedFiles',
            'layoutRootPath' => '',
            'partialRootPath' => ''
        ]);

        $tls = new TemplateLoaderService();
        $items = $tls->getAvailableTemplates();

        $this->assertEquals(count($items), 1);
    }

    /**
     * @test
     */
    public function canCreateItemArrayWithCorrectTemplateConfiguration()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['fluidloader'] = serialize([
            'templateRootPath' => 'fileadmin/CorrectFiles',
            'layoutRootPath' => '',
            'partialRootPath' => ''
        ]);

        $tls = new TemplateLoaderService();
        $items = $tls->getAvailableTemplates();

        $this->assertEquals($items, [
            ['Template One', 'templateone'],
            ['Template Two', 'templatetwo']
        ]);
    }

    /**
     * @test
     */
    public function canGetTemplateById()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['fluidloader'] = serialize([
            'templateRootPath' => 'fileadmin/CorrectFiles',
            'layoutRootPath' => '',
            'partialRootPath' => ''
        ]);

        $tls = new TemplateLoaderService();
        $template = $tls->getTemplateById('templatetwo');

        $this->assertEquals($template['filename'], 'TemplateTwo.html');
    }

    /**
     * @test
     */
    public function canGetBackendLayoutByTemplateId()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['fluidloader'] = serialize([
            'templateRootPath' => 'fileadmin/CorrectFiles',
            'layoutRootPath' => '',
            'partialRootPath' => ''
        ]);

        $tls = new TemplateLoaderService();
        $layout = $tls->getBackendLayoutByTemplateId('templatetwo');

        $this->assertEquals($layout, 'backend_layout {
colCount = 1
rowCount = 3
rows {
1 {
columns {
1 {
name = Pos1
colPos = 0
}
}
}
2 {
columns {
1 {
name = Pos2
colPos = 1
}
}
}
3 {
columns {
1 {
name = Pos3
colPos = 2
}
}
}
}
}
');
    }
}
