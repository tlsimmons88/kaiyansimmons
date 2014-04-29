<?php

class layout 
{
	private $view;
	private $viewData = array();
	private $controller;
	private $action;
	private $layout;
	
	public function __construct()
	{
		$this->view =& get_instance();
	}
	
	public function set($name , $data)
	{
		$this->viewData[$name] = $data;
	}
	
	public function render($layout = 'default')
	{
		$this->controller = $this->view->router->fetch_class();
		$this->action = $this->view->router->fetch_method();
		
		//Check that the view actually exists.
		$viewFolder = APPPATH . 'views/';
		if(!is_file($viewFolder . $this->controller . '/' . $this->action . '.phtml'))
		{
			throw new ErrorException('Missing View ' . $this->controller . '/' . $this->action . '.phtml');
		}
		
		//Check if they want a layout and if it actually exists.
		if($layout)
		{
			if(!is_file($viewFolder . 'layouts/' . $layout . '.phtml'))
			{
				throw new ErrorException('Missing Layout ' . 'layouts/' . $layout . '.phtml');
			}
			
			//Because codeigniter is so stupid, we nest the variables to be created inside itself.  So that the variables
			//the programmer created can both be accessed in the layouts and in the final view. 
			$this->viewData['variables_for_view'] = $this->viewData;
			$this->viewData['view_to_render'] = $this->controller . '/' . $this->action . '.phtml';
			$this->view->load->view('layouts/'.$layout.'.phtml' , $this->viewData);
		}
		else
		{
			$this->view->load->view($this->controller . '/' . $this->action . '.phtml' , $this->viewData);
		}
	}
}