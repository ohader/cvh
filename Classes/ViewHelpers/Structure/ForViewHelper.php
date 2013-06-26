<?php
namespace OliverHader\Cvh\ViewHelpers\Structure;

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

class ForViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\ForViewHelper {

	/**
	 * Iterates through elements of $each and renders child nodes
	 * Besides that a given array like
	 *   field1 => ...
	 *   text1 => ...
	 *   field2 => ...
	 *   text2 => ...
	 * will be converted into a structure like
	 *   1 => array(
	 *     field => ...
	 *     text => ...
	 *   )
	 *   2 => array(
	 *     field => ...
	 *     text => ...
	 *   )
	 *
	 * @param array $each The array or \TYPO3\CMS\Extbase\Persistence\ObjectStorage to iterated over
	 * @param string $as The name of the iteration variable
	 * @param string $key The name of the variable to store the current array key
	 * @param boolean $reverse If enabled, the iterator will start with the last element and proceed reversely
	 * @param string $iteration The name of the variable to store iteration information (index, cycle, isFirst, isLast, isEven, isOdd)
	 * @return string Rendered string
	 * @api
	 */
	public function render($each, $as, $key = '', $reverse = FALSE, $iteration = NULL) {
		$structure = array();

		foreach ($each as $eachKey => $eachValue) {
			if (preg_match('/^(.*?)(\d+)$/', $eachKey, $matches)) {
				$name = $matches[1];
				$index = $matches[2];

				if (!isset($structure[$index])) {
					$structure[$index] = array();
				}

				$structure[$index][$name] = $eachValue;
			}
		}

		$this->arguments['each'] = $structure;

		return self::renderStatic($this->arguments, $this->buildRenderChildrenClosure(), $this->renderingContext);
	}

}


?>