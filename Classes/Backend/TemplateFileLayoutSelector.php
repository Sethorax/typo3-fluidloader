<?php

namespace Sethorax\Fluidloader\Backend;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Sethorax\Fluidloader\Service\TemplateLoaderService;

/**
 * Class TemplateFileLayoutSelector
 * @package Sethorax\Fluidloader\Backend
 */
class TemplateFileLayoutSelector
{

    /**
     * Adds all available templates to the options array
     *
     * @param array $options
     * @return array
     */
    public function addLayoutOptions($options)
    {
        $templateLoader = GeneralUtility::makeInstance(TemplateLoaderService::class);
        $templates = $templateLoader->getAvailableTemplates();

        $options['items'] = array_merge(
            [[' ', '-1']],
            $templates
        );

        return $options;
    }
}
