<?php 
	
	include("config.php");

	$sql = "SELECT *
			FROM (SELECT a.P_id,a.AccountName,a.Character,a.Color,b.IM,IM_base,CHM,CHM_base,RM,RM_base,OM,OM_base,Oth,Oth_base,Overall,Bonus,Month,Year,Rank as RK,
				row_number() over (partition by Account_id order by Year desc,Month desc) as rn			
				FROM Account a,Details b
				WHERE a.P_id = b.Account_id
				) as T
				
			WHERE rn=1 ORDER BY AccountName";
	

	$arr_act=[];
	$jscript="";
	$stmt = sqlsrv_query($conn, $sql,array(), array( "Scrollable" => 'static' ));
	if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		
	while($row = sqlsrv_fetch_Array($stmt)) {
		$arr = [];
		$width=0;
		$arr[0]=$row["P_id"];
		$arr[1]=$row["Character"];
		$arr[2]=$row["AccountName"];
		
		
		$Overall=$row["Overall"];
		$Bonus=$row["Bonus"];
		$arr[3]=$Overall+$Bonus;
		
		$width=$arr[3]*.7;
		$width=round($width,1);
		$arr[4]=$row["Color"];
		$arr[5]=$width;
		array_push($arr_act,$arr);
	}
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
    <meta name="author" content="Karl Adrian Chiucinco">
    <link rel="icon" href="../../favicon.ico">

    <title>Avengers</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
  </head>

  <body style="font-family:Marvel;">

    <div class="container-fluid" >
		<?php 
		
		foreach($arr_act as $act){
			echo 
			'<div class="row" style="margin-top:15px;">
				<div class="col-2"><h1 class="text-right" style="padding-top:5px;">'.$act[2].'</h1></div>

				<div class="col-10">
					<div id="'.$act[0].'" class="hero_path" 
						style="width:0%;height:2px;margin-top:30px;
						box-shadow: 0 0 15px 10px '.$act[4].';
						background-color:'.$act[4].';
						display:inline-block;
						float:left;
						">
					</div>
					<img src="img/race/'.$act[1].'.png" style="float:left;height:60px;width:auto;">
					
				</div>
			</div>';
			$jscript.='moveBar("'.$act[0].'",'.$act[5].');';
		};
		
		?>
		
		
	</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	
	<script>
	<?php 
		echo $jscript;
	?>
	function moveBar(id,val)
	{
		var i=0;
		var inter = setInterval(function(){
			if(i<=val) {
				$("#"+id).css("width",i+"%");
				i=i+.10;
			}		
			else{
				clearInterval(inter);	
			}
		},25);
	}
	</script>
  </body>
</html>

