<?php
class Invoices_model extends CI_Model {

    /**
     * Gets the number all filtered invoices.
     * @param $filter    - array containing all filter values.
     * @return the number of all filtered invoices within the filter values.
     * @return 0 if error. 
     */
    public function countFilteredInvoices($filter){

        $sql_select_invoices = " SELECT count(i.id) as count FROM invoices as i 
                                 where paid = ".$this->db->escape($filter["paid"])." "; 

        if($filter["quick_text"]){
            $sql_select_invoices .= " and (i.invoice_num like '%".$this->db->escape_like_str($filter["quick_text"])."%') ";
        }

        if($filter["date_from"]){
            $sql_select_invoices .= " and i.date_created between '".$this->db->escape_str($filter["date_from"])." 00:00:00' and '".$this->db->escape_str($filter["date_to"])." 23:59:59' ";
        }

        $select_query_invoices = $this->db->query($sql_select_invoices);
        $invoices = $select_query_invoices->result_array();

        if($invoices){
            return $invoices[0]["count"];
        }
        else {
            return 0;
        }
    }

    /**
     * Gets all filtered invoices.
     * @param $filter    - array containing all filter values.
     * @return $invoices - array filled with all details of filtered invoices.
     */
    public function getFilteredInvoices($filter){ 

        $sql_select_invoices = " SELECT i.* FROM invoices as i 
                                 where paid = ".$this->db->escape($filter["paid"])." "; 

        if($filter["quick_text"]){
            $sql_select_invoices .= " and (i.invoice_num like '%".$this->db->escape_like_str($filter["quick_text"])."%') ";
        }

        if($filter["date_from"]){
            $sql_select_invoices .= " and i.date_created between '".$this->db->escape_str($filter["date_from"])." 00:00:00' and '".$this->db->escape_str($filter["date_to"])." 23:59:59' ";
        }

        $sql_select_invoices .= " limit ".$this->db->escape_str($filter["pag_from"]).", 20 ";

        $select_query_invoices = $this->db->query($sql_select_invoices);
        $invoices = $select_query_invoices->result_array();

        if($invoices){
            return $invoices;
        }
        else {
            return array();
        }
        
    }

    /**
     * Getting all details for a certain invoice.
     * @param $id - id of the invoice.
     * @return $details - array of the invoice details.
     * @return 0 if error.
     */
    public function getInvoiceDetails($id) {
        $sql = "SELECT date_format(i.date_export, '%d.%m.%Y') as date_export, date_format(i.date_done_from, '%d.%m.%Y') as date_done_from,
                       date_format(i.date_done_to, '%d.%m.%Y') as date_done_to, date_format(i.date_deadline, '%d.%m.%Y') as date_deadline , 
                       i.invoice_num, i.price, i.num_of_orders as quantity 
                FROM invoices as i
                WHERE i.id = ".$this->db->escape($id)."";
        $result = $this->db->query($sql);
        $details["invoice_details"] = $result->result_array()[0];

        $sql_orders = " SELECT o.* from orders as o
                        WHERE o.invoices_id = ".$this->db->escape($id)."";
        $result_ord = $this->db->query($sql_orders);
        $details["invoice_orders"] = $result_ord->result_array();

        if ($details) {
            return $details;
        } else {
            return 0;
        }
    }

    /**
     * Adds a new invoice into the database.
     * @param $details - array of the invoice details.
     * @return $invoice_id - id of the new invoice.
     * @return 0 if error.
     */
    public function createInvoice($details){
        var_dump($details); exit();
        $sql_insert_invoice = " INSERT into invoices 
                                (num_of_orders, invoice_num, price, date_created, paid, date_export, date_done_from, date_deadline, date_done_to)
                                values 
                                (".$this->db->escape($details["num_of_orders"]).",
                                 ".$this->db->escape($details["invoice_num"]).",
                                 ".$this->db->escape($details["invoice_price"]).",
                                 now(), 0,
                                 ".$this->db->escape($details["date_export"]).",
                                 ".$this->db->escape($details["date_done_from"]).",
                                 ".$this->db->escape($details["date_deadline"]).",
                                 ".$this->db->escape($details["date_done_to"]).")";
        $sql_insert_query = $this->db->query($sql_insert_invoice);
        $invoice_id = $this->db->insert_id();

        if ($invoice_id) {
            return $invoice_id;
        } else {
            return 0;
        }
    }

    /**
     * Updates invoices and orders containing certain invoices.
     * @param $invoices - array of the invoice ids' to be updated.
     * @param $status - the id of the order status.
     * @return 1 if queries are successful.
     * @return 0 if error.
     */
    public function changeInvoiceStatus($invoices, $status){
        $sql_update_invoice = " UPDATE invoices set
                                paid = 1 
                                where id in (".$this->db->escape_str(implode(',', $invoices)).")";
        $sql_insert_query_inv = $this->db->query($sql_update_invoice);
        
        $sql_update_orders = "  UPDATE orders set
                                order_status_id = ".$this->db->escape($status)." 
                                where invoices_id in (".$this->db->escape_str(implode(',', $invoices)).")";
        $sql_insert_query_ord = $this->db->query($sql_update_orders);

        if ($sql_update_invoice && $sql_update_orders) {
            return 1;
        } else {
            return 0;
        }
    }

}