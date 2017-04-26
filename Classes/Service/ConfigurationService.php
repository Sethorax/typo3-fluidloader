<?php

namespace Sethorax\Fluidloader\Service;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class ConfigurationService
 * @package Sethorax\Fluidloader\Service
 */
class ConfigurationService implements SingletonInterface
{

    /**
     * @var ObjectManager
     */
    protected $objectManager;


    /**
     * @param ObjectManager $objectManager
     * @return void
     */
    public function injectObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }


    /**
     * @param Int $pageId
     * @return array
     */
    public function getPageConfiguration($pageId = 0)
    {
        if ($pageId == 0) {
            $pageId = $GLOBALS['TSFE']->id;
        }

        $pageConfiguration = $GLOBALS['TSFE']->sys_page->getPage_noCheck($pageId);

        return $pageConfiguration;
    }

    /**
     * Returns the extension configuration as an array
     *
     * @return mixed
     */
    public function getExtensionConfiguration()
    {
        return unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['fluidloader']);
    }
}
