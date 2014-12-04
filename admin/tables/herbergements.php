<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
 * Herbegements Table class
 */
class GestTaxeSejourTableHebergements extends JTable {
  /**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$db) {
		parent::__construct('#__hebergements', 'id', $db);
	}

	/**
	 * Overloaded check method to ensure data integrity.
	 *
	 * @return	boolean	True on success.
	 */
	function check() {
		if (empty($this->adress)) {
			$this->setError(JText::_('COM_TDSMANAGER_REQUIRES_ADRESS'));
			return false;
		}

		if (empty($this->postalcode)) {
			$this->setError(JText::_('COM_TDSMANAGER_REQUIRES_POSTALCODE'));
			return false;
		}

		if (empty($this->ville)) {
			$this->setError(JText::_('COM_TDSMANAGER_REQUIRES_VILLE'));
			return false;
		}

		if (empty($this->phone)) {
			$this->setError(JText::_('COM_TDSMANAGER_REQUIRES_PHONE'));
			return false;
		}

		if (empty($this->email)) {
			$this->setError(JText::_('COM_TDSMANAGER_REQUIRES_EMAIL'));
			return false;
		}

		if (empty($this->owner_name)) {
			$this->setError(JText::_('COM_TDSMANAGER_REQUIRES_OWNER_NAME'));
			return false;
		}

		return true;
	}

	/**
	 * Overloaded delete method to unsure that there aren't hosting places in reglements or declarations.
	 *
	 * @param	mixed	An optional primary key value to delete.  If not set the
	 *					instance property value is used.
	 * @return	boolean	True on success.
	 */
	public function delete($pk = null) {
	 // check in hosting place


	 // check in reglements


	 // check in declarations

	 return true;
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table directly.
	 *
	 * @param	mixed	An optional array of primary key values to update.  If not
	 *					set the instance property value is used.
	 * @param	integer The publishing state. eg. [0 = unpublished, 1 = published]
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function publish($pks = null, $state = 1) {
	  // Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks)) {
			if ($this->$k) {
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else {
				$this->setError(JText::_('COM_TDSMANAGER_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Build the WHERE clause for the primary keys.
		$where = $k.' IN ('.implode(',', $pks).')';

		// Update the publishing state for rows with the given primary keys.
		$this->_db->setQuery(
			'UPDATE '.$this->_db->quoteName($this->_tbl).
			' SET '.$this->_db->quoteName('state').' = '.(int) $state .
			' WHERE ('.$where.')'
		);
		$this->_db->query();

		// Check for a database error.
		if ($this->_db->getErrorNum()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

	 return true;
	}
}