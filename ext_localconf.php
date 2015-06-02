<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][$_EXTKEY] =
	'EXT:' . $_EXTKEY . '/Classes/Hook/CmsLayout.php:CIC\Fluidhtml\Hook\PageLayoutViewDrawItemHook';

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_fluidhtml_pi1.php', '_pi1', 'CType', 1);
?>