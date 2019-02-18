<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][$_EXTKEY] =
	'EXT:' . $_EXTKEY . '/Classes/Hook/CmsLayout.php:CIC\Fluidhtml\Hook\PageLayoutViewDrawItemHook';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'CIC.'.$_EXTKEY, 'pi1',
	['FluidHTML' => 'index'],
	[],
	'CType'
);