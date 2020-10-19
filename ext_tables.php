<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem'] = $TCA['tt_content']['types']['html']['showitem'];

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'_pi1',
	'Fluid HTML',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'ext_icon.gif'
);

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY,'static/fluid_html_static_template/', 'Fluid HTML Static Template');
