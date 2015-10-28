<?php
	$sName = $_POST['name'];
	$sEmail = $_POST['email'];
	$sPhone = $_POST['phone'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$ok2Send = true;
	if ($sName == "") {
		$ok2Send = false;
		$errMsg = "FAILED: No Name";
	} else {
		if (!filter_var($sEmail, FILTER_VALIDATE_EMAIL)) {
    		$ok2Send = false;
			$errMsg = "FAILED: Invalid Email";
		} else {
			if ($message == "") {
				$ok2Send = false;
				$errMsg = "FAILED: No Message";
			}
		}
	}
	if ($ok2Send) {
		$message = "NAME: " . $sName . "\nEmail: " . $sEmail . "\nPhone: " . $sPhone . "\nMessage: " . $message;
		mail("robert@d2eauto.com, 6025498140@txt.att.net, 6235213010@vtext.com", $subject, $message, "From: website@d2eauto.com");
		echo "<p class=\"h3 text-success\">Message was Sent</p>
<p class=\"lead\">Someone will reply to you promptly</p>";
	} else {
		echo $errMsg;
	}
?>