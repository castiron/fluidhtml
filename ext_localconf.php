<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][$_EXTKEY.'_pi1'] =
	CIC\Fluidhtml\Hook\PageLayoutViewDrawItemHook::class;

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'CIC.'.$_EXTKEY, 'pi1',
	['FluidHTML' => 'index'],
	[],
	'CType'
);
