<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller for Dashboards functions
 */
class Dashboard extends MY_Controller {

	/**
	 * Index function showing the Dashboard page.
	 */
	public function index()
	{
		$this->load->view('common/header');
		$this->load->view('dashboard');
		$this->load->view('common/footer');

		if($this->session->userdata["data"]["logged_this_week"]==0){
			$this->load->model('user_model');
			$this->user_model->changeUserLoggedThisWeek($this->session->userdata["data"]["user_id"]);
			$this->session->userdata["data"]["logged_this_week"] = 1;
		}
	}

	/**
	 * Init function gets the needed informations for initializing the site.
	 *
	 * Gets the box statistics for the dashboard, and the order statuses for init the order table
	 *
	 * @return array Count of the orders with same order status (statistic)
	 * @return array All informations about the order statuses
	 *
	 */
	public function init()
	{
		$this->load->model('statuses_model');
		$this->load->model('statistics_model');

		$data = array();

		$data["box_stats"] 	= $this->statistics_model->getBoxOrderStatistics();
		$data["statuses"] 	= $this->statuses_model->getAllStatuses();

		echo json_encode($data);
		exit();
	}

	/**
	 * Getting count of the filtered orders, for the pagination.
	 *
	 * Checking if the filters exists. We form the timestamps to strings.
	 *
	 * @param string $query The searched string from the dashboard
	 * @param timestamp $date_from
	 * @param timeptamp $date_from
	 * @param string $status
	 *
	 * @return int Count of the filtered orders
	 *
	 */
	public function countFilteredOrders()
	{
		$this->load->model('orders_model');

		if($this->input->post('date_from') && $this->input->post('date_to')){
            $filter["date_from"]           = $this->input->post('date_from')." 00:00:00";
            $filter["date_to"]             = $this->input->post('date_to')." 23:59:59";

        }
        else{
            $filter["date_from"]           = false;
            $filter["date_to"]             = false;
        }

        if($this->input->post('quick_text')){
            $filter["quick_text"]           = $this->input->post('quick_text');
        }
        else{
            $filter["quick_text"]           = false;
        }

        if($this->input->post('status')){
            $filter["status"]           	= $this->input->post('status');
        }
        else{
            $filter["status"]           	= false;
        }

		$result 	= $this->orders_model->countFilteredOrders($filter);

		echo $result;
		exit();
	}

	/**
	 * Getting data of the filtered orders, for the pagination.
	 *
	 * Checking if the filters exists. We form the timestamps to date.
	 *
	 * @param string $query The searched string from the dashboard
	 * @param timestamp $date_from
	 * @param timeptamp $date_from
	 * @param string $status
	 * @param int $from
	 *
	 * @return array All informations of the filtered orders
	 *
	 */
	public function getFilteredOrders()
	{

		$this->load->model('orders_model');

		if($this->input->post('date_from') && $this->input->post('date_to')){
            $filter["date_from"]           = $this->input->post('date_from')." 00:00:00";
            $filter["date_to"]             = $this->input->post('date_to')." 23:59:59";
        }
        else{
            $filter["date_from"]           = false;
            $filter["date_to"]             = false;
        }

        if($this->input->post('status')){
            $filter["status"]           	= $this->input->post('status');
        }
        else{
            $filter["status"]           	= false;
        }

        if($this->input->post('quick_text')){
            $filter["quick_text"]           = $this->input->post('quick_text');
            $filter["status"]           	= false;
        }
        else{
            $filter["quick_text"]           = false;
        }

        if($this->input->post('from')){
            $filter["pag_from"]           	= $this->input->post('from');
        }
        else{
            $filter["pag_from"]           	= 0;
        }

		$result 	= $this->orders_model->getFilteredOrders($filter);

		echo json_encode($result);
		exit();
	}

	public function countFilteredInvoices()
	{
		$this->load->model('invoices_model');

		if($this->input->post('date_from') && $this->input->post('date_to')){
            $filter["date_from"]           = $this->input->post('date_from')." 00:00:00";
            $filter["date_to"]             = $this->input->post('date_to')." 23:59:59";
        }
        else{
            $filter["date_from"]           = false;
            $filter["date_to"]             = false;
        }

        if($this->input->post('paid')){
            $filter["paid"]           	= $this->input->post('paid');
        }
        else{
            $filter["paid"]           	= false;
        }

        if($this->input->post('status')){
            $filter["status"]           	= $this->input->post('status');
        }
        else{
            $filter["status"]           	= false;
        }

        if($this->input->post('quick_text')){
            $filter["quick_text"]           = $this->input->post('quick_text');
            $filter["status"]           	= false;
        }
        else{
            $filter["quick_text"]           = false;
        }

		$result 	= $this->invoices_model->countFilteredInvoices($filter);

		echo $result;
		exit();

	}

	/*
	 * Function for getting all details according to the filter parameters.
	 */
	public function getFilteredInvoices()
	{
		$this->load->model('invoices_model');

		if($this->input->post('date_from') && $this->input->post('date_to')){
            $filter["date_from"]           = $this->input->post('date_from')." 00:00:00";
            $filter["date_to"]             = $this->input->post('date_to')." 23:59:59";
        }
        else{
            $filter["date_from"]           = false;
            $filter["date_to"]             = false;
        }

        if($this->input->post('quick_text')){
            $filter["quick_text"]           = $this->input->post('quick_text');
        }
        else{
            $filter["quick_text"]           = false;
        }

        if($this->input->post('paid')){
            $filter["paid"]           	= $this->input->post('paid');
        }
        else{
            $filter["paid"]           	= false;
        }

        if($this->input->post('from')){
            $filter["pag_from"]           	= $this->input->post('from');
        }
        else{
            $filter["pag_from"]           	= 0;
        }

		$result 	= $this->invoices_model->getFilteredInvoices($filter);

		echo json_encode($result);
		exit();

	}

	/*
	 * Function for getting information about a certain invoice.
	 */
	public function getInvoiceDetails(){
		$this->load->model('invoices_model');

        $invoice_id           	= $this->input->post('invoice_id');

		$details = $this->invoices_model->getInvoiceDetails($invoice_id);

		echo json_encode($details);
		exit();
	}

}

?>
