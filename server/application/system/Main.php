<?php

class Main extends Engine {
	//-----------------------------------------------------------
	//	Protected methods
	//-----------------------------------------------------------

	/**
	 *	Initializes the selected controller, based on the url.
	 *	
	 *	@return	void
	 */
	protected function initController() 
	{
		if (Auth::getUser() === null && @$_GET['controller'] !== "auth") {
			$this->controller = new LoginController();
			return;
		}
		parent::initController();
	}
}