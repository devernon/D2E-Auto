<?php
	require("../codelib.php");
	$SQL = new mSQL;
	$myDay = new DateTime();
	$today = $myDay->format("Y-m-d");
	$myDay->add(new DateInterval('P7D'));
	$week = $myDay->format("Y-m-d");
	$reminders = $SQL->selectQ("newsletter", "*", "rmDate >= '" . $today . "' && rmDate < '" . $week . "'");
	if (!$reminders) {
		$result = "RESULTS: no emails sent";
	} else {
		$result = "RESULTS: ";
		foreach($reminders as $recip) {
			$result .= reviewMail($recip["cName"], $recip["email"], $recip["unsub"], $recip["reminder"], $recip["chDate"],  $recip["rmMileage"], $recip["rmType"]);
		}
	}
	echo $result;
	
	function reviewMail($name, $email, $ID, $reminder, $chDate, $rmMileage, $rmType) {
		$to = $email;
		$changeDate = new DateTime($chDate);
		$chDate = $changeDate->format("n/j/Y");
		$subject = "Courtesy reminder from D2E Auto";
		$headers = "To: " . $name . " <" . $email. ">\r\n";
		$headers .= "From: D2E Auto <webmaster@d2eauto.com>\r\n";
		$headers .= "Reply-To: robert@d2eauto.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = "
		<html>
		<head>
		<title>D2E Auto</title>
		</head>
		<body>
		<table width='800' align='center' border='0' cellspacing='0' cellpadding='2'>
		  <tr>
			<td><img src='http://www.d2eauto.com/images/ebanner.png' /></td>
		  </tr>
		  <tr>
			<td><font size='+1' color='#B20000'><p><strong>Dear " . $name . ",</strong></p>
			  <p><strong>This is a friendly reminder that it might be time to bring your vehicle in for an oil change. A reminder was set for " . $reminder . " months or " . $reminder . ",000 miles, which ever comes first. ";
		if ($rmType == "TIME") {
			$message .= "This reminder was sent at " . $reminder . " months due to no mileage information on file or the mileage information present found that you shouldn't have reached " . $reminder . ",000 miles as of yet. If you have done any excessive driving and you have exceeded " . number_format($rmMileage) . " miles then you maybe overdue for an oil change. ";
		} else {
			$message .= "This remnder was sent now because do to our records and the average mileage recorded during your visits you may have reached " . number_format($rmMileage) . " miles. If you have exceeded this you maybe overdue for an oil change. If not your oil change will be due when you reach this mileage or " . $chDate . ", which ever comes first. ";
		}
		$message .= "Either way we would be happy to set up an appointment to change your oil. Please call us at (602) 761-7730 to set up your appointment.</strong></p>
			  <p><strong>We are glad you have chosen D2E Auto to service your vehicle. If you have any problems or concerns please let us know. We pride ourselves in integrity, quality of service, and low cost to the customer.</strong></p>
			  <p><strong>Thank You,<br>
			The Staff At  D2E Auto</strong></p>
			<p>Please visit our website at <a href='http://www.d2eauto.com/'>d2eauto.com</a> for services and special offers.</p></font></td>
		  </tr>
		  <tr>
			<td>
				<p align='center'>You may continue to  receive emails with reminders for service and/or our newsletter with news,  updates, and specials.</p>
				<p align='center'>If you would like to discontinue any of these please feel free to unsubscribe <a href='http://www.d2eauto.com/unsubscribe.php?id=" . $ID . "'>here</a></p>
			</td>
		  </tr>
		</table>
		</body>
		</html>";
		mail($to, $subject, $message, $headers);
		return "(Email Sent: " . $email . ")";
	}
?>