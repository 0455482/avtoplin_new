<?php
class User_model extends CI_Model {


    /**
     * Validate user in database.
     * 
     * @param string $username
     * @param string $password
     * 
     * @return 1 if user exist in database.
     * @return 0 if user not exist in database.
     * 
     */
    public function validateUser($username, $password){
        $sql_select = "SELECT count(u.id) as count from user as u 
        			   where u.active = 1 and u.username = ".$this->db->escape($username)." 
        			   and u.password = ".$this->db->escape($password)." "; 

        $select_query = $this->db->query($sql_select);
        $user = $select_query->result_array();

        if((int)$user[0]["count"] === 1) {
        	return 1;
        }
        else {
        	return 0;
        }
    }

    /**
     * Getting informations for one user from database.
     * 
     * @param string $username
     * @param string $password
     * 
     * @return array The user informations.
     * @return 0 If user not exist
     * 
     */
    public function getUserData($username, $password){
        $sql_select = "SELECT u.id as user_id, u.username, u.type, u.logged_this_week from user as u 
                       where u.active = 1 and u.username = ".$this->db->escape($username)." 
                       and u.password = ".$this->db->escape($password)." "; 

        $select_query = $this->db->query($sql_select);
        $user = $select_query->result_array();

        if($user) {
            return $user[0];
        }
        else {
            return 0;
        }
    }

    /**
     * Getting informations for all users from database.
     * 
     * @return array The users informations.
     * @return 0 Error
     * 
     */
    public function getAllUsers(){
        $sql_select = "SELECT u.id as user_id, u.username, u.date_created, u.type, u.active from user as u "; 

        $select_query = $this->db->query($sql_select);
        $users = $select_query->result_array();

        if($users) {
            return $users;
        }
        else {
            return 0;
        }
    }

    /**
     * Get certain details for a designated user.
     *
     * @param $id - id for the wanted user.
     * @return $users - array of the user details if query is successful.
     * @return 0 if error.
     */
    public function getUserDetails($id){
        $sql_select = " SELECT u.id as user_id, u.username, u.date_created, u.type, u.active 
                        from user as u 
                        where u.id = ".$this->db->escape($id)." "; 

        $select_query = $this->db->query($sql_select);
        $users = $select_query->result_array();

        if($users) {
            return $users[0];
        }
        else {
            return 0;
        }
    }

    /**
     * Adds a new user into the database.
     * 
     * @param $details - array with all the user details like username, password etc.
     * @return 1 if query is successful.
     * @return 0 if error.
     */
    public function createUser($details){
        $sql_insert = "INSERT into user 
                        (username, password, date_created, created_from, type, active) 
                       values 
                        (".$this->db->escape($details["username"]).", ".$this->db->escape($details["password"])."
                       , now(), ".$this->db->escape($details["created_from"])."
                       , ".$this->db->escape($details["type"]).", 1) "; 

        $result = $this->db->query($sql_insert);

        if($result) {
            return 1;
        }
        else {
            return 0;
        }
    }

    /**
     * Updates attributes of a certain user.
     * 
     * @param $details - array containing user details to be updated and id of the wanted user.
     * @return 1 if query is successful.
     * @return 0 if error.
     */
    public function editUser($details){
        $sql_insert = "UPDATE user 
                        set 
                        username    = ".$this->db->escape($details["username"]).", 
                        password    = ".$this->db->escape($details["password"]).", 
                        type        = ".$this->db->escape($details["type"]).", 
                        active      = ".$this->db->escape($details["active"])."
                       where id = ".$this->db->escape($details["user_id"])." "; 

        $result = $this->db->query($sql_insert);

        if($result) {
            return 1;
        }
        else {
            return 0;
        }
    }

    /**
     * Updates the active status of a certain user in the database.
     *
     * @param $id     - id of the user.
     * @param $active - value of the activeness status.
     * @return 1 if query is successful.
     * @return 0 if error.
     */
    public function changeUserActive($id, $active){
        $sql_update = "UPDATE user set active = ".$this->db->escape($active)."
                       where id = ".$this->db->escape($id)." "; 

        $result = $this->db->query($sql_update);

        if($result) {
            return 1;
        }
        else {
            return 0;
        }
    }

    /**
     * Sets the logged_this_week attribute to 1 for the deisgnated user.
     * This way, they get a notification every week about all unprocesed orders. 
     *
     * @param $user_id - id of the user.
     * @return 1 if query is successful.
     * @return 0 if error.
     */
    public function changeUserLoggedThisWeek($user_id){

        $sql_update = "UPDATE user set logged_this_week = 1
                       where id = ".$this->db->escape($user_id)." "; 

        $result = $this->db->query($sql_update);

        if($result) {
            return 1;
        }
        else {
            return 0;
        }
    }
}

?>