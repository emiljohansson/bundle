<?php

class HomeView extends View {

	public $storagePath;
	public $localPath;
	private $lister;

	public function __construct() {
		parent::__construct();
		$this->initLister();
	}

	public function init() {
		$this->initFolderForm();
		$this->initUploadForm();
	}

	public function addFolderRow(Folder $folder) {
		$hpanel = new HorizontalPanel();

		$icon = new Icon('fa fa-folder');
		$link = new Link($folder->basename, '?folder='.$this->localPath.'/'.$folder->basename, $icon);
		$hpanel->add($link);

		$this->addRemoveLink($folder, $hpanel);

		$this->lister->add($hpanel);
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

	private function initFolderForm() {
		$form = new FormPanel();
		$form->setAction('api/folder/add');
		$form->setMethod(FormPanel::METHOD_POST);

		$input = new Hidden($this->storagePath);
		$input->setName('path');
		$form->add($input);

		$input = new Input();
		$input->setName('folderName');
		$form->add($input);

		$submit = new Input("Submit");
		$submit->setType('submit');
		$form->add($submit);

		$this->add($form);
	}

	private function initUploadForm() {
		$form = new FormPanel();
		$form->setAction('api/file/upload');
		$form->setMethod(FormPanel::METHOD_POST);
		$form->setAttribute('enctype', 'multipart/form-data');

		$input = new Hidden($this->storagePath);
		$input->setName('path');
		$form->add($input);

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
		$hpanel->add(new Label());

		$icon = new Icon('fa fa-eye');
		$link = new Link($file->basename, 'file/?preview='.$file->basename, $icon);
		$hpanel->add($link);

		$icon = new Icon('glyphicon glyphicon-download');
		$link = new Link('Download', 'file/?download='.$file->basename, $icon);
		$hpanel->add($link);

		$this->addRemoveLink($file, $hpanel);

		$this->lister->add($hpanel);
	}

	private function addRemoveLink(File $file, Panel $panel) {
		$icon = new Icon('glyphicon glyphicon-trash');
		$link = new Link('Remove', $file->type.'/?remove='.$file->basename, $icon);
		$panel->add($link);
	}
}
