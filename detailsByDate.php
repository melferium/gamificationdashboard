<?php
	session_start();
	include("config.php");

	
	$yearInput=$_POST["yr"];
	$monthInput=$_POST["mon"];

	$sql = "SELECT a.P_id,a.AccountName,a.Character,Overall,Bonus,Rank as RK		
			FROM Account a,Details b
			WHERE a.P_id = b.Account_id AND
			Month='".$monthInput."' AND Year='".$yearInput."'
			ORDER BY RK";
	
	$arr_img=[];
	$ActSpacer="";
	$ctr=0;
	$stmt = sqlsrv_query($conn, $sql,array(), array( "Scrollable" => 'static' ));
	if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		
	while($row = sqlsrv_fetch_Array($stmt)) {
		
		$arr = [];
		$arr[0]=$row["Character"];
		$arr[1]=$row["AccountName"];
		$arr[2]=$row["Overall"];
		$arr[3]=$row["Bonus"];
		$arr[4]=$row["P_id"];
		
		array_push($arr_img,$arr);
		
		$ctr++;
	}
	
	while($ctr<8)
	{	
		if($ctr%2==1) $ActSpacer.="<div class='col'></div>";
		$ctr++;
	}
	
	echo $ActSpacer;
	foreach($arr_img as $acc)
	{
		$total=$acc[2];
		$total=round($total,1);
		
		echo	"<div class='col accDiv' style='padding-left:10px;padding-right:10px;'>
					<div>
						<a href='details.php?acc=".$acc[4]."&mon=".$monthInput."&yr=".$yearInput."'><img class='img-fluid' src='img/main/".$acc[0].".png'/></a>
					</div>
					<h3 class='accName' style='margin:20px 0px;'>".$acc[1]." [".$total."]</h3>
					
					<!--div class='row' style='margin-top:20px;'>
						<div class='col-12'>
							<div class='progress' >
								<div class=\"progress-bar\" role=\"progressbar\" style=\"font-weight:bold;background-color:#64ff00;color:#000; width:".floor($acc[2])."%;\" aria-valuenow=\"$acc[2]\" aria-valuemin=\"0\" aria-valuemax=\"100\">
									".round($acc[2],1)."
								</div>
							</div>
						</div>
						<!--span class='col-2'><b>".$acc[2]."%</b></span-->
					</div-->
					
					<div class='row' style='margin-top:20px;'>
						<div class='col-12'>
							<div class='progress' >
								<div class=\"progress-bar\" role=\"progressbar\" style=\"font-weight:bold;background-color:#00c9ff; color:#000;width:".floor($acc[3])."%;\" aria-valuenow=\"$acc[3]\" aria-valuemin=\"0\" aria-valuemax=\"100\">
									<!--".round($acc[3],1)."-->
								</div>
							</div>
							
						</div>
						<span class='col-2'><b>".round($acc[3],1)."</b></span>
					</div>
				</div>
				";
	}
	echo $ActSpacer;
			
?>