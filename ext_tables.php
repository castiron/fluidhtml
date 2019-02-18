<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem'] = $TCA['tt_content']['types']['html']['showitem'];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array(
	'LLL:EXT:fluidhtml/locallang_db.xml:tt_content.CType_pi1',
	$_EXTKEY . '_pi1',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'CType');

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY,'static/fluid_html_static_template/', 'Fluid HTML Static Template');
