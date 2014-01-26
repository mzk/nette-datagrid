<?php

namespace mzk\DataGrid\Filters;
use Nette\Forms\IControl;

/**
 * Defines method that must be implemented to allow a component act like a data grid column's filter.
 *
 * @author     Roman Sklenář
 * @copyright  Copyright (c) 2009 Roman Sklenář (http://romansklenar.cz)
 * @license    New BSD License
 * @package    Nette\Extras\DataGrid
 */
interface IColumnFilter
{
	/**
	 * Returns filter's form element.
	 * @return IControl
	 */
	function getFormControl();


	/**
	 * Gets filter's value, if was filtered.
	 * @return string
	 */
	public function getValue();

}