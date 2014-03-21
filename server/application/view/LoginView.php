<?php

class LoginView extends View {
	public function init() {
		$wrapper = new SimplePanel();
		$wrapper->setAttribute('id', 'login-container');

		$container = new HorizontalPanel();
		$container->setAttribute('id', 'signin');
		$container->addStyleName("container");
		
		$form = new FormPanel();
		$form->setAction('auth/login');
		$form->setMethod(FormPanel::METHOD_POST);
		
		$title = new Widget();
		$h2 = DOM::createHElement(1);
		$h2->setInnerHTML("Welcome");
		$title->setElement($h2);
		$form->add($title);

		$mailInput = new Input();
		$mailInput->setName("username");
		$mailInput->addStyleName("form-control");
		$mailInput->setAttribute("placeholder", "Username");
		$mailInput->setAttribute("required", "");
		$mailInput->setAttribute("autofocus", "");
		$form->add($mailInput);

		$passwordInput = new Input();
		$passwordInput->setName("password");
		$passwordInput->addStyleName("form-control");
		$passwordInput->setAttribute("placeholder", "Password");
		$passwordInput->setAttribute("required", "");
		$passwordInput->setType('password');
		$form->add($passwordInput);

		$submit = new Input("Sign in");
		$submit->addStyleName("btn btn-lg btn-primary btn-block");
		$submit->setType('submit');
		$form->add($submit);

		$container->add($form);
		$wrapper->add($container);
		$this->add($wrapper);
	}
}