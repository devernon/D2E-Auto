<?php
	require("codelib.php");
	session_start();
	if (isset($_POST['action'])) {
		if($_POST['action'] == "login") {
			$SQL = new mSQL;
			$myEmail = $_POST['email'];
			$myPassword = $_POST['password'];
			$myResult = $SQL->rselectQ("users", "email = '".$myEmail."'");
			if ($myResult == false) {
				echo "FAILED: email";
			} else {
				if ($myResult["password"] != $myPassword) {
					echo "FAILED: password";
				} else {
					$_SESSION['isLogged'] = "I AM NOW LOGGED IN";
					echo "SUCCESS";
				}
			}
		} else if($_POST['action'] == "addCustomer") {
			$SQL = new mSQL;
			$myEmail = $_POST['email'];
			$myName = $_POST['name'];
			$myDate = $_POST['date'];
			$myMileage = $_POST['mileage'];
			$myReminders = $_POST['reminders'];
			$myNewsletter = $_POST['newsLetter'];
			$myReview = $_POST['review'];
			$noErr = true;
			if (!filter_var($myEmail, FILTER_VALIDATE_EMAIL)) {
				$noErr = false;
				$rtnID = "FAILema";
				$rtnMsg = "<strong>Email Address is in invalid format!</strong>";
			} else {
				if ($myName == "") {
					$noErr = false;
					$rtnID = "FAILnam";
					$rtnMsg = "<strong>Name field cannot be blank!</strong>";
				} else {
					if ($myMileage == "") {
						$noErr = false;
						$rtnID = "FAILmil";
						$rtnMsg = "<strong>Mileage field cannot be blank!</strong>";
					} else {
						try {
							$newDate = new DateTime($myDate);
						} catch (Exception $e) {
							$noErr = false;
							$rtnID = "FAILdat";
							$rtnMsg = "<strong>Date is in invalid format!</strong>";
						}
					}
				}
			}
			if ($noErr) {
				$rtnCls = "alert-success";
				$rtnID = "SUCCESS";
				$existing = $SQL->rselectQ("newsletter", "email = '" . $myEmail . "'");
				if ($existing == false) {
					$unsubscribe = md5(microtime().rand());
					if ($myNewsletter == '1') {
						$newsResult = "The newsletters will be sent to their email.";
					} else {
						$newsResult = "They will not be receiving the newsletter emails.";	
					}
					if ($myReminders == 5) {
						$rmDate = clone $newDate;
						$rmDate->add(new DateInterval('P5M'));
						$rmMileage = intval($myMileage) + 5000;
						$rmType = "TIME";
						$mpd = 0;
						$addMsg = "A reminder will be sent in approx. 5 months, at or around " . $rmDate->format("m/d/Y") . ".";
						$newDateS = $newDate->format("Y-m-d");
						$chDate = $rmDate->format("Y-m-d");
						$rmDateS = $rmDate->format("Y-m-d");
					} else if ($myReminders == 3) {
						$rmDate = clone $newDate;
						$rmDate->add(new DateInterval('P3M'));
						$rmMileage = intval($myMileage) + 3000;
						$rmType = "TIME";
						$mpd = 0;
						$addMsg = "A reminder will be sent in approx. 3 months, at or around " . $rmDate->format("m/d/Y") . ".";
						$newDateS = $newDate->format("Y-m-d");
						$chDate = $rmDate->format("Y-m-d");
						$rmDateS = $rmDate->format("Y-m-d");
					} else {
						$rmDateS = "NULL";
						$chDate = "NULL";
						$mrMileage = 0;
						$rmType = "";
						$mpd = 0;
						$addMsg = "No reminder will be sent.";
						$newDateS = $newDate->format("Y-m-d");
					}
					if ($myReview == '1') {
						$reviewMailer = new Mailer;
						$reviewResult = $reviewMailer->reviewMail($myName, $myEmail, $unsubscribe);
					} else {
						$reviewResult = "No Thank You/Review email sent.";
					}
					$result = $SQL->insertQ("newsletter", array( "cName", "email", "newsletter", "review", "reminder", "svDate", "mileage", "chDate", "rmDate", "rmMileage", "rmType", "mpd", "unsub" ), array( $myName, $myEmail, $myNewsletter, $myReview, $myReminders, $newDateS, $myMileage, $chDate, $rmDateS, $rmMileage, $rmType, $mpd, $unsubscribe ));
					$rtnMsg = "<strong>" . $myEmail . " has been ADDED.</strong><br>" . $addMsg . "<br>" . $reviewResult. "<br>" . $newsResult;
				} else {
					$unsubscribe = $existing["unsub"];
					$prevMileage = intval($existing["mileage"]);
					$newMileage = intval($myMileage);
					$prevMPD = intval($existing["mpd"]);
					$prevDate = new DateTime($existing["svDate"]);
					$interval = $prevDate->diff($newDate);
					$daysSince = intval($interval->format('%R%a'));
					$newMPD = intval(($newMileage - $prevMileage) / $daysSince);
					if ($prevMPD != 0) {
						$newMPD = intval(($prevMPD + $newMPD) / 2);
					}
					if ($myNewsletter == '1') {
						$newsResult = "The newsletters will be sent to their email.";
					} else {
						$newsResult = "They will not be receiving the newsletter emails.";	
					}
					if ($myReminders == '5' || $myReminders == '3') {
						$tDate = clone $newDate;
						$mDate = clone $newDate;
						$tDate->add(new DateInterval('P' . $myReminders . 'M'));
						$daysToMileage = intval((intval($myReminders) * 1000) / $newMPD);
						$mDate->add(new DateInterval('P' . $daysToMileage . 'D'));
						$rmMileage = intval($myMileage) + (intval($myReminders) * 1000);
						$chDate = $tDate->format("Y-m-d");
						if ($tDate < $mDate) {
							$rmType = "TIME";
							$addMsg = "A reminder will be sent in approx. " . $myReminders . " months, at or around " . $tDate->format("m/d/Y") . ".";
							$rmDateS = $tDate->format("Y-m-d");
						} else {
							$rmType = "MILE";
							$addMsg = "A reminder will be sent at or around " . $mDate->format("m/d/Y") . " based of average mileage.";
							$rmDateS = $mDate->format("Y-m-d");
						}
					} else if ($myReminders == '0') {
						$rmDateS = "NULL";
						$chDate = "NULL";
						$rmMileage = 0;
						$rmType = "";
						$addMsg = "No reminder will be sent.";
					} else {
						$rmType = $existing["rmType"];
						$rmDateS = $existing["rmDate"];
						$chDate = $existing["chDate"];
						$myReminders = $existing["reminder"];
						$addMsg = "Existing reminder will not be changed.";
					}
					if ($existing["review"] == '1') {
						$reviewResult = "Thank You/Review email previously sent.";
						$myReview = '1';
					} else {
						if ($myReview == '1') {
							$reviewMailer = new Mailer;
							$reviewResult = $reviewMailer->reviewMail($myName, $myEmail, $unsubscribe);
						} else {
							$reviewResult = "No Thank You/Review email sent.";
						}
					}
					$newDateS = $newDate->format("Y-m-d");
					$result = $SQL->updateQ("newsletter", "email = '" . $myEmail . "'", array( "newsletter", "review", "reminder", "svDate", "mileage", "chDate", "rmDate", "rmMileage", "rmType", "mpd" ), array( $myNewsletter, $myReview, $myReminders, $newDateS, $myMileage, $chDate, $rmDateS, $rmMileage, $rmType, $newMPD ));
					$rtnMsg = "<strong>" . $myEmail . " has been UPDATED.</strong><br>" . $addMsg . "<br>" . $reviewResult. "<br>" . $newsResult;
				}
			} else {
				$rtnCls = "alert-danger";
			}
			echo "
<div id=\"" . $rtnID . "\" class=\"alert alert-dismissable " . $rtnCls . "\">
	<button	type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
	". $rtnMsg . "
</div>";
		} else if($_POST['action'] == "saveLetter") {
			$SQL= new mSQL;
			$sName = $_POST['sName'];
			$body = $_POST['body'];
			$result = $SQL->insertQ("letters", array("sName", "body"), array($sName, $body));
			echo "SUCCESS: ID " . $result;
		} else if($_POST['action'] == "getLetterNames") {
			$SQL = new mSQL;
			$letters = $SQL->selectQ("letters");
			$rtnVal = "";
			foreach($letters as $ltr) {
				$rtnVal .= "<option value='" . $ltr["ID"] . "'>" . $ltr["sName"] . "</option>";
			}
			echo $rtnVal;
		} else  if($_POST['action'] == "loadLetter") {
			$SQL = new mSQL;
			$id = $_POST['id'];
			$result = $SQL->fselectQ("letters", "body", "ID = '" . $id . "'");
			echo $result;
		} else if($_POST['action'] == "deleteLetter") {
			$SQL = new mSQL;
			$id = $_POST['id'];
			$result = $SQL->deleteQ("letters", "ID = '" . $id . "'");
			echo $result;
		} else if($_POST['action'] == "previewLetter") {
			$ltr = new Mailer;
			echo $ltr->letterHTML($_POST['body']);
		} else if($_POST['action'] == "sendLetter") {
			$myBody = $_POST['body'];
			$SQL = new mSQL;
			$ltr = new Mailer;
			$recipients = $SQL->selectQ("newsletter", "*", "newsletter = '1'");
			foreach ($recipients as $rec) {
				$ltr->mailNews($rec["cName"], $rec["email"], $rec["unsub"], $myBody);
			}
			echo "Completed " . count($recipients) . " mailings.";
		} else if($_POST['action'] == "unsubNewsletter") {
			$id = $_POST['id'];
			$do = $_POST['do'];
			$SQL = new mSQL;
			$SQL->updateQ("newsletter", "unsub = '" . $id . "'", array( "newsletter" ), array( $do ));
			echo "Completed";
		} else if($_POST['action'] == "unsubReminder") {
			$id = $_POST['id'];
			$SQL = new mSQL;
			$SQL->updateQ("newsletter", "unsub = '" . $id . "'", array( "reminder", "chDate", "rmDate", "rmType" ), array( "0", "NULL", "NULL", "" ));
			echo "Completed";
		}
	}
?>