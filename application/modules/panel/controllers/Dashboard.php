<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'controllers/AppBackend.php' );

class Dashboard extends AppBackend
{
	function __construct() {
		parent::__construct();
		$this->load->model(['Statistic_model']);
	}

	public function dump($var, $die = true) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';

		if ($die) {
			die;
		};
	}

	public function index() {
		$data = array(
			'app' => $this->app(),
      'main_js' => $this->load_main_js('dashboard'),
			'statistic' => $this->Statistic_model->getStatistic(),
			'blog_rank' => $this->Statistic_model->getBlogRank(),
			'page_rank' => $this->Statistic_model->getPageRank(),
			'page_title' => 'Dashboard',
			'page_subTitle' => 'Welcome to the admin panel of '.$this->app()->app_name.'.'
		);

		$this->template->set('title', $data['app']->app_name, TRUE);
		$this->template->load_view('dashboard/index', $data, TRUE);
		$this->template->render();
	}

	public function ajax_get_statisticPeriod() {
		$this->handle_ajax_request();
		$sp1 = $this->Statistic_model->getByPeriod(date('Y') - 1);
		$sp2 = $this->Statistic_model->getByPeriod(date('Y'));
		$sp3 = array(
			'sp1' => $sp1,
			'sp2' => $sp2
		);
		echo json_encode(array('status' => true, 'data' => $sp3));
  }
}
