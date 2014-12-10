<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('tt_content');
#$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem'] = '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.general;general, header;LLL:EXT:cms/locallang_ttc.xml:header.ALT.html_formlabel, bodytext;LLL:EXT:cms/locallang_ttc.xml:bodytext.ALT.html_formlabel;;nowrap, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access, --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility, --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.appearance, --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.frames;frames, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.extended';

$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem'] = $TCA['tt_content']['types']['html']['showitem'];

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array(
	'LLL:EXT:fluidhtml/locallang_db.xml:tt_content.CType_pi1',
	$_EXTKEY . '_pi1',
	TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'CType');

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY,'static/fluid_html_static_template/', 'Fluid HTML Static Template');
?>