<?php 

	include("config.php");
	
	$acc=$_GET["acc"];
	$mon=$_GET["mon"];
	$yr=$_GET["yr"];
	
	$sql = "SELECT a.P_id,a.AccountName,a.Character,b.IM,IM_base,CHM,CHM_base,RM,RM_base,OM,OM_base,Oth,Oth_base,Overall,STA,Bonus,Month,Year,
			row_number() over (partition by Account_id order by Year desc,Month desc) as rn			
			FROM Account a,Details b
			WHERE a.P_id = b.Account_id AND a.P_id='$acc'
			AND Year='$yr' 
			AND Month='$mon'			
			";
	

	$arr_img=[];
	$stmt = sqlsrv_query($conn, $sql,array(), array( "Scrollable" => 'static' ));
	if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		
	if($row = sqlsrv_fetch_Array($stmt)) {
		$hero=$row["Character"];
		$acctName=$row["AccountName"];
		
		$IM=$row["IM"];
		$IM_base=$row["IM_base"];
		$IM_per=(((int)$row["IM_base"]-(int)$row["IM"])/(int)$row["IM_base"])*100;
		$IM_per=round($IM_per,2);
		
		$CHM=$row["CHM"];
		$CHM_base=$row["CHM_base"];
		$CHM_per=(((int)$row["CHM_base"]-(int)$row["CHM"])/(int)$row["CHM_base"])*100;
		$CHM_per=round($CHM_per,2);
		
		$RM=$row["RM"];
		$RM_base=$row["RM_base"];
		$RM_per=(((int)$row["RM_base"]-(int)$row["RM"])/(int)$row["RM_base"])*100;
		$RM_per=round($RM_per,2);
		
		$OM=$row["OM"];
		$OM_base=$row["OM_base"];
		$OM_per=(((int)$row["OM_base"]-(int)$row["OM"])/(int)$row["OM_base"])*100;
		$OM_per=round($OM_per,2);
		
		$OTH=$row["Oth"];
		$OTH_base=$row["Oth_base"];
		$OTH_per=(((int)$row["Oth_base"]-(int)$row["Oth"])/(int)$row["Oth_base"])*100;
		$OTH_per=round($OTH_per,2);
		
		
		$STA=$row["STA"];
		if($STA==null)$STA=0;
		$Bonus=$row["Bonus"];
		$Bonus=round($Bonus,2);
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

  <body style="font-family:arial;">

    <div class="container-fluid" >
		<div class="row" style="box-shadow: 0px 5px 10px rgba(255, 255, 255, 0.6">
			<div class="col-12 detailsHeader text-left" style="font-size:50px;padding-left:40px;">
				<div class="row">
					<div class="col-10"><?Php echo $acctName;?></div>
					<a class="col-2" href="index.php"><div style="padding-top:20px;"></div></a>
				</div>
			</div>
			
		</div>
		<div class="row" style="margin:20px;margin-top:35px;" >
			<div class="col-4 details_img" style="padding:0px;">
				<img class="img-fluid" src="img/<?php echo $hero;?>/1.png" style="border:2px solid white;">
			</div>
			<div class="col-4 details_center" >
				<div class="row" style="padding-top:28%;">
				</div>
				<div class="row" style="height:10%;">
					<div class="col-4" style="height:100%;">
					</div>
					<div class="col-2 gem" data='CHM' data2='<?php echo $CHM_per;?>%' onclick="glowDiv('CHM')" style="height:100%;margin-left:4%;">
						<span class="tooltiptext" ></span>
					</div>
					<div class="col-2 gem" data='RM' data2='<?php echo $RM_per;?>%' onclick="glowDiv('RM')" style="height:100%;margin-top:15px;">
						<span class="tooltiptext" ></span>
					</div>
					<div class="col-1 gem" data='OM' data2='<?php echo $OM_per;?>%' onclick="glowDiv('OM')" style="height:100%;margin-top:35px;">
						<span class="tooltiptext" ></span>
					</div>
					
				</div>
				<div class="row" style="height:10%;">
					<div class="col-1" style="height:100%;">
					</div>
					<div class="col-2 gem" data='IM' data2='<?php echo $IM_per;?>%' onclick="glowDiv('IM')" style="height:100%;">
						<span class="tooltiptext" ></span>
					</div>
					<div class="col-6" style="height:100%;">
						<span class="tooltiptext" ></span>
					</div>
					<div class="col-1 gem" data='OTH' data2='<?php echo $OTH_per;?>%' onclick="glowDiv('OTH')" style="height:100%;margin-left:5%;">
						<span class="tooltiptext" ></span>
					</div>
					
				</div>
				<div class="row" style="height:12%;margin-top:5%;">
					<div class="col-6" style="height:100%;">
					</div>
					<div class="col-2 gem" data='BNX' data2='<?php echo $Bonus;?>%' onclick="glowDiv('BNX')" style="height:100%;">
						<span class="tooltiptext" ></span>
					</div>
				</div>
			</div>
			<div class="col-4 ">
				<div class="row ">
					<div class="col-12">
					
						<div id="IM" class="row details_info_div" >
							<div class="col-3 details_info">
								IM
							</div>
							<div class="col-9 text-right details_info2">
								<p class="text-right"><?php echo $IM_per;?>% (<?php echo $IM;?> / <?php echo $IM_base;?>)</p>
								<div class='progress'>
									<div class="progress-bar" role="progressbar" style="background-color:#ffed00; width:<?php echo $IM_per;?>%" aria-valuenow="<?php echo $IM_per;?>" aria-valuemin="0" aria-valuemax="100">
									</div>
								</div>
							</div>
						</div>
						<div id="CHM" class="row details_info_div">
							<div class="col-3 details_info">
								ChM
							</div>
							<div class="col-9 test-right details_info2">
								<p class="text-right"><?php echo $CHM_per;?>% (<?php echo $CHM;?> / <?php echo $CHM_base;?>)</p>
								<div class='progress'>
									<div class="progress-bar" role="progressbar" style="background-color:#ffed00; width:<?php echo $CHM_per;?>%" aria-valuenow="<?php echo $CHM_per;?>" aria-valuemin="0" aria-valuemax="100">
									</div>
								</div>
							</div>
						</div>
						<div id="RM" class="row details_info_div">
							<div class="col-3 details_info">
								RM
							</div>
							<div class="col-9 test-right details_info2">
								<p class="text-right"><?php echo $RM_per;?>% (<?php echo $RM;?> / <?php echo $RM_base;?>)</p>
								<div class='progress'>
									<div class="progress-bar" role="progressbar" style="background-color:#ffed00; width:<?php echo $RM_per;?>%" aria-valuenow="<?php echo $RM_per;?>" aria-valuemin="0" aria-valuemax="100">
									</div>
								</div>
							</div>
						</div>
						<div id="OM" class="row details_info_div">
							<div class="col-3 details_info">
								OM
							</div>
							<div class="col-9 test-right details_info2">
								<p class="text-right"><?php echo $OM_per;?>% (<?php echo $OM;?> / <?php echo $OM_base;?>)</p>
								<div class='progress'>
									<div class="progress-bar" role="progressbar" style="background-color:#ffed00; width:<?php echo $OM_per;?>%" aria-valuenow="<?php echo $OM_per;?>" aria-valuemin="0" aria-valuemax="100">
									</div>
								</div>
							</div>
						</div>
						<div id="OTH" class="row details_info_div">
							<div class="col-3 details_info">
								Oth
							</div>
							<div class="col-9 test-right details_info2">
								<p class="text-right"><?php echo $OTH_per;?>% (<?php echo $OTH;?> / <?php echo $OTH_base;?>)</p>
								<div class='progress'>
									<div class="progress-bar" role="progressbar" style="background-color:#ffed00; width:<?php echo $OTH_per;?>%" aria-valuenow="<?php echo $OTH_per;?>" aria-valuemin="0" aria-valuemax="100">
									</div>
								</div>
							</div>
						</div>
						
						<!--div id="STA" class="row details_info_div">
							<div class="col-3 details_info">
								STA
							</div>
							<div class="col-9 text-right details_info2">
								<p class="test-right"><?php echo $STA;?>%</p>
								<div class='progress'>
									<div class="progress-bar" role="progressbar" style="background-color:#ffed00; width:<?php echo $STA;?>%" aria-valuenow="<?php echo $STA;?>" aria-valuemin="0" aria-valuemax="100">
									</div>
								</div>
							</div>
						</div-->
						
						<div id="BNX" class="row details_info_div">
							<div class="col-3 details_info">
								BNX
							</div>
							<div class="col-9 test-right  details_info2 ">
								<p class="text-right"><?php echo $Bonus;?>%</p>
								<div class='progress'>
									<div class="progress-bar" role="progressbar" style="background-color:#00c9ff; width:<?php echo $Bonus;?>%" aria-valuenow="<?php echo $Bonus;?>" aria-valuemin="0" aria-valuemax="100">
									</div>
								</div>
							</div>
						</div>
						<!--div class="row" style="margin:20px;">
							<p style="font-size:34px;" class="col-2"><b>Bionics</b></p>
							<div class='col-10'>
								<div class='progress'>
									<div class="progress-bar" role="progressbar" style="background-color:#00c9ff; width:<?php echo $Bonus;?>%" aria-valuenow="<?php echo $Bonus;?>" aria-valuemin="0" aria-valuemax="100">
									</div>
								</div>
							</div>
						</div-->
					</div>
				</div>
			</div>
		</div>
		
		
	</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
	<script src="js/jquery-3.1.1.min.js"></script>
   <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.typeit/4.4.0/typeit.min.js"></script>

	<script>
	
		function glowDiv(id){
			/*
			if(id=="ALL"){
				$(".details_info_div").addClass("glow");
			}
			else{
				$(".glow" ).removeClass( "glow" );
				$("#"+id).addClass("glow");
			}*/
			$(".glow" ).removeClass( "glow" );
			$("#"+id).addClass("glow");
		}
		
		$(".gem").mouseover(function(){
			var id=$(this).attr("data");
			var value =$(this).attr("data2");
			tooltipText=id+" "+value;
			$(this).children().typeIt({
				strings: tooltipText,
				typeSpeed: 90
			});
		
			

		})
	</script>
  </body>
</html>
