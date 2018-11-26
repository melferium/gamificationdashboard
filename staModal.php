<?php 
	
	include("config.php");

	$sql_sta = "SELECT *
			FROM (SELECT a.P_id,a.AccountName,a.Character,a.Color,b.IM,IM_base,CHM,CHM_base,RM,RM_base,OM,OM_base,Oth,Oth_base,Overall,STA,Bonus,Month,Year,Rank as RK,
				row_number() over (partition by Account_id order by Year desc,Month desc) as rn			
				FROM Account a,Details b
				WHERE a.P_id = b.Account_id
				) as T
				
			WHERE rn=1 ORDER BY AccountName";
	

	$arr_sta=[];
	$jscript_sta="";
	$stmt_sta = sqlsrv_query($conn, $sql_sta,array(), array( "Scrollable" => 'static' ));
	if( $stmt_sta === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		
	while($row = sqlsrv_fetch_Array($stmt_sta)) {
		$sta = [];
		$width=0;
		$sta[0]=$row["P_id"]+"a";
		$sta[1]=$row["Character"];
		$sta[2]=$row["AccountName"];
		$sta[3]=$row["STA"];
		$width=$sta[3];
		$width=round($width,1);
		$sta[4]=$row["Color"];
		$sta[5]=$width;
		array_push($arr_sta,$sta);
	}
	
?>


    

