<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'controllers/AppBackend.php' );

class ModuleAbout extends AppBackend
{
	function __construct() {
    parent::__construct();
    $this->load->model('../../about/models/About_model');
    $this->load->library('form_validation');
	}

	public function index() {
		$data = array(
      'app' => $this->app(),
      'main_js' => $this->load_main_js('moduleAbout'),
      'card_title' => 'Module › About',
      'data' => $this->About_model->getActive()
		);
		$this->template->set('title', 'Module About | ' . $data['app']->app_name, TRUE);
		$this->template->load_view('moduleAbout/index', $data, TRUE);
		$this->template->render();
  }

  public function ajax_save() {
    $this->handle_ajax_request();
    $this->form_validation->set_rules($this->About_model->rules());

    if ($this->form_validation->run() === true) {
      $cpUpload = new CpUpload();
      $upload = $cpUpload->run('image', 'about', true, true, 'jpg|png|gif');
      $_POST['image'] = '';

      if ($upload->status === true) {
        $_POST['image'] = $upload->data->base_path;
      };

      echo json_encode($this->About_model->update());
    } else {
      $errors = validation_errors('<div>- ', '</div>');
      echo json_encode(array('status' => false, 'data' => $errors));
    };
  }
}
