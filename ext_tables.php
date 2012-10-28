<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
#$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem'] = '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.general;general, header;LLL:EXT:cms/locallang_ttc.xml:header.ALT.html_formlabel, bodytext;LLL:EXT:cms/locallang_ttc.xml:bodytext.ALT.html_formlabel;;nowrap, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access, --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility, --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.appearance, --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.frames;frames, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.extended';

$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem'] = $TCA['tt_content']['types']['html']['showitem'];

t3lib_extMgm::addPlugin(array(
	'LLL:EXT:fluidhtml/locallang_db.xml:tt_content.CType_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'CType');

t3lib_extMgm::addStaticFile($_EXTKEY,'static/fluid_html_static_template/', 'Fluid HTML Static Template');
?>