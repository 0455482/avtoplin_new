<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller for LogIn functions
 */
class Order_details extends MY_Controller {

	/**
	 * Index function showing the Order details page.
	 */
	public function index(){
		$this->load->view('common/header');
		$this->load->view('order_details');
		$this->load->view('common/footer');
	}

	public function init(){
		include(FCPATH.'/resources/htmlDOMphp/simple_html_dom.php');

		$this->load->model('orders_model');
		$this->load->model('statuses_model');
		$this->load->model('common_model');

		if($this->input->post("order_id")){
			$order_id 	= $this->input->post("order_id");
		}
		else{
			echo 0;
			exit();
		}

		$result 			= $this->orders_model->getOrderDetails($order_id);
		$result["statuses"] = $this->statuses_model->getAllStatuses();
		$result["fuel"] 	= $this->common_model->getFuelPrices();

		if($result){
			echo json_encode($result);
		}
		else{
			echo 0;
		}
		exit();
	}

	/*
	 * Function for updating the attributes of a certain order.
	 */
	public function editOrderDetails(){
		$this->load->model('orders_model');

		$details = $this->input->post("order_details");

		$result = $this->orders_model->editOrderDetails($details);

		if($result){
			echo 1;
		}
		else{
			echo 0;
		}
		exit();
	}

	/*
	 * Function for getting all details about a certain order history merged with appropriate username.
	 */
	public function getOrderHistory(){
		$this->load->model('orders_model');

		$order_id = $this->input->post("order_id");

		$result = $this->orders_model->getOrderHistory($order_id);

		echo json_encode($result);
		exit();
	}

	/*
	 * Function for getting all active sms templates.
	 */
	public function getActiveTemplates () {
		$this->load->model('sms_model');

		echo json_encode($this->sms_model->getAllActiveTemplates());
		exit();
	}

}

?>