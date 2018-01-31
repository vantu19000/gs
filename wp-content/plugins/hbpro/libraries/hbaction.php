<?php
//use HB\AImporter;
class HBAction{
	
	//protected $methods;
	//task is method to execute
	protected $task;
	//list of public methods in the class that can execute
	protected $taskMap;
	//name of the controller, it defines param in url and where is the folder of the controller file
	public $name;
	//input of request
	public $input;
	public $table;
	
	public function __construct(){
		$this->taskMap = array();
		$this->name = $this->getName();
		//$this->methods = array();
		$r = new ReflectionClass($this);
		$rMethods = $r->getMethods(ReflectionMethod::IS_PUBLIC);

		foreach ($rMethods as $rMethod)
		{
			$mName = $rMethod->getName();
			// Add default display method if not explicitly declared.
			$this->taskMap[strtolower($mName)] = $mName;
		}
		$this->input = HBFactory::getInput();
		$this->table = $this->get_table();
	}
	
	/**
	 * Execute a function in the controller
	 * Enter description here ...
	 * @param $task
	 */
	public function execute($task)
	{
		$this->task = $task;

		$task = strtolower($task);

		if (isset($this->taskMap[$task]))
		{
			$doTask = $this->taskMap[$task];
		}
		else
		{
			throw new Exception(sprintf(__('Task not found "%s" in class %s'), $task, get_class($this)), 404);
		}

		// Record the actual task being fired
		$this->doTask = $doTask;

		return $this->$doTask();
	}
	
	public function display($file){
		$file = $file.'.php';
		$find[] = HB_Template_Loader::getRoot().$file;
		$template       = locate_template( array_unique( $find ) );		
		include $template;
	}
	
/**
	 * Method to get the controller name
	 *
	 * The dispatcher name is set by default parsed using the classname, or it can be set
	 * by passing a $config['name'] in the class constructor
	 *
	 * @return  string  The name of the dispatcher
	 *
	 * @since   12.2
	 * @throws  Exception
	 */
	public function getName()
	{
		if (empty($this->name))
		{
			$r = null;
			
			if (!preg_match('/HBAction(.*)/', get_class($this), $r))
			{
				throw new Exception(sprintf(__('Invalid action name')), 500);
			}
			$this->name = strtolower($r[1]);
		}

		return $this->name;
	}
	
/**
	 * Method to get a reference to the current view and load it if necessary.
	 *
	 * @param   string  $name    The view name. Optional, defaults to the controller name.
	 * @param   string  $type    The view type. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for view. Optional.
	 *
	 * @return  JViewLegacy  Reference to the view or an error.
	 *
	 * @since   12.2
	 * @throws  Exception
	 */
	public function getView($name = '', $type = '', $prefix = '', $config = array())
	{
		// @note We use self so we only access stuff in this class rather than in all classes.
		if (!isset(self::$views))
		{
			self::$views = array();
		}

		if (empty($name))
		{
			$name = $this->getName();
		}

		if (empty($prefix))
		{
			$prefix = $this->getName() . 'View';
		}

		if (empty(self::$views[$name][$type][$prefix]))
		{
			if ($view = $this->createView($name, $prefix, $type, $config))
			{
				self::$views[$name][$type][$prefix] = & $view;
			}
			else
			{
				$response = 500;
				$app = JFactory::getApplication();

				/*
				 * With URL rewriting enabled on the server, all client
				 * requests for non-existent files are being forwarded to
				 * Joomla.  Return a 404 response here and assume the client
				 * was requesting a non-existent file for which there is no
				 * view type that matches the file's extension (the most
				 * likely scenario).
				 */
				if ($app->get('sef_rewrite'))
				{
					$response = 404;
				}

				throw new Exception(JText::sprintf('JLIB_APPLICATION_ERROR_VIEW_NOT_FOUND', $name, $type, $prefix), $response);
			}
		}

		return self::$views[$name][$type][$prefix];
	}
	
	public function get_table($table_name = '',$primary_key = array('id')){
		$this->table = new HbTable($table_name, $primary_key);
		return $this->table;
	}
	
	
	
}