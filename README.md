# TYPO3 Extension ``fluidloader``

[![Build Status](https://travis-ci.org/Sethorax/typo3-fluidloader.svg?branch=master)](https://travis-ci.org/Sethorax/typo3-fluidloader)
[![StyleCI](https://styleci.io/repos/89520397/shield?branch=master)](https://styleci.io/repos/89520397)
[![Latest Stable Version](https://poser.pugx.org/sethorax/typo3-fluidloader/v/stable)](https://packagist.org/packages/sethorax/typo3-fluidloader)
[![License](https://poser.pugx.org/sethorax/typo3-fluidloader/license)](https://packagist.org/packages/sethorax/typo3-fluidloader)

> This extension automatically loads HTML fluid template files from a directory.

### Features

- Automatically loads HTML template files from a directory as soon as they are added
- Available templates can be assigned to a page in the page settings
- Backend layout can directly in the template

This extension makes it very easy to work with different fluid templates for TYPO3 pages.  


### Usage

#### Installation

Installation using Composer

It is recommended to install this extension via composer.  
To install it just do ``composer require sethorax/typo3-fluidloader``

This extension can also be installed traditionally via the TYPO3 Extension Repository (TER).


#### Setup

1. Include the static TypoScript template of the extension.
2. Set your template, partial and layout root paths in the extension settings.
3. Start adding some HTML fluid templates to the template root path as you wold normally do.
4. Once a template is added, you can select this template in the page settings. Please note that the template must contain a special fluid section for the configuration options.


#### Fluid Template

##### Configuration Section
 
All templates must contain a special fluid section with the template configuration in XML format.

Example configuration:
```HTML
<f:section name="configuration">
    <configuration>
        <general>
            <layoutName>My awesome template</layoutName>
        </general>
        <backendLayout>
            <row>
                <column pos="0" colspan="2">Full width</column>
            </row>
            <row>
                <column pos="1">50% Width Left</column>
                <column pos="2">50% Width Right</column>
            </row>
            <row>
                <column pos="3" colspan="2">Some more content</column>
            </row>
        </backendLayout>
    </configuration>
</f:section>
```

The template configuration is located within the "configuration" fluid section.  
The configuration is in XML format.

The configuration has one root element `configuration`. Within that element you can specify `general` configuration and the `backendLayout`.  
Within `general` you can set the name of the template. This name will be used as the display value of the select field in the page settings. 

Whitin `backendLayout` you can configure the backend layout of this template. The example above should be self explanatory. The content of the `column` elements is the label for that section.  

Please note that the content of `<f:section name="configuration">` must be valid XML!

##### Rest of the template

The rest of the template is just standard fluid. You can specify as many sections as you like and of course set the layout of the template.  

It is recommended to use the **FluidTYPO3 VHS** extension to easily render the columns.

The configuration of the current page can be accessed via the `page` fluid variable.


### Sidenotes  

The creation of this extension was heavily inspired by FluidTYPO3's [fluidpages](https://github.com/FluidTYPO3/fluidpages) extension.