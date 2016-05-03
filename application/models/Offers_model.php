<?php
class Offers_model extends CI_Model {

    /**
     * Gets all engines, discounts and installments details from database.
     * @return array of engines, discounts and installments details like name,price,subsidy etc.
     */
    public function getOfferParameters() {
        $sql_select_engine = "SELECT e.type, e.v4_price, e.v4_work, e.v6_price, e.v6_work, e.v8_price, e.v8_work, e.lubricating FROM engine as e"; 

        $select_query_engine = $this->db->query($sql_select_engine);
        $return["engines"] = $select_query_engine->result_array();

        $sql_select_discounts = "SELECT d.type, d.value FROM discounts as d "; 

        $select_query_discounts = $this->db->query($sql_select_discounts);
        $return["discounts"] = $select_query_discounts->result_array();

        $sql_select_installments = "SELECT i.type, i.subsidy, i.deposit, i.num_of_installments FROM installment as i "; 

        $select_query_installments = $this->db->query($sql_select_installments);
        $return["installments"] = $select_query_installments->result_array();

        if($return) {
        	return $return;
        }
        else {
        	return 0;
        }
    }

    /**
     * Updates all engine,discount,installment parameters with the appropriate values.
     * @param $engines      - array containg values for appropriate details for the designated engine.
     * @param $discounts    - array containg values for appropriate details for the designated discount.
     * @param $installments - array containg values for appropriate details for the designated installment.
     * @return 1 if query is succesful.
     * @return 0 if error.
     */
    public function changeOfferParameters ($engines, $discounts, $installments){
        $sql_update_engines = "UPDATE engine SET ";
        foreach ($engines[0] as $key => $value) {
            $sql_update_engines_tmp[] =  "".$this->db->escape_str($key)." = CASE 
                                    WHEN type = ".$this->db->escape($engines[0]["type"])." THEN ".$this->db->escape($engines[0][$key])."
                                    WHEN type = ".$this->db->escape($engines[1]["type"])." THEN ".$this->db->escape($engines[1][$key])."
                                    END ";
        }
        $sql_update_engines .= implode($sql_update_engines_tmp, ",");

        $result['engines'] = $this->db->query($sql_update_engines);

        $sql_update_discounts = "UPDATE discounts SET ";
        foreach ($discounts[0] as $key => $value) {
            $sql_update_discounts_tmp[] =  " ".$this->db->escape_str($key)." = CASE 
                                    WHEN type = ".$this->db->escape($discounts[0]["type"])." THEN ".$this->db->escape($discounts[0][$key])."
                                    WHEN type = ".$this->db->escape($discounts[1]["type"])." THEN ".$this->db->escape($discounts[1][$key])."
                                    END ";
        }

        $sql_update_discounts .= implode($sql_update_discounts_tmp, ",");

        $result['discounts'] = $this->db->query($sql_update_discounts);

        $sql_update_installments = "UPDATE installment SET ";
        foreach ($installments[0] as $key => $value) {
            $sql_update_installments_tmp[] =  $this->db->escape_str($key)." = CASE 
                                    WHEN type = ".$this->db->escape($installments[0]["type"])." THEN ".$this->db->escape($installments[0][$key])."
                                    WHEN type = ".$this->db->escape($installments[1]["type"])." THEN ".$this->db->escape($installments[1][$key])."
                                    WHEN type = ".$this->db->escape($installments[2]["type"])." THEN ".$this->db->escape($installments[2][$key])."
                                    END ";
        }
        $sql_update_installments .= implode($sql_update_installments_tmp, ",");

        $result['installments'] = $this->db->query($sql_update_installments);

        if ($result['engines'] || $result['discounts'] || $result['installments']) {
            return 1;
        } else {
            return 0;
        }
        
    }

    /**
     * Gets details about the engine, its sale discount and included installments from an offer in the database.
     * @param $id - the id for the designated offer.
     * @return $return - array with the details if query is successful.
     * @return 0 if error.
     */
    public function getOffer($id){
        $sql_get_offer = "select of.*, o.email from offers as of
                          left join  (select * from orders) as o on of.order_id = o.id
                          where of.id = ".$this->db->escape($id); 

        $result = $this->db->query($sql_get_offer);
        $offer  = $result->result_array()[0];    

        $sql_get_offer_infos = "select * from engine where type = ".$this->db->escape($offer["motor"]);

        $result2 = $this->db->query($sql_get_offer_infos);
        $engine_infos  = $result2->result_array()[0];

        $sql_get_installment_infos = "select * from installment";

        $result3 = $this->db->query($sql_get_installment_infos);
        $installment_infos  = $result3->result_array();

        $sql_get_discounts_infos = "select * from discounts";

        $result4 = $this->db->query($sql_get_discounts_infos);
        $discounts_infos  = $result4->result_array();

        $return["motor_name"]   = $engine_infos["text_name"];

        if($offer["lubricant"] == 1){
            $return["fin_price_text"]    = $engine_infos["text_with_lubricant"];
            $lube_price                  = (int)$engine_infos['lubricating'];
        }
        else{
            $return["fin_price_text"]    = $engine_infos["text_without_lubricant"];
            $lube_price                  = (int)0;
        }

        $return["guarantee"]    = $engine_infos["text_guarantee"];
        $return["work_time"]    = $engine_infos[$offer["motor_type"]."_work"];
        $return["work_price"]   = $engine_infos[$offer["motor_type"]."_price"] + $lube_price;

        foreach ($installment_infos as $key=>$value) {
            $return[$value['type']] = $value;
        }
        foreach ($discounts_infos as $key => $value) {
            $return[$value["type"]] = $value['value'];
        }
        $return["order_id"] = $offer["order_id"];
        $return['mail_to']  = $offer['email'];
        if($return) {
            return $return;
        }
        else {
            return 0;
        }
    }

    /*
     * Gets all offers containing the desiganted order.
     * @param $order_id - the id of the designated order.
     * @return $offers - array of all offers with the order if query is successful.
     * @return 0 if error.
     */
    public function getOrderOffers($order_id){
        $sql_get_offers = " select * from offers where order_id = ".$this->db->escape($order_id)." "; 

        $result = $this->db->query($sql_get_offers);
        $offers  = $result->result_array();

        if($offers){
            return $offers;
        }
        else{
            return array();
        }
    }

    /**
     * Creates a new offer in the database.
     * @param $details - array containg all offer attribute values accordingly.
     * @return id of the new offer inserted in the database if query is successful.
     * @return 0 if error.
     */
    public function createOffer($details){
        $sql_insert = " insert into offers 
                        (order_id, motor, motor_type, lubricant, discount, date_created)
                        values 
                        (".$this->db->escape($details["order_id"]).", ".$this->db->escape($details["motor"]).",
                         ".$this->db->escape($details["motor_type"]).", ".$this->db->escape($details["lubricant"]).",
                         ".$this->db->escape($details["discount"]).", now() ) "; 

        $result = $this->db->query($sql_insert);

        if($result) {
            return $this->db->insert_id();
        }
        else {
            return 0;
        }
    }

    public function insertOfferInHistory ($data, $offer_id) {
        $sql = "INSERT INTO history_offers (user_id, order_id, datetime, type, action)
                VALUES (".$this->session->userdata["data"]["user_id"].",".$this->db->escape_str($data['order_id']).",NOW(),'offer_sent', ".$this->db->escape_str($offer_id).")";

        $query  = $this->db->query($sql);

        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }
    
}

?>