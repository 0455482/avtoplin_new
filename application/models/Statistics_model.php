<?php
class Statistics_model extends CI_Model {

    /**
     * Getting orders statistics from database.
     * 
     * @return array The order status statistics.
     * @return 0 If there is no stats.
     * 
     */
    public function getBoxOrderStatistics(){
        $sql_select = " SELECT count(o.id) as count, o.order_status_id, os.name
                        from orders as o
                        left join order_status as os on o.order_status_id = os.id
                        group by o.order_status_id"; 
        
        $select_query = $this->db->query($sql_select);
        $statistics   = $select_query->result_array();
        
        foreach ($statistics as $statistic) {
            $countNames[$statistic['name']] = $statistic;
        }

        $sql_selectName = "SELECT name FROM order_status";  

        $query          = $this->db->query($sql_selectName);
        $statNames      = $query->result_array();
        
        $i = 0;
        foreach ($statNames as $status) {
            if ($countNames[$status['name']]) {
                $return[$i]['count'] = (int)$countNames[$status['name']]['count'];
                $return[$i]['name']  = $status['name']; 
            } else {
                $return[$i]['count'] = (int)"0";
                $return[$i]['name']  = $status['name']; 
            }
            $i++;
        }
        return $return;
    }
    
    /**
     * Getting utm statistics.
     * Calculating how many orders were influenced by which advertisement. Per day (from - to) or per month (1 year).
     * @param $filters - array conatining date values and a flag value determining the query process.
     * @return array of days/months and appropriate number of orders per day/month, along with their 'source'.
     *
     */
    public function getFromToStatistikaUtm($filters){
        if ($filters['flag'] == 0) {
            $sql_get_utm = "select count(o.id) as count, o.utm, date_format(o.date_created, '%b %e') as date  
                            from orders as o 
                            WHERE (o.date_created BETWEEN '".$this->db->escape_str($filters["date_from"])."' AND '".$this->db->escape_str($filters["date_to"])."') 
                            group by o.utm, date
                            order by o.date_created";
            $datePeriod = $this->returnDates($filters["date_from"], $filters["date_to"]);
        } else {
            $to_year = $filters['date_year']+1; 
            $sql_get_utm = "select count(o.id) as count, o.utm, date_format(o.date_created, '%b') as date  
                            from orders as o 
                            WHERE (o.date_created BETWEEN '".$this->db->escape_str($filters['date_year'])."-01-01 00:00:00' AND '".$this->db->escape_str($to_year)."-01-01 00:00:00')
                            group by o.utm, date
                            order by o.date_created";
            $start    = (new DateTime($filters["date_year"].'-01'))->modify('first day of this month');
            $end      = (new DateTime($to_year."-01"))->modify('first day of this month');
            $interval = DateInterval::createFromDateString('1 month');
            $datePeriod   = new DatePeriod($start, $interval, $end);
        }
        
        $query_get_utm = $this->db->query($sql_get_utm);
        $utm_list      = $query_get_utm->result_array();       
        
        foreach ($utm_list as $key => $val) {
            $res = array();
            $utm_temp = explode(",", $val["utm"]);
            if($utm_temp[0]) {
                foreach ($utm_temp as $k => $v) {
                    $vars = explode("=", $v);
                    $res[$vars[0]] = $vars[1];

                }
            }

            $results[$val["date"]][$res[$filters["utm"]]] += $val["count"];
            $utms[$res[$filters["utm"]]] = $res[$filters["utm"]];           // $res[$filters["utm"] -> source ??
            
        }
        
        foreach ($utms as $one_utm) {
            if($one_utm == "") {
                $return['count'][0]["name"] = "Direct";
            } else {
                $return['count'][0]["name"] = $one_utm;
            }
        }
        
        foreach ($datePeriod as $date) {
            if ($filters['flag'] == 0) {
                $return['date'][] = $date->format('M d');
                if ($results[$date->format('M d')]) {
                    $return ['count'][0]['data'][] = (int)$results[$date->format('M d')][$return['count'][0]["name"]];
                } else {
                    $return ['count'][0]['data'][] = (int)"0";
                }
            } else {
                $return['date'][] = $date->format('M');
                if ($results[$date->format('M')]) {
                    $return ['count'][0]['data'][] = (int)$results[$date->format('M')][$return['count'][0]["name"]];
                } else {
                    $return ['count'][0]['data'][] = (int)"0";
                }
            }
        }
        $return['date']  = array_unique($return['date']);

        return $return;
    }

    /**
     * Getting statistics of orders per day/month appropriately from database.
     * Gets the number of all orders regardless of status made per day/month within a designated time interval.
     * @param $filters - array conatining date values and a flag value determining the query process.
     * @return array of days/months and appropriate number of all orders on that day/month.
     *
     */
    public function getAllOrdersFromTo ($filters) {
        if ($filters['flag'] == 0) {
            $sql = "select count(o.id) as count, date_format(o.date_created, '%b %d') as date
                    from orders as o
                    WHERE (o.date_created BETWEEN '".$this->db->escape_str($filters["date_from"])."' AND '".$this->db->escape_str($filters["date_to"])."')
                    group by date 
                    order by o.date_created";

            $datePeriod = $this->returnDates($filters["date_from"], $filters["date_to"]);
            
        } else {
            $to_year = $filters['date_year']+1;
            $sql = "SELECT count(o.id) as count, date_format(o.date_created, '%b') as date
                    from orders as o
                    WHERE (o.date_created BETWEEN '".$this->db->escape_str($filters['date_year'])."-01-01 00:00:00' AND '".$this->db->escape_str($to_year)."-01-01 00:00:00')
                    group by date
                    order by o.date_created";

            $start    = (new DateTime($filters["date_year"].'-01'))->modify('first day of this month');
            $end      = (new DateTime($to_year."-01"))->modify('first day of this month');
            $interval = DateInterval::createFromDateString('1 month');
            $datePeriod   = new DatePeriod($start, $interval, $end);
        }

        $query  = $this->db->query($sql);
        $orders = $query->result_array();
         
        foreach ($orders as $order) {
            $newOrders[$order['date']] = $order;
        }

        if ($filters['flag'] == 0) {
            foreach ($datePeriod as $date) {
                $return['date'][] = $date->format('M d');
                if ($newOrders[$date->format('M d')]) {
                    $return['count'][0]['data'][] = (int)$newOrders[$date->format('M d')]['count'];
                } else {
                    $return['count'][0]['data'][] = (int)"0";                
                }
            }
        } else {
            foreach ($datePeriod as $date) {
                $return['date'][] = $date->format('M');
                if ($newOrders[$date->format('M')]) {
                    $return['count'][0]['data'][] = (int)$newOrders[$date->format('M')]['count'];
                } else {
                    $return['count'][0]['data'][] = (int)"0";                
                }
            }
        }

        $return['count'][0]['name'] = "Naročila";
        return $return;
    }

    /**
     * Getting statistics of only reserved orders per day/month appropriately from database.
     * Gets the number of only reserved orders made per day/month within a designated time interval.
     * @param $filters - array conatining date values and a flag value determining the query process.
     * @return array of days/months and appropriate number of only reserved orders on that day/month.
     *
     */
    public function getReservedOrdersFromto ($filters) {
        if ($filters['flag'] == 0) {
            $sql = "select count(o.id) as count, date_format(o.date_created, '%b %d') as date, o.reservation_flag
                    from orders as o
                    WHERE (o.date_created BETWEEN '".$this->db->escape_str($filters["date_from"])."' AND '".$this->db->escape_str($filters["date_to"])."') AND reservation_flag = 1
                    group by date 
                    order by o.date_created";

            $datePeriod = $this->returnDates($filters["date_from"], $filters["date_to"]);        
        } else {
            $to_year = $filters['date_year']+1;
            $sql = "SELECT count(o.id) as count, date_format(o.date_created, '%b') as date
                    from orders as o
                    WHERE (o.date_created BETWEEN '".$this->db->escape_str($filters['date_year'])."-01-01 00:00:00' AND '".$this->db->escape_str($to_year)."-01-01 00:00:00') AND reservation_flag = 1
                    group by date
                    order by date";

            $start    = (new DateTime($filters["date_year"].'-01'))->modify('first day of this month');
            $end      = (new DateTime($to_year."-01"))->modify('first day of this month');
            $interval = DateInterval::createFromDateString('1 month');
            $datePeriod   = new DatePeriod($start, $interval, $end);
        }

        $query = $this->db->query($sql);
        $orders = $query->result_array();

        foreach ($orders as $order) {
            $newOrders[$order['date']] = $order;
        } 

        if ($filters['flag'] == 0) {
            foreach ($datePeriod as $date) {
                $return['date'][] = $date->format('M d');
                if ($newOrders[$date->format('M d')]) {
                    $return['count'][0]['data'][] = (int)$newOrders[$date->format('M d')]['count'];
                } else {
                    $return['count'][0]['data'][] = (int)"0";
                }
            }
        } else {
            foreach ($datePeriod as $date) {
                $return['date'][] = $date->format('M');
                if ($newOrders[$date->format('M')]) {
                    $return['count'][0]['data'][] = (int)$newOrders[$date->format('M')]['count'];
                } else {
                    $return['count'][0]['data'][] = (int)"0";
                }
            }
        }

        $return['count'][0]['name'] = "Naročila";     
        return $return;
    }

    /**
     * Getting statistics of only realized orders per day/month appropriately from database.
     * Gets the number of only realized orders made per day/month within a designated time interval.
     * @param $filters - array conatining date values and a flag value determining the query process.
     * @return array of days/months and appropriate number of only realized on that day/month.
     *
     */
    public function getRealizedOrdersFromto ($filters) {
        if ($filters['flag'] == 0) {
            $sql = "select count(o.id) as count, date_format(o.date_created, '%b %d') as date, o.reservation_flag
                    from orders as o
                    WHERE (o.date_created BETWEEN '".$this->db->escape_str($filters["date_from"])."' AND '".$this->db->escape_str($filters["date_to"])."') AND realization_flag = 1
                    group by date 
                    order by o.date_created";

            $datePeriod = $this->returnDates($filters["date_from"], $filters["date_to"]);        
        } else {
            $to_year = $filters['date_year']+1;
            $sql = "SELECT count(o.id) as count, date_format(o.date_created, '%b') as date
                    from orders as o
                    WHERE (o.date_created BETWEEN '".$this->db->escape_str($filters['date_year'])."-01-01 00:00:00' AND '".$this->db->escape_str($to_year)."-01-01 00:00:00') AND realization_flag = 1
                    group by date
                    order by date";

            $start    = (new DateTime($filters["date_year"].'-01'))->modify('first day of this month');
            $end      = (new DateTime($to_year."-01"))->modify('first day of this month');
            $interval = DateInterval::createFromDateString('1 month');
            $datePeriod   = new DatePeriod($start, $interval, $end);
        }

        $query = $this->db->query($sql);
        $orders = $query->result_array();

        foreach ($orders as $order) {
            $newOrders[$order['date']] = $order;
        } 

        if ($filters['flag'] == 0) {
            foreach ($datePeriod as $date) {
                $return['date'][] = $date->format('M d');
                if ($newOrders[$date->format('M d')]) {
                    $return['count'][0]['data'][] = (int)$newOrders[$date->format('M d')]['count'];
                } else {
                    $return['count'][0]['data'][] = (int)"0";
                }
            }
        } else {
            foreach ($datePeriod as $date) {
                $return['date'][] = $date->format('M');
                if ($newOrders[$date->format('M')]) {
                    $return['count'][0]['data'][] = (int)$newOrders[$date->format('M')]['count'];
                } else {
                    $return['count'][0]['data'][] = (int)"0";
                }
            }
        }

        $return['count'][0]['name'] = "Naročila";     
        return $return;
    }

    /**
     * Gets the number of realized orders over all orders per day/month within a desiganted time interval.
     * @param $filters - array conatining date values and a flag value determining the query process.
     * @return array of days/months and appropriate number of all orders on that day/month.
     *
     */
    public function getConversionNumber ($filters) {
        if ($filters['flag'] == 0) {
            $sql          = "select count(o.id) as count, date_format(o.date_created, '%b %d') as date
                             from orders as o
                             WHERE (o.date_created BETWEEN '".$this->db->escape_str($filters["date_from"])."' AND '".$this->db->escape_str($filters["date_to"])."')
                             group by date 
                             order by o.date_created";
            $sql_realized = "select count(o.id) as count, date_format(o.date_created, '%b %d') as date
                             from orders as o
                             WHERE (o.date_created BETWEEN '".$this->db->escape_str($filters["date_from"])."' AND '".$this->db->escape_str($filters["date_to"])."') AND realization_flag = 1
                             group by date 
                             order by o.date_created";
            $datePeriod = $this->returnDates($filters["date_from"], $filters["date_to"]);
        } else {
            $to_year = $filters['date_year'] + 1;
            $sql  = "select count(o.id) as count, date_format(o.date_created, '%b') as date
                             from orders as o
                             WHERE (o.date_created BETWEEN '".$this->db->escape_str($filters['date_year'])."-01-01 00:00:00' AND '".$this->db->escape_str($to_year)."-01-01 00:00:00')
                             group by date 
                             order by o.date_created";
            $sql_realized = "select count(o.id) as count, date_format(o.date_created, '%b') as date
                             from orders as o
                             WHERE (o.date_created BETWEEN '".$this->db->escape_str($filters['date_year'])."-01-01 00:00:00' AND '".$this->db->escape_str($to_year)."-01-01 00:00:00') AND realization_flag = 1
                             group by date 
                             order by o.date_created";
            $start    = (new DateTime($filters["date_year"].'-01'))->modify('first day of this month');
            $end      = (new DateTime($to_year."-01"))->modify('first day of this month');
            $interval = DateInterval::createFromDateString('1 month');
            $datePeriod   = new DatePeriod($start, $interval, $end);
        }
        $query = $this->db->query($sql);
        $orders = $query->result_array();       
        $query_realized = $this->db->query($sql_realized);
        $realizedOrders = $query_realized->result_array();

        foreach ($realizedOrders as $order) {
            $newRealizedOrders[$order['date']] = $order;
        }      
        foreach ($orders as $order) {
            $newOrders[$order['date']] = $order;
        }
        
        if ($filters['flag'] == 0) {
            foreach ($datePeriod as $date) {
                $return['date'][] = $date->format('M d');
                if ($newOrders[$date->format('M d')]) {
                    if ($newRealizedOrders[$date->format('M d')]) {
                        $return['count'][0]['data'][] = (int)$newRealizedOrders[$date->format('M d')]['count'] / $newOrders[$date->format('M d')]['count'];
                    } else {
                        $return['count'][0]['data'][] = (int)"0";
                    }
                } else {
                    $return['count'][0]['data'][] = (int)"0";
                }        
            }
        } else {
            foreach ($datePeriod as $date) {
                $return['date'][] = $date->format('M');
                if ($newOrders[$date->format('M')]) {
                    if ($newRealizedOrders[$date->format('M')]) {
                        $return['count'][0]['data'][] = (int)$newRealizedOrders[$date->format('M')]['count'] / $newOrders[$date->format('M')]['count'];
                    } else {
                        $return['count'][0]['data'][] = (int)"0";
                    }
                } else {
                    $return['count'][0]['data'][] = (int)"0";
                }        
            }
        }

        $return['count'][0]['name'] = "Naročila";    
        return $return;
    }

    /**
     * Updates or inserts the value of expenses for a certain month.
     * Value and month are contained in the parameter.
     * @param $filters - array containing the id, expense value and the designated month to be changed.
     * @return 1 if query is successful.
     * @return 0 if error.
     *
     */
    public function addToMonthlyExpenses ($filters) {
        if ($filters['id'] == -1) {
            $sql = "INSERT INTO monthly_expenses (date, expenses)
                    VALUES ('".$this->db->escape_str($filters['date'])."-01 00:00:00"."', ".$this->db->escape_str($filters['expenses']).")";
            $result = $this->db->query($sql);
        } else {
            $sql = "UPDATE monthly_expenses
                    SET date = '".$this->db->escape_str($filters['date'])."-01 00:00:00', expenses = ".$this->db->escape_str($filters['expenses'])."
                    WHERE id = ".$this->db->escape($filters['id'])."";
            $result = $this->db->query($sql);
        }

        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }

    /**
     * Calculates the profit made per month for a whole designated year.
     * Presents income and expense per month.
     * @param $filters - containing the designated year.
     * @return $return - array of all months, income and expenses per month.
     */
    public function calculateProfit ($filters) {
        $to_year = (int)$filters["date_year"] + 1;
        $sql = "SELECT count(o.id) as count, date_format(o.date_created, '%b') as date, me.expenses 
                FROM orders as o
                LEFT JOIN (SELECT *, date_format(date, '%b') FROM monthly_expenses) as me on date_format(o.date_created, '%b') = date_format(me.date, '%b')
                WHERE (o.date_created BETWEEN '".$filters["date_year"]."-01-01 00:00:00' AND '".$to_year."-01-01 00:00:00') AND realization_flag = 1
                group by date 
                order by o.date_created";
        $query = $this->db->query($sql);
        $orders = $query->result_array();

        foreach ($orders as $order) {
            $ords[$order['date']] = $order;
        }

        $sql_get_expenses = "SELECT date_format(me.date, '%b') as date, me.expenses FROM monthly_expenses as me";
        $query_expenses   = $this->db->query($sql_get_expenses);
        $monthly_expenses = $query_expenses->result_array();

        foreach ($monthly_expenses as $month) {
            $mnths[$month['date']] = $month;
        }

        $start    = (new DateTime($filters["date_year"].'-01'))->modify('first day of this month');
        $end      = (new DateTime($to_year."-01"))->modify('first day of this month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);
        
       
        foreach ($period as $dt) {
            if ($ords[$dt->format("M")]) {
                $return['date'][]  = $dt->format("M")."(".(($ords[$dt->format("M")]['count'] * 120) - (int)$ords[$dt->format("M")]['expenses']).")";
                $return['count'][0]['name'] = 'Prihod';              
                $return['count'][0]['data'][] = $ords[$dt->format("M")]['count'] * 120;          
                $return['count'][1]['name'] = 'Stroski';              
                $return['count'][1]['data'][] = (int)$ords[$dt->format("M")]['expenses'];              
            } else {
                $return['date'][]  = $dt->format("M")."(".-(int)$mnths[$dt->format("M")]['expenses'].")";
                $return['count'][0]['name'] = 'Prihod';              
                $return['count'][0]['data'][] = $ords[$dt->format("M")]['count'] * 120;          
                $return['count'][1]['name'] = 'Stroski';              
                $return['count'][1]['data'][] = (int)$mnths[$dt->format("M")]['expenses'];   
            }              
        }

        return $return;
        exit();
    }

    /**
     * Gets the value of expenses for a designated month.
     * @param $filters - array containing the designated month.
     * @return the id and value of expenses for the month. 
     *
     */
    public function getExpensesDate ($filters) {
        $sql = "SELECT me.id, me.expenses FROM monthly_expenses as me
                WHERE date_format(me.date, '%b') = date_format('".$this->db->escape_str($filters['date'])."', '%b')";
        
        $query  = $this->db->query($sql);
        $result = $query->result_array()[0];

        if (!$result) {
            $result['id'] = -1;
        } 

        return $result;
        exit();
    }

    /**
     * Returns all dates in a sequence within a designated time interval.
     * @param $fromdate is the start date.
     * @param $todate is the end date.
     * @return a DatePeriod array containg all days within the time interval.
     *
     */
    public function returnDates($fromdate, $todate) {
        $fromdate = DateTime::createFromFormat('Y-m-d H:i:s', $fromdate);
        $todate = DateTime::createFromFormat('Y-m-d H:i:s', $todate);
        return new DatePeriod(
            $fromdate,
            new DateInterval('P1D'),
            $todate
        );
    } 

}

?>