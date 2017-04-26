<?php

namespace Sethorax\Fluidloader\Parser;

use Sethorax\Fluidloader\Utility\StringUtility;

/**
 * Class TemplateParser
 * @package Sethorax\Fluidloader\Parser
 */
class TemplateParser
{

    /**
     * @var string
     */
    protected $template;

    /**
     * @var
     */
    protected $templateConfiguration;


    /**
     * TemplateParser constructor.
     * Gets file contents of $templatePath if it exists and parses the configuration
     *
     * @param $templatePath
     */
    public function __construct($templatePath)
    {
        if (file_exists($templatePath)) {
            $this->template = file_get_contents($templatePath);

            $this->parseConfiguration();
        }
    }

    /**
     * Gets the template configuration
     *
     * @return mixed
     */
    public function getTemplateConfiguration()
    {
        return $this->templateConfiguration;
    }


    /**
     * Parses the XML configuration within the fluid section "configuration"
     */
    protected function parseConfiguration()
    {
        libxml_use_internal_errors(true);
        $configurationString = StringUtility::getContentsBetweenStrings($this->template, '<f:section name="configuration">', '</f:section>');
        $xmlConf = simplexml_load_string(trim($configurationString));

        if ($xmlConf) {
            $this->templateConfiguration = $xmlConf;
        } else {
            libxml_clear_errors();
        }
    }
}
