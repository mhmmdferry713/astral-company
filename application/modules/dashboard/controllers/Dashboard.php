<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'controllers/App.php' );

class Dashboard extends App
{
	function __construct() {
		parent::__construct();
		$this->load->model([
			'Dashboard_model',
			'../../client/models/Client_model',
			'../../portfolio/models/PortfolioModel',
			'../../testimonial/models/TestimonialModel',
			'../../blog/models/Blog_model',
			'../../service/models/ServiceModel'
		]);
	}

	public function index() {
		$data = array(
			'app' => $this->app(),
			'data' => json_decode($this->Dashboard_model->getObject()),
			'data_client' => $this->Client_model->getAll(),
			'data_portfolio' => $this->PortfolioModel->getLatest(),
			'data_testimonial' => $this->TestimonialModel->getLatest(),
			'data_blog' => $this->Blog_model->getLatest(),
			'data_service' => $this->ServiceModel->getAll()
		);

		$this->template->set('title', $data['app']->app_name, TRUE);
		$this->template->load_view($data['app']->template_frontend.'/index', $data, TRUE);
		$this->template->render();
	}
}
