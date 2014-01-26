<?php

namespace mzk\DataGrid\Filters;

use Nette;

/**
 * Representation of data grid column textual filter.
 *
 * @author     Roman Sklenář
 * @copyright  Copyright (c) 2009 Roman Sklenář (http://romansklenar.cz)
 * @license    New BSD License
 * @example    http://addons.nette.org/datagrid
 * @package    Nette\Extras\DataGrid
 */
class TextFilter extends ColumnFilter
{
	/**
	 * Returns filter's form element.
	 * @return Nette\Application\UI\Control
	 */
	public function getFormControl()
	{
		if ($this->element instanceof Nette\Application\UI\Control) return $this->element;
		$this->element = new Nette\Forms\Controls\TextInput($this->getName(), 5);
		return $this->element;
	}
}
