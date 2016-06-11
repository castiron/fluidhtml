<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Cast Iron Coding, Inc. <zach@castironcoding.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


/**
 * Plugin 'Fluid HTML' for the 'fluidhtml' extension.
 *
 * @author	Cast Iron Coding, Inc. <zach@castironcoding.com>
 * @package	TYPO3
 * @subpackage	tx_fluidhtml
 */
class tx_fluidhtml_pi1 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin {
	var $prefixId      = 'tx_fluidhtml_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_fluidhtml_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'fluidhtml';	// The extension key.
	var $pi_checkCHash = true;

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf)	{

			// check if the needed extensions are installed
		if (!\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('fluid')) {
			return 'You need to install "Fluid" in order to use the FLUIDTEMPLATE content element';
		}

		/**
		 * 1. initializing Fluid StandaloneView and setting configuration parameters
		 **/
		try {
			$view = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Fluid\View\StandaloneView');
				// fetch the Fluid template
			$file = isset($conf['file.'])
				? $this->cObj->stdWrap($conf['file'], $conf['file.'])
				: $conf['file'];
			$templatePathAndFilename = $GLOBALS['TSFE']->tmpl->getFileName($file);
			// $view->setTemplateSource won't accept a null value, so we make it an empty string. If the page is loaded before
			// the html source for the plugin has been set, an exception is thrown and breaks the page. Setting $source to an empty
			// string fixes that. MM 06/22/11.
			$source = empty($this->cObj->data['bodytext']) ? '' : $this->cObj->data['bodytext'];
			$view->setTemplateSource($source);

				// override the default layout path via typoscript
			$layoutRootPath = isset($conf['layoutRootPath.'])
				? $this->cObj->stdWrap($conf['layoutRootPath'], $conf['layoutRootPath.'])
				: $conf['layoutRootPath'];
			if($layoutRootPath) {
				$layoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($layoutRootPath);
				$view->setLayoutRootPath($layoutRootPath);
			}

				// override the default partials path via typoscript
			$partialRootPath = isset($conf['partialRootPath.'])
				? $this->cObj->stdWrap($conf['partialRootPath'], $conf['partialRootPath.'])
				: $conf['partialRootPath'];
			if($partialRootPath) {
				$partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($partialRootPath);
				$view->setPartialRootPath($partialRootPath);
			}

				// override the default format
			$format = isset($conf['format.'])
				? $this->cObj->stdWrap($conf['format'], $conf['format.'])
				: $conf['format'];
			if ($format) {
				$view->setFormat($format);
			}

				// set some default variables for initializing Extbase
			$requestPluginName = isset($conf['extbase.']['pluginName.'])
				? $this->cObj->stdWrap($conf['extbase.']['pluginName'], $conf['extbase.']['pluginName.'])
				: $conf['extbase.']['pluginName'];
			if($requestPluginName) {
				$view->getRequest()->setPluginName($requestPluginName);
			}

			$requestControllerExtensionName = isset($conf['extbase.']['controllerExtensionName.'])
				? $this->cObj->stdWrap($conf['extbase.']['controllerExtensionName'], $conf['extbase.']['controllerExtensionName.'])
				: $conf['extbase.']['controllerExtensionName'];
			if($requestControllerExtensionName) {
				$view->getRequest()->setControllerExtensionName($requestControllerExtensionName);
			}

			$requestControllerName = isset($conf['extbase.']['controllerName.'])
				? $this->cObj->stdWrap($conf['extbase.']['controllerName'], $conf['extbase.']['controllerName.'])
				: $conf['extbase.']['controllerName'];
			if($requestControllerName) {
				$view->getRequest()->setControllerName($requestControllerName);
			}

			$requestControllerActionName = isset($conf['extbase.']['controllerActionName.'])
				? $this->cObj->stdWrap($conf['extbase.']['controllerActionName'], $conf['extbase.']['controllerActionName.'])
				: $conf['extbase.']['controllerActionName'];
			if($requestControllerActionName) {
				$view->getRequest()->setControllerActionName($requestControllerActionName);
			}

			/**
			 * 2. variable assignment
			 */
			$reservedVariables = array('data', 'current');
				// accumulate the variables to be replaced
				// and loop them through cObjGetSingle
			$variables = (array) $conf['variables.'];
			foreach ($variables as $variableName => $cObjType) {
				if (is_array($cObjType)) {
					continue;
				}
				if(!in_array($variableName, $reservedVariables)) {
					$view->assign($variableName, $this->cObj->cObjGetSingle($cObjType, $variables[$variableName . '.']));
				} else {
					throw new InvalidArgumentException('Cannot use reserved name "' . $variableName . '" as variable name in FLUIDTEMPLATE.', 1288095720);
				}
			}

			$view->assign('data', $this->cObj->data);
			$view->assign('current', $this->cObj->data[$this->cObj->currentValKey]);

			/**
			 * 3. render the content
			 */
			$theValue = $view->render();

			if(isset($conf['stdWrap.'])) {
				$theValue = $this->cObj->stdWrap($theValue, $conf['stdWrap.']);
			}
		} catch(Exception $e) {
			$theValue = 'An Fluid exception occurred while rendering a fluidhtml content element: '.$e->getMessage();
		}

		return $theValue;

	}

}
