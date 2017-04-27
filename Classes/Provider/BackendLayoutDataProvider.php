<?php

namespace Sethorax\Fluidloader\Provider;

use Sethorax\Fluidloader\Service\TemplateLoaderService;
use Sethorax\Fluidloader\Utility\FlashMessageUtility;
use TYPO3\CMS\Backend\View\BackendLayout\BackendLayout;
use TYPO3\CMS\Backend\View\BackendLayout\BackendLayoutCollection;
use TYPO3\CMS\Backend\View\BackendLayout\DataProviderContext;
use TYPO3\CMS\Backend\View\BackendLayout\DataProviderInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class BackendLayoutDataProvider
 */
class BackendLayoutDataProvider implements DataProviderInterface
{
    const BE_LAYOUT_IDENTIFIER = 'tx_fluidloader_backendlayout';

    /**
     * Adds backend layouts to the given backend layout collection.
     *
     * @param DataProviderContext $dataProviderContext
     * @param BackendLayoutCollection $backendLayoutCollection
     * @return void
     */
    public function addBackendLayouts(DataProviderContext $dataProviderContext, BackendLayoutCollection $backendLayoutCollection)
    {
        $backendLayout = $this->createBackendLayout();
        $backendLayoutCollection->add($backendLayout);
    }

    /**
     * Gets a backend layout by (regular) identifier.
     *
     * @param string $identifier
     * @param int $pageId
     * @return void|BackendLayout
     */
    public function getBackendLayout($identifier, $pageId)
    {
        if ($identifier === self::BE_LAYOUT_IDENTIFIER) {
            $backendLayout = $this->createBackendLayout($pageId);

            if (isset($backendLayout)) {
                return $backendLayout;
            }
        }
    }

    /**
     * Creates a new backend layout using the given record data.
     *
     * @return BackendLayout
     */
    protected function createBackendLayout($pageId = 0)
    {
        $layoutConfiguration = \TYPO3\CMS\Backend\View\BackendLayoutView::getDefaultColumnLayout();

        if ($pageId !== 0) {
            $templateId = $this->getTemplateIdOfPage($pageId);

            if ($templateId !== '-1') {
                $parsedConfiguration = GeneralUtility::makeInstance(TemplateLoaderService::class)->getBackendLayoutByTemplateId($templateId);

                if (isset($parsedConfiguration)) {
                    if ($parsedConfiguration) {
                        $layoutConfiguration = $parsedConfiguration;
                    } else {
                        FlashMessageUtility::showError(
                            LocalizationUtility::translate('flashmessages.dir_not_found_error.message', 'fluidloader'),
                            LocalizationUtility::translate('flashmessages.dir_not_found_error.title', 'fluidloader')
                        );
                    }
                } else {
                    FlashMessageUtility::showError(
                        LocalizationUtility::translate('flashmessages.parse_error.message', 'fluidloader'),
                        LocalizationUtility::translate('flashmessages.parse_error.title', 'fluidloader')
                    );
                }
            } else {
                FlashMessageUtility::showWarning(
                    LocalizationUtility::translate('flashmessages.template_not_found.message', 'fluidloader'),
                    LocalizationUtility::translate('flashmessages.template_not_found.title', 'fluidloader')
                );
            }
        }

        $backendLayout = BackendLayout::create(
            self::BE_LAYOUT_IDENTIFIER,
            'LLL:EXT:fluidloader/Resources/Private/Language/locallang.xlf:backendlayout.name',
            $layoutConfiguration
        );

        return $backendLayout;
    }

    /**
     * Gets the template for the given page from the database
     *
     * @param $pageId
     * @return string
     */
    protected function getTemplateIdOfPage($pageId)
    {
        $attributeName = 'tx_fluidloader_layout';

        $queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable('pages');
        $layout = $queryBuilder
            ->select($attributeName)
            ->from('pages')
            ->where($queryBuilder->expr()->eq('uid', $pageId))
            ->execute()
            ->fetch()[$attributeName];

        return $layout;
    }
}
