<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require (APPPATH . '../vendor/autoload.php');

use Xajax\Xajax;
use Xajax\Response\Response;
use Xajax\Utils\Container as XajaxContainer;

class Xajax
{
	protected $xajax = null;
	protected $response = null;
	protected $validator = null;

	protected $preCallback = null;
	protected $postCallback = null;
	protected $initCallback = null;

	// Requested controller and method
	private $controller = null;
	private $method = null;

	/**
	 * Create a new Xajax instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->ci = get_instance();
		$this->xajax = Xajax::getInstance();
		$this->response = new Response();
		$this->validator = XajaxContainer::getInstance()->getValidator();
	}

	/**
	 * Initialise the Xajax library.
	 *
	 * @return void
	 */
	public function setup()
	{
		/**
		 * Todo: change to CodeIgniter setup
		 */
        // Xajax application settings
        $appConfig = $this->ci->config('app', 'xajax');
        $controllerDir = (array_key_exists('dir', $appConfig) ? $appConfig['dir'] : APPPATH . 'xajax');
        $namespace = (array_key_exists('namespace', $appConfig) ? $appConfig['namespace'] : '\\Xajax\\App');

        $excluded = (array_key_exists('excluded', $appConfig) ? $appConfig['excluded'] : array());
        // The public methods of the Controller base class must not be exported to javascript
        $controllerClass = new \ReflectionClass('\\Xajax\\CI\\Controller');
        foreach ($controllerClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $xMethod)
        {
            $excluded[] = $xMethod->getShortName();
        }
        // Use the Composer autoloader
        $this->xajax->useComposerAutoLoader();
        // Xajax library default options
        $this->xajax->setOptions(array(
            'js.app.export' => !$this->ci->config('debug'),
            'js.app.minify' => !$this->ci->config('debug'),
            'js.app.uri' => $this->ci->config('base_url') . 'xajax/js',
            'js.app.dir' => FCPATH . 'xajax/js',
        ));
        // Xajax library settings
        $libConfig = $this->ci->config('lib', 'xajax');
        \Xajax\Config\Config::setOptions($libConfig);
        // The request URI can be set with a CI route
        if(!$this->xajax->hasOption('core.request.uri'))
        {
            $this->xajax->setOption('core.request.uri', 'xajax');
        }
        // Register the default Xajax class directory
        $this->xajax->addClassDir($controllerDir, $namespace, $excluded);
	}

	/**
	 * Check if the current request is an Xajax request.
	 *
	 * @return boolean  True if the request is Xajax, false otherwise.
	 */
	public function canProcessRequest()
	{
		return $this->xajax->canProcessRequest();
	}

	/**
	 * Get the Xajax response.
	 *
	 * @return object  the Xajax response
	 */
	public function response()
	{
		return $this->response;
	}

	/**
	 * Register the Xajax classes.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->xajax->registerClasses();
	}

	/**
	 * Register a specified Xajax class.
	 *
	 * @return void
	 */
	public function registerClass($sClassName)
	{
		$this->xajax->registerClass($sClassName);
	}

	/**
	 * Get the javascript code generated for all registered classes.
	 *
	 * @return string  the javascript code
	 */
	public function javascript()
	{
		return $this->xajax->getJavascript();
	}

	/**
	 * Get the javascript code generated for all registered classes.
	 *
	 * @return string  the javascript code
	 */
	public function js()
	{
		return $this->xajax->getJsInclude();
	}

	/**
	 * Get the javascript code generated for all registered classes.
	 *
	 * @return string  the javascript code
	 */
	public function css()
	{
		return $this->xajax->getCssInclude();
	}

	/**
	 * Set the init callback, used to initialise controllers.
	 *
	 * @param  callable  $callable the callback function
	 * @return void
	 */
	public function setInitCallback($callable)
	{
		$this->initCallback = $callable;
	}

	/**
	 * Set the pre-request processing callback.
	 *
	 * @param  callable  $callable the callback function
	 * @return void
	 */
	public function setPreCallback($callable)
	{
		$this->preCallback = $callable;
	}

	/**
	 * Set the post-request processing callback.
	 *
	 * @param  callable  $callable the callback function
	 * @return void
	 */
	public function setPostCallback($callable)
	{
		$this->postCallback = $callable;
	}

	/**
	 * Initialise a controller.
	 *
	 * @return void
	 */
	protected function initController($controller)
	{
		// Si le controller a déjà été initialisé, ne rien faire
		if(!($controller) || ($controller->response))
		{
			return;
		}
		// Placer les données dans le controleur
		$controller->ci_xajax = $this;
		$controller->response = $this->response;
		if(($this->initCallback))
		{
			$cb = $this->initCallback;
			$cb($controller);
		}
		$controller->init();
	}

	/**
	 * Get a controller instance.
	 *
	 * @param  string  $classname the controller class name
	 * @return object  The registered instance of the controller
	 */
	public function controller($classname)
	{
		$controller = $this->xajax->registerClass($classname, true);
		if(!$controller)
		{
			return null;
		}
		$this->initController($controller);
		return $controller;
	}

	/**
	 * This is the pre-request processing callback passed to the Xajax library.
	 *
	 * @param  boolean  &$bEndRequest if set to true, the request processing is interrupted.
	 * @return object  the Xajax response
	 */
	public function preProcess(&$bEndRequest)
	{
		// Validate the inputs
		$class = $_POST['xjxcls'];
		$method = $_POST['xjxmthd'];
		if(!$this->validator->validateClass($class) || !$this->validator->validateMethod($method))
		{
			// End the request processing if the input data are not valid.
			// Todo: write an error message in the response
			$bEndRequest = true;
			return $this->response;
		}
		// Instanciate the controller. This will include the required file.
		$this->controller = $this->controller($class);
		$this->method = $method;
		if(!$this->controller)
		{
			// End the request processing if a controller cannot be found.
			// Todo: write an error message in the response
			$bEndRequest = true;
			return $this->response;
		}

		// Call the user defined callback
		if(($this->preCallback))
		{
			$cb = $this->preCallback;
			$cb($this->controller, $method, $bEndRequest);
		}
		return $this->response;
	}

	/**
	 * This is the post-request processing callback passed to the Xajax library.
	 *
	 * @return object  the Xajax response
	 */
	public function postProcess()
	{
		if(($this->postCallback))
		{
			$cb = $this->postCallback;
			$cb($this->controller, $this->method);
		}
		return $this->response;
	}

	/**
	 * Process the current Xajax request.
	 *
	 * @return void
	 */
	public function processRequest()
	{
		// Process Xajax Request
		$this->xajax->register(XAJAX_PROCESSING_EVENT, XAJAX_PROCESSING_EVENT_BEFORE, array($this, 'preProcess'));
		$this->xajax->register(XAJAX_PROCESSING_EVENT, XAJAX_PROCESSING_EVENT_AFTER, array($this, 'postProcess'));
		if($this->xajax->canProcessRequest())
		{
			// Traiter la requete
			$this->xajax->processRequest();
		}
	}
}
