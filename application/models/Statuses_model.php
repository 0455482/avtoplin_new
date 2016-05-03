<?php
/**
 * Model for all init and index functions.
 */
class Statuses_model extends CI_Model {
    
    /**
     * Getting all order statuses from database.
     * 
     * @return array The order statuses details.
     * @return 0 If there is no statuses.
     * 
     */
    public function getAllStatuses(){
        $sql_select = "SELECT os.* from order_status as os "; 

        $select_query = $this->db->query($sql_select);
        $statuses = $select_query->result_array();

        if($statuses) {
            return $statuses;
        }
        else {
            return 0;
        }
    }

    public function getNextStatusesForStatus($id){
        $sql_select = "SELECT * FROM order_status 
                       where id in (select id from order_status where back_status like '%".$this->db->escape_like_str($id)."%')";

        $select_query = $this->db->query($sql_select);
        $statuses = $select_query->result_array();

        if($statuses) {
            return $statuses;
        }
        else {
            return 0;
        }
    }

    /**
     * Setting color for order status.
     * 
     * @param $id Order status id
     * @param $color
     * 
     * @return 1 Success.
     * @return 0 Error.
     * 
     */
    public function setStatusColor($id, $color){
        $sql_update = "UPDATE order_status set color = ".$this->db->escape($color)." 
                       where id = ".$this->db->escape($id)." "; 

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