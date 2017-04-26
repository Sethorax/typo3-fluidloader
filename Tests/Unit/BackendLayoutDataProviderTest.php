<?php

namespace Sethorax\Fluidloader\Tests\Unit;

use Sethorax\Fluidloader\Provider\BackendLayoutDataProvider;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Backend\View\BackendLayout\BackendLayout;
use TYPO3\CMS\Backend\View\BackendLayout\BackendLayoutCollection;
use TYPO3\CMS\Backend\View\BackendLayout\DataProviderContext;

class BackendLayoutDataProviderTest extends UnitTestCase
{
    const BE_LAYOUT_IDENTIFIER = 'tx_fluidloader_backendlayout';

    protected $backendLayoutDataProvider;



    public function setUp()
    {
        $this->backendLayoutDataProvider = $this->getAccessibleMock(BackendLayoutDataProvider::class, ['dummy'], [], '');
    }


    /**
     * @test
     */
    public function canAddBackendLayoutConfiguration()
    {
        $dataProviderContext = new DataProviderContext();
        $backendLayoutCollection = new BackendLayoutCollection('dummy');

        $this->backendLayoutDataProvider->addBackendLayouts($dataProviderContext, $backendLayoutCollection);
        $backendLayout = $backendLayoutCollection->get(self::BE_LAYOUT_IDENTIFIER);

        $this->assertEquals($backendLayout->getConfiguration(), \TYPO3\CMS\Backend\View\BackendLayoutView::getDefaultColumnLayout());
    }
}
