<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller for Dashboards functions
 */
class Actions extends MY_Controller {

	/**
	 * Init function gets the needed informations for initializing the site.
	 * 
	 * Gets the box statistics for the dashboard, and the order statuses for init the order table
	 * 
	 * @param string $username
	 * @param string $password
	 * 
	 * @return array Count of the orders with same order status (statistic) 
	 * @return array All informations about the order statuses 
	 * 
	 */
	public function changeOrdersStatus ()
	{
		$this->load->model('orders_model');
		$this->load->model('invoices_model');

		if(is_array($this->input->post('orders'))){
			$orders = $this->input->post('orders');
		}
		else {
			$orders[] = $this->input->post('orders');
		}
		$status = $this->input->post('status');

		$additional = array();
		
		if($status == 3){ // if status changed to "Reserved"
			if($this->input->post('reservation_date')){
				$additional["reservation_date"] = $this->input->post('reservation_date');
			}
		}
		else if($status == 4){ //if status changed to "Realized"
			$additional["realization_flag"] = 1;
		}
		else if($status == 5){ //if status changed to "Invoice"
			if($this->input->post('invoice_num')){
				$additional["invoice_num"] 		= $this->input->post('invoice_num');
				$additional["date_export"] 		= $this->input->post('date_export');
				$additional["date_done_from"] 	= $this->input->post('date_done_from');
				$additional["date_done_to"] 	= $this->input->post('date_done_to');
				$additional["date_deadline"] 	= $this->input->post('date_deadline');
				$additional["num_of_orders"] 	= count($orders);
				$additional["invoice_price"] 	= count($orders)*120;
			}
			else {
				echo "Prislo je do napake!";
				exit();
			}
			$additional["invoice_id"] = $this->invoices_model->createInvoice($additional);
		}
		else if($status == 7){ //if status changed to "Archive"
			if($this->input->post('archive_comment')){
				$additional["archive_comment"] = $this->input->post('archive_comment');
			}
		}
		else if($status == 8){ //if status changed to "Deleted"
			if($this->input->post('deleted')==1){
				$additional["deleted"] = 0;
			}
		}
		
		$res 	= $this->orders_model->changeOrdersStatus($orders, $status, $additional);
		
		echo $res;
		exit();
	}

	/*
	 * Function for getting all possible following statuses for a certain status.
	 */
	public function getNextStatusesForStatus(){
		$this->load->model('statuses_model');

		$id = $this->input->post('status_id');
		
		$res 	= $this->statuses_model->getNextStatusesForStatus($id);
		
		echo json_encode($res);
		exit();
	}

	/*
	 * Function for getting all possible following statuses for a certain status.
	 */
	public function changeInvoicesStatus()
	{
		$this->load->model('invoices_model');

		if(is_array($this->input->post('invoices'))){
			$invoices = $this->input->post('invoices');
		}
		else {
			$invoices[] = $this->input->post('invoices');
		}
		$status = $this->input->post('status');
		
		$res = $this->invoices_model->changeInvoiceStatus($invoices, $status);

		echo $res;
		exit();
	}

	/*
	 * Function for getting all offers containing a single certain order.
	 */
	public function getOrderOffers(){
		$this->load->model('offers_model');

		$order_id = $this->input->post('order_id');

		$offers = $this->offers_model->getOrderOffers($order_id);

		echo json_encode($offers);
		exit();
	}

	/*
	 * Function for getting all offers containing a single certain order.
	 */
	public function previewInvoice (){
		$this->load->model('invoices_model');
		$inv_id = $this->input->post('inv_id');

		$details = $this->invoices_model->getInvoiceDetails($inv_id);
		$details['func'] = 'preview';
		$this->makeExcelInvoice($details);
	}

	/*
	 * Function for sending email containing excel file with orders and offers.
	 */
	public function sendInvoiceEmail() {
		$this->load->model('invoices_model');
		$inv_id = $this->input->post('inv_id');

		if ($inv_id) {
			$details = $this->invoices_model->getInvoiceDetails($inv_id);
			$details['func'] = 'mail';
			$this->makeExcelInvoice($details);

			$config = Array(
			    'protocol'  => 'smtp',
			    'smtp_host' => 'ssl://host.ventrigo.com',
			    'smtp_port' =>  465,
			    'smtp_user' => 'jurij.kercmar@g1avtoplin.com',
			    'smtp_pass' => 'espacex365',
			    'mailtype'  => 'html', 
			    'charset'   => 'utf-8',
			    'newline'	=> "\r\n",
			    'wordwrap'  =>  TRUE
			);
			$this->email->initialize($config);

			$this->email->from('jurij.kercmar@g1avtoplin.com')
	        			->to('srajchevski@gmail.com')
	        			->subject('Email Test')
	        			->message('Nesto')
	        			->attach('tmp/Offer.xlsx')
	        			->send();
				 
	        unlink(FCPATH.'tmp/Offer.xlsx');
	        echo 1;
	    } else {
	    	echo 0;
	    }
        exit();
	}

	/*
	 * Function for displaying an offer in the browser as a pdf file.
	 */
	public function viewOffer(){
		include (FCPATH.'/resources/mpdf60/mpdf.php');
		$this->load->model('offers_model');

		$offer_id = $this->input->post('offer_id');
		
		if ($offer_id) {
			$offer = $this->offers_model->getOffer($offer_id);

			$mpdf = new mPDF();
	     	$mpdf->SetDisplayMode('fullpage');
			$html = $this->load->view('invoice', $offer, true);
			$mpdf->WriteHTML($html);
			$mpdf->Output(FCPATH.'tmp/Offer.pdf', 'I');
			unlink(FCPATH.'tmp/Offer.pdf');	
			echo 1;
		} else {
			echo 0;
			exit();
		}	
	}

	/*
	 * Function for sending an email with an offer as a pdf file.
	 */
	public function sendOfferEmail(){
		include (FCPATH.'/resources/mpdf60/mpdf.php');
		$this->load->model('offers_model');
		$this->load->model('orders_model');
		$offer_id = $this->input->post('offer_id');

		if ($offer_id) {
			$data = $this->offers_model->getOffer($offer_id);
			
			$mpdf = new mPDF();
			$html = $this->load->view('invoice', $data, true);
			$mpdf->WriteHTML($html);
			$mpdf->Output('tmp/Offer.pdf', 'F');

			$noteOffer = $this->offers_model->insertOfferInHistory($data, $offer_id);

			$config = Array(
			    'protocol'  => 'smtp',
			    'smtp_host' => 'ssl://host.ventrigo.com',
			    'smtp_port' =>  465,
			    'smtp_user' => 'jurij.kercmar@g1avtoplin.com',
			    'smtp_pass' => 'espacex365',
			    'mailtype'  => 'html', 
			    'charset'   => 'utf-8',
			    'newline'	=> "\r\n",
			    'wordwrap'  =>  TRUE
			);
			$this->email->initialize($config);
			
	        $this->email->from('jurij.kercmar@g1avtoplin.com')
	        			->to($data['mail_to']) 
	        			->subject('Ponudba za predelavo vašega avtomobila na plin.')
	        			->message("Spoštovani, 
	        						<br/> <br/>
									v priponki je ponudba za predelavo vašega avtomobila na plin, v spodnji 
									povezavi, pa si lahko ogledate celovito predstavitev podjetja G-1 d.o.o. v oddaji Prava ideja.
									<br/> <br/>
									<a href='http://www.rtvslo.si/play/prava-ideja-poslovna-oddaja/ava2.31977900/' target='_blank'>http://www.rtvslo.si/play/prava-ideja-poslovna-oddaja/ava2.31977900/</a>
									<br/> <br/>
									Lep pozdrav,
									Jurij Kerčmar")
	        			->attach('tmp/Offer.pdf')
	        			->send();
	        unlink(FCPATH.'tmp/Offer.pdf');

	        $orders[] 	= $data["order_id"];
	        $additional = array();
			$res 		= $this->orders_model->changeOrdersStatus($orders, 2, $additional);
	        echo 1;
	        exit();
	    } else {
	    	echo 0;
        	exit();
	    }
	}

	/*
	 * Function for creating a new offer.
	 */
	public function createOrderOffer(){
		$this->load->model('offers_model');

		if($this->input->post('offer')){
			$offer_details 		= $this->input->post('offer');

			$det["order_id"] 	= $this->input->post('order_id');
			$det["motor"] 		= $offer_details['motor'];
			$det["motor_type"] 	= $offer_details['motor_type'];
			$det["lubricant"]	= $offer_details['lubricant'];
			$det["discount"]	= $offer_details['discount'];

			$id 				= $this->offers_model->createOffer($det);

			echo $id;
		}
		else{
			echo -1;
		}
		exit();
	}

	/*
	 * Function for sending a single sms to a client.
	 */
	public function sendSingleSms () {
		$this->load->model('sms_model');

		if ($this->input->post('telephone')) {
			$filters['telephone'] = $this->input->post('telephone');
		}
		if ($this->input->post('text')) {
			$filters['text'] 	  = $this->input->post('text');
		}
		if ($this->input->post('st_id')) {
			$filters['st_id'] 	  = $this->input->post('st_id');
		}
		if ($this->input->post('o_id')) {
			$filters['o_id'] 	  = $this->input->post('o_id');
		}

		$res = $this->sms_model->sendOneSms($filters);

		if($res){
			$this->load->model('orders_model');
			$orders[] 						= $filters['o_id'];
			$additional["archive_comment"] 	= "SMS sended";
			$result 						= $this->orders_model->changeOrdersStatus($orders, 7, $additional);
		}

		echo $res;
		exit();
	}


	/*
	 * Function for exporting selected orders.
	 */
	public function exportOrders () {
		include (FCPATH.'/resources/PHPExcel.php');
		$this->load->model('orders_model');

		$orders_ids = $this->input->post('orders');
		$orders 		= $this->orders_model->getOrdersDetailsForExport($orders_ids); 

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// STYLE
		$styleColor = array(
		    'fill' => array(
		        'type' => PHPExcel_Style_Fill::FILL_SOLID,
		        'color' => array('rgb' => 'FFFF00')
			),	
		);
		$styleBorders = array(
	    	'borders' => array(
		        'allborders' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THIN,
		            'color' => array('rgb' => '000000')
		        )
	    	)
		);

		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleColor);
		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleBorders);
		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('16');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('16');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('16');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('16');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('16');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('16');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('16');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('16');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth('16');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth('16');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth('16');

		// CELL VALUES
		$objPHPExcel->getActiveSheet()
					->SetCellValue('A1', 'Customer')
					->SetCellValue('B1', 'Email')
					->SetCellValue('C1', 'Status')
					->SetCellValue('D1', 'Telephone')
					->SetCellValue('E1', 'City')
					->SetCellValue('F1', 'Car model')
					->SetCellValue('G1', 'Comment')
					->SetCellValue('H1', 'UTM-Source')
					->SetCellValue('I1', 'UTM-Campaign')
					->SetCellValue('J1', 'UTM-Placement')
					->SetCellValue('K1', 'UTM-Content')
					->SetCellValue('L1', 'UTM-Term')
					->SetCellValue('M1', 'Date Creted');

		$i = 2;			
		foreach ($orders as $key => $order) {
			$objPHPExcel->getActiveSheet()
						->SetCellValue('A'.$i, $order['customer'])
						->SetCellValue('B'.$i, $order['email'])
						->SetCellValue('C'.$i, $order['status_name'])
						->SetCellValue('D'.$i, $order['telephone'])
						->SetCellValue('E'.$i, $order['city'])
						->SetCellValue('F'.$i, $order['car_model'])
						->SetCellValue('G'.$i, $order['customer_profile'])
						->SetCellValue('H'.$i, $order['utm']['source'])
						->SetCellValue('I'.$i, $order['utm']['medium'])
						->SetCellValue('J'.$i, $order['utm']['placement'])
						->SetCellValue('K'.$i, $order['utm']['content'])
						->SetCellValue('L'.$i, $order['utm']['term'])
						->SetCellValue('M'.$i, $order['date_created']);
			$i++;
		}
					
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);



		header('Content-Type: application/vnd.ms-excel');
	    header('Content-Disposition: attachment;filename='.FCPATH.'tmp/Offer.xlsx');
	    header('Cache-Control: max-age=0');	
		$objWriter->save('php://output');

		// $objWriter->save(FCPATH.'tmp/ExportedOrders.xlsx');
		// echo json_encode(1);
	}


	/*
	 * Function for generating an offer as an excel file.
	 */
	public function makeExcelInvoice($details) {
		include (FCPATH.'/resources/PHPExcel.php');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// ADD IMG
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setPath('images/g1excel.jpg');
		$objDrawing->setCoordinates('B1');	
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		$objDrawing->setWidthAndHeight(590,180);
		$objDrawing->setResizeProportional(true);	

		// MERGE CELLS
		$objPHPExcel->getActiveSheet()->mergeCells('B6:D6');  
		$objPHPExcel->getActiveSheet()->mergeCells('B7:D7'); 
		$objPHPExcel->getActiveSheet()->mergeCells('B8:D8');
		$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
		$objPHPExcel->getActiveSheet()->mergeCells('G7:H7');
		$objPHPExcel->getActiveSheet()->mergeCells('G8:H8');
		$objPHPExcel->getActiveSheet()->mergeCells('B12:D12');
		$objPHPExcel->getActiveSheet()->mergeCells('B13:D13');
		$objPHPExcel->getActiveSheet()->mergeCells('B15:D15');
		$objPHPExcel->getActiveSheet()->mergeCells('B16:D16');
		$objPHPExcel->getActiveSheet()->mergeCells('B19:B20');
		$objPHPExcel->getActiveSheet()->mergeCells('C19:D20');
		$objPHPExcel->getActiveSheet()->mergeCells('E19:E20');
		$objPHPExcel->getActiveSheet()->mergeCells('F19:F20');
		$objPHPExcel->getActiveSheet()->mergeCells('G19:G20');
		$objPHPExcel->getActiveSheet()->mergeCells('H19:H20');

		// STYLES
		$styleBorders = array(
	    	'borders' => array(
		        'allborders' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THIN,
		            'color' => array('rgb' => '000000')
		        )
	    	)
		);
		$styleOutlineBorders = array(
		    'borders' => array(
		    	'outline' => array(
		        	'style' => PHPExcel_Style_Border::BORDER_THIN,
		        	'color' => array('rgb' => '000000')
		    	)
		  	)
		);
		$styleAlignCenter = array(
			'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        )
		);
		$styleAlignRight= array(
			'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        )
		);
		$styleColor = array(
		    'fill' => array(
		        'type' => PHPExcel_Style_Fill::FILL_SOLID,
		        'color' => array('rgb' => 'D9DBE2')
			),	
		);
		$objPHPExcel->getActiveSheet()->getStyle('B1:H37')->applyFromArray($styleOutlineBorders);
		$objPHPExcel->getActiveSheet()->getStyle('B6:G8')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B19:H19')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B19:H19')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('B19:H19')->applyFromArray($styleBorders);
		$objPHPExcel->getActiveSheet()->getStyle('B19:H19')->applyFromArray($styleColor);
		$objPHPExcel->getActiveSheet()->getStyle('B19:H19')->applyFromArray($styleAlignCenter);
		$objPHPExcel->getActiveSheet()->getStyle('B19:H19')->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('B19:H19')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('30');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('12');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('12');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('12');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('12');
		
		// CELL VALUES	
		$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'G-1 d.o.o.');
		$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Ljubljanska cesta 37');
		$objPHPExcel->getActiveSheet()->SetCellValue('B8', '3000 Celje');

		$objPHPExcel->getActiveSheet()->SetCellValue('G6', 'Račun št.: '.$details["invoice_details"]['invoice_num'].'/2016'); // godinata!
		$objPHPExcel->getActiveSheet()->SetCellValue('G7', 'Sklic: 00-'.$details["invoice_details"]['invoice_num']);
		$objPHPExcel->getActiveSheet()->SetCellValue('G8', 'ID za DDV: SI66642272');

		$objPHPExcel->getActiveSheet()->SetCellValue('B12', 'Kraj izdaje računa: Žalec');
		$objPHPExcel->getActiveSheet()->SetCellValue('B13', 'Datum izdaje računa: '.$details["invoice_details"]['date_export']);
		$objPHPExcel->getActiveSheet()->SetCellValue('B15', 'Datum opravljene storitve: '.$details["invoice_details"]['date_done_from'].' - '.$details['invoice_details']['date_done_to']);
		$objPHPExcel->getActiveSheet()->SetCellValue('B16', 'Rok plačila do: '.$details["invoice_details"]['date_deadline']);

		$objPHPExcel->getActiveSheet()->SetCellValue('B19', 'Količina');
		$objPHPExcel->getActiveSheet()->SetCellValue('C19', 'Vrsta storitve');
		$objPHPExcel->getActiveSheet()->SetCellValue('E19', 'Cena brez DDV v EUR');
		$objPHPExcel->getActiveSheet()->SetCellValue('F19', 'Stopnja DDV');
		$objPHPExcel->getActiveSheet()->SetCellValue('G19', 'Znesek DDV v EUR');
		$objPHPExcel->getActiveSheet()->SetCellValue('H19', 'Vrednost z DDV v EUR');

		$sum = 0;
		$row = 21;
		$qty = 0;
		foreach ($details['invoice_orders'] as $order) {
			$objPHPExcel->getActiveSheet()->mergeCells('C'.($row).':D'.($row+2));
			$objPHPExcel->getActiveSheet()->mergeCells('B'.($row).':B'.($row+2));
			$objPHPExcel->getActiveSheet()->mergeCells('E'.($row).':E'.($row+2));
			$objPHPExcel->getActiveSheet()->mergeCells('F'.($row).':F'.($row+2));
			$objPHPExcel->getActiveSheet()->mergeCells('G'.($row).':G'.($row+2));
			$objPHPExcel->getActiveSheet()->mergeCells('H'.($row).':H'.($row+2));

			$objPHPExcel->getActiveSheet()->getStyle('B'.($row).':H'.($row))->applyFromArray($styleBorders);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':H'.$row)->applyFromArray($styleAlignCenter);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':H'.$row)->getFont()->setSize(10);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':H'.$row)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setWrapText(true);

			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row, '1');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$row, 'Realizacija G1 sistemov za '.ucwords($order['customer']));
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row, number_format(120, 2, ',', ''));
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$row, '22%');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$row, number_format((120*22/100), 2, ',', ''));
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$row, number_format((120 + (120*22/100)), 2, ',', ''));
			$sum += 120 + 120*22/100;
			$row += 3;
			$qty++;
		}
		$objPHPExcel->getActiveSheet()->getStyle('E'.$row.':H'.$row)->applyFromArray($styleBorders);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$row.':H'.$row)->applyFromArray($styleAlignCenter);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$row.':H'.$row)->getFont()->setBold(true);


		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row, number_format(($qty*120), 2, ',', ''));
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$row, '22%');
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$row, number_format(($qty*(120*22/100)), 2, ',', ''));
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$row, number_format($sum, 2, ',', ''));
		
		$row += 2;
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':D'.($row+1));
		$objPHPExcel->getActiveSheet()->mergeCells('B'.($row+2).':D'.($row+3));
		$objPHPExcel->getActiveSheet()->mergeCells('E'.$row.':H'.($row+1));
		$objPHPExcel->getActiveSheet()->mergeCells('E'.($row+2).':H'.($row+2));
		$objPHPExcel->getActiveSheet()->mergeCells('E'.($row+3).':H'.($row+3));
		$objPHPExcel->getActiveSheet()->mergeCells('G'.($row+8).':H'.($row+8));

		$objPHPExcel->getActiveSheet()->getStyle('B'.($row).':G'.($row+3))->applyFromArray($styleBorders);
		$objPHPExcel->getActiveSheet()->getStyle('B'.($row).':B'.($row+2))->applyFromArray($styleColor);
		$objPHPExcel->getActiveSheet()->getStyle('B'.($row).':B'.($row+2))->applyFromArray($styleAlignRight);
		$objPHPExcel->getActiveSheet()->getStyle('B'.($row).':B'.($row+2))->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('B'.($row).':B'.($row+2))->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleAlignCenter);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getFont()->setSize(13);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('H'.($row+6))->applyFromArray($styleAlignRight);
		$objPHPExcel->getActiveSheet()->getStyle('G'.($row+8))->applyFromArray($styleAlignRight);

		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row, 'Skupaj za plačilo:');
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row, number_format($sum, 2, ',', '') . '  EUR');
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.($row+2), 'Nakazilo na transakcijski račun:');
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.($row+2), 'številka: 		SI56 0510 0801 2454 210');
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.($row+3), 'odprt pri: 	Abanka Vipa d.d.');

		$objPHPExcel->getActiveSheet()->SetCellValue('H'.($row+6), 'Izdal:');
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.($row+8), 'Peter Šelekar s.p.');

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

		if ($details['func'] == 'preview') {
			header('Content-Type: application/vnd.ms-excel');
	    	header('Content-Disposition: attachment;filename='.FCPATH.'tmp/Offer.xlsx');
	    	header('Cache-Control: max-age=0');	
			$objWriter->save('php://output');
		} else {
			$objWriter->save(FCPATH.'tmp/Offer.xlsx');
		}

	}

}

?>