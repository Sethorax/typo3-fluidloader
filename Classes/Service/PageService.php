<?php

namespace Sethorax\Fluidloader\Service;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class PageService
 */
class PageService implements SingletonInterface
{

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ConfigurationService
     */
    protected $configurationService;

    /**
     * @var TemplateLoaderService
     */
    protected $templateLoaderService;

    /**
     * @param ObjectManager $objectManager
     * @return void
     */
    public function injectObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param ConfigurationService $configurationService
     * @return void
     */
    public function injectConfigurationService(ConfigurationService $configurationService)
    {
        $this->configurationService = $configurationService;
    }

    /**
     * @param TemplateLoaderService $templateLoaderService
     * @return void
     */
    public function injectTemplateLoaderService(TemplateLoaderService $templateLoaderService)
    {
        $this->templateLoaderService = $templateLoaderService;
    }

    /**
     * Gets the template for the current page and returns the root paths
     *
     * @return array
     */
    public function getPageTemplate()
    {
        $templateId = $this->configurationService->getPageConfiguration()['tx_fluidloader_layout'];
        $templateData = $this->templateLoaderService->getTemplateById($templateId);

        $layoutRootPath = GeneralUtility::getFileAbsFileName($this->configurationService->getExtensionConfiguration()['layoutRootPath']);
        $partialRootPath = GeneralUtility::getFileAbsFileName($this->configurationService->getExtensionConfiguration()['partialRootPath']);

        return [
            'templatePath' => $templateData['path'],
            'layoutRootPath' => $layoutRootPath,
            'partialRootPath' => $partialRootPath
        ];
    }
}
