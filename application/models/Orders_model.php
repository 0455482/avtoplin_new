<?php
class Orders_model extends CI_Model {

    /*
     * Gets all details about a certain order.
     *
     * @param $id - id of the order.
     * @return array of order details.
     */
    public function getOrdersDetailsForExport($orders_ids){
        $sql_select = " select o.customer,o.email,o.telephone,o.city,o.car_model,
                        o.customer_profile, o.date_created, o.utm, os.name as status_name from orders as o
                        left join order_status as os on o.order_status_id = os.id
                        where o.id in (".implode(', ',$this->db->escape_str($orders_ids)).")"; 

        $select_query  = $this->db->query($sql_select);
        $return = $select_query->result_array();

        
        $i = 0;
        foreach ($return as $order) {
          $res = array();
          $utm_temp = explode(",", $order["utm"]);
            
          if($utm_temp[0]) {
            foreach ($utm_temp as $k => $v) {
                $vars = explode("=", $v);
                $res[$vars[0]] = $vars[1];
            }

            $return[$i]["utm"] = $res;
          } else { 
            $return[$i]["utm"] = array();
          }
          $i++;
        }
        
        return $return;
    }


    /*
     * Gets all details about a certain order.
     *
     * @param $id - id of the order.
     * @return array of order details.
     */
    public function getOrderDetails($id){
        $sql_select = " select o.*, os.name, os.color from orders as o
                        left join order_status as os on o.order_status_id = os.id
                        where o.id = ".$this->db->escape($id)." "; 

        $select_query  = $this->db->query($sql_select);
        $return["order_details"] = $select_query->result_array()[0];

        $res = array();
        $utm_temp = explode(",", $return["order_details"]["utm"]);
        if($utm_temp[0]) {
            foreach ($utm_temp as $k => $v) {
                $vars = explode("=", $v);
                if ($vars[1] !== "") {
                    $res[$vars[0]] = $vars[1];
                }                              
            }
            $return['order_details']["utm"] = $res;
        } else { 
            $return['order_details']["utm"] = array();
        }

        $sql_select_old = " select o.*, os.name, os.color from orders as o
                        left join order_status as os on o.order_status_id = os.id
                        where o.id != ".$this->db->escape($id)." and (o.email = ".$this->db->escape($order_details["email"])." 
                        or o.telephone like '%".$this->db->escape_like_str(substr(preg_replace("/[^0-9]/", "", $order_details["telephone"]), -5))."%') "; 

        $select_query_old  = $this->db->query($sql_select_old);
        $return["old_order_details"] = $select_query_old->result_array();


        $sql_select_offers = "select of.* from offers as of
                              where of.order_id = ".$this->db->escape($id)." "; 

        $select_query_offers  = $this->db->query($sql_select_offers);
        $return["order_offers"] = $select_query_offers->result_array();

        return $return;
    }

    /*
     * Gets number of orders according to filters.
     *
     * @param $filter - array of filters.
     * @return number of orders.
     */
    public function countFilteredOrders($filter){
        $sql_select = " select count(a.id) as count from
                        (select o.* from orders as o
                        ) as a
                        where active = 1  "; 

        if($filter["status"]){
            $sql_select .= " and a.order_status_id = ".$this->db->escape($filter["status"])." ";
        }

        if($filter["quick_text"]){
            $sql_select .= " and (a.customer like '%".$this->db->escape_like_str($filter["quick_text"])."%' || a.email like '%".$this->db->escape_like_str($filter["quick_text"])."%' 
                            || a.telephone like '%".$this->db->escape_like_str($filter["quick_text"])."%' || a.customer_profile like '%".$this->db->escape_like_str($filter["quick_text"])."%') ";
        }

        if($filter["date_from"]){
            $sql_select .= " and a.date_created between '".$this->db->escape_str($filter["date_from"])." 00:00:00' and '".$this->db->escape_str($filter["date_to"])." 23:59:59' ";
        }

        $select_query = $this->db->query($sql_select);
        $orders = $select_query->result_array();

        return (int)$orders[0]["count"];
    }

    /*
     * Gets details about filtered orders.
     *
     * @param $filter - array of filters.
     * @return array filled with details of orders.
     */
    public function getFilteredOrders($filter){
        $sql_select = " select a.* from
                        (select o.*, os.name as status_name from orders as o
                          left join order_status as os on o.order_status_id = os.id
                        ) as a
                        where active = 1  "; 

        if($filter["status"]){
            $sql_select .= " and a.order_status_id = ".$this->db->escape($filter["status"])." ";
        }

        if($filter["quick_text"]){
            $sql_select .= " and (a.customer like '%".$this->db->escape_like_str($filter["quick_text"])."%' || a.email like '%".$this->db->escape_like_str($filter["quick_text"])."%' 
                            || a.telephone like '%".$this->db->escape_like_str($filter["quick_text"])."%' || a.customer_profile like '%".$this->db->escape_like_str($filter["quick_text"])."%') ";
        }

        if($filter["date_from"]){
            $sql_select .= " and a.date_created between '".$this->db->escape_str($filter["date_from"])." 00:00:00' and '".$this->db->escape_str($filter["date_to"])." 23:59:59' ";
        }

        $sql_select .= " limit ".$this->db->escape_str($filter["pag_from"]).", 20 ";

        $select_query = $this->db->query($sql_select);

        return $select_query->result_array();
    }

    /*
     * Updates orders details and inserts into history database.
     *
     * @param $orders     - array of order ids'.
     * @param $status     - status id.
     * @param $additional - array of order details.
     * @return 1 if queries are succesful.
     * @return 0 if error.
     */
    public function changeOrdersStatus($orders, $status, $additional){
        $sql_get_order = " select o.*, os.name as status_name from orders as o
                           left join order_status as os on o.order_status_id = os.id
                           where o.id in (".$this->db->escape_str(implode(',', $orders)).") "; 

        $select_query       = $this->db->query($sql_get_order);
        $old_orders_details  = $select_query->result_array();

        $sql_reservation_date = " ";
        $sql_realization_date = " ";
        $sql_new_invoice_id   = " ";
        $sql_inactive         = " ";
        $sql_archive_comment  = " ";

        if($additional["invoice_num"]){
                $sql_new_invoice_id = " , invoices_id = ".$this->db->escape($additional["invoice_id"])." ";
        }
        else if($additional["reservation_date"]){
            $sql_reservation_date = " , reservation_date = ".$this->db->escape($additional["reservation_date"])."
                                      , reservation_flag = 1 ";
        }
        else if($additional["realization_flag"]){
            $sql_realization_date = " , realization_date = now() 
                                      , realization_flag = 1 ";
        }
        else if($additional["deleted"]){
            $sql_inactive = " , inactive = ".$this->db->escape($additional["deleted"])." ";
        }
        else if($additional["archive_comment"]){
            $sql_archive_comment = " , archive_comment = ".$this->db->escape($additional["archive_comment"])." ";
        }

        $sql_update = "update orders set 
                        order_status_id = ".$this->db->escape($status)."
                        ".$sql_reservation_date." 
                        ".$sql_realization_date."
                        ".$sql_new_invoice_id."
                        ".$sql_inactive."
                        ".$sql_archive_comment."
                       where id in (".$this->db->escape_str(implode(',', $orders)).")  ";

        $update_query = $this->db->query($sql_update);

        if($update_query){
            $sql_get_order = " select o.*, os.name as status_name from orders as o
                               left join order_status as os on o.order_status_id = os.id
                               where o.id in (".$this->db->escape_str(implode(',', $orders)).") "; 

            $select_query       = $this->db->query($sql_get_order);
            $new_order_details  = $select_query->result_array();

            $sql_insert_history = "INSERT into history
                                   (user_id, datetime, order_id, type, action_old, action_new)
                                   values ";
                                   foreach ($old_orders_details as $key => $order) {
                                       $tmp_hist[] = "  (".$this->session->userdata["data"]["user_id"].",
                                                        now(),
                                                        ".$this->db->escape($order["id"]).",
                                                        'order_status',
                                                        '".$this->db->escape_str(json_encode($order))."',
                                                        '".$this->db->escape_str(json_encode($new_order_details[$key]))."') ";
                                   }
            $sql_insert_history .= implode(",", $tmp_hist);

            $res = $this->db->query($sql_insert_history);

            if($res) {
                return 1;
            }
            else {
                return 0;
            }
        }
        else{
            return 0;
        }
    }

    /*
     * Updates orders details and inserts into history database.
     *
     * @param $details - array of order details and values.
     * @return 1 if queries are successful.
     * @return 0 if error.
     */
    public function editOrderDetails($details){
        $sql_get_order = " select o.* from orders as o
                           where o.id = ".$this->db->escape($details["id"])." "; 

        $select_query       = $this->db->query($sql_get_order);
        $old_order_details  = $select_query->result_array()[0];

        //$this->session->userdata["data"]["user_id"]

        if($details["reservation_date"]!=""){
            $sql_res_tmp = " reservation_date    = ".$this->db->escape($details["reservation_date"]).",";
        }

        $sql_update = "update orders set 
                        customer            = ".$this->db->escape($details["customer"]).",
                        email               = ".$this->db->escape($details["email"]).",
                        telephone           = ".$this->db->escape($details["telephone"]).",
                        address             = ".$this->db->escape($details["address"]).",
                        postal_code         = ".$this->db->escape($details["postal_code"]).",
                        city                = ".$this->db->escape($details["city"]).",
                        car_model           = ".$this->db->escape($details["car_model"]).",
                        order_status_id     = ".$this->db->escape($details["order_status_id"]).",
                        customer_profile    = ".$this->db->escape($details["customer_profile"]).",
                        ".$sql_res_tmp."
                        fuel                = ".$this->db->escape($details["fuel"]).",
                        average_consumption = ".$this->db->escape($details["average_consumption"]).",
                        fuel_month_expences = ".$this->db->escape($details["fuel_month_expences"]).",
                        droved_km_year      = ".$this->db->escape($details["droved_km_year"])."
                       where id = ".$this->db->escape($details["id"])." ";

        $update_query = $this->db->query($sql_update);

        if($update_query){
          $sql_get_order = " select o.* from orders as o
                             where o.id = ".$this->db->escape($details["id"])." "; 

          $select_query       = $this->db->query($sql_get_order);
          $new_order_details  = $select_query->result_array()[0];
          if(array_diff_assoc($old_order_details, $new_order_details)){
            $sql_insert_history = "INSERT into history
                                   (user_id, datetime, order_id, type, action_old, action_new)
                                   values 
                                   (".$this->session->userdata["data"]["user_id"].",
                                    now(),
                                    ".$this->db->escape($details["id"]).",
                                    'order_details',
                                    '".$this->db->escape_str(json_encode($old_order_details))."',
                                    '".$this->db->escape_str(json_encode($new_order_details))."' ) "; 

            $res = $this->db->query($sql_insert_history);

            if($res) {
                return 1;
            }
            else {
                return 0;
            }
          }
          else {
            return 1;
          }
        }
        else{
            return 0;
        }
    }

    /*
     * Gets details about a certain order in the history database.
     *
     * @param $order_id - id of the order in the history database.
     * @return array of order details from history database.
     */
    public function getOrderHistory($order_id){
      $sql_get_order = " select h.*, u.username from history as h
                         left join user as u on h.user_id = u.id
                         where order_id = ".$this->db->escape_str($order_id)." 
                         order by h.datetime desc "; 

      $select_query   = $this->db->query($sql_get_order);
      $order_history  = $select_query->result_array();

      $sql = "SELECT ho.*, u.username FROM history_offers as ho
              LEFT JOIN user as u on ho.user_id = u.id
              WHERE order_id = ".$this->db->escape_str($order_id)." 
              order by ho.datetime desc ";

      $query  = $this->db->query($sql);
      $offer_history = $query->result_array();

      $i = 0;
      foreach ($order_history as $key => $history) {
        if($order_history[$key+1]){
          $order_before             = json_decode($order_history[$key]["action_old"],true);
          $order_after              = json_decode($order_history[$key+1]["action_old"],true);
          $return[$i]               = array('username' => $history["username"], 'date_added' => $history["datetime"], 'type' => $history["type"]);
          $return[$i]["changes"]    = array_diff_assoc($order_before, $order_after);
        } else {
          $order_before             = json_decode($order_history[$key]["action_old"],true);
          $order_after              = json_decode($order_history[$key]["action_new"],true);
          $return[$i]               = array('username' => $history["username"], 'date_added' => $history["datetime"], 'type' => $history["type"]);
          $return[$i]["changes"]    = array_diff_assoc($order_before, $order_after);
        }
        $i++;
      }

      foreach ($offer_history as $key => $history) {
        $return[$i] = array('username' => $history['username'], 'date_added' => $history["datetime"], 'type' => $history["type"], 'changes' => array("Stevilko poslane ponudbe"=>'Poslano '.$history['action'].' na '.$history["datetime"]));
        $i++;
      }
      
      return $return;
    }

}

?>