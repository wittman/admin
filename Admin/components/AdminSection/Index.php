<?php

require_once 'Admin/AdminUI.php';
require_once 'SwatDB/SwatDB.php';
require_once 'Admin/pages/AdminIndex.php';
require_once 'Admin/AdminTableStore.php';

/**
 * Index page for AdminSections
 *
 * @package Admin
 * @copyright silverorange 2004
 */
class AdminAdminSectionIndex extends AdminIndex
{
	// init phase
	// {{{ protected function initInternal()

	protected function initInternal()
	{
		$this->ui->loadFromXML(dirname(__FILE__).'/index.xml');
	}

	// }}}

	// process phase
	// {{{ protected function processActions()

	protected function processActions(SwatTableView $view, SwatActions $actions)
	{
		$num = count($view->checked_items);
		$message = null;
		
		switch ($actions->selected->id) {
			case 'delete':
				$this->app->replacePage('AdminSection/Delete');
				$this->app->getPage()->setItems($view->checked_items);
				break;

			case 'show':
				SwatDB::updateColumn($this->app->db, 'AdminSection',
					'boolean:show', true, 'id', $view->checked_items);

				$message = new SwatMessage(sprintf(Admin::ngettext(
					'One section has been shown.',
					'%d sections have been shown.', $num),
					SwatString::numberFormat($num)));

				break;

			case 'hide':
				SwatDB::updateColumn($this->app->db, 'AdminSection',
					'boolean:show', false, 'id', $view->checked_items);

				$message = new SwatMessage(sprintf(Admin::ngettext(
					"One section has been hidden.",
					"%d sections have been hidden.", $num),
					SwatString::numberFormat($num)));

				break;
		}

		if ($message !== null)
			$this->app->messages->add($message);
	}

	// }}}

	// build phase
	// {{{ protected function getTableStore()

	protected function getTableStore($view)
	{
		$sql = 'select id, title, show
				from AdminSection
				order by displayorder';

		$sections = SwatDB::query($this->app->db, $sql);
		$store = new SwatTableStore();

		foreach ($sections as $section)
			$store->addRow($section);

		if ($store->getRowCount() == 0)
			$this->ui->getWidget('order_tool')->visible = false;


		return $store;
	}

	// }}}
}

?>
