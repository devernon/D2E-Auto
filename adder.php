<?php
	$sName = $_POST['name'];
	$sEmail = $_POST['email'];
	$ok2Send = true;
	if ($sName == "") {
		$ok2Send = false;
		$errMsg = "FAILED: No Name";
	} else {
		if (!filter_var($sEmail, FILTER_VALIDATE_EMAIL)) {
    		$ok2Send = false;
			$errMsg = "FAILED: Invalid Email";
		}
	}
	if ($ok2Send) {
		try {
				$db = @mysql_connect ("d2eauto.db.9420823.hostedresource.com", "d2eauto", "D2E@auto");
				if (!$db)
					throw new dbConnectException();
				$ds = @mysql_select_db ("d2eauto");
				if (!$ds)
					throw new dbSelectException();
				$query = "INSERT INTO newsletter (cName, email) VALUES ('" . $sName . "', '" . $sEmail . "')";
				$result = mysql_query($query);
			} catch (dbConnectionException $foe) {
				echo "<p class=\"h3 text-success\">Error occured during database connection</p>";
			} catch (dbSelectException $foe) {
				echo "<p class=\"h3 text-success\">Error occured during database selection</p>";
			} catch (dbQFormatException $foe) {
				echo "<p class=\"h3 text-success\">Error in Insert Query Format</p>";
			}
		echo "<p class=\"lead\">Your name and email have been added to receive our newsletter and specials. If you would like to discontinue receipt of the newsletter you can unsubscribe with link in email.</p>";
	} else {
		echo $errMsg;
	}
?>