<?php
/**
 * Model for all init and index functions.
 */
class Common_model extends CI_Model {
    /**
     * Function for getting and updating the fuel prices accordingly in the database.
     */
    public function getFuelPrices($id, $active){
        $sql_select_fuel = "SELECT f.* FROM fuel as f "; 

        $select_query_fuel = $this->db->query($sql_select_fuel);
        $return = $select_query_fuel->result_array();

        if($return) {
        	return $return;
        }
        else {
        	return 0;
        }
    }
}

?>