<?php

namespace mzk\DataGrid\Renderers;

use mzk\DataGrid;

/**
 * Defines method that must implement data grid rendered.
 *
 * @author     Roman Sklenář
 * @copyright  Copyright (c) 2009 Roman Sklenář (http://romansklenar.cz)
 * @license    New BSD License
 * @package    Nette\Extras\DataGrid
 */
interface IRenderer
{
	/**
	 * Provides complete data grid rendering.
	 * @param \mzk\DataGrid\DataGrid $dataGrid
	 * @return string
	 */
	function render(DataGrid\DataGrid $dataGrid);

}
