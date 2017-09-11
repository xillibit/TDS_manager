<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
 * Declarations Table class
 */
class TDSManagerTableDeclarations extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$db) {
		parent::__construct('#__declarations', 'id', $db);
	}

	/**
	 * Overloaded check method to ensure data integrity.
	 *
	 * @return	boolean	True on success.
	 */
	function check() {
		if (empty($this->start_date)) {
			$this->setError(JText::_('COM_TDSMANAGER_REQUIRES_STARTDATE'));
			return false;
		}

		if (empty($this->end_date)) {
			$this->setError(JText::_('COM_TDSMANAGER_REQUIRES_ENDDATE'));
			return false;
		}

		if (empty($this->identification_periode)) {
			$this->setError(JText::_('COM_TDSMANAGER_REQUIRES_IDENTIFICATION_PERIODE'));
			return false;
		}

		if (empty($this->nb_personnes_assujetties)) {
			$this->setError(JText::_('COM_TDSMANAGER_REQUIRES_PERSONNES_ASSUJETTIES'));
			return false;
		}

		if (empty($this->nb_total_nuitee)) {
			$this->setError(JText::_('COM_TDSMANAGER_REQUIRES_TOTAL_NUITEE'));
			return false;
		}

		if (empty($this->montant_encaisse_jour)) {
			$this->setError(JText::_('COM_TDSMANAGER_REQUIRES_MONTANT_ENCAISSE_JOUR'));
			return false;
		}

		return true;
	}
}