<?php
	session_start();
	if(!isset($_SESSION['isLogged']))
	{
		$logged = false;
	} else {
		$logged = true;
		if (isset($_GET["d"])) {
			$myPage = $_GET["d"];
			if ($myPage == "Logout") {
				session_unset();
				header('Location: admin.php');
			}
		} else {
			$myPage = "home";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>D2E Auto - Administration Area</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/d2eauto.css" rel="stylesheet" media="screen">
<?php
	if($myPage == "Newsletter") {
		?>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="css/summernote.css" rel="stylesheet">
<?php
	}
?>    <style type="text/css">
      body { background-color: #000000; }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
<div class="navbar navbar-default">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="admin.php?d=home">D2E Auto Admin</a>
  </div>
 <?php
 	if ($logged)
	{
		?>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
      <li><a href="admin.php?d=AddCustomer">Add Customer Info</a></li>
      <li><a href="admin.php?d=Newsletter">Newsletter</a></li>
      <li><a href="admin.php?d=EditNameList">Edit Name List</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="admin.php?d=Logout">Logout</a></li>
    </ul>
  </div>
<?php
	}
?>
</div>
<?php
	if (!$logged)
	{
		?>
<form class="form-horizontal">
	<fieldset>
    	<legend>Administration Log-In</legend>
        <div class="form-group">
        	<label for="inputEmail" class="col-lg-2 control-label">Email</label>
            <div class="col-lg-10">
            	<input class="form-control" id="inputEmail" placeholder="Email" type="text">
            </div>
        </div>
        <div class="form-group">
        	<label for="inputPassword" class="col-lg-2 control-label">Password</label>
            <div class="col-lg-10">
            	<input class="form-control" id="inputPassword" placeholder="Password" type="password">
            </div>
        </div>
        <div class="form-group">
        	<div class="col-lg-10 col-lg-offset-2">
            	<button id="submitButton" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </fieldset>
</form>
<?php	
	} else {
		if ($myPage == "AddCustomer") {
?>
<form class="form-horizontal">
	<fieldset>
    	<legend>Customer Info Entry</legend>
        <div class="form-group">
        	<label for="inputEmail" class="col-lg-2 control-label">Email</label>
            <div class="col-lg-10">
            	<input class="form-control" id="inputEmail" placeholder="Email" type="text">
            </div>
        </div>
        <div class="form-group">
        	<label for="inputName" class="col-lg-2 control-label">Name</label>
            <div class="col-lg-10">
            	<input class="form-control" id="inputName" placeholder="Name" type="text">
            </div>
        </div>
        <div class="form-group">
        	<label for="inputDate" class="col-lg-2 control-label">Date</label>
            <div class="col-lg-4">
            	<input class="form-control" id="inputDate" placeholder="Date" type="date" value="<?php echo date("m/d/Y"); ?>">
            </div>
        </div>
        <div class="form-group">
        	<label for="inputMileage" class="col-lg-2 control-label">Mileage</label>
            <div class="col-lg-4">
            	<input class="form-control" id="inputMileage" placeholder="Mileage" type="text">
            </div>
        </div>
        <div class="form-group">
        	<label class="col-lg-2 control-label">Reminder:</label>
            <div class="col-lg-4">
            	<div class="radio">
                	<label>
                    	<input name="optionsReminders" id="optionReminder1" value="5" checked type="radio">
                        5 months / 5000 miles
                    </label>
                </div>
                <div class="radio">
                	<label>
                    	<input name="optionsReminders" id="optionReminder2" value="3" type="radio">
                        3 months / 3000 miles
                    </label>
                </div>
                <div class="radio">
                	<label>
                    	<input name="optionsReminders" id="optionReminder3" value="0" type="radio">
                        No Reminder
                    </label>
                </div>
                <div class="radio">
                	<label>
                    	<input name="optionsReminders" id="optionReminder4" value="-1" type="radio">
                        Did not preform oil change
                    </label>
                </div>
            </div>
            <div class="col-lg-6">
            	<div class="checkbox">
                	<label>
                    	<input type="checkbox" id="chkNewsletter" checked>  Receive Newsletter
                    </label>
                </div>
                <div class="checkbox">
                	<label>
                    	<input type="checkbox" id="chkReview" checked> Request Review
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
        	<div class="col-lg-10 col-lg-offset-2">
            	<button id="submitButton" class="btn btn-primary" type="submit">Submit</button>
            </div>
        </div>
    </fieldset>
</form>
<div class="row"><div id="alertHolder" class="col-lg-12"></div></div>
<?php
		} else if($myPage == "Newsletter") {
?>
<div class="row">
	<div class="col-lg-9"><span class="h1 text-primary">Send Newsletter</span><span> (Enter or paste body of newsletter in word processor below)</span></div>
    <div class="col-lg-3 text-right">
    	<div class="btn-group">
        	<button id="btnSave" class="btn btn-primary" type="button" data-original-title="Save"><i class="fa fa-floppy-o"></i></button>
            <button id="btnLoad" class="btn btn-primary" type="button" data-original-title="Load"><i class="fa fa-download"></i></button>
            <button id="btnPreview" class="btn btn-primary" type="button" data-original-title="Preview"><i class="fa fa-file"></i></button>
            <button id="btnSend" class="btn btn-primary" type="button" data-original-title="Send"><i class="fa fa-paper-plane"></i></button>
            <button id="btnClear" class="btn btn-primary" type="button" data-original-title="Clear Form"><i class="fa fa-eraser"></i></button>
        </div>
    </div>
</div>
<div id="saveFile" class="row hidden">
	<div class="col-lg-7"></div>
	<div class="col-lg-4">
		<input class="form-control" id="inputSaveName" placeholder="Enter Save Name Here" type="text">
    </div>
    <div class="col-lg-1">
	    <button id="saveNewsletter", class="btn btn-info" type="button" style="width: 100%;">Save</button>
    </div>
</div>
<div id="loadFile" class="row hidden text-right">
	<div class="col-sm-6"></div>
   	<div class="col-sm-4">
    	<select class="form-control" id="fileSelect"></select>
    </div>
    <div class="btn-group col-sm-2">
        <button id="loadNewsletter", class="btn btn-info" type="button" style="width: 65%;">Load</button>
        <button id="eraseNewsletter", class="btn btn-warning" type="button" style="width: 35%;"><i class="fa fa-trash-o"></i></button>
    </div>
</div>
<div class="summernote row">
    <div id="summernote" class="col-lg-12"><p></p></div>
</div>
<?php
		} else if($myPage == "EditNameList") {
			require("codelib.php");
			$SQL = new mSQL;
			$myCustomers = $SQL->selectQ("newsletter");
?>
<table class="table table-striped table-hover">
	<thead>
    	<tr>
        	<th>E-Mail</th>
            <th>Name</th>
            <th>Newsletter</th>
            <th>Sent Review</th>
            <th>Reminder</th>
            <th>Reminder Date</th>
            <th>Last Service</th>
            <th>Last Mileage</th>
            <th>Avg Miles Per Day</th>
        </tr>
    </thead>
	<tbody>
<?php
			foreach($myCustomers as $cust) {
				if ($cust["newsletter"] == '1') {
					$myLtr = "Yes";
				} else {
					$myLtr = "No";
				}
				if ($cust["review"] == '1') {
					$myRvw = "Yes";
				} else {
					$myRvw = "No";
				}
				if ($cust["reminder"] == '5') {
					$myRem = "Yes (5/5000)";
					$d = new DateTime($cust["rmDate"]);
					$remDate = $d->format("m/d/Y");
				} else if($cust["reminder"] == '3') {
					$myRem = "Yes (3/3000)";
					$d = new DateTime($cust["rmDate"]);
					$remDate = $d->format("m/d/Y");
				} else {
					$myRem = "No";
					$remDate = "&nbsp;";
				}
				$d = new DateTime($cust["chDate"]);
				$repDate = $d->format("m/d/Y");
				echo "
    	<tr>
        	<th>" . $cust["email"] . "</th>
            <th>" . $cust["cName"] . "</th>
            <th>" . $myLtr . "</th>
            <th>" . $myRvw . "</th>
            <th>" . $myRem . "</th>
            <th>" . $remDate . "</th>
            <th>" . $repDate . "</th>
			<th>" . number_format($cust["mileage"]) . "</th>
            <th>" . $cust["mpd"] . "</th>
        </tr>";	
			}
?>
    </tbody>
</table>
 <?php
		} else {
?>
	<div class="row">
    	<div class="col-lg-12"><img class="img-responsive" src="images/d2eAdmin.png"></div>
    </div>
<?php
		}
	}
?>
<div id="foot" class="navbar navbar-default">
<div class="col-sm-6">Design and Development by<br>David Vernon at <a class="dvernon_link" href="http://dvernon.com" target="_blank">dvernon.com</a></div>
<div class="col-sm-6 text-right">copyright <span class="glyphicon glyphicon-copyright-mark"></span> 2014 D2E Auto<br>ALL RIGHTS RESERVED</div>
</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<?php
	if (!$logged)
	{
		?>
<script>
	$('#submitButton').on('click', function(e) {
		e.preventDefault();
		$('#submitButton').hide();
		var formData = new FormData();
		formData.append('action', 'login');
		formData.append('email', $('#inputEmail').val());
		formData.append('password', $('#inputPassword').val());
		$.ajax({
			url: 'adminCode.php',
			type: 'post',
			processData: false,
			contentType: false,
			data: formData,
			success: function(data, status) {
				console.log(data);
				if (data.substring(0, 6) == "FAILED") {
					if (data == "FAILED: email") {
						$('#inputEmail').parent().parent().addClass('has-error');
					} else {
						$('#inputEmail').parent().parent().removeClass('has-error');
					}
					if (data == "FAILED: password") {
						$('#inputPassword').parent().parent().addClass('has-error');
					} else {
						$('#inputPassword').parent().parent().removeClass('has-error');
					}
					$('#submitButton').show();
				} else {
					document.location.reload(true);
				}
			},
			error: function(xhr, desc, err) {
				console.log(xhr);
				console.log("Details: " + desc + "\nError:" + err);
				alert("Details: " + desc + "\nError:" + err);
			}
		});
	});
</script>
<?php	
	 } else {
		if ($myPage == "AddCustomer") {
?>
<script>
	var reminderValue = 5;
	$('input:radio[name=optionsReminders]').click(function() {
		reminderValue = $(this).val();
	});
	$('#submitButton').on('click', function(e) {
		e.preventDefault();
		$('#submitButton').hide();
		var formData = new FormData();
		formData.append('action', 'addCustomer');
		formData.append('email', $('#inputEmail').val());
		formData.append('name', $('#inputName').val());
		formData.append('date', $('#inputDate').val());
		formData.append('mileage', $('#inputMileage').val());
		formData.append('reminders', reminderValue);
		if ($('#chkNewsletter').is(":checked"))
		{
			formData.append('newsLetter', '1');
		} else {
			formData.append('newsLetter', '0');
		}
		if ($('#chkReview').is(":checked"))
		{
			formData.append('review', '1');
		} else {
			formData.append('review', '0');
		}
		$.ajax({
			url: 'adminCode.php',
			type: 'post',
			processData: false,
			contentType: false,
			data: formData,
			success: function(data, status) {
				console.log(data);
				$('.alert').remove();
				var respMsg = data.substring(10, 17);
				if (respMsg == "FAILema") {
					$('#inputEmail').parent().parent().addClass('has-error');
					$('#inputEmail').focus();
				} else {
					$('#inputEmail').parent().parent().removeClass('has-error');
				}
				if (respMsg == "FAILnam") {
					$('#inputName').parent().parent().addClass('has-error');
					$('#inputName').focus();
				} else {
					$('#inputName').parent().parent().removeClass('has-error');
				}
				if (respMsg == "FAILdat") {
					$('#inputDate').parent().parent().addClass('has-error');
					$('#inputDate').focus();
				} else {
					$('#inputDate').parent().parent().removeClass('has-error');
				}
				if (respMsg == "FAILmil") {
					$('#inputMileage').parent().parent().addClass('has-error');
					$('#inputMileage').focus();
				} else {
					$('#inputMileage').parent().parent().removeClass('has-error');
				}
				$('#alertHolder').append(data);
				if (respMsg == "SUCCESS") {
					$('#inputEmail').val("");
					$('#inputName').val("");
					$('#inputDate').val("<?php echo date("m/d/Y"); ?>");
					$('#inputMileage').val("");
					$('#optionReminder1').prop('checked', true);
					reminderValue = 5;
					$('#chkNewsletter').prop('checked', true);
					$('#chkReview').prop('checked', true);
					$('#inputEmail').focus();
				}
			},
			error: function(xhr, desc, err) {
				console.log(xhr);
				console.log("Details: " + desc + "\nError:" + err);
				alert("Details: " + desc + "\nError:" + err);
			}
		});
		$('#submitButton').show();
	});
</script>
<?php
		} else if ($myPage == "Newsletter") {
?>
<script src="js/summernote.min.js"></script>
<script>
	var sFile = false;
	var lFile = false;
	$(document).ready(function() {
		$('#summernote').summernote({
			height: 300,
			toolbar: [
				//[groupname, [button list]]
				 
				['redo', ['undo', 'redo']],
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['insert', ['link', 'hr', 'table']],
				['misc', ['fullscreen', 'help', 'codeview']],
			  ]
		});
		$('.btn-primary').tooltip();
	});
	$('#btnSave').on('click', function() {
		if (sFile) {
			$('#saveFile').addClass('hidden');
			sFile = false;
		} else {
			if (lFile) {
				$('#loadFile').addClass('hidden');
				$lFile = false;
				$('option').remove();
			}
			$('#saveFile').removeClass('hidden');
			sFile = true;
			$('#inputSaveName').focus();
		}
	});
	$('#btnLoad').on('click', function() {
		if (lFile) {
			$('#loadFile').addClass('hidden');
			lFile = false;
			$('option').remove();
		} else {
			if (sFile) {
				$('#saveFile').addClass('hidden');
				$sFile = false;
			}
			var formData = new FormData();
			formData.append('action', 'getLetterNames');
			$.ajax({
				url: 'adminCode.php',
				type: 'post',
				processData: false,
				contentType: false,
				data: formData,
				success: function(data, status) {
					console.log(data);
					$('#fileSelect').append(data);
				},
				error: function(xhr, desc, err) {
					console.log(xhr);
					console.log("Details: " + desc + "\nError:" + err);
					alert("Details: " + desc + "\nError:" + err);
				}
			});
			$('#loadFile').removeClass('hidden');
			lFile = true;
		}
	});
	$('#saveNewsletter').on('click', function() {
		if ($('#inputSaveName').val() != "" && $('#summernote').code() != "<p></p>") {
			var formData = new FormData();
			formData.append('action', 'saveLetter');
			formData.append('sName', $('#inputSaveName').val());
			formData.append('body', htmlEscape($('#summernote').code()));
			$.ajax({
				url: 'adminCode.php',
				type: 'post',
				processData: false,
				contentType: false,
				data: formData,
				success: function(data, status) {
					console.log(data);
					$('#inputSaveName').val("");
					$('#saveFile').addClass('hidden');
					sFile = false;
				},
				error: function(xhr, desc, err) {
					console.log(xhr);
					console.log("Details: " + desc + "\nError:" + err);
					alert("Details: " + desc + "\nError:" + err);
				}
			});
		}
	});
	$('#loadNewsletter').on('click', function() {
		$('#summernote').code("<p></p>");
		var formData = new FormData();
		formData.append('action', 'loadLetter');
		formData.append('id', $('#fileSelect').val());
		$.ajax({
			url: 'adminCode.php',
			type: 'post',
			processData: false,
			contentType: false,
			data: formData,
			success: function(data, status) {
				console.log(data);
				$('#summernote').code($('<div/>').html(data).text());
				$('#loadFile').addClass('hidden');
				$lFile = false;
				$('option').remove();
			},
			error: function(xhr, desc, err) {
				console.log(xhr);
				console.log("Details: " + desc + "\nError:" + err);
				alert("Details: " + desc + "\nError:" + err);
			}
		});
	});
	$('#eraseNewsletter').on('click', function() {
		var formData = new FormData();
		formData.append('action', 'deleteLetter');
		formData.append('id', $('#fileSelect').val());
		$.ajax({
			url: 'adminCode.php',
			type: 'post',
			processData: false,
			contentType: false,
			data: formData,
			success: function(data, status) {
				console.log(data);
				$('#loadFile').addClass('hidden');
				$lFile = false;
				$('option').remove();
			},
			error: function(xhr, desc, err) {
				console.log(xhr);
				console.log("Details: " + desc + "\nError:" + err);
				alert("Details: " + desc + "\nError:" + err);
			}
		});
	});
	$('#btnPreview').on('click', function() {
		var w = window.open('', 'newwindow', config='height=600, width=800, '
        + 'toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, '
        + 'directories=no, status=no');
		var formData = new FormData();
		formData.append('action', 'previewLetter');
		formData.append('body', htmlEscape($('#summernote').code()));
		$.ajax({
			url: 'adminCode.php',
			type: 'post',
			processData: false,
			contentType: false,
			data: formData,
			success: function(data, status) {
				console.log(data);
				$(w.document.body).html($('<div/>').html(data).text());
			},
			error: function(xhr, desc, err) {
				console.log(xhr);
				console.log("Details: " + desc + "\nError:" + err);
				alert("Details: " + desc + "\nError:" + err);
			}
		});
	});
	$('#btnSend').on('click', function() {
		var formData = new FormData();
		formData.append('action', 'sendLetter');
		formData.append('body', htmlEscape($('#summernote').code()));
		$.ajax({
			url: 'adminCode.php',
			type: 'post',
			processData: false,
			contentType: false,
			data: formData,
			success: function(data, status) {
				console.log(data);
				alert(data);
			},
			error: function(xhr, desc, err) {
				console.log(xhr);
				console.log("Details: " + desc + "\nError:" + err);
				alert("Details: " + desc + "\nError:" + err);
			}
		});
	});
	$('#btnClear').on('click', function() {
		$('#summernote').code("<p></p>");
	});
	function htmlEscape(str) {
		return String(str)
			.replace(/&/g, '&amp;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#39;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;');
	}
</script>
<?php
		}
	 }
?>
</body>
</html>