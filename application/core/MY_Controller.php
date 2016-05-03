<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

class MY_Controller extends CI_Controller {
	public function __construct() {
        parent::__construct();

        $controller = $this->router->class;
        //echo $this->session->userdata["loggedin"] ." - ". $controller . " 1 " . uri_string();

        // if(!isset($this->session->userdata["loggedin"]) 
        //        && $this->session->userdata["loggedin"] !== 1
        //        && $controller !== "login") { //user not logged in and not on login controller
        //         //$this->session->userdata["before_url"] = current_url();
        //         redirect("login");

        // }
        // else if(isset($this->session->userdata["before_url"])
        //            && isset($this->session->userdata["loggedin"]) 
        //            && $this->session->userdata["loggedin"] == 1) {
        //     echo "user loggedin";

        //     $url = $this->session->userdata["before_url"];
        //     unset($this->session->userdata["before_url"]);
        //     redirect($url);
        // }
        //echo $this->session->userdata["loggedin"] . "  ". $controller;

        if(isset($this->session->userdata["loggedin"]) && $this->session->userdata["loggedin"] == 1) { //user logged in
            if(strtolower($controller == "login")) {
                redirect("dashboard");
            }
        }
        else { //user not logged in
            if(strtolower($controller) != "login") {
                redirect("login");
            }
        }
	}
}
?>