<?php
	require("codelib.php");
	if (isset($_GET["id"])) {
		$myID = $_GET["id"];
		$SQL = new mSQL;
		$myInfo = $SQL->rselectQ("newsletter", "unsub = '" . $myID . "'");
		if($myInfo["newsletter"] == '1') {
			$isChecked = " checked";
		} else {
			$isChecked = "";
		}
		$rmDate = new DateTime($myInfo["rmDate"]);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>D2E Auto - Automotive Service and Repair Center</title>
<meta name="description" content="D2E Auto provides quality and honest auto repair. We do not upsale you with unnecessary and unwanted repair. Our prices are low but our service is superior.">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/d2eauto.css" rel="stylesheet" media="screen">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
<div class="row">
<div class="col-lg-12">
<img id="banner" class="img-responsive" src="images/banner.png" />
</div>
</div>
<div id="myTop"></div>
<div id="un-head" class="navbar navbar-default">
<div class="col-sm-6">D2E Auto E-Mail Subscription Services</div>
<div class="col-sm-6 text-right">Client: <?php echo $myInfo["cName"]; ?></div>
</div>
<div class="row">
    <div class="col-lg-4">
    	<div class="panel panel-warning" style="height: 375px;">
        	<div class="panel-heading">
            	<h3 class="panel-title">D2E Auto Privacy Promise</h3>
            </div>
            <div class="panel-body">
				We at D2E Auto take your privacy very seriously. We will never give out or sell your email address. We don't overload your email with spam. If you decide to participate in our E-Mail Subscription Services you will receive an occasional Newsletter with news and specials and/or Service Reminders of when its time to return for an oil change or routine maintenance. Please understand that we value our customers and want them returning when you need service on your vehicle. We offer these as a convenience for our customers, not to be annoying advertisement. We are sure that you will return by the quality and low cost service we offer.
           </div>
        </div>
    </div>
	<div class="col-lg-4">
    	<div class="panel panel-primary" style="height: 375px;">
        	<div class="panel-heading">
            	<h3 class="panel-title">Newsletter</h3>
            </div>
            <div class="panel-body">
            	<div class="checkbox">
                	<label>
                    	<input id="rcvLetter" type="checkbox"<?php echo $isChecked; ?>> Newsletter
                    </label>
                </div>
                <p>If the box above is checked then you are set to receive our newsletter when they are sent out. Uncheck the above box if you no longer wish to receive them.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
    	<div class="panel panel-primary" style="height: 375px;">
        	<div class="panel-heading">
            	<h3 class="panel-title">E-Mail Service Reminder</h3>
            </div>
            <div id="rmndPanel" class="panel-body">
<?php
	if($myInfo["reminder"] == '0') {
		echo "            	There are no reminders set for you. These are set when you have done an oil change with us so we may remind you of when its time to change your oil again.";
	} else {
?>  				<div class="checkbox">
                	<label>
                    	<input id="chkReminder" type="checkbox" checked> Reminder Scheduled
                    </label>
                </div>
                <p>You have a reminder scheduled from your last routine service. This reminder is estimated at <?php echo $myInfo["reminder"]; ?> months or <?php echo $myInfo["reminder"]; ?>,000 miles, which ever comes first. The approximate date the reminder is to be sent is <?php 
				echo $rmDate->format('m/d/Y'); 
				if ($myInfo["rmType"] == "TIME") {
					echo ". This is based off of " . $myInfo["reminder"] . " months from last service.";
				} else {
					echo ". This is based off the average mileage you have driven between services at our shop.";
				}?></p>
                <p>If you would like to cancel this service please uncheck the box above and confirm below. Please be aware that once canceled the reminder cannot be reinstated.</p>
                <p align="center"><button id="btnConfirm" class="btn btn-primary" type="button">Confirm</button></p>
<?
	}
?>
            </div>
        </div>
    </div>
</div>
<div id="foot" class="navbar navbar-default">
<div class="col-sm-6">Design and Development by<br>David Vernon at <a class="dvernon_link" href="http://dvernon.com" target="_blank">dvernon.com</a></div>
<div class="col-sm-6 text-right">copyright <span class="glyphicon glyphicon-copyright-mark"></span> 2014 D2E Auto<br>ALL RIGHTS RESERVED</div>
</div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
	$('#rcvLetter').change(function() {
		var formData = new FormData();
		formData.append('action', 'unsubNewsletter');
		formData.append('id', '<?php echo $myID; ?>');
		if(this.checked) {
			formData.append('do', '1');
		} else {
			formData.append('do', '0');
		}
		$.ajax({
			url: 'adminCode.php',
			type: 'post',
			processData: false,
			contentType: false,
			data: formData,
			success: function(data, status) {
				console.log(data);
			},
			error: function(xhr, desc, err) {
				console.log(xhr);
				console.log("Details: " + desc + "\nError:" + err);
				alert("Details: " + desc + "\nError:" + err);
			}
		});
	});
	$('#btnConfirm').on('click', function() {
		if(!$('#chkReminder').prop('checked')) {
			var formData = new FormData();
			formData.append('action', 'unsubReminder');
			formData.append('id', '<?php echo $myID; ?>');
			$.ajax({
				url: 'adminCode.php',
				type: 'post',
				processData: false,
				contentType: false,
				data: formData,
				success: function(data, status) {
					console.log(data);
					$('#rmndPanel').empty();
					$('#rmndPanel').text("The reminder has been removed and will no longer be sent.");
				},
				error: function(xhr, desc, err) {
					console.log(xhr);
					console.log("Details: " + desc + "\nError:" + err);
					alert("Details: " + desc + "\nError:" + err);
				}
			});
		}
	});
</script>
</body>
</html>
<?php
	} else {
		header('Location: index.html');
	}
?>