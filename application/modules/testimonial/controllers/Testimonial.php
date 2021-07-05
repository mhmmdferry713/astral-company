<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'controllers/App.php' );

class Testimonial extends App
{
	function __construct() {
		parent::__construct();
		$this->load->model(['Testimonial_model']);
		$this->load->library('pagination');
	}

	public function index() {
		$pagination = $this->setPagination();
		$data = array(
			'app' => $this->app(),
			'data' => $this->Testimonial_model->getAll([], 'created_at desc', $pagination->config->per_page, $pagination->offset),
			'pagination' => $pagination->link
		);

		$this->template->set('title', $data['app']->active_module->name . ' | ' . $data['app']->app_name, TRUE);
		$this->template->load_view($data['app']->template_frontend.'/index', $data, TRUE);
		$this->template->render();
	}

	private function setPagination() {
		$pagination = array(
			'per_page' => 12,
			'base_url' => base_url('testimonial/'),
			'total_rows' => $this->Testimonial_model->getRowCount(),
			'use_page_numbers' => true,
			'page_query_string' => true,
			'query_string_segment' => 'page',
			'first_link' => 'First',
			'last_link' => 'Last',
			'next_link' => 'Next',
			'prev_link' => 'Prev',
			'full_tag_open' => '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">',
			'full_tag_close' => '</ul></nav></div>',
			'num_tag_open' => '<li class="page-item"><span class="page-link">',
			'num_tag_close' => '</span></li>',
			'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
			'cur_tag_close' => '<span class="sr-only">(current)</span></span></li>',
			'next_tag_open' => '<li class="page-item"><span class="page-link">',
			'next_tagl_close' => '<span aria-hidden="true">&raquo;</span></span></li>',
			'prev_tag_open' => '<li class="page-item"><span class="page-link">',
			'prev_tagl_close' => '</span>Next</li>',
			'first_tag_open' => '<li class="page-item"><span class="page-link">',
			'first_tagl_close' => '</span></li>',
			'last_tag_open' => '<li class="page-item"><span class="page-link">',
			'last_tagl_close' => '</span></li>'
		);
		
		$page = (isset($_GET['page']) && $_GET['page'] > 1) ? (int)($_GET['page']) : 1;
		$offset = ($page > 1) ? ($page * $pagination['per_page']) - $pagination['per_page'] : 0;
		$config = array(
			'config' => (object)$pagination,
			'page' => $page,
			'offset' => $offset
		);

		$this->pagination->initialize($pagination);

		$link = array('link' => $this->pagination->create_links());
		$response = array_merge($config, $link);

		return (object)$response;
	}
}
