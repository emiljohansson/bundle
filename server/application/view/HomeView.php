<?php

class HomeView extends View {

	private $lister;

	public function init() {
		$this->initUploadForm();
		$this->initLister();
	}

	public function addFileRow(File $file) {
		switch ($file->extension) {
		 	case 'png':
		 	case 'gif':
		 	case 'jpg':
		 	case 'jpeg':
		 		$this->addImageRow($file);
		 		break;
		 	
		 	default:
		 		$this->addTextRow($file);
		 		break;
		 }
	}

	private function initUploadForm() {
		$form = new FormPanel();
		$form->setAction('api/file/upload');
		$form->setMethod(FormPanel::METHOD_POST);
		$form->setAttribute('enctype', 'multipart/form-data');

		$input = new Input();
		$input->setType('file');
		$input->setName('file');
		$input->setAttribute('id', 'drop-area');
		$form->add($input);

		$submit = new Input("Submit");
		$submit->addStyleName("ui-hidden");
		$submit->setType('submit');
		$submit->setAttribute('id', 'drop-submit');
		$form->add($submit);

		$this->add($form);
	}

	private function initLister() {
		$this->lister = new VerticalPanel();
		$this->lister->setAttribute('id', 'lister-table');
		$this->add($this->lister);
	}

	private function addImageRow(File $file) {
		$hpanel = new HorizontalPanel();
		$icon = new Image('file/?download='.$file->basename, $file->basename);
		$icon->setAttribute('style', 'width:35px;');
		$hpanel->add($icon);
		$hpanel->add(new Anchor('preview', 'file/?preview='.$file->basename));
		$this->addRemoveLink($file, $hpanel);
		$this->lister->add($hpanel);
	}

	private function addTextRow(File $file) {
		$hpanel = new HorizontalPanel();
		$hpanel->add(new Label($file->basename));
		$hpanel->add(new Anchor('preview', 'file/?preview='.$file->basename));

		$icon = new Icon('glyphicon glyphicon-download');
		$link = new Link('', 'file/?remove='.$file->basename, $icon);

		$hpanel->add($link);
		$this->addRemoveLink($file, $hpanel);
		$this->lister->add($hpanel);
	}

	private function addRemoveLink(File $file, Panel $panel) {
		$icon = new Icon('glyphicon glyphicon-trash');
		$link = new Link('', 'file/?remove='.$file->basename, $icon);
		$panel->add($link);
	}
}