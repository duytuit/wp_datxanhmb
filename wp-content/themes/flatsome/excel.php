<?php
include_once('PhpSpreadsheet/vendor/autoload.php');
function outputCsv( $assocDataArray ) {

	
            if ( !empty( $assocDataArray ) ):
                header("Content-Type: Content-type: application/csv");
header("Content-Disposition: attachment; filename=products.csv");

header("Expires: 0");
	header("Cache-Control: must-revalidate");
header("Pragma: must-revalidate");
                $fp = fopen( 'php://output', 'w' );
                fputcsv( $fp, array_keys( reset($assocDataArray) ) );

                foreach ( $assocDataArray AS $values ):
                    fputcsv( $fp, $values );
                endforeach;

                fclose( $fp );
            endif;

            exit();
        }
function fnBangChiTietHangThang($sotienvay, $laisuatvay, $sothangvay, $paymentmethod) //Lãi theo năm
		{
		  
		  $laivay = $laisuatvay / 12; 
		  $tiengoc = $sotienvay/$sothangvay;
		  $laiphang = $sotienvay * ($laisuatvay/100/12);
		  $gocconlaitruoc = $sotienvay;
	      $tonglai = 0;
	      $tongcong = 0;
		  $data = array();
	     
		  if($paymentmethod ==true)
		  {
		  for($n = 0; $n < $sothangvay; $n++) 
	      {
		      
			 $tiengocconlai = ($n== $sothangvay-1?0:$gocconlaitruoc - $tiengoc);
			 $lai = $gocconlaitruoc* ($laisuatvay/100/12);
			 $tonglai += $lai;
			 $gocvalai = $tiengoc + $lai;
			 
			 $data[]  = array(
			     'KyThanhToan' => $n + 1,
			     'DuNoDauKy' => round($gocconlaitruoc),
			     'LaiThanhToan' => round($lai),
			     'GocThanhToan' => round($tiengoc),
			     'DuNoCuoiKy' => round($tiengocconlai),
			     'TongThanhToan' => round($gocvalai)
			     );
			  $gocconlaitruoc = $gocconlaitruoc - $tiengoc;
		  }
		   }
		   else{
		     for($n = 0; $n < $sothangvay; $n++) 
	      {
		     $goc = $tiengoc; 
			 $tiengocconlai = ($n==$sothangvay-1?0:$gocconlaitruoc - $goc);
			
			 $gocvalai = $goc + $laiphang;
				 $data[]  = array(
			     'KyThanhToan' => $n + 1,
			     'DuNoDauKy' => round($gocconlaitruoc),
			     'LaiThanhToan' => round($laiphang),
			     'GocThanhToan' => round($tiengoc),
			     'DuNoCuoiKy' => round($tiengocconlai),
			     'TongThanhToan' => round($gocvalai)
			     );
			    $gocconlaitruoc = $gocconlaitruoc - $tiengoc;
			
		  }
		   }
		  
		   return $data;
		}
 // $header is an array containing column headers
    $giatrinhadat = 1200000000;
	  $tylevay = '50';	
	  $sotienvay = 600000000;
     $laisuat = '7.6';
		$sonam = '10';
$kieutralai = true;
	   if (!empty($_POST['giatrinhadat'])) { //Name cannot be empty
   $giatrinhadat = $_POST['giatrinhadat'];
      }
    if (!empty($_POST['tylevay'])) { //Name cannot be empty
   $tylevay = $_POST['tylevay'];
      }
	  if (!empty($_POST['sotienvay'])) { //Name cannot be empty
   $sotienvay = $_POST['sotienvay'];
}
		 if (!empty($_POST['laisuat'])) { //Name cannot be empty
   $laisuat = $_POST['laisuat'];
}
 if (!empty($_POST['sonam'])) { //Name cannot be empty
   $sonam = $_POST['sonam'];
}
if (!empty($_POST['kieutralai'])) { //Name cannot be empty
   $kieutralai = ($_POST['kieutralai']=='true'?true:false);
}
	  $data = fnBangChiTietHangThang($sotienvay, $laisuat, $sonam*12,$kieutralai);
	  $sotienvay_unit = ($giatrinhadat>=1000000000?'ty':'trieu');
     $sotienvay_name = ($giatrinhadat>=1000000000?round($giatrinhadat/1000000000,2):round($giatrinhadat/100000000,2));

  // file name for download
  $filename = "vaymuanha_" . strval( $sotienvay_name) .$sotienvay_unit .'_vay'.$tylevay .'%_'. $laisuat  .'%_'. $sonam .'nam';
	  $header = array("Kỳ thanh toán", "Dư nợ đầu kỳ", "Lãi thanh toán", "Gốc thanh toán", "Dư nợ cuối kỳ", "Tổng thanh toán");
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->fromArray($header , NULL, 'A1');     
    $sheet->fromArray($data , NULL, 'A2');   
    // redirect output to client browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
   
    ob_start();
 $writer->save('php://output');
$xlsData = ob_get_contents();
ob_end_clean();

$response =  array(
        'op' => 'ok',
        'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($xlsData),
	    'data' => $data,
	    'filename' => $filename
    );

echo json_encode($response);
    
    
    