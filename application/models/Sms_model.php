<?php
class Sms_model extends CI_Model {

    /**
     * Getting orders statistics from database.
     * 
     * @return array The order status statistics.
     * @return 0 If there is no stats.
     * 
     */
    public function getAllSmsTemplates(){
        $sql_select = " SELECT st.* FROM sms_templates as st "; 

        $select_query = $this->db->query($sql_select);
        $sms_templates = $select_query->result_array();

        if($sms_templates) {
            return $sms_templates;
        }
        else {
            return 0;
        }
    }

    /** 
     * Getting sms template details from ONE template.
     *
     * @param $id - of wanted template.
     * @return array details of sms template.
     */
    public function getSmsTemplateDetails($id){
        $sql_select = " SELECT st.* FROM sms_templates as st where st.id = ".$this->db->escape($id)." "; 

        $select_query = $this->db->query($sql_select);
        $sms_templates = $select_query->result_array();

        if($sms_templates) {
            return $sms_templates[0];
        }
        else {
            return 0;
        }
    }

    /**
     * Inserting new template into database.
     * @param $details - array of values to be inserted.
     * @return 1 if inserted.
     * @return 0 if error.
     */
    public function createSmsTemplate($details){
        $sql_insert = "INSERT into sms_templates 
                        (name, text, active) 
                       values 
                        (".$this->db->escape($details["name"]).", ".$this->db->escape($details["text"]).", 1) "; 

        $result     = $this->db->query($sql_insert);

        if($result) {
            return 1;
        }
        else {
            return 0;
        }
    }

    /**
     * Update certain sms template.
     * @param $details - array of values for updating.
     * @return 1 if updated.
     * @return 0 if error.
     */
    public function editSmsTemplate($details){
        $sql_update = "UPDATE sms_templates set 
                        name    = ".$this->db->escape($details["name"]).", 
                        text    = ".$this->db->escape($details["text"]).", 
                        active  = ".$this->db->escape($details["active"])."
                       where id = ".$this->db->escape($details["id"])." "; 

        $result = $this->db->query($sql_update);

        if($result) {
            return 1;
        }
        else {
            return 0;
        }
    }

    /**
     * Update activeness of certain sms template.
     * @param $id - of wanted template.
     * @param $active - active status value to be updated.
     * @return 1 if updated.
     * @return 0 if error.
     */
    public function changeSmsTemplateActive($id, $active){
        $sql_update = "UPDATE sms_templates set active = ".$active." 
                       where id = ".$this->db->escape($id)." "; 

        $result     = $this->db->query($sql_update);

        if($result) {
            return 1;
        }
        else {
            return 0;
        }
    }

    /**
     * Get all sent sms messages from database.
     * @return $sms_history - array of sms messages.
     * @return 0 if error.
     */
    public function getAllSmsHistory (){
        $sql_select   = "SELECT sh.*, o.customer FROM sms_history as sh
                         LEFT JOIN (SELECT * FROM orders) as o on sh.order_id = o.id"; 
        $select_query = $this->db->query($sql_select);
        $sms_history  = $select_query->result_array();

        if($sms_history) {
            return $sms_history;
        }
        else {
            return 0;
        }

        return $return;
    }

    /**
     * Get all active sms templates from database.
     * @return $result - array of sms templates containing only ID,NAME,TEXT.
     */
    public function getAllActiveTemplates () {
        $sql    = "SELECT st.id,st.name,st.text FROM sms_templates as st WHERE active = 1";
        $query  = $this->db->query($sql);
        $result = $query->result_array();

        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }

    /**
     * Send sms message to a certain person (not connected with database).
     * @param $filters - array of receiver details (telephone, text, template id, order id)
     * @return 1 if message sent and inserted and noted in database.
     * @return 0 if error.
     */
    public function sendOneSms ($filters) {
        $sql = "SELECT o.customer, o.reservation_date FROM orders as o
                WHERE id = ".$this->db->escape($filters['o_id'])."";
        $query  = $this->db->query($sql);
        $result = $query->result_array()[0];
        //prepare data
        $content = str_replace ('{{customer}}', $result['customer'], $filters['text']);
        $content = str_replace ('{{reservation_date}}', $result['reservation_date'], $content);
        $url = 'http://www.smsapi.si/poslji-sms';            //url we are posting to (defined in sms api documentation)
        $data = array('un'   => urlencode('peter_selekar'),     //api username
                      'ps'   => urlencode('3f0ec482e83371aeff05cb496e4665b2c48821afd6'),     //api pass
                      'from' => urlencode('041388893'),      //don't send as int
                      //'from' => urlencode('031480333'), 
                      'to'   => urlencode($filters['telephone']),        //don't send as int
                      'm'    => urlencode($content),  //msg
                      'cc'   => urlencode('386'),
                      // 'sid' => urlencode('1'),
                      // 'sname' => urlencode('Lux-Factor')               //don't send as int 
                     );
        ########### SEND SMS WITH POST ###############
        //send SMS
        $res = $this->doPostRequest($url, $data);
        $error = explode("#", $response);
        if ($error[0] != "-1") {
            $sql_insert_sms = "INSERT INTO sms_history (date_sent, telephone, text, sms_template_id, order_id) 
                               VALUES (NOW(), '".$this->db->escape_str($filters['telephone'])."', '".$this->db->escape_str($content)."', ".$this->db->escape($filters['st_id']).", ".$this->db->escape($filters['o_id']).")";
            $result  = $this->db->query($sql_insert_sms);

            if ($result) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        exit();
    }

    /**
     * Send sms message to a certain person (not connected with database).
     * @param $url - url of sms api (smsapi.si/...)
     * @param $data - array of information about sending sms and sms text, receiver telephone.
     * @return $result - some value determining if it's successful or not (if first char is -1 -> successful).
     */
    public function doPostRequest($url, $data) {
        // Initialisation
        $ch=curl_init();
            
        // Set parameters
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);

        // Activate the POST method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1) ;
            
        // Request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            
        // execute the connexion
        $result = curl_exec($ch);
            
        // Close it
        curl_close($ch);
        
        return $result;
    }
}

?>