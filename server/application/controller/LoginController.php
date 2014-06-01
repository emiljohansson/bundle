<?php

class LoginController extends Controller {
	public function initView() {
		$this->view = new LoginView();
		$this->view->init();
	}
}
