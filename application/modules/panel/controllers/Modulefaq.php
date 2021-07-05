<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'controllers/AppBackend.php' );

class ModuleFaq extends AppBackend
{
	function __construct() {
    parent::__construct();
    $this->load->model([
      'App_model',
      '../../faq/models/Faq_model'
    ]);
    $this->load->library('form_validation');
	}

	public function index() {
		$data = array(
      'app' => $this->app(),
      'main_js' => $this->load_main_js('moduleFaq'),
			'card_title' => 'Module › FAQ'
		);
		$this->template->set('title', 'Module Faq | ' . $data['app']->app_name, TRUE);
		$this->template->load_view('moduleFaq/index', $data, TRUE);
		$this->template->render();
  }
  
  public function ajax_getAll() {
    $this->handle_ajax_request();
		$dtAjax_config = array(
      'table_name' => 'faq',
      'order_column' => 4,
      'order_direction' => 'desc'
		);
    $response = $this->App_model->getData_dtAjax( $dtAjax_config );
		echo json_encode( $response );
  }

  public function ajax_save($id = null) {
    $this->handle_ajax_request();
    $this->form_validation->set_rules($this->Faq_model->rules());

    if ($this->form_validation->run() === true) {
      if (is_null($id)) {
        // Insert
        echo json_encode($this->Faq_model->insert());
      } else {
        // Update
        echo json_encode($this->Faq_model->update($id));
      };
    } else {
      $errors = validation_errors('<div>- ', '</div>');
      echo json_encode(array('status' => false, 'data' => $errors));
    };
  }

  public function ajax_delete($id) {
    $this->handle_ajax_request();
    echo json_encode($this->Faq_model->delete($id));
  }
}
