<?php

namespace Sethorax\Fluidloader\Controller;

use Sethorax\Fluidloader\Service\PageService;
use Sethorax\Fluidloader\Service\ConfigurationService;
use TYPO3\CMS\Extbase\Mvc\Controller\ControllerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Class PageController
 * @package Sethorax\Fluidloader\Controller
 */
class PageController extends ActionController implements ControllerInterface
{
    
    /**
     * @var PageService
     */
    protected $pageService;

    /**
     * @var ConfigurationService
     */
    protected $pageConfigurationService;

    
    /**
     * @param PageService $pageService
     */
    public function injectPageService(PageService $pageService)
    {
        $this->pageService = $pageService;
    }


    /**
     * @param ConfigurationService $pageConfigurationService
     * @return void
     */
    public function injectPageConfigurationService(ConfigurationService $pageConfigurationService)
    {
        $this->pageConfigurationService = $pageConfigurationService;
    }


    /**
     * Render the selected template and set the layout and partial paths.
     * This action also assigns the entire page configuration as a template variable
     *
     * @return string
     * @route off
     */
    public function renderAction()
    {
        $renderer = $this->objectManager->get(StandaloneView::class);

        $templateData = $this->pageService->getPageTemplate();

        $renderer->setTemplatePathAndFilename($templateData['templatePath']);
        $renderer->setLayoutRootPaths([$templateData['layoutRootPath']]);
        $renderer->setPartialRootPaths([$templateData['partialRootPath']]);

        $renderer->assign('page', $this->pageConfigurationService->getPageConfiguration());

        return $renderer->render();
    }
}
