<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'controllers/AppBackend.php' );

class ModuleCareer extends AppBackend
{
	function __construct() {
    parent::__construct();
    $this->load->model([
      'App_model',
      'Provinces_model',
      'Regencies_model',
      '../../career/models/Career_model'
    ]);
    $this->load->library('form_validation');
	}

	public function index() {
		$data = array(
      'app' => $this->app(),
      'main_js' => $this->load_main_js('moduleCareer'),
      'card_title' => 'Module › Career',
		);
		$this->template->set('title', 'Module Career | ' . $data['app']->app_name, TRUE);
		$this->template->load_view('moduleCareer/index', $data, TRUE);
		$this->template->render();
  }

	public function create() {
		$data = array(
      'app' => $this->app(),
      'main_js' => $this->load_main_js('moduleCareer'),
      'card_title' => 'Module › Career: Create',
      'data_provinces' => $this->Provinces_model->getAll()
		);
		$this->template->set('title', 'Module Career: Create | ' . $data['app']->app_name, TRUE);
		$this->template->load_view('moduleCareer/form', $data, TRUE);
		$this->template->render();
  }

	public function update($id) {
    $temp = $this->Career_model->getDetail('id', $id);
		$data = array(
      'app' => $this->app(),
      'main_js' => $this->load_main_js('moduleCareer'),
      'card_title' => 'Module › Career: Update',
      'data' => $temp,
      'data_provinces' => $this->Provinces_model->getAll(),
      'data_regencies' => $this->Regencies_model->getFilter('province_id', $temp->province_id)
		);
		$this->template->set('title', 'Module Career: Update | ' . $data['app']->app_name, TRUE);
		$this->template->load_view('moduleCareer/form', $data, TRUE);
		$this->template->render();
  }
  
  public function ajax_getAll() {
    $this->handle_ajax_request();
		$dtAjax_config = array(
      'table_name' => 'view_career',
      'order_column' => 5,
      'order_direction' => 'desc'
		);
    $response = $this->App_model->getData_dtAjax( $dtAjax_config );
		echo json_encode( $response );
  }

  public function ajax_getRegencies($province_id) {
    $this->handle_ajax_request();
    echo json_encode($this->Regencies_model->getFilter('province_id', $province_id));
  }

  public function ajax_save() {
    $this->handle_ajax_request();
    $this->form_validation->set_rules($this->Career_model->rules());

    if ($this->form_validation->run() === true) {
      if (empty($_POST['id'])) {
        // Insert
        echo json_encode($this->Career_model->insert());
      } else {
        // Update
        echo json_encode($this->Career_model->update($_POST['id']));
      };
    } else {
      $errors = validation_errors('<div>- ', '</div>');
      echo json_encode(array('status' => false, 'data' => $errors));
    };
  }

  public function ajax_delete($id) {
    $this->handle_ajax_request();
    echo json_encode($this->Career_model->delete($id));
  }
}
