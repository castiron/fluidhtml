<?php namespace CIC\Fluidhtml\Hook;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PageLayoutViewDrawItemHook
 * @package CIC\Fluidhtml\Hook
 */
class PageLayoutViewDrawItemHook implements \TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface {

    /**
     * @param \TYPO3\CMS\Backend\View\PageLayoutView $parentObject
     * @param bool $drawItem
     * @param string $headerContent
     * @param string $itemContent
     * @param array $row
     */
	public function preProcess(\TYPO3\CMS\Backend\View\PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row)
	{
		$objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->fileRepository = $objectManager->get('TYPO3\\CMS\\Core\\Resource\\FileRepository');
		$this->pageRepository = $objectManager->get('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
		$this->ffService = $objectManager->get('TYPO3\\CMS\\Extbase\\Service\\FlexFormService');

		switch ($row['CType']) {
			case 'html':
				return $this->htmlTeaser('HTML',$parentObject, $drawItem, $headerContent, $itemContent, $row);
			break;
			case 'fluidhtml_pi1':
				return $this->fluidHtmlTeaser('Fluid HTML',$parentObject, $drawItem, $headerContent, $itemContent, $row);
			break;
		}
	}

    /**
     * @param $header
     * @param \TYPO3\CMS\Backend\View\PageLayoutView $parentObject
     * @param $drawItem
     * @param $headerContent
     * @param $itemContent
     * @param array $row
     */
	protected function fluidHtmlTeaser($header, \TYPO3\CMS\Backend\View\PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row) {
        $headerContent = '<strong>' . htmlspecialchars($header) . '</strong><br />' . '<strong>' . $row['header'] . '</strong>';
        $input = strip_tags($row['bodytext']);
        $input = GeneralUtility::fixed_lgd_cs($input, 1500);
        $input = nl2br(htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8', FALSE));
        $input = preg_replace('/\r\n\s+<br \/>/','',$input);
        $input = (strlen($input) > 100) ? substr($input, 0, 100) . '<br /> ...' : $input;
        $itemContent = $input;
		$drawItem = false;
	}

    /**
     * @param $header
     * @param \TYPO3\CMS\Backend\View\PageLayoutView $parentObject
     * @param $drawItem
     * @param $headerContent
     * @param $itemContent
     * @param array $row
     */
	protected function htmlTeaser($header, \TYPO3\CMS\Backend\View\PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row) {
        $headerContent = '<strong>' . htmlspecialchars($header) . '</strong><br />' . '<strong>' . $row['header'] . '</strong>';
		$input = strip_tags($row['bodytext']);
		$input = GeneralUtility::fixed_lgd_cs($input, 1500);
		$input = nl2br(htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8', FALSE));
		$input = preg_replace('/\r\n\s+<br \/>/','',$input);
        $input = (strlen($input) > 100) ? substr($input, 0, 100) . '<br /> ...' : $input;
		$itemContent = $input;
		$drawItem = false;
	}

    /**
     * @param $ffData
     * @return mixed
     */
	protected function parseFlexFormData($ffData) {
		$ffArray = $this->ffService->convertFlexFormContentToArray($ffData);
		return $ffArray;
	}

}
