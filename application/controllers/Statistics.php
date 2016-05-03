<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller for Dashboards functions
 */
class Statistics extends MY_Controller {

    /**
     * Index function showing the Dashboard page.
     */
    public function index()
    {
        $this->load->view('common/header');
        $this->load->view('statistics');
        $this->load->view('common/footer');
    }

    /**
     * Index function showing the Dashboard page.
     */
    public function init()
    {
        //$this->load->model('user_model');

        $return['user_type'] = $this->session->userdata["data"]["type"];

        echo json_encode($return);
    }

    /*
    * Function for getting Utm statistics.
    */
    public function getUtmStatistika(){
        $this->load->model("statistics_model");

        $filters["utm"] = $this->input->post('utm');

        if($this->input->post('date_from')) {
            $filters["date_from"] = $this->input->post('date_from') . " 00:00:00";
        }
        if($this->input->post('date_to')) {
            $filters["date_to"]   = $this->input->post('date_to') . " 23:59:59";
        }
        if ($this->input->post('flag')) {
            $filters['flag']      = $this->input->post('flag');
        }
        if ($this->input->post('date_year')) {
            $filters['date_year'] = $this->input->post('date_year');
        }     

        echo json_encode($this->statistics_model->getFromToStatistikaUtm($filters));
        exit();
    }

    /*
    * Function for getting all orders.
    */
    public function getAllOrders () {
        $this->load->model("statistics_model");
        if($this->input->post('date_from')) {
            $filters["date_from"] = $this->input->post('date_from') . " 00:00:00";
        }
        if($this->input->post('date_to')) {
            $filters["date_to"]   = $this->input->post('date_to') . " 23:59:59";
        }
        if ($this->input->post('flag')) {
            $filters['flag']      = $this->input->post('flag');
        }
        if ($this->input->post('date_year')) {
            $filters['date_year'] = $this->input->post('date_year');
        }

        echo json_encode($this->statistics_model->getAllOrdersFromTo($filters));
        exit();
    }

    /*
    * Function for getting only reserved orders.
    */
    public function getReservedOrders () {
        $this->load->model('statistics_model');
        if($this->input->post('date_from')) {
            $filters["date_from"] = $this->input->post('date_from') . " 00:00:00";
        }
        if($this->input->post('date_to')) {
            $filters["date_to"]   = $this->input->post('date_to') . " 23:59:59";
        }
        if ($this->input->post('flag')) {
            $filters['flag']      = $this->input->post('flag');
        }
        if ($this->input->post('date_year')) {
            $filters['date_year'] = $this->input->post('date_year');
        }

        echo json_encode($this->statistics_model->getReservedOrdersFromTo($filters));
        exit();
    }

    /*
    * Function for getting only realized orders.
    */
    public function getRealizedOrders () {
        $this->load->model('statistics_model');
        if($this->input->post('date_from')) {
            $filters["date_from"] = $this->input->post('date_from') . " 00:00:00";
        }
        if($this->input->post('date_to')) {
            $filters["date_to"]   = $this->input->post('date_to') . " 23:59:59";
        }
        if ($this->input->post('flag')) {
            $filters['flag']      = $this->input->post('flag');
        }
        if ($this->input->post('date_year')) {
            $filters['date_year'] = $this->input->post('date_year');
        }

        echo json_encode($this->statistics_model->getRealizedOrdersFromto($filters));
        exit();
    }

    /*
    * Function for getting the converted number of realized orders over the number of all orders.
    */
    public function getConversion () {
        $this->load->model('statistics_model');
        if($this->input->post('date_from')) {
            $filters["date_from"] = $this->input->post('date_from') . " 00:00:00";
        }
        if($this->input->post('date_to')) {
            $filters["date_to"]   = $this->input->post('date_to') . " 23:59:59";
        }
        if ($this->input->post('flag')) {
            $filters['flag']      = $this->input->post('flag');
        }
        if ($this->input->post('date_year')) {
            $filters['date_year'] = $this->input->post('date_year');
        }

        echo json_encode($this->statistics_model->getConversionNumber($filters));
        exit();
    }

    /*
    * Function for adding or updating monthly expenses in the database.
    */
    public function addMonthlyExpenses () {
        $this->load->model('statistics_model');
        if ($this->input->post('date')) {
            $filters['date']     = $this->input->post('date');
        }
        if ($this->input->post('expenses')) {
            $filters['expenses'] = $this->input->post('expenses');
        }
        if ($this->input->post('id')) {
            $filters['id'] = $this->input->post('id');
        }

        $this->statistics_model->addToMonthlyExpenses($filters);
        exit();
    }

    /*
    * Function for calculating the profit for a whole year.
    */
    public function calculateYearProfit () {
        $this->load->model('statistics_model');
        if ($this->input->post('date_year')) {
            $filters['date_year'] = $this->input->post('date_year');
        }

        echo json_encode($this->statistics_model->calculateProfit($filters));
        exit();
    }

    /*
    * Function for getting the expense value for a month.
    */
    public function getExpensesForDate () {
        $this->load->model('statistics_model');
        if ($this->input->post('date')) {
            $filters['date'] = $this->input->post('date') . "-01 00:00:00";
        }

        echo json_encode($this->statistics_model->getExpensesDate($filters));
        exit();
    }
}

?>