<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'controllers/App.php' );

class About extends App
{
	function __construct() {
		parent::__construct();
    $this->load->model('About_model');
	}

	public function index() {
		$data = array(
			'app' => $this->app(),
      'data' => $this->About_model->getActive()
		);

		$this->template->set('title', $data['app']->active_module->name . ' | ' . $data['app']->app_name, TRUE);
		$this->template->load_view($data['app']->template_frontend.'/index', $data, TRUE);
		$this->template->render();
	}
}
