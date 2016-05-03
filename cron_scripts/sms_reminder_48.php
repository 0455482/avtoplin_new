<?php
	$conn = new mysqli('109.123.4.55', 'root', 'P0t3nc1a123!', 'avtoplin');

	$sql = "SELECT o.customer, o.telephone, st.text, st.id as st_id, o.id as o_id, date_format(o.reservation_date, '%d/%m/%Y') as date_reserved FROM orders as o
			LEFT JOIN (SELECT * FROM sms_templates) as st on st.name = '48_reservation_reminder'
			WHERE o.reservation_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 2 DAY) AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)";

	$result = mysqli_query($conn, $sql);
    $sql_insert_sms = "INSERT INTO sms_history (date_sent, telephone, text, sms_template_id, order_id) VALUES ";

	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$content = $row['text'];
		$content = str_replace('{{customer}}', $row['customer'], $content);
		$content = str_replace('{{reservation_date}}', $row['date_reserved'], $content);

		//prepare data
        $url = 'http://www.smsapi.si/poslji-sms';            //url we are posting to (defined in sms api documentation)
        $data = array('un'   => urlencode('peter_selekar'),     //api username
                      'ps'   => urlencode('3f0ec482e83371aeff05cb496e4665b2c48821afd6'),     //api pass
                      'from' => urlencode('041388893'),      //don't send as int
                      //'from' => urlencode('031480333'), 
                      'to'   => urlencode($row['telephone']),        //don't send as int
                      'm'    => urlencode($content),  //msg
                      'cc'   => urlencode('386'),
                      // 'sid' => urlencode('1'),
                      // 'sname' => urlencode('Lux-Factor')               //don't send as int 
                     );
        ########### SEND SMS WITH POST ###############
        //send SMS
        doPostRequest($url, $data);
        $sql_insert_sms .= "(NOW(), ".$row['telephone'].", '".$content."', ".$row['st_id'].", ".$row['o_id']."), ";  
	}
    $sql_insert_sms = substr ($sql_insert_sms, 0, -2);
    $result_sms     = mysqli_query($conn, $sql_insert_sms);

	/**
     * Posts $data on $url and returns content of website
     * POST request was made to.
     * 
     * @param $url - url where we are posting data
     * @param $data - array with key => value pairs for post 
     *                e.g. array('un' => 'example', 'ps' => 'pass', ...)
     *
     * @return string
     */
    function doPostRequest($url, $data) {
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
        
?>