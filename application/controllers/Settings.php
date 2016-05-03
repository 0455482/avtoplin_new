<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller for Dashboards functions
 */
class Settings extends MY_Controller {

	/**
	 * Index function showing the Dashboard page.
	 */
	public function index(){
		$this->load->view('common/header');
		$this->load->view('settings');
		$this->load->view('common/footer');
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
	public function init(){
		$this->load->model('user_model');

		$return['users']     = $this->user_model->getAllUsers();		
		$return['user_type'] = $this->session->userdata["data"]["type"];

		echo json_encode($return);
	}

	/**
	 * Getting informations about the templates.
	 * 
	 * @return array Needed informations about the sms templates 
	 * 
	 */
	public function getAllSmsTemplates(){
		$this->load->model('sms_model');

		$sms_templates 	= $this->sms_model->getAllSmsTemplates();

		echo json_encode($sms_templates);
		exit();
	}

	/**
	 * Getting informations about the templates.
	 * 
	 * @return array Needed informations about the sms templates 
	 * 
	 */
	public function getSmsTemplateDetails(){
		$this->load->model('sms_model');

		$id = $this->input->post("id");

		$sms_templates 	= $this->sms_model->getSmsTemplateDetails($id);

		echo json_encode($sms_templates);
		exit();
	}

	/**
	 * Creating new sms template.
	 * 
	 * Gets the details and create new sms template.
	 * 
	 * @param string $name
	 * @param string $text
	 * 
	 * @return int 1 For succes 
	 * @return int 0 For fail 
	 * 
	 */
	public function createSmsTemplate(){
		$this->load->model('sms_model');

		$details = $this->input->post("sms");

		$sms_templates 	= $this->sms_model->createSmsTemplate($details);

		echo json_encode($sms_templates);
		exit();
	}

	/**
	 * Editing sms template.
	 * 
	 * Gets the details and edit the sms template.
	 * 
	 * @param string $id
	 * @param string $name
	 * @param string $text
	 * 
	 * @return int 1 For succes 
	 * @return int 0 For fail 
	 * 
	 */
	public function editSmsTemplate(){
		$this->load->model('sms_model');

		$details 			= $this->input->post("sms");
		$details["active"] 	= ($details["active"] == 1 ? 1 : 0);

		$sms_templates 	= $this->sms_model->editSmsTemplate($details);

		echo json_encode($sms_templates);
		exit();
	}

	/**
	 * Changeing if the template is active or inactive.
	 * 
	 * Change the status of the sms template to inactive or to active.
	 * 
	 * @param string $id
	 * @param int $active
	 * 
	 * @return int 1 For succes 
	 * @return int 0 For fail 
	 * 
	 */
	public function changeSmsTemplateActive(){
		$this->load->model('sms_model');

		$id 	= $this->input->post("id");
		$active = ($this->input->post("active") == 1 ? 1 : 0);

		$sms_templates 	= $this->sms_model->changeSmsTemplateActive($id, $active);

		echo json_encode($sms_templates);
		exit();
	}

	/**
	 * Getting history informations about the sms campagns.
	 * 
	 * @return array Needed informations about the sms history 
	 * 
	 */
	public function getSmsHistory(){
		$this->load->model('sms_model');

		echo json_encode($this->sms_model->getAllSmsHistory());
		exit();
	}

	/**
	 * Get all order status informations.
	 * 
	 * @return array Needed informations about the order statuses. 
	 * 
	 */
	public function getAllStatuses(){
		$this->load->model('statuses_model');

		$statuses 	= $this->statuses_model->getAllStatuses();

		echo json_encode($statuses);
		exit();
	}

	/**
	 * Delete sms template.
	 * 
	 * Change the status of the sms template to inactiv.
	 * 
	 * @param string $id
	 * 
	 * @return int 1 For succes 
	 * @return int 0 For fail 
	 * 
	 */
	public function setStatusColor(){
		$this->load->model('statuses_model');

		$id 	= $this->input->post("id");
		$color 	= $this->input->post("color");

		$res 	= $this->statuses_model->setStatusColor($id, $color);

		echo $res;
		exit();
	}

	/**
	 * Function for getting all users from database.
	 */
	public function getAllUsers(){
		$this->load->model('user_model');

		$users 	= $this->user_model->getAllUsers();

		echo json_encode($users);
		exit();
	}

	/**
	 * Function for getting information about a certain user.
	 */
	public function getUserDetails(){
		$this->load->model('user_model');

		$id = $this->input->post("user_id");

		$users 	= $this->user_model->getUserDetails($id);

		echo json_encode($users);
		exit();
	}

	/** 
	 * Function for creating and inserting a new user into the database.
	 */
	public function createUser(){
		$this->load->model('user_model');

		$details 					= $this->input->post("user");
		$details["password"] 		= $this->encryption_pass->encrypt($details["password"]); //encode password
		$details["created_from"] 	= $this->session->userdata["data"]["user_id"];

		$result 	= $this->user_model->createUser($details);

		echo $result;
		exit();
	}

	/** 
	 * Function for updating details about a certain user in the database.
	 */
	public function editUser(){
		$this->load->model('user_model');

		$details 					= $this->input->post("user");
		$details["password"] 		= $this->encryption_pass->encrypt($details["password"]); //encode password

		$result 	= $this->user_model->editUser($details);

		echo $result;
		exit();
	}

	/**
	 * Function for changing the activeness status of a certain user.
	 */
	public function changeUserActive(){
		$this->load->model('user_model');

		$id 		= $this->input->post("user_id");
		$active 	= ($this->input->post("active") == 1 ? 1 : 0);

		$result 	= $this->user_model->setUserInactive($id, $active);

		echo $result;
		exit();
	}

	/**
	 * Function for getting engines, discounts and installments details from database.
	 */
	public function getOfferParameters(){
		$this->load->model('offers_model');

		$result = $this->offers_model->getOfferParameters();

		echo json_encode($result);
		exit();
	}

	/**
	 * Function for updating engine, discount and installment details in the database.
	 */
	public function changeOfferParameters(){
		$this->load->model('offers_model');

		$engines 	  = $this->input->post('engine');
		$discounts    = $this->input->post('discounts');
		$installments = $this->input->post('installments');

		$result = $this->offers_model->changeOfferParameters($engines, $discounts, $installments);
		if ($result) {
			echo 1;
		} else {
			echo 0;
		}
		exit();
	}
}

?>