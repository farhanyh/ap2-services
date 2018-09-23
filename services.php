<?php
//KONEKSI.. 
$host='localhost';
$username='root';
$password='';
$database='dummy_ap2';
$connection = mysqli_connect($host,$username,$password,$database);
if(!$connection){
    die('Connection Failed'.mysqli_connect_error());
} 

		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        ini_set('max_execution_time', 3000);

if($_GET["pilihan"]=="yesterday"){



		if(isset($_GET["search"])){


		}else{
			header('Content-Type: application/json');
			$query = mysqli_query($connection, "SELECT * FROM `dummy_manifest` WHERE print_date LIKE '%2017-12-31%'");



			$data = new \stdClass();
			$result = array();
			$data->status = 200;
			$data->status_message = "Data found";
			while($row = mysqli_fetch_array($query)){
				array_push($result,array(
				'pax_id'		=> $row['pax_id'],
				'daily_id'		=> $row['daily_id'],
				'pax_name'		=> $row['pax_name'],
				'seat_no'		=> $row['seat_no'],
				'flight_no'		=> $row['flight_no'],
				'pnr'			=> $row['pnr'],
				'bp_time'		=> $row['bp_time'],
				'is_infant'		=> $row['is_infant'],
				'flight_date'	=> $row['flight_date'],
				'print_date'	=> $row['print_date'],
				'print_ip'		=> $row['print_ip'],
				'gate'			=> $row['gate'],
				'scan1'			=> $row['scan1'],
				'scan2'			=> $row['scan2'],
				'scan3'			=> $row['scan3'],
				'scan4'			=> $row['scan4'],
				'scan5'			=> $row['scan5'],
				'scan6'			=> $row['scan6'],
				'door'			=> $row['door'],
				'barcode'		=> $row['barcode'],
				'username'		=> $row['username'],
				'category'		=> $row['category'],
				'price'			=> $row['price'],
				'status'		=> $row['status'],
				'airline_data'	=> $row['airline_data'],
				'airline_scan_data'	=> $row['airline_scan_data'],
				'eticket_no'	=> $row['eticket_no'],
				'fqtv'			=> $row['fqtv'],
				'modified_by'	=> $row['modified_by'],
				'airline_data'	=> $row['airline_data'],
				'modified_time'	=> $row['modified_time'],
				'notes2'		=> $row['notes2'],
				'airport_code'	=> $row['airport_code'],
				'file_name'		=> $row['file_name'],
				'inserted_time'	=> $row['inserted_time']
			));

		}
		$data->data = $result;

		echo json_encode($data);
	
	
		}

}else if($_GET["pilihan"]=="yesterday_query_build"){

		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");

        $fromDate = date("Y-m-d", strtotime("-12 months"));
        $yesterday = date("Y-m-d", strtotime("-1 day", strtotime($fromDate)));


		if(isset($_GET["search"])){
			$search_array = explode(",", $_GET["search"]);
			if(count($search_array)==1){

				// var_dump($_GET['search']);
				// die();
				$query = mysqli_query($connection, "SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE airport_code='".$_GET['search']."' AND (airport_code is not null or airport_code <> '') AND print_date LIKE '%".$yesterday."%' GROUP BY HOUR(print_date)");

				// var_dump("SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE airport_code='".$_GET['search']."' AND airport_code is not null or airport_code <> '' AND print_date LIKE '%".$yesterday."%' GROUP BY HOUR(print_date)");
				// die();

			}else{

				$dump = "'".$search_array[0]."'";

				for ($i=1; $i < count($search_array) ; $i++) { 
					$dump .=",'".$search_array[$i]."'";
				}

				$query = mysqli_query($connection, "SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE airport_code IN (".$dump.") AND (airport_code is not null or airport_code <> '') AND print_date LIKE '%".$yesterday."%' GROUP BY HOUR(print_date)");

				// var_dump("SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE airport_code IN (".$dump.") AND (airport_code is not null or airport_code <> '') AND print_date LIKE '%".$yesterday."%' GROUP BY HOUR(print_date)");
				// die();				

				// $test = "SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE airport_code IN (".$dump.") GROUP BY HOUR(print_date)";
				
			}


			// var_dump($query);
			// die();


			$data = new \stdClass();
			$result = array();
			$data->status = 200;
			$data->status_message = "Data found";
			while($row = mysqli_fetch_array($query)){
				// echo $row['hour'];
				array_push($result,array(
					'jam_kedatangan' => $row['hour'],
					'pnmpg_per_jam' => $row['jml_penumpang']
				));
			}

			// var_dump($result);
			// die();
			if(isset($_GET["search"])){
				if($_GET["search"]==""){
					$data->data = array();
					// echo "disini";
					// die();
				}else{
					$data->data = $result;
					// echo "string";
					// die();

				}
			}
			// $data->data = $result;
			echo json_encode($data);


		}else{
			header('Content-Type: application/json');
			$query = mysqli_query($connection, "SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE print_date LIKE '%".$yesterday."%' GROUP BY HOUR(print_date)");



			$data = new \stdClass();
			$result = array();
			$data->status = 200;
			$data->status_message = "Data found";
			while($row = mysqli_fetch_array($query)){
				array_push($result,array(
					'jam_kedatangan' => $row['hour'],
					'pnmpg_per_jam' => $row['jml_penumpang']
				));
			}
			$data->data = $result;
			echo json_encode($data);


		}




}else if($_GET["pilihan"]=="weekly_query_build"){


		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");

        $fromDate = date("Ymd", strtotime("-12 months"));
        $sevendays = date("Ymd", strtotime("-7 day", strtotime($fromDate)));

        // var_dump($fromDate);
        // var_dump($yesterday);

        // die();


		if(isset($_GET["search"])){
			$search_array = explode(",", $_GET["search"]);
			if(count($search_array)==1){


				if(isset($_GET['tanggal'])){
					$query = mysqli_query($connection, "SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE airport_code='".$_GET['search']."' AND (airport_code is not null or airport_code <> '') AND print_date = '".$_GET["tanggal"]."' GROUP BY HOUR(print_date)");
				}else{

				$query = mysqli_query($connection, "SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE airport_code='".$_GET['search']."' AND (airport_code is not null or airport_code <> '') AND print_date >= '".$sevendays."' and print_date < '".$fromDate."' GROUP BY HOUR(print_date)");

				}

				// var_dump($_GET['search']);
				// die();


				// var_dump("SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE airport_code='".$_GET['search']."' AND airport_code is not null or airport_code <> '' AND print_date LIKE '%".$yesterday."%' GROUP BY HOUR(print_date)");
				// die();

			}else{

				$dump = "'".$search_array[0]."'";

				for ($i=1; $i < count($search_array) ; $i++) { 
					$dump .=",'".$search_array[$i]."'";
				}

				if(isset($_GET["tanggal"])){
					$query = mysqli_query($connection, "SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE airport_code IN (".$dump.") AND (airport_code is not null or airport_code <> '') AND print_date = '".$_GET["tanggal"]."' GROUP BY HOUR(print_date)");					
				}else{
					$query = mysqli_query($connection, "SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE airport_code IN (".$dump.") AND (airport_code is not null or airport_code <> '') AND print_date >= '".$sevendays."' and print_date < '".$fromDate."' GROUP BY HOUR(print_date)");

				}



				// var_dump("SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE airport_code IN (".$dump.") AND (airport_code is not null or airport_code <> '') AND print_date LIKE '%".$yesterday."%' GROUP BY HOUR(print_date)");
				// die();				

				// $test = "SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE airport_code IN (".$dump.") GROUP BY HOUR(print_date)";
				
			}


			// var_dump($query);
			// die();


			$data = new \stdClass();
			$result = array();
			$data->status = 200;
			$data->status_message = "Data found";
			while($row = mysqli_fetch_array($query)){
				// echo $row['hour'];
				array_push($result,array(
					'jam_kedatangan' => $row['hour'],
					'pnmpg_per_jam' => $row['jml_penumpang']
				));
			}

			// var_dump($result);
			// die();
			if(isset($_GET["search"])){
				if($_GET["search"]==""){
					$data->data = array();
					// echo "disini";
					// die();
				}else{
					$data->data = $result;
					// echo "string";
					// die();

				}
			}
			// $data->data = $result;
			echo json_encode($data);


		}else{

			$query = mysqli_query($connection, "SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE print_date >= '".$sevendays."' and print_date < '".$fromDate."' GROUP BY HOUR(print_date)");


			// var_dump("SELECT HOUR(print_date) as hour,COUNT(*) as jml_penumpang FROM dummy_manifest WHERE print_date >= '".$sevendays."' and print_date < '".$fromDate."'");
			// die();

			$data = new \stdClass();
			$result = array();
			$data->status = 200;
			$data->status_message = "Data found";

			while($row = mysqli_fetch_array($query)){
				array_push($result,array(
					'jam_kedatangan' => $row['hour'],
					'pnmpg_per_jam' => $row['jml_penumpang']
				));
			}
			$data->data = $result;
			echo json_encode($data);

		}

		// header('Content-Type: application/json');



}else if($_GET["pilihan"]=="weekly"){

		header('Content-Type: application/json');
		$query = mysqli_query($connection, "SELECT DISTINCT(*) FROM `dummy_manifest` WHERE print_date >= '20171224' and print_date < '20171231'");


		$data = new \stdClass();
		$result = array();
		$data->status = 200;
		$data->status_message = "Data found";
		while($row = mysqli_fetch_array($query)){
						array_push($result,array(
				'pax_id'		=> $row['pax_id'],
				'daily_id'		=> $row['daily_id'],
				'pax_name'		=> $row['pax_name'],
				'seat_no'		=> $row['seat_no'],
				'flight_no'		=> $row['flight_no'],
				'pnr'			=> $row['pnr'],
				'bp_time'		=> $row['bp_time'],
				'is_infant'		=> $row['is_infant'],
				'flight_date'	=> $row['flight_date'],
				'print_date'	=> $row['print_date'],
				'print_ip'		=> $row['print_ip'],
				'gate'			=> $row['gate'],
				'scan1'			=> $row['scan1'],
				'scan2'			=> $row['scan2'],
				'scan3'			=> $row['scan3'],
				'scan4'			=> $row['scan4'],
				'scan5'			=> $row['scan5'],
				'scan6'			=> $row['scan6'],
				'door'			=> $row['door'],
				'barcode'		=> $row['barcode'],
				'username'		=> $row['username'],
				'category'		=> $row['category'],
				'price'			=> $row['price'],
				'status'		=> $row['status'],
				'airline_data'	=> $row['airline_data'],
				'airline_scan_data'	=> $row['airline_scan_data'],
				'eticket_no'	=> $row['eticket_no'],
				'fqtv'			=> $row['fqtv'],
				'modified_by'	=> $row['modified_by'],
				'airline_data'	=> $row['airline_data'],
				'modified_time'	=> $row['modified_time'],
				'notes2'		=> $row['notes2'],
				'airport_code'	=> $row['airport_code'],
				'file_name'		=> $row['file_name'],
				'inserted_time'	=> $row['inserted_time']
			));

		}
		$data->data = $result;

		echo json_encode($data);
	

}else if($_GET['pilihan']=="get_airport_code"){


		header('Content-Type: application/json');

		$query = mysqli_query($connection, "SELECT DISTINCT(airport_code) FROM dummy_manifest WHERE (airport_code is not null or airport_code <> '')");

		$data = new \stdClass();
		$result = array();
		$data->status = 200;
		$data->status_message = "Data found";
		while($row = mysqli_fetch_array($query)){
						array_push($result,array(
				'airport_code'		=> $row['airport_code']
			));
		}
		$data->data = $result;

		echo json_encode($data);

	
}else if($_GET['pilihan']=="daily"){
		header('Content-Type: application/json');

		if(isset($_GET["tanggal"])){
			$tanggal = $_GET["tanggal"];
			if(isset($_GET["search"])){
				$search = $_GET['search'];
				$result = getAggrgateHour($connection,$tanggal,1,$search);
			}else{
				$result = getAggrgateHour($connection,$tanggal,1);
			}			
		}else{
			$tanggal = "2018-08-27";
			if(isset($_GET["search"])){
				$search = $_GET['search'];
				$result = getAggrgateHour($connection,$tanggal,1,$search);
			}else{
				// var_dump("expression");
				// die();
				$result = getAggrgateHour($connection,$tanggal,1);
				// var_dump($result);
				// die();

			}
		}
		$data = new \stdClass();
		$output = array();
		$data->status = 200;
		$data->status_message = "Data found";
		for($i=0; $i<sizeof($result); $i++){
			array_push($output,array(
				'kategori' => $i,
				'value' => $result[$i]
			));
		}
		$data->data = $output;
		echo json_encode($data);


}else if($_GET['pilihan']=="seven_days"){

		header('Content-Type: application/json');


		if(isset($_GET["tanggal"])){
			$tanggal = $_GET["tanggal"];
			if(isset($_GET["search"])){

				$search = $_GET['search'];
				// $result = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
				// $result = [];
				// $totResult =[];
				// $beginDate = date('Y-m-d',strtotime($tanggal)); //defined date. ganti $_GET['tanggal']
				// // $rangeDate = date("Y-m-d", strtotime("-1 day", strtotime($beginDate)));
				// // var_dump($daysIteration);
				// // die();
				// // $cgk_terminal = ["CT3","T2F","CT1"];
				// // $term_cgk = [];
				// // echo $beginDate;


				// for ($j=0; $j < 7 ; $j++) { 

					// $nowDate = date("Y-m-d", strtotime("-".$j." day", strtotime($beginDate)));
					// $beforeDate = date("Y-m-d", strtotime("-".$j." day", strtotime($rangeDate)));
					// echo "string";
					// var_dump($nowDate);
					// var_dump($result);

				$result = getAggrgateHour($connection,$tanggal,7,$search);
					 
					// array_push($totResult,));
					// die();
				// }


				// var_dump($totResult);
				// die();

			}else{
				$result = getAggrgateHour($connection,$tanggal,7);
			}			
		}else{
			// var_dump("expression");
			// die();

			$tanggal = "2018-08-27";
			if(isset($_GET["search"])){
				$search = $_GET["search"];
				var_dump($tanggal);
				var_dump($search);
				die();
				$result = getAggrgateHour($connection,$tanggal,7,$search);
			}else{
				$result = getAggrgateHour($connection,$tanggal,7);
			}
		}
		// $result = getAggrgateHour($connection,"2018-08-27",7);


		$data = new \stdClass();
		$output = array();
		$data->status = 200;
		$data->status_message = "Data found";
		for($i=0; $i<sizeof($result); $i++){
			array_push($output,array(
				'kategori' => $i,
				'value' => $result[$i]
			));
		}
		$data->data = $output;
		echo json_encode($data);



}else if($_GET["pilihan"]=="seven_days_by_days"){

		// var_dump("tae");
		// die();
		header('Content-Type: application/json');
		$date = "2018-08-27";


		// $result = [];
		// $tanggal = [];

		// $beginDate = date('Y-m-d',strtotime("2018-08-27")); //ganti now date
		// // var_dump($beginDate);
		// // die();
		// for ($j=0; $j < 7 ; $j++) { 
		// 	$nowDate = date("Y-m-d", strtotime("-".$j." day", strtotime($beginDate)));


		// 	$query = mysqli_query($connection, "SELECT COUNT(*) as penumpang FROM complate_dummy_internal WHERE DATE_SUB(atmsatad, INTERVAL 30 MINUTE) LIKE '%".$nowDate."%'");

		// 	$row = mysqli_fetch_array($query);

		// 	// var_dump("SELECT COUNT(*) as penumpang FROM complate_dummy_internal WHERE DATE_SUB(atmsatad, INTERVAL 30 MINUTE) LIKE '%".$nowDate."%'");
		// 	// die();
		// 	array_push($result, $row['penumpang']);
		// 	array_push($tanggal, $nowDate);

		// }

		$data = new \stdClass();
		$output = array();
		$data->status = 200;
		$data->status_message = "Data found";
		// var_dump($result);
		// die();


		if(isset($_GET["tanggal"])){
			$tanggal = $_GET["tanggal"];
			if(isset($_GET["search"])){
				$search = $_GET['search'];
				// $result = getAggrgateHour($connection,$tanggal,7,$search);
				$output = getAggrgateDay($connection,$tanggal,7,$search);

			}else{
				// $result = getAggrgateHour($connection,$tanggal,7);
				$output = getAggrgateDay($connection,$tanggal,7);
			}			
		}else{
			$tanggal = "2018-08-27";
			if(isset($_GET["search"])){
				$search = $_GET['search'];
				// $result = getAggrgateHour($connection,$tanggal,7,$search);
				$output = getAggrgateDay($connection,$tanggal,7,$search);
			}else{
				// var_dump("disini");
				// die();
				$output = getAggrgateDay($connection,$tanggal,7);
			}
		}
		// $output = getAggrgateDay($connection,$tanggal,7);


		// for($i=0; $i<sizeof($result); $i++){
		// 	array_push($output,array(
		// 		'tanggal' => $tanggal[$i],
		// 		'jml_penumpang' => $result[$i]
		// 	));
		// }
		$data->data = $output;
		echo json_encode($data);


}else if($_GET["pilihan"]=="one_month_hourly"){
		header('Content-Type: application/json');
		$result = getAggrgateHour($connection,"2018-08-27",30);


		$data = new \stdClass();
		$output = array();
		$data->status = 200;
		$data->status_message = "Data found";
		for($i=0; $i<sizeof($result); $i++){
			array_push($output,array(
				'kategori' => $i,
				'value' => $result[$i]
			));
		}
		$data->data = $output;
		echo json_encode($data);
}else if($_GET["pilihan"]=="one_month_daily"){

		header('Content-Type: application/json');
		$date = "2018-08-27";

		$data = new \stdClass();
		// $output = array();
		$data->status = 200;
		$data->status_message = "Data found";
		// var_dump($result);
		// die();
		$output = getAggrgateDay($connection,$date,30);


		// for($i=0; $i<sizeof($result); $i++){
		// 	array_push($output,array(
		// 		'tanggal' => $tanggal[$i],
		// 		'jml_penumpang' => $result[$i]
		// 	));
		// }
		$data->data = $output;
		echo json_encode($data);

}





function getAggrgateHour($connection,$beginDate,$daysIteration,$search = "")
{
	$result = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
	$beginDate = date('Y-m-d',strtotime($beginDate)); //defined date. ganti $_GET['tanggal']
	$rangeDate = date("Y-m-d", strtotime("-1 day", strtotime($beginDate)));
	// var_dump($daysIteration);
	// die();
	$cgk_terminal = ["CT3","T2F","CT1"];
	$term_cgk = [];

			for ($j=0; $j < $daysIteration ; $j++) { 

				$nowDate = date("Y-m-d", strtotime("-".$j." day", strtotime($beginDate)));
				$beforeDate = date("Y-m-d", strtotime("-".$j." day", strtotime($rangeDate)));

						// var_dump($nowDate);
						// die();


				if($search != ""){

					// var_dump($search);
					// die();
					$search_array = explode(",", $search);

					for ($i=0; $i < sizeof($search_array) ; $i++) { 
						if(in_array($search_array[$i], $cgk_terminal)){
							array_push($term_cgk, $search_array[$i]);
							$search_array[$i] = "CGK";

						}
					} //get cgk

					// var_dump($search_array);
					// var_dump($term_cgk);
					// die();

					if(count($search_array)==1){ //only_cgk
						if(count($term_cgk)!=0){
							$dump_airport = "'".$search_array[0]."'";
							$dump_term = "'".$term_cgk[0]."'";

							if(count($term_cgk)>1){
								for ($j=1; $j < count($term_cgk) ; $j++) { 
									$dump_term .=",'".$term_cgk[$j]."'";
								}
							}

							// var_dump($dump_airport);
							// var_dump($dump_term);
							// die();
							$query = mysqli_query($connection, "SELECT HOUR(DATE_SUB(atmsatad, INTERVAL 30 MINUTE)) as jam_atmsatad, atmsatad, DATE_SUB(atmsatad, INTERVAL 30 MINUTE) as before_boarding, HOUR(print_date)as jam_print_date, print_date FROM complate_dummy_internal WHERE atmsatad LIKE '%".$nowDate."%' AND terminal_id IN (".$dump_term.") ");

							$query_before =  mysqli_query($connection, "SELECT HOUR(DATE_SUB(atmsatad, INTERVAL 30 MINUTE)) as jam_atmsatad, atmsatad, DATE_SUB(atmsatad, INTERVAL 30 MINUTE) as before_boarding, HOUR(print_date) as jam_print_date, print_date FROM complate_dummy_internal WHERE print_date LIKE '%".$beforeDate."%' AND atmsatad LIKE '%".$nowDate."%' AND terminal_id IN (".$dump_term.")");

						}else{ //bukan cgk
							// var_dump("ini");
							// die();
							$query = mysqli_query($connection, "SELECT HOUR(DATE_SUB(atmsatad, INTERVAL 30 MINUTE)) as jam_atmsatad, atmsatad, DATE_SUB(atmsatad, INTERVAL 30 MINUTE) as before_boarding, HOUR(print_date)as jam_print_date, print_date FROM complate_dummy_internal WHERE atmsatad LIKE '%".$nowDate."%' AND airport_code IN ('".$search_array[0]."') ");


							$query_before =  mysqli_query($connection, "SELECT HOUR(DATE_SUB(atmsatad, INTERVAL 30 MINUTE)) as jam_atmsatad, atmsatad, DATE_SUB(atmsatad, INTERVAL 30 MINUTE) as before_boarding, HOUR(print_date) as jam_print_date, print_date FROM complate_dummy_internal WHERE print_date LIKE '%".$beforeDate."%' AND atmsatad LIKE '%".$nowDate."%' AND airport_code IN ('".$search_array[0]."')");

						}
					}else{ //lebih dari 1 airport


						$dump_airport = "'".$search_array[0]."'";
						for ($j=1; $j < count($search_array) ; $j++) { 
							$dump_airport .=",'".$search_array[$j]."'";
						}




						// $dump_term = "'".$term_cgk[0]."'";
						
						if(count($term_cgk)>0){
							$dump_term = "'".$term_cgk[0]."'";
							if(count($term_cgk)>1){
								for ($j=1; $j < count($term_cgk) ; $j++) { 
									$dump_term .=",'".$term_cgk[$j]."'";
								}

							}





							$query = mysqli_query($connection, "SELECT HOUR(DATE_SUB(atmsatad, INTERVAL 30 MINUTE)) as jam_atmsatad, atmsatad, DATE_SUB(atmsatad, INTERVAL 30 MINUTE) as before_boarding, HOUR(print_date)as jam_print_date, print_date FROM complate_dummy_internal WHERE atmsatad LIKE '%".$nowDate."%' AND (terminal_id IN (".$dump_term.") OR airport_code IN (".$dump_airport.")) ");

							$query_before =  mysqli_query($connection, "SELECT HOUR(DATE_SUB(atmsatad, INTERVAL 30 MINUTE)) as jam_atmsatad, atmsatad, DATE_SUB(atmsatad, INTERVAL 30 MINUTE) as before_boarding, HOUR(print_date) as jam_print_date, print_date FROM complate_dummy_internal WHERE print_date LIKE '%".$beforeDate."%' AND atmsatad LIKE '%".$nowDate."%' AND (terminal_id IN (".$dump_term.") OR airport_code IN (".$dump_airport."))");

						}else{
							// var_dump($dump_term);
							// var_dump($dump_airport);
							// var_dump("SELECT HOUR(DATE_SUB(atmsatad, INTERVAL 30 MINUTE)) as jam_atmsatad, atmsatad, DATE_SUB(atmsatad, INTERVAL 30 MINUTE) as before_boarding, HOUR(print_date)as jam_print_date, print_date FROM complate_dummy_internal WHERE atmsatad LIKE '%".$nowDate."%' AND airport_code IN (".$dump_airport.")");
							// die();


						// var_dump($dump_airport);
						// var_dump($nowDate);
						// die();

							$query = mysqli_query($connection, "SELECT HOUR(DATE_SUB(atmsatad, INTERVAL 30 MINUTE)) as jam_atmsatad, atmsatad, DATE_SUB(atmsatad, INTERVAL 30 MINUTE) as before_boarding, HOUR(print_date)as jam_print_date, print_date FROM complate_dummy_internal WHERE atmsatad LIKE '%".$nowDate."%' AND airport_code IN (".$dump_airport.") ");

							$query_before =  mysqli_query($connection, "SELECT HOUR(DATE_SUB(atmsatad, INTERVAL 30 MINUTE)) as jam_atmsatad, atmsatad, DATE_SUB(atmsatad, INTERVAL 30 MINUTE) as before_boarding, HOUR(print_date) as jam_print_date, print_date FROM complate_dummy_internal WHERE print_date LIKE '%".$beforeDate."%' AND atmsatad LIKE '%".$nowDate."%' AND airport_code IN (".$dump_airport.")");


						}
		




					}

				}else{ //withour search
					$query = mysqli_query($connection, "SELECT HOUR(DATE_SUB(atmsatad, INTERVAL 30 MINUTE)) as jam_atmsatad, atmsatad, DATE_SUB(atmsatad, INTERVAL 30 MINUTE) as before_boarding, HOUR(print_date)as jam_print_date, print_date FROM complate_dummy_internal WHERE atmsatad LIKE '%".$nowDate."%'");

					$query_before =  mysqli_query($connection, "SELECT HOUR(DATE_SUB(atmsatad, INTERVAL 30 MINUTE)) as jam_atmsatad, atmsatad, DATE_SUB(atmsatad, INTERVAL 30 MINUTE) as before_boarding, HOUR(print_date) as jam_print_date, print_date FROM complate_dummy_internal WHERE print_date LIKE '%".$beforeDate."%' AND atmsatad LIKE '%".$nowDate."%'");


				}



				while($row = mysqli_fetch_array($query)){

					$awal_print = $row['jam_print_date'];
					$berangkat = $row['jam_atmsatad'];
					$selisih = $berangkat-$awal_print;
					// var_dump($awal_print);
					// var_dump($berangkat);
					// var_dump($selisih);


					// die();
					if($berangkat > $awal_print){
						for ($i=0; $i <= $selisih ; $i++) { 
							$result[$awal_print+$i] = $result[$awal_print+$i]+1;
						}
					}else{
						for ($i=0; $i < $berangkat ; $i++) { 
							$result[$i] = $result[$i]+1;
						}
					}
				}


				// var_dump($result);
				// die();

				while($row = mysqli_fetch_array($query_before)){
					$berangkat = $row['jam_atmsatad'];
					for ($i=0; $i <= $berangkat ; $i++) { 
							$result[$i] = $result[$i]+1;
					}
				}
			}

	// var_dump($result);
	// die();
	return $result;



}



function getAggrgateDay($connection,$date,$iteration,$search=""){

		$result = [];
		$tanggal = [];

		$beginDate = date('Y-m-d',strtotime($date)); //ganti now date
		// var_dump($beginDate);
		// die();



		$cgk_terminal = ["CT3","T2F","CT1"];
		$term_cgk = [];

		// var_dump(count($search));
		// die();

		for ($j=0; $j < $iteration ; $j++) { 
			$nowDate = date("Y-m-d", strtotime("-".$j." day", strtotime($beginDate)));



				if($search != ""){
					// var_dump($search);
					// die();
					$search_array = explode(",", $search);

					for ($i=0; $i < sizeof($search_array) ; $i++) { 
						if(in_array($search_array[$i], $cgk_terminal)){
							array_push($term_cgk, $search_array[$i]);
							$search_array[$i] = "CGK";

						}
					} //get cgk

					// var_dump($search_array);
					// var_dump($term_cgk);
					// die();

					if(count($search_array)==1){ //only_cgk
						if(count($term_cgk)!=0){
							$dump_airport = "'".$search_array[0]."'";
							$dump_term = "'".$term_cgk[0]."'";

							if(count($term_cgk)>1){
								for ($k=1; $k < count($term_cgk) ; $k++) { 
									$dump_term .=",'".$term_cgk[$k]."'";
								}
							}

							// var_dump($dump_airport);
							// var_dump($dump_term);
							// die();

							$query = mysqli_query($connection, "SELECT COUNT(*) as penumpang FROM complate_dummy_internal WHERE DATE_SUB(atmsatad, INTERVAL 30 MINUTE) LIKE '%".$nowDate."%' AND terminal_id IN (".$dump_term.")");

						}else{ //bukan cgk
							// var_dump("ini");
							// die();
							$query = mysqli_query($connection, "SELECT COUNT(*) as penumpang FROM complate_dummy_internal WHERE DATE_SUB(atmsatad, INTERVAL 30 MINUTE) LIKE '%".$nowDate."%' AND airport_code IN ('".$search_array[0]."')");

						}
					}else{ //lebih dari 1 airport


						$dump_airport = "'".$search_array[0]."'";
						for ($k=1; $k < count($search_array) ; $k++) { 
							$dump_airport .=",'".$search_array[$k]."'";
						}

						// var_dump($term_cgk);
						// var_dump($search_array);
						// die();

						// $dump_term = "'".$term_cgk[0]."'";
						
						if(count($term_cgk)>0){
							$dump_term = "'".$term_cgk[0]."'";
							if(count($term_cgk)>1){
								for ($k=1; $k < count($term_cgk) ; $k++) { 
									$dump_term .=",'".$term_cgk[$k]."'";
								}

							}

							// var_dump($dump_term);
							// var_dump($dump_airport);
							// die();

							$query = mysqli_query($connection, "SELECT COUNT(*) as penumpang FROM complate_dummy_internal WHERE DATE_SUB(atmsatad, INTERVAL 30 MINUTE) LIKE '%".$nowDate."%' AND (terminal_id IN (".$dump_term.") OR airport_code IN (".$dump_airport."))");


						}else{
							// var_dump($dump_term);
							// var_dump($dump_airport);
							// var_dump("SELECT HOUR(DATE_SUB(atmsatad, INTERVAL 30 MINUTE)) as jam_atmsatad, atmsatad, DATE_SUB(atmsatad, INTERVAL 30 MINUTE) as before_boarding, HOUR(print_date)as jam_print_date, print_date FROM complate_dummy_internal WHERE atmsatad LIKE '%".$nowDate."%' AND airport_code IN (".$dump_airport.")");
							// die();

							$query = mysqli_query($connection, "SELECT COUNT(*) as penumpang FROM complate_dummy_internal WHERE DATE_SUB(atmsatad, INTERVAL 30 MINUTE) LIKE '%".$nowDate."%' AND airport_code IN (".$dump_airport.")");


						}
		




					}


				}else{ //withour search
					// var_dump("disini");
					// die();

					$query = mysqli_query($connection, "SELECT COUNT(*) as penumpang FROM complate_dummy_internal WHERE DATE_SUB(atmsatad, INTERVAL 30 MINUTE) LIKE '%".$nowDate."%' ");

				}



			$row = mysqli_fetch_array($query);

			// var_dump("SELECT COUNT(*) as penumpang FROM complate_dummy_internal WHERE DATE_SUB(atmsatad, INTERVAL 30 MINUTE) LIKE '%".$nowDate."%'");
			// die();
			array_push($result, $row['penumpang']);
			array_push($tanggal, $nowDate);

		}


		$output = array();
		for($i=0; $i<sizeof($result); $i++){
			array_push($output,array(
				'kategori' => $tanggal[$i],
				'value' => $result[$i]
			));
		}
		return $output;
}
 
?>