<?php
require_once('Swat/SwatControlCellRenderer.php');

/**
 * Edit Control
 *
 * Convenience class for an Edit button
 *
 * @package Admin
 * @copyright silverorange 2004
 */
class AdminEditControlCellRenderer extends SwatControlCellRenderer {
	
	public function render($prefix) {
		$this->width  = 28;
		$this->height = 22;
		$this->title = _("Edit Item");
		$this->alt = _("Edit");
		$this->src = 'admin/images/b_edit.png';
	
		parent::render($prefix);
	}
}
