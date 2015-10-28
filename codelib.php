<?php
class mSQL {
    private $server = "*****";
    private $user = "*****";
    private $pass = "*****";
    private $database = "*****";
    
    function __construct() {
        try {
            $db = @mysql_connect ($this->server,$this->user,$this->pass);
            if (!$db)
                throw new dbConnectException();
            $ds = @mysql_select_db ($this->database);
            if (!$ds)
                throw new dbSelectException();
        } catch (dbConnectionException $foe) {
            echo "Error occured during database connection";
        } catch (dbSelectException $foe) {
            echo "Error occured during database selection";
        }
    }
    function insertQ($table, $fields, $fielddata) {
        try {
            if (count($fields) <> count($fielddata))
                throw new dbQFormatException();
            $a = $fields[0];
            $b = "'".addslashes($fielddata[0])."'";
            for ($x = 1; $x <= count($fields)-1; $x++) {
                $a = $a.", ".$fields[$x];
                $b = $b.", '".addslashes($fielddata[$x])."'";
            }
            $query = "INSERT INTO ".$table." (".$a.") VALUES (".$b.")";
            $result = mysql_query($query);
            return mysql_insert_id();
        } catch (dbQFormatException $foe) {
            echo "Error in Insert Query Format";
        }
    }
    function updateQ($table, $where, $fields, $fielddata) {
        try {
            if (count($fields) <> count($fielddata))
                throw new dbQFormatException();
            $query = "UPDATE ".$table." SET ".$fields[0]."='".addslashes($fielddata[0])."'";
            for ($x = 1; $x <= count($fields)-1; $x++) {
                $query = $query.", ".$fields[$x]."='".addslashes($fielddata[$x])."'";
            }
            $query = $query." WHERE ".$where;
            $result = mysql_query($query);
            return $result;
        } catch (dbQFormatException $foe) {
            echo "Error in Update Query Format";
        }
    }
    function selectQ($table, $fields="*", $where="", $order="") {
        $query = "SELECT ".$fields." FROM ".$table;
        if ($where <> "") {
            $query = $query." WHERE ".$where;
        }
        if ($order <> "") {
            $query = $query." ORDER BY ".$order;
        }
        $result = mysql_query($query);
        if (mysql_num_rows($result) == 0) {
            return False;
        } else {
            $x = 0;
            while($row=mysql_fetch_array($result)) {
                $myResults[$x] = $row;
                $x++;
            }
            return $myResults;
        }
    }
	function rselectQ($table, $where) {
		$query = "SELECT * FROM " . $table . " WHERE " . $where;
		$result = mysql_query($query);
		if (mysql_num_rows($result) != 1) {
			return False;
		} else {
			$row = mysql_fetch_array($result);
			return $row;
		}
	}
	function fselectQ($table, $field, $where) {
		$query = "SELECT " . $field . " FROM " . $table . " WHERE " . $where;
		$result = mysql_query($query);
		if (mysql_num_rows($result) != 1) {
			return False;
		} else {
			$row = mysql_fetch_array($result);
			return $row[0];
		}
	}
	function deleteQ($table, $where) {
		$query = "DELETE FROM " . $table . " WHERE " . $where;
		$result = mysql_query($query);
		return $result;
	}
}
class Mailer {
	const FROM_ADD = "From: D2E Auto <webmaster@d2eauto.com>\r\n";
	const REPLY_TO = "Reply-To: robert@d2eauto.com\r\n";
	const REVIEW_SUBJECT = "Thank You for your recent visit to D2E Auto";
	const NEWSLT_SUBJECT = "News and specials from D2E Auto";
	const NEWSLT_PART1 = "&lt;table border=&quot;0&quot; cellpadding=&quot;2&quot; cellspacing=&quot;0&quot; align=&quot;center&quot; width=&quot;800&quot;&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td&gt;&lt;img src=&quot;http://www.d2eauto.com/images/ebanner.png&quot;&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;&lt;hr&gt;";
	const NEWSLT_PART2 = "&lt;hr&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr align=&quot;center&quot;&gt;&lt;td&gt;&lt;h4&gt;&lt;span style=&quot;color: rgb(156, 0, 0);&quot;&gt;Please visit our website at &lt;a href=&quot;http://www.d2eauto.com/&quot;&gt;d2eauto.com&lt;/a&gt; for services and special offers.&lt;/span&gt;&lt;/h4&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;&lt;p align=&quot;center&quot;&gt;You may continue to  receive emails with reminders for service and/or our newsletter with news,  updates, and specials.&lt;/p&gt;&lt;p align=&quot;center&quot;&gt;If you would like to discontinue any of these please feel free to unsubscribe &lt;a href=&quot;http://www.d2eauto.com/unsubscribe.php?id=CODE&quot;&gt;here&lt;/a&gt;&lt;/p&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;";
	
	function testConstants() {
		return self::FROM_ADD . "||" . self::REPLY_TO . "||" . self::REVIEW_SUBJECT;
	}
	
	function reviewMail($name, $email, $ID) {
		$to = $email;
		$subject = self::REVIEW_SUBJECT;
		$headers = "To: " . $name . " <" . $email. ">\r\n";
		$headers .= self::FROM_ADD;
		$headers .= self::REPLY_TO;
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
			  <p><strong>We wanted to  drop you a note and thank you for allowing us to service your vehicle. If there  are any problems with the work that we have done please let us know  immediately. It is our mission to give every customer quality service and a  reasonable price. We will never pressure you with upselling for unnecessary  repair. We hope that you will continue to bring your vehicles to us and  continue to be a valued customer.</strong></p>
			  <p><strong>Please feel  free to fill out an online review of our company on <a href='https://plus.google.com/+D2eauto/?review=1'>Google</a> or <a href='http://www.yelp.com/biz/d2e-auto-glendale-2'>Yelp</a>. This will help us  to improve our business and would be greatly appreciated.</strong></p>
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
		return "Thank You/Review Email Sent.";
	}
	function mailNews($name, $email, $ID, $myCode) {
		$to = $email;
		$subject = self::NEWSLT_SUBJECT;
		$headers = "To: " . $name . " <" . $email. ">\r\n";
		$headers .= self::FROM_ADD;
		$headers .= self::REPLY_TO;
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = "		
		<html>
		<head>
		<title>D2E Auto</title>
		</head>
		<body>";
		$message .= html_entity_decode(str_replace("id=CODE", "id=".$ID, $this->letterHTML($myCode)));
		$message .= "
		</body>
		</html>";
		mail($to, $subject, $message, $headers);
		return true;
	}
	function letterHTML($myCode) {
		return self::NEWSLT_PART1 . $myCode . self::NEWSLT_PART2;
	}
}
?>