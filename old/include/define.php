<?php
    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php';

	$isDebugMode = true;
	
	define("NAME", "Raspberry");
	define("MINUTI", 30);


	// ****************** Funzioni PHP Generiche ******************
	function sendEmail ($subject, $body) {
		$mail = new PHPMailer();
		// $mail->SMTPDebug = 2;                   // Enable verbose debug output
		$mail->isSMTP();                        // Set mailer to use SMTP
		$mail->Host       = "smtp.hostinger.com;";    // Specify main SMTP server
		$mail->SMTPAuth   = true;               // Enable SMTP authentication
		$mail->Username   = "kappo@kappo.it";     // SMTP username
		$mail->Password   = "kp-Kpp$22";         // SMTP password
		$mail->SMTPSecure = "ssl";              // Enable SSL encryption, "TLS" also accepted
		$mail->Port       = 465;                // TCP port to connect to
		$mail->setFrom("kappo@kappo.it", "Centralina Tende");           // Set sender of the mail
		// $mail->addAddress("trigger@applet.ifttt.com");           // Add a recipient
		$mail->addAddress("andrea30.4.99@gmail.com", "Kappo");   // Name is optional
		$mail->addAddress("roberto.cappone63@gmail.com", "Roby");   // Name is optional
		$mail->isHTML(true);                                  
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = $subject;
		$mail->send();
	}

	// INVIO Allarme a IFTTT
	function sendAlarm () {
		$mail = new PHPMailer();
		// $mail->SMTPDebug = 2;                   // Enable verbose debug output
		$mail->isSMTP();                        // Set mailer to use SMTP
		$mail->Host       = "smtp.hostinger.com;";    // Specify main SMTP server
		$mail->SMTPAuth   = true;               // Enable SMTP authentication
		$mail->Username   = "kappo@kappo.it";     // SMTP username
		$mail->Password   = "kp-Kpp$22";         // SMTP password
		$mail->SMTPSecure = "ssl";              // Enable SSL encryption, "TLS" also accepted
		$mail->Port       = 465;                // TCP port to connect to
		$mail->setFrom("kappo@kappo.it");           // Set sender of the mail
		$mail->addAddress("trigger@applet.ifttt.com");           // Add a recipient
		// $mail->addAddress("andrea30.4.99@gmail.com", "Kappo");   // Name is optional
		// $mail->isHTML(true);                                  
		$mail->Subject = "#allarme-tende";
		$mail->Body    = "Allarme Tende";
		$mail->AltBody = "Allarme Tende";
		$mail->send();
	}
	
	
	// ****************** Funzioni PHP MySQL ******************
	function getQueryResult ($query, $oneElementAsArray = true) {
		openConnectionJSON();
		global $connessione;
		$arr = null;
		$risultato = mysqli_query($connessione, $query);
		if ($risultato) {
			$arr = array();
			while (($riga = mysqli_fetch_array($risultato, MYSQLI_ASSOC))) {
				$arr[] = $riga;
			}
		}
		else if ($isDebugMode) {
			print_sqlError($query);
		}
		if (count($arr) == 0)
			$arr = null;
		else if (count($arr) == 1 && !$oneElementAsArray)
			$arr = $arr[0];
		closeConnection();
		return $arr;
	}
	
	function my_print_r ($arr) {
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
	
	function print_sqlError ($query) {
		global $connessione;
		echo json_encode(array("code" => 500, "info" => "Errore durante l'elaborazione della query", "query" => $query, "error" => mysqli_error($connessione)));
		exit;
	}
	
	function openConnection ($name = "u253831929_smarthome", $user = "u253831929_SmartHome", $pass = "SmartHomeDB99") {
		global $connessione;
		
		$host = "localhost";
		
		$connessione = @mysqli_connect($host, $user, $pass, $name);
		
		if (!$connessione) {
			echo "<br>Error: Unable to connect to MySQL.";
			echo "<br>Debugging errno: " . mysqli_connect_errno();
			echo "<br>Debugging error: " . mysqli_connect_error();
			exit;
		}
	}
	function openConnectionJSON ($name = "u253831929_smarthome", $user = "u253831929_SmartHome", $pass = "SmartHomeDB99") {
		global $connessione;
		
		$host = "localhost";
		
		$connessione = @mysqli_connect($host, $user, $pass, $name);
		
		if (!$connessione) {
			$errno = mysqli_connect_errno();
			$error = mysqli_connect_error();
			echo json_encode(array("code" => 500, "info" => "Errore connessione Database MySQL", "errno" => $errno, "error" => $error));
			exit;
		}
	}
	
	function closeConnection () {
		global $connessione;
		mysqli_close($connessione);
	}

	function setReturnTrue ($body = null) {
		http_response_code(200);
		return json_encode(array("code" => 200, "info" => "Operazione eseguita con successo", "body" => $body));
	}
	
	function setReturnFalse ($c) {
		$error = mysqli_error($c);
		return json_encode(array("code" => 400, "info" => "Operazione fallita", "sql_error" => $error));
	}

?>


