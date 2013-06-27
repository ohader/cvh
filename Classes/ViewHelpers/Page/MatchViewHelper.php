<?php
namespace OliverHader\Cvh\ViewHelpers\Page;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Oliver Hader <oliver.hader@typo3.org>
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
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Example:
 * {cvh:page.match(pageId:'63',assignments:'{4:\'page-4\',62:\'page-62\'}',defaultValue:'page-default')}
 *
 * @package OliverHader\Cvh\ViewHelpers\Page
 */
class MatchViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @param integer $pageId
	 * @param array $assignments
	 * @param string $defaultValue
	 * @return string
	 */
	public function render($pageId, array $assignments, $defaultValue = '') {
		$content = $defaultValue;
		$pageId = (int) $pageId;

		$rootLine = $this->getRootLine($pageId);
		if ($rootLine !== NULL) {
			foreach ($rootLine as $page) {
				$currentPageId = (int) $page['uid'];

				if (isset($assignments[$currentPageId])) {
					$content = $assignments[$currentPageId];
					break;
				}
			}
		}

		return $content;
	}

	/**
	 * @param integer $pageId
	 * @return NULL|array
	 */
	protected function getRootLine($pageId) {
		$rootLine = NULL;

		if (TYPO3_MODE === 'FE') {
			$rootLine = $this->getFrontend()->sys_page->getRootLine($pageId);
		} elseif (TYPO3_MODE === 'BE') {
			$rootLine = \TYPO3\CMS\Backend\Utility\BackendUtility::BEgetRootLine($pageId);
		}

		return $rootLine;
	}

	/**
	 * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
	 */
	protected function getFrontend() {
		return $GLOBALS['TSFE'];
	}

}


?>