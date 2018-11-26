<?php 
	
	
	include("config.php");
	include("staModal.php");
	include("raceModal.php");
	
	function getCapabDate(){
		
		$sql="SELECT DISTINCT CAST(Month AS int) AS Mon, CAST(Year AS int) AS Yr			
				FROM Details
				ORDER BY Yr desc, Mon desc";
			
		$stmt = sqlsrv_query($GLOBALS['conn'], $sql,array(), array( "Scrollable" => 'static' ));
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$optionDisplay="";
		$FlagFirst=true;
		while($row = sqlsrv_fetch_Array($stmt)) {
			
			
			switch($row['Mon']){
				case 1: $month= "JAN";break;
				case 2: $month= "FEB";break;
				case 3: $month= "MAR";break;
				case 4: $month= "APR";break;
				case 5: $month= "MAY";break;
				case 6: $month= "JUN";break;
				case 7: $month= "JUL";break;
				case 8: $month= "AUG";break;
				case 9: $month= "SEP";break;
				case 10: $month= "OCT";break;
				case 11: $month= "NOV";break;
				case 12: $month= "DEC";break;
				break;
			}
			$disDate=$month." ".$row['Yr'];
			if($FlagFirst){
				$optionDisplay.="<option value='".$row['Mon']."-".$row['Yr']."' selected>".$disDate."</option>";
				$FlagFirst=false;
			}
			else{
				$optionDisplay.="<option value='".$row['Mon']."-".$row['Yr']."' >".$disDate."</option>";
			}
		}
		
		echo $optionDisplay;
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

    <div class="container-fluid parentDiv">
		<div class="row">
			<div class="col-8">
			</div>
			<div class="col-1 ">
				<button class="btn btn-primary" onclick="startSTA();"  
				style="background-color:black;border:none;border-bottom:1px solid white;cursor:pointer;border-radius:0px;margin-right:10px;"> STA
					<img src="img/shield.gif" style="width:30px;height:auto;"/>

				</button>
			</div>
			<div class="col-1 ">
				<button class="btn btn-primary" onclick="startRace();" 
				style="background-color:black;border:none;border-bottom:1px solid white;cursor:pointer;border-radius:0px;"> RACE
					<img src="img/shield.gif" style="width:30px;height:auto;"/>

				</button>
			</div>
			<div class="col-2 ">
				<select id="dateID" class="form-control text-white custom-select" style="background-color:#000;max-width:150px;">
					<?php 
						getCapabDate();
					?>
				</select>
			</div>
		</div>
		<div id="mainDiv" class="row childDiv" style="margin:0px 20px;">
			
		</div>
		<div id="raceModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="raceModal" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document" >
				<div class="modal-content" style="background-color:#111;">
					<div class="modal-header">
					<h3 class="modal-title" id="exampleModalLabel">THE RACE</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="color:white;">&times;</span>
					</button>
					</div>
					<div class="modal-body">
					<?php 
						foreach($arr_race as $race){
							echo 
							'<div class="row" style="margin-top:15px;">
								<div class="col-2"><h1 class="text-right" style="padding-top:5px;">'.$race[2].'</h1></div>

								<div class="col-10">
									<div id="'.$race[0].'" class="hero_path" 
										style="width:0%;height:2px;margin-top:30px;
										box-shadow: 0 0 15px 10px '.$race[4].';
										background-color:'.$race[4].';
										display:inline-block;
										float:left;
									">
									</div>
									<img src="img/race/'.$race[1].'.png" style="float:left;height:60px;width:auto;">
									
								</div>
							</div>';
							$jscript_race.='moveBar("'.$race[0].'",'.$race[5].');';
						};
						
					?>
					</div>
					
				</div>
			</div>
		</div>
		<div id="staModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="staModal" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document" >
				<div class="modal-content" style="background-color:#111;">
					<div class="modal-header">
					<h3 class="modal-title" id="exampleModalLabel">STA CONTRIBUTIONS</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="color:white;">&times;</span>
					</button>
					</div>
					<div class="modal-body">
					<?php 
						foreach($arr_sta as $sta){
							echo 
							'<div class="row" style="margin-top:15px;">
								<div class="col-2"><h1 class="text-right" style="padding-top:5px;">'.$sta[2].'</h1></div>

								<div class="col-10">
									<div id="'.$sta[0].'" class="hero_path" 
										style="width:0%;height:2px;margin-top:30px;
										box-shadow: 0 0 15px 10px '.$sta[4].';
										background-color:'.$sta[4].';
										display:inline-block;
										float:left;
									">
									<h4 class="text-right">'.$sta[5].'</h4>
									</div>
									<img src="img/race/'.$sta[1].'.png" style="float:left;height:60px;width:auto;">
									
								</div>
							</div>'; 
							$jscript_sta.='moveBar("'.$sta[0].'",'.$sta[5].');';
							
						};
					?>
					</div>
					
				</div>
			</div>
		</div>
		<div id="vidModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="vidModal" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document" >
				<div class="modal-content" style="background-color:#111;">
					<div class="modal-header">
						<h3 class="modal-title" id="exampleModalLabel">INTRO</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" style="color:white;">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row" >
							<div class="embed-responsive embed-responsive-16by9">
								<video id="videoId" class="embed-responsive-item" style="height:auto;"controls>
									<source src="vid\PHBionixRace.mp4" type="video/mp4">
									Your browser does not support HTML5 video.
								</video>
							</div>
							<button class="btn btn-outline-secondary btn-block" style="margin:10px 5px;margin-bottom:0px;" type="button" onclick="startRaceFromVid();">
								Proceed to Race
							</button>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script>
		if (navigator.appName == 'Microsoft Internet Explorer' ||  !!(navigator.userAgent.match(/Trident/) || navigator.userAgent.match(/rv:11/)) || (typeof $.browser !== "undefined" && $.browser.msie == 1))
		{
		  alert("Please do not use Internet Explorer.");
		}	 
	</script>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	<script>
		
		 $(document).ready(function(){
			
			$('#videoId').on('ended',function(){
				startRaceFromVid();
			});
			
			$('#vidModal').on('hidden.bs.modal', function (e) {
			  $('#videoId').get(0).pause();
			})
			
			$("#dateID").change(function(){
				dateChange();
			});
			<!--startRace();-->
			dateChange();
		  });
		  
		 function dateChange(){
				$("#mainDiv").html("");
				var dateValue=$("#dateID").val();
				var dateArr = dateValue.split("-");
				
				$.ajax({
				  method: "POST",
				  url: "detailsByDate.php",
				  data: { mon: dateArr[0], yr: dateArr[1] }
				})
				.done(function( msg ) {
					$("#mainDiv").html(msg);
				 });
			 
		 } 
		function startRaceFromVid(){
			$('#vidModal').modal('hide');
			$('#videoId').get(0).pause();
			startRace();
		}
		function startVid(){
			$('#vidModal').modal('show');
			var vid=$('#videoId');
			vid.get(0).play()
		}
		function startRace(){
			$('#raceModal').modal('show');
			
			<?php 
				echo $jscript_race;
			?>
		}
		function startSTA(){
			$('#staModal').modal('show');
			
			<?php 
				echo $jscript_sta;
			?>
		}
		
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
			},5);
		}


	</script>
  </body>
</html>
