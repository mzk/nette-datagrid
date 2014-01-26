<?php

namespace mzk\DataGrid;

use Nette;
use Nette\Utils\Html;

/**
 * Representation of data grid action.
 *
 * @author     Roman Sklenář
 * @copyright  Copyright (c) 2009 Roman Sklenář (http://romansklenar.cz)
 * @license    New BSD License
 * @example    http://addons.nette.org/datagrid
 * @package    Nette\Extras\DataGrid
 */
class Action extends Nette\ComponentModel\Container implements IAction
{
	/**#@+ special action key */
	const WITH_KEY = TRUE;
	const WITHOUT_KEY = FALSE;
	/**#@-*/

	/** @var Nette\Utils\Html  action element template */
	protected $html;

	/** @var string */
	static public $ajaxClass = 'datagrid-ajax';

	/** @var string */
	public $destination;

	/** @var bool|string */
	public $key;

	/** @var Nette\Callback|\Closure */
	public $ifDisableCallback;


	/**
	 * Data grid action constructor.
	 * @note   for full ajax support, destination should not change module,
	 * @note   presenter or action and must be ended with exclamation mark (!)
	 *
	 * @param $title String
	 * @param String $destination link
	 * @param \Nette\Utils\Html $icon
	 * @param bool $useAjax
	 * @param bool $key link with argument? (if yes you can specify name of parameter
	 *                   otherwise variable mzk\DataGrid\DataGrid::$keyName will be used and must be defined)
	 * @return \mzk\DataGrid\Action
	 */
	public function __construct($title, $destination, Html $icon = NULL, $useAjax = FALSE, $key = self::WITH_KEY)
	{
		parent::__construct();
		$this->destination = $destination;
		$this->key = $key;

		$a = Html::el('a')
			->title($title);
		if ($useAjax) $a->addClass(self::$ajaxClass);

		if ($icon !== NULL && $icon instanceof Nette\Utils\Html) {
			$a->add($icon);
		} else {
			$a->setText($title);
		}
		$this->html = $a;
	}


	/**
	 * Generates action's link. (use before data grid is going to be rendered)
	 * @param array $args
	 * @return void
	 */
	public function generateLink(array $args = NULL)
	{
		$dataGrid = $this->lookup('mzk\DataGrid\DataGrid', TRUE);
		$control = $dataGrid->lookup('Nette\Application\Ui\Control', TRUE);

		switch ($this->key) {
			case self::WITHOUT_KEY:
				$link = $control->link($this->destination);
				break;
			case self::WITH_KEY:
			default:
				$key = $this->key == NULL || is_bool($this->key) ? $dataGrid->keyName : $this->key;
				$link = $control->link($this->destination, array($key => $args[$dataGrid->keyName]));
				break;
		}

		$this->html->href($link);
	}


	/********************* interface mzk\DataGrid\IAction *********************/


	/**
	 * Gets action element template.
	 * @return Nette\Utils\Html
	 */
	public function getHtml()
	{
		return $this->html;
	}

}