<?php

namespace mzk\DataGrid\Columns;

use mzk\DataGrid\Action;
use mzk\DataGrid\Filters\IColumnFilter;
use Nette;

/**
 * Representation of data grid action column.
 * If you want to write your own implementation you must inherit this class.
 *
 * @author     Roman Sklenář
 * @copyright  Copyright (c) 2009 Roman Sklenář (http://romansklenar.cz)
 * @license    New BSD License
 * @example    http://addons.nette.org/datagrid
 * @package    Nette\Extras\DataGrid
 */
class ActionColumn extends Column implements \ArrayAccess
{

	/**
	 * Action column constructor.
	 * @param string $caption column's textual caption
	 * @return \mzk\DataGrid\Columns\ActionColumn
	 */
	public function __construct($caption = 'Actions')
	{
		parent::__construct($caption);
		$this->addComponent(new Nette\ComponentModel\Container, 'actions');
		$this->removeComponent($this->getComponent('filters'));
		$this->orderable = FALSE;
	}


	/**
	 * Has column filter box?
	 * @return bool
	 */
	public function hasFilter()
	{
		return FALSE;
	}


	/**
	 * Returns column's filter.
	 * @param bool $need throw exception if component doesn't exist?
	 * @throws \Nette\InvalidStateException
	 * @return IColumnFilter|NULL
	 */
	public function getFilter($need = TRUE)
	{
		if ($need == TRUE) {
			throw new Nette\InvalidStateException("mzk\DataGrid\Columns\ActionColumn cannot has filter.");
		}
		return NULL;
	}


	/**
	 * Action factory.
	 * @param $title
	 * @param $signal
	 * @param  bool    generate link with argument? (variable $keyName must be defined in data grid)
	 * @param bool $useAjax
	 * @param bool $type
	 * @return Action
	 */
	public function addAction($title, $signal, $icon = NULL, $useAjax = FALSE, $type = Action::WITH_KEY)
	{
		$action = new Action($title, $signal, $icon, $useAjax, $type);
		$this[] = $action;
		return $action;
	}


	/**
	 * Does column has any action?
	 * @return bool
	 */
	public function hasAction($type = NULL)
	{
		return count($this->getActions($type)) > 0;
	}


	/**
	 * Returns column's action specified by name.
	 * @param  string action's name
	 * @param  $need bool   throw exception if component doesn't exist?
	 * @return Nette\ComponentModel\IComponent|NULL
	 * @todo return type
	 */
	public function getAction($name = NULL, $need = TRUE)
	{
		return $this->getComponent('actions')
			->getComponent($name, $need);
	}


	/**
	 * Iterates over all column's actions.
	 * @param  string
	 * @return \ArrayIterator|NULL
	 */
	public function getActions($type = 'mzk\DataGrid\IAction')
	{
		$actions = new \ArrayObject();
		foreach ($this->getComponent('actions')
					 ->getComponents(FALSE, $type) as $action) {
			$actions->append($action);
		}
		return $actions->getIterator();
	}


	/**
	 * Formats cell's content.
	 * @param $value
	 * @param  \DibiRow|array
	 * @throws \Nette\InvalidStateException
	 * @return string
	 */
	public function formatContent($value, $data = NULL)
	{
		throw new Nette\InvalidStateException("mzk\DataGrid\Columns\ActionColumn cannot be formated.");
	}


	/**
	 * Filters data source.
	 * @param $value
	 * @throws \Nette\InvalidStateException
	 * @return void
	 */
	public function applyFilter($value)
	{
		throw new Nette\InvalidStateException("mzkDataGrid\Columns\ActionColumn cannot be filtered.");
	}


	/********************* interface \ArrayAccess *********************/


	/**
	 * Adds the component to the container.
	 * @param $name Nette\ComponentModel\IComponent
	 * @param mixed $component
	 * @throws \InvalidArgumentException
	 * @return void.
	 */
	final public function offsetSet($name, $component)
	{
		if (!$component instanceof Nette\ComponentModel\IComponent) {
			throw new \InvalidArgumentException("mzk\DataGrid\Columns\ActionColumn accepts only Nette\ComponentModel\IComponent objects.");
		}
		$this->getComponent('actions')
			->addComponent($component, $name == NULL ? count($this->getActions()) : $name);
	}


	/**
	 * Returns component specified by name. Throws exception if component doesn't exist.
	 * @param $name Nette\ComponentModel\IComponent
	 * @return Nette\ComponentModel\IComponent
	 */
	final public function offsetGet($name)
	{
		return $this->getAction((string)$name, TRUE);
	}


	/**
	 * Does component specified by name exists?
	 * @param  string  component name
	 * @return bool
	 */
	final public function offsetExists($name)
	{
		return $this->getAction($name, FALSE) !== NULL;
	}


	/**
	 * Removes component from the container. Throws exception if component doesn't exist.
	 * @param  string  component name
	 * @return void
	 */
	final public function offsetUnset($name)
	{
		$component = $this->getAction($name, FALSE);
		if ($component !== NULL) {
			$this->getComponent('actions')
				->removeComponent($component);
		}
	}
}
