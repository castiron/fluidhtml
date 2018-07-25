<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

/**
 * Having somd trouble getting this to autoload in TYPO3 8... Here's a quick and dirty fix for that.
 */
require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'pi1/class.tx_fluidhtml_pi1.php');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][$_EXTKEY] =
	'EXT:' . $_EXTKEY . '/Classes/Hook/CmsLayout.php:CIC\Fluidhtml\Hook\PageLayoutViewDrawItemHook';

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43($_EXTKEY,null, '_pi1', 'CType', 1);
