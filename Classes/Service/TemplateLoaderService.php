<?php

namespace Sethorax\Fluidloader\Service;

use Sethorax\Fluidloader\Backend\BackendLayoutTransformer;
use Sethorax\Fluidloader\Parser\TemplateParser;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class TemplateLoaderService
 */
class TemplateLoaderService implements SingletonInterface
{

    /**
     * @var array
     */
    protected $rootPaths;

    /**
     * @var array
     */
    protected $templates;

    /**
     * TemplateLoaderService constructor.
     * Sets the root paths and creates the templates array
     */
    public function __construct()
    {
        $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['fluidloader']);

        $this->setRootPath($extConf, 'templateRootPath');
        $this->setRootPath($extConf, 'layoutRootPath');
        $this->setRootPath($extConf, 'partialRootPath');

        $this->createTemplatesArray();
    }

    /**
     * Checks the available templates in the template root path
     * If template and configuration is valid it is added to the select array
     *
     * @return void
     */
    public function getAvailableTemplates()
    {
        $selectItems = [];

        if (isset($this->rootPaths['templateRootPath'])) {
            foreach ($this->templates as $id => $templateData) {
                $templateName = (string) $this->getTemplateName($templateData['path'])[0];

                if (isset($templateName) && !empty($templateName)) {
                    $selectItems[] = [$templateName, $id];
                }
            }
        }

        return $selectItems;
    }

    /**
     * Gets the template by id
     *
     * @param string $id
     * @return mixed
     */
    public function getTemplateById($id)
    {
        return $this->templates[$id];
    }

    /**
     * Gets the typoscript version of the specified backend layout configuration
     *
     * @param string $id
     * @return bool|string
     */
    public function getBackendLayoutByTemplateId($id)
    {
        if (isset($this->templates)) {
            $templateData = $this->templates[$id];

            $parser = new TemplateParser($templateData['path']);
            $conf = $parser->getTemplateConfiguration()->backendLayout;

            $transformer = new BackendLayoutTransformer($conf);
            $configurationIsValid = $transformer->validateConfiguration();

            if ($configurationIsValid) {
                return $transformer->transformToTypoScript();
            }
        } else {
            return false;
        }
    }

    /**
     * Gets the template name from the template configuration
     *
     * @param string $templatePath
     * @return mixed
     */
    protected function getTemplateName($templatePath)
    {
        $parser = new TemplateParser($templatePath);
        $conf = $parser->getTemplateConfiguration();

        return $conf->general->layoutName;
    }

    /**
     * Creates the templates array with filename and path
     */
    protected function createTemplatesArray()
    {
        if (isset($this->rootPaths['templateRootPath'])) {
            $templateFiles = $this->getTemplateFilesFromDir($this->rootPaths['templateRootPath']);
            $templates = [];

            foreach ($templateFiles as $template) {
                $key = (string) strtolower(substr($template, 0, strpos($template, '.html')));

                $templates[$key] = [
                    'filename' => $template,
                    'path' => $this->rootPaths['templateRootPath'] . '/' . $template
                ];
            }

            $this->templates = $templates;
        }
    }

    /**
     * Reads all available html files in the template root path
     *
     * @param string $dir
     * @return array
     */
    protected function getTemplateFilesFromDir($dir)
    {
        $htmlFiles = [];

        if (file_exists($dir)) {
            $allFiles = scandir($dir);

            foreach ($allFiles as $file) {
                $fileInfo = pathinfo($file);

                if ($fileInfo['extension'] == 'html') {
                    $htmlFiles[] = $file;
                }
            }
        }

        return $htmlFiles;
    }

    /**
     * Sets the root path for the given $key
     *
     * @param array $extConf
     * @param string $key
     */
    protected function setRootPath($extConf, $key)
    {
        // Set path if set and exists
        if (isset($extConf[$key])) {
            $rootPath = GeneralUtility::getFileAbsFileName($extConf[$key]);

            if (file_exists($rootPath)) {
                $this->rootPaths[$key] = $rootPath;
            }
        }
    }
}
