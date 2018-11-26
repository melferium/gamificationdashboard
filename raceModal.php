<?php 
	
	include("config.php");
	
	$sql_race = "SELECT *
			FROM (SELECT a.P_id,a.AccountName,a.Character,a.Color,b.IM,IM_base,CHM,CHM_base,RM,RM_base,OM,OM_base,Oth,Oth_base,Overall,Bonus,Month,Year,Rank as RK,
				row_number() over (partition by Account_id order by Year desc,Month desc) as rn			
				FROM Account a,Details b
				WHERE a.P_id = b.Account_id
				) as T
				
			WHERE rn=1 ORDER BY AccountName";
	

	$arr_race=[];
	$jscript_race="";
	$stmt_race = sqlsrv_query($conn, $sql_race,array(), array( "Scrollable" => 'static' ));
	if( $stmt_race === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		
	while($row = sqlsrv_fetch_Array($stmt_race)) {
		$race = [];
		$width=0;
		$race[0]=$row["P_id"];
		$race[1]=$row["Character"];
		$race[2]=$row["AccountName"];
		$race[3]=$row["Overall"];
		
		$width=$race[3];
		$width=round($width,1);
		
		$race[4]=$row["Color"];
		$race[5]=$width;
		array_push($arr_race,$race);
	}
	
?>


    

