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
     * @return array|FALSE
     */
    public function getPageTemplate()
    {
        $templateId = $this->configurationService->getPageConfiguration()['tx_fluidloader_layout'];

        if ($templateId === '-1' || $templateId === null) {
            $templateId = $this->getInheritedPageTemplateId();
        }

        if ($templateId === null) {
            $templateId = '-1';
        }

        if ($templateId !== '-1') {
            $templateData = $this->templateLoaderService->getTemplateById($templateId);
            $layoutRootPath = GeneralUtility::getFileAbsFileName($this->configurationService->getExtensionConfiguration()['layoutRootPath']);
            $partialRootPath = GeneralUtility::getFileAbsFileName($this->configurationService->getExtensionConfiguration()['partialRootPath']);

            return [
                'templatePath' => $templateData['path'],
                'layoutRootPath' => $layoutRootPath,
                'partialRootPath' => $partialRootPath
            ];
        } else {
            return false;
        }
    }

    /**
     * Checks template id of parent pages for inheritance.
     *
     * @return string
     */
    protected function getInheritedPageTemplateId()
    {
        $templateId = '-1';
        $pageId = $this->configurationService->getPageConfiguration()['pid'];

        while (($templateId === '-1' || $templateId === null) && $pageId !== 0) {
            $config = $this->configurationService->getPageConfiguration($pageId);
            $pageId = $config['pid'];
            $templateId = $config['tx_fluidloader_subpage_layout'];
        }

        return $templateId;
    }
}
