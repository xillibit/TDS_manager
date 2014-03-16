<?php
/**
 * Kunena Component
 * @package Kunena.Framework
 *
 * @copyright (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

jimport ( 'joomla.application.component.view' );

/**
 * Gesttaxe View Class
 */
class TdsmanagerView extends JView {
	public $document = null;
	public $app = null;
	public $embedded = false;

	protected $_row = 0;

	function __construct($config = array()){
		parent::__construct($config);
		$this->document = JFactory::getDocument(); 		
		$this->app = JFactory::getApplication ();
			
	}

	function displayAll() {	 
   if (JFactory::getApplication()->isAdmin()) {
			$this->displayLayout();
		} else {
      $view = $this->getName ();	
      $this->displayTemplateFile($view, 'default');
    }    	
	}

	function displayLayout($layout=null, $tpl = null) {     		
    if ($layout) $this->setLayout ($layout);
		$view = $this->getName ();
		$layout = $this->getLayout ();
		$viewName = ucfirst($view);
		$layoutName = ucfirst($layout);
		$layoutFunction = 'display'.$layoutName;  
	             
		if (isset($this->common)) {
			if ($this->config->board_offline && ! $this->me->isAdmin ()) {
				// Forum is offline
				$this->common->header = JText::_('COM_KUNENA_FORUM_IS_OFFLINE');
				$this->common->body = $this->config->offline_message;
				$this->common->html = true;
				$this->common->display('default');
				KUNENA_PROFILER ? $this->profiler->stop("display {$viewName}/{$layoutName}") : null;
				return;
			} elseif ($this->config->regonly && ! $this->me->exists()) {
				// Forum is for registered users only
				$this->common->header = JText::_('COM_KUNENA_LOGIN_NOTIFICATION');
				$this->common->body = JText::_('COM_KUNENA_LOGIN_FORUM');
				$this->common->display('default');
				KUNENA_PROFILER ? $this->profiler->stop("display {$viewName}/{$layoutName}") : null;
				return;
			} elseif (!method_exists($this, $layoutFunction) && !file_exists(KPATH_SITE."/views/{$view}/{$layout}.php")) {
				// Layout was not found (don't allow Joomla to raise an error)
				echo $this->displayNoAccess(array(JText::_('COM_KUNENA_NO_ACCESS')));
				KUNENA_PROFILER ? $this->profiler->stop("display {$viewName}/{$layoutName}") : null;
				return;
			}
		}
    
    $state = $this->get ( 'State' );
               
		$this->assignRef ( 'state', $state );
		if (method_exists($this, $layoutFunction)) {
			$contents = $this->$layoutFunction ($tpl);
		} else {
			$contents = $this->display($tpl);
		}
		
		return $contents;
	}
	
	function getViewFile($view, $tpl) {     	  
    $tpl =  JPATH_BASE.'/components/com_gesttaxesejour/views/'.$view.'/tmpl/'.$tpl.'.php';
    if (!file_exists($tpl)) JError::raiseError(500, JText::sprintf('JLIB_APPLICATION_ERROR_LAYOUTFILE_NOT_FOUND', $tpl));
    
    ob_start();
		include $tpl;
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
  }

	function displayModulePosition($position) {
		echo $this->getModulePosition($position);
	}

	function isModulePosition($position) {
		return JDocumentHTML::countModules ( $position );
	}

	function getModulePosition($position) {
		$html = '';
		if (JDocumentHTML::countModules ( $position )) {
			$renderer = JFactory::getDocument ()->loadRenderer ( 'modules' );
			$options = array ('style' => 'xhtml' );
			$html .= '<div class="'.$position.'">';
			$html .= $renderer->render ( $position, $options, null );
			$html .= '</div>';
		}
		return $html;
	}

	function parse($text, $len=0) {
		return KunenaHtmlParser::parseBBCode($text, $this, $len);
	}

	public function getButton($link, $name, $scope, $type, $id = null) {
		return $this->ktemplate->getButton($link, $name, $scope, $type, $id);
	}

	function getIcon($name, $title='') {
		return $this->ktemplate->getIcon($name, $title);
	}

	function getImage($image, $alt='') {
		return $this->ktemplate->getImage($image, $alt);
	}

	function getClass($class, $class_sfx='') {
		return $this->ktemplate->getClass($class, $class_sfx);
	}

	public function get($property, $default = null) {
		//KUNENA_PROFILER ? $this->profiler->start("model get{$property}") : null;
		$result = parent::get($property, $default);
		//KUNENA_PROFILER ? $this->profiler->stop("model get{$property}") : null;
		return $result;
	}

	function getTime() {
		if ( !$this->config->time_to_create_page ) return;
		$time = $this->profiler->getTime('Total Time');
		return sprintf('%0.3f', $time);
	}

	/**
	 * This function formats a number to n significant digits when above
	 * 10,000. Starting at 10,0000 the out put changes to 10k, starting
	 * at 1,000,000 the output switches to 1m. Both k and m are defined
	 * in the language file. The significant digits are used to limit the
	 * number of digits displayed when in 10k or 1m mode.
	 *
	 * @param int $number 		Number to be formated
	 * @param int $precision	Significant digits for output
	 */
	function formatLargeNumber($number, $precision = 3) {
		$output = '';
		// Do we need to reduce the number of significant digits?
		if ($number >= 10000){
			// Round the number to n significant digits
			$number = round ($number, -1*(log10($number)+1) + $precision);
		}

		if ($number < 10000) {
			$output = $number;
		} elseif ($number >= 1000000) {
			$output = $number / 1000000 . JText::_('COM_KUNENA_MILLION');
		} else {
			$output = $number / 1000 . JText::_('COM_KUNENA_THOUSAND');
		}

		return $output;
	}

	public function getCategoryLink(KunenaForumCategory $category, $content = null, $title = null, $class = null) {
		if (!$content) $content = $this->escape($category->name);
		if ($title === null) $title = JText::sprintf('COM_KUNENA_VIEW_CATEGORY_LIST_CATEGORY_TITLE', $this->escape($category->name));
		return JHTML::_('kunenaforum.link', $category->getUri(), $content, $title, $class, 'follow');
	}

	public function getTopicLink(KunenaForumTopic $topic, $action = null, $content = null, $title = null, $class = null, KunenaForumCategory $category = NULL) {
		$uri = $topic->getUri($category ? $category : $this->category, $action);
		if (!$content) $content = KunenaHtmlParser::parseText($topic->subject);
		if ($title === null) {
			if ($action instanceof KunenaForumMessage) {
				$title = JText::sprintf('COM_KUNENA_TOPIC_MESSAGE_LINK_TITLE', $this->escape($topic->subject));
			} else {
				switch ($action) {
					case 'first':
						$title = JText::sprintf('COM_KUNENA_TOPIC_FIRST_LINK_TITLE', $this->escape($topic->subject));
						break;
					case 'last':
						$title = JText::sprintf('COM_KUNENA_TOPIC_LAST_LINK_TITLE', $this->escape($topic->subject));
						break;
					case 'unread':
						$title = JText::sprintf('COM_KUNENA_TOPIC_UNREAD_LINK_TITLE', $this->escape($topic->subject));
						break;
					default:
						$title = JText::sprintf('COM_KUNENA_TOPIC_LINK_TITLE', $this->escape($topic->subject));
				}
			}
		}
		return JHTML::_('kunenaforum.link', $uri, $content, $title, $class, 'nofollow');
	}

	public function addStyleSheet($filename) {
		return KunenaFactory::getTemplate()->addStyleSheet ( $filename );
	}

	public function addScript($filename) {
		return KunenaFactory::getTemplate()->addScript ( $filename );
	}

	function displayNoAccess($errors = array()) {
		$output = '';
		foreach ($errors as $error) $output .= "<p>{$error}</p>";
		$this->common->setLayout ( 'default' );
		$this->common->assign ( 'header', JText::_('COM_KUNENA_ACCESS_DENIED'));
		$this->common->assign ( 'body', $output);
		$this->common->assign ( 'html', true);
		$this->common->display();
		$this->setTitle(JText::_('COM_KUNENA_ACCESS_DENIED'));
	}

	function displayMenu() {
		echo $this->common->display('menu');
	}

	function displayLoginBox() {
		echo $this->common->display('loginbox');
	}

	function displayFooter() {
		echo $this->common->display('footer');
	}

	function displayBreadcrumb() {
		echo $this->common->display('breadcrumb');
	}

	function displayForumJump() {
		if (KunenaFactory::getConfig()->enableforumjump) {
			$this->common->catid = !empty($this->category->id) ? $this->category->id : 0;
			echo $this->common->display('forumjump');
		}
	}

	function displayWhoIsOnline($tpl = null) {
		if (KunenaFactory::getConfig()->showwhoisonline > 0) {
			echo $this->common->display('whosonline');
		}
	}

	function displayStatistics() {
		if (KunenaFactory::getConfig()->showstats > 0) {
			echo $this->common->display('statistics');
		}
	}

	function displayAnnouncement() {
		if (KunenaFactory::getConfig()->showannouncement > 0) {
			echo $this->common->display('announcement');
		}
	}

	function displayFormToken() {
		echo '[K=TOKEN]';
	}

	function row($start=false) {
		if ($start) $this->_row = 0;
		return ++$this->_row & 1 ? 'odd' : 'even';
	}

	public function displayTemplateFile($view, $layout, $template = null) {
		$file = JPATH_SITE."/components/com_gesttaxesejour/views/{$view}/tmpl/{$layout}.php";		
		if (!file_exists($file)) JError::raiseError(500, JText::sprintf('JLIB_APPLICATION_ERROR_LAYOUTFILE_NOT_FOUND', $file));

		ob_start();
		include $file;
		$output = ob_get_contents();
		ob_end_clean();
		if (JDEBUG || $this->config->get('debug')) {
			$output = trim($output);
			$output = "\n<!-- START {$file} -->\n{$output}\n<!-- END {$file} -->\n";
		}
		echo $output;
	}

	/**
	 * Load a template file -- first look in the templates folder for an override
	 *
	 * @param   string   The name of the template source file ...
	 * 					automatically searches the template paths and compiles as needed.
	 * @return  string   The output of the the template script.
	 */
	public function loadTemplateFile($tpl = null)
	{
		KUNENA_PROFILER ? $this->profiler->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;

		static $files = array();

		// Create the template file name based on the layout
		$layout = $this->getLayout();
		$file = isset($tpl) ? $layout.'_'.$tpl : $layout;

		if (!isset($files[$file])) {
			$template = JFactory::getApplication()->getTemplate();
			// TODO: what is this?
			$layoutTemplate = null; // $this->getLayoutTemplate();

			// Clean the file name
			$file = preg_replace('/[^A-Z0-9_\.-]/i', '', $file);
			$tpl  = isset($tpl)? preg_replace('/[^A-Z0-9_\.-]/i', '', $tpl) : $tpl;

			// Change the template folder if alternative layout is in different template
			if (isset($layoutTemplate) && $layoutTemplate != '_' && $layoutTemplate != $template)
			{
				$path = str_replace($template, $layoutTemplate, $this->_path['template']);
			} else {
				$path = $this->_path['template'];
			}

			// Load the template script
			jimport('joomla.filesystem.path');
			$filetofind	= $this->_createFileName('template', array('name' => $file));
			$files[$file] = JPath::find($path, $filetofind);

			// If alternate layout can't be found, fall back to default layout
			// TODO: allow alternative layouts from Joomla templates
/*
			if ($files[$file] == false)
			{
				$filetofind = $this->_createFileName('', array('name' => 'default' . (isset($tpl) ? '_' . $tpl : $tpl)));
				$files[$file] = JPath::find($this->_path['template'], $filetofind);
			}
*/
		}
		$this->_template = $files[$file];

		if ($this->_template != false)
		{
			$templatefile = preg_replace('%'.JPATH_ROOT.'/%', '', $this->_template);

			// Unset so as not to introduce into template scope
			unset($tpl);
			unset($file);

			// Never allow a 'this' property
			if (isset($this->this)) {
				unset($this->this);
			}

			// Start capturing output into a buffer
			ob_start();
			// Include the requested template filename in the local scope
			// (this will execute the view logic).
			include $this->_template;

			// Done with the requested template; get the buffer and
			// clear it.
			$output = ob_get_contents();
			ob_end_clean();

			if (JDEBUG || $this->config->get('debug')) {
				$output = trim($output);
				$output = "\n<!-- START {$templatefile} -->\n{$output}\n<!-- END {$templatefile} -->\n";
			}
		} else {
			$output = JError::raiseError(500, JText::sprintf('JLIB_APPLICATION_ERROR_LAYOUTFILE_NOT_FOUND', $file));
		}
		KUNENA_PROFILER ? $this->profiler->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		return $output;
	}

	final public function poweredBy() {
			$credits = '<div style="text-align:center">';
			$credits .= JHTML::_('kunenaforum.link', 'index.php?option=com_kunena&view=credits', JText::_('COM_KUNENA_POWEREDBY'), '', '', 'follow', array('style'=>'display: inline; visibility: visible; text-decoration: none;'));
			$credits .= ' <a href="http://www.kunena.org" rel="follow" target="_blank" style="display: inline; visibility: visible; text-decoration: none;">'.JText::_('COM_KUNENA').'</a>';
			if ($this->ktemplate->params->get('templatebyText')) {
				$credits .= ' :: <a href ="'. $this->ktemplate->params->get('templatebyLink').'" rel="follow" target="_blank" style="text-decoration: none;">' . $this->ktemplate->params->get('templatebyText') .' '. $this->ktemplate->params->get('templatebyName') .'</a>';
			}
			$credits .= '</div>';
			echo $credits;
	}

	// Caching
	function getTemplateMD5() {
		return md5(serialize($this->_path['template']).'-'.$this->ktemplate->name);
	}

	function setTitle($title) {
		if (!$this->state->get('embedded')) {
			// Check for empty title and add site name if param is set
			$title = strip_tags($title);
			if ($this->app->getCfg('sitename_pagetitles', 0) == 1) {
				$title = JText::sprintf('JPAGETITLE', $this->app->getCfg('sitename'), $this->config->board_title .' - '. $title);
			} elseif ($this->app->getCfg('sitename_pagetitles', 0) == 2) {
				$title = JText::sprintf('JPAGETITLE', $title .' - '. $this->config->board_title, $this->app->getCfg('sitename'));
			} else {
				// TODO: allow translations/overrides (also above)
				$title = KunenaFactory::getConfig()->board_title .' :: '. $title;
			}
			$this->document->setTitle($title);
		}
	}

	function setKeywords($keywords) {
		if (!$this->state->get('embedded')) {
			if ( !empty($keywords) ) $this->document->setMetadata ( 'keywords', $keywords );
		}
	}

	function setDescription($description) {
		if (!$this->state->get('embedded')) {
			// TODO: allow translations/overrides
			$this->document->setMetadata ( 'description', $this->document->get ( 'description' ) . '. ' . $description );
		}
	}
}