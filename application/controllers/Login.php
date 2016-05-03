<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller for LogIn functions
 */
class Login extends MY_Controller {

	/**
	 * Index function showing the login page.
	 */
	public function index()
	{
		if($_GET["validation"] == "0"){
			$data["validation"] = 0;
		}
		else {
			$data["validation"] = 1;
		}

		$this->load->view('common/login_header');
		$this->load->view('login', $data);
		$this->load->view('common/footer');
	}

	/**
	 * Authentication user to administration.
	 * 
	 * Checking the login credentials, save users infos if allow or deny if not allow to log into the sistem.
	 * If user exist redirect to dashboard of the administration.
	 * 
	 * @param string $_POST["username"]
	 * @param string $_POST["password"]
	 * 
	 * @throws validate=0 on invalid credentials. 
	 * 
	 */
	public function login_user(){
		$username = $this->input->post("username");
		$password = $this->encryption_pass->encrypt($this->input->post("password")); //encode password

		if($this->validateUser($username, $password) === 1){
			$this->session->userdata["loggedin"] 	= true;
			$this->session->userdata["data"] 		= $this->getUserData($username, $password);

            redirect('/dashboard');
		}
		else {
            redirect('/login?validation=0');
		}
	}

	/**
	 * Private function for validating user credentials.
	 * 
	 * Checking if the credentials matches user in our database sistem, and than returns the result.
	 * 
	 * @param string $username
	 * @param string $password
	 * 
	 * @return bool true For validate success.
	 * @return bool false For invalid validate.
	 * 
	 */

	private function validateUser($username, $password){
		$this->load->model('user_model');

		if($this->user_model->validateUser($username, $password)==1){
			return 1;
		}
		else {
			return 0;
		}
	}

	/**
	 * Private function for getting user information.
	 * 
	 * @param string $username
	 * @param string $password
	 * 
	 * @return array The needed user informations that are saved into the session.
	 * 
	 */

	private function getUserData($username, $password){
		$this->load->model('user_model');
		
		$user_details = $this->user_model->getUserData($username, $password);

		return $user_details;
	}


}
