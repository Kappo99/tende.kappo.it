<?php
	header('Content-type: application/json');
	require_once $_SERVER["DOCUMENT_ROOT"]."/include/define.php";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$action = $_POST["action"];
		openConnectionJSON();
		
		if ($action == "insert-wind") {
			$frequency = $_POST["frequency"];
			$frequency = json_decode($frequency);
			$date = $_POST["date"];
			$date = json_decode($date);
			$query = "INSERT INTO `smart-home_wind-sensor`(date,frequency) VALUES ";
			for ($i = 0; $i < count($frequency); $i++) {
				// $currentDate = date("Y-m-d H:i:s", $date[$i]);
				$currentDate = $date[$i];
				$currentFreq = $frequency[$i];
				$query .= "('$currentDate','$currentFreq'),";
			}
			$query .= ";";
			$query = str_replace(",;", ";", $query);
			$risultato = mysqli_query($connessione, $query);
			$return = $risultato ? setReturnTrue() : setReturnFalse($connessione);
		}
		else if ($action == "insert-rain") {
			$rain = $_POST["rain"];
			$rain = json_decode($rain);
			$date = $_POST["date"];
			$date = json_decode($date);
			$query = "INSERT INTO `smart-home_rain-sensor`(date,rain) VALUES ";
			for ($i = 0; $i < count($rain); $i++) {
				// $currentDate = date("Y-m-d H:i:s", $date[$i]);
				$currentDate = $date[$i];
				$currentRain = $rain[$i];
				$query .= "('$currentDate','$currentRain'),";
			}
			$query .= ";";
			$query = str_replace(",;", ";", $query);
			$risultato = mysqli_query($connessione, $query);
			$return = $risultato ? setReturnTrue() : setReturnFalse($connessione);
		}
		else if ($action == "send-allarme") {
			$idAlarm = $_POST["idAlarm"];
			date_default_timezone_set("Europe/Rome");
			$date = date("Y-m-d H:i:s");
			// Memorizzo l'ultimo allarme prima dell'inserimento di quello nuovo
			$query = "SELECT date FROM `smart-home_alarm-register` WHERE `active` = 1 ORDER BY date DESC LIMIT 1";
			$alarm = getQueryResult($query, false)["date"];
			$from_time = strtotime($alarm);
			$to_time = strtotime($date);
			$minutes = round(abs($to_time - $from_time) / 60);
			// echo setReturnTrue(array("FROM"=>$from_time, "TO"=>$to_time, "MINUTES"=>$minutes));
			// exit;
			// Memorizzo allarme nel registro
			openConnectionJSON();
			$risultato = mysqli_query($connessione, "SET @date = \"$date\"");
			$risultato = mysqli_query($connessione, "SET @idAlarm = $idAlarm");
			$risultato = mysqli_query($connessione, "SET @active = ".($minutes < MINUTI ? 0 : 1));
			$query = "INSERT INTO `smart-home_alarm-register`(date,idAlarm,active) VALUES (@date,@idAlarm,@active)";
			$risultato = mysqli_query($connessione, $query);
			$return = $risultato ? setReturnTrue() : setReturnFalse($connessione);
			// Verifico che siano passati almeno MINUTI dall'ultimo allarme
			if ($minutes < MINUTI) {
				echo setReturnTrue($minutes);
				exit;
			}
			// Invio allarme a IFTTT
			// sendAlarm(); // NO da May 2023 (IFTTT max 2 applet)
			// Invio allarme a eWeLink
			file_get_contents("https://eu-apia.coolkit.cc/v2/smartscene2/webhooks/execute?id=9cd2ddacfb484bd6842d5869246e59b2");
			// Invio allarme tramite email
			$template = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/assets/emailTemplates/allarme-tende.html");
			$tipoAllarme = "INDEFINITO";
			switch ($idAlarm) {
				case 0:
					$tipoAllarme = "TEST";
					break;
				case 1:
					$tipoAllarme = "VENTO";
					break;
				case 2:
					$tipoAllarme = "PIOGGIA";
					break;
			}
			$template = str_replace("{{ tipoAllarme }}", $tipoAllarme, $template);
			sendEmail("Allarme tende | $tipoAllarme", $template);
			// Invio allarme a Node-RED
			file_get_contents("http://kappo.ddns.net:1880/allarme-tende?alarm=$tipoAllarme");
			// Invio allarme ad Alexa
			file_get_contents("https://www.virtualsmarthome.xyz/url_routine_trigger/activate.php?trigger=9e93eb74-f01a-4b9e-ac5f-2dc2ed267fde&token=5636eb57-12a3-4e28-afc8-2238c80471a2&response=json");
		}
		
		echo $return;
	}
	else if ($_SERVER["REQUEST_METHOD"] == "GET") {
		$action = $_GET["action"];
		if 		($action == "get-minutes") {
			date_default_timezone_set("Europe/Rome");
			$date = date("Y-m-d H:i:s");
			$query = "SELECT date FROM `smart-home_wind-sensor` ORDER BY date DESC LIMIT 1";
			$sensor = getQueryResult($query, false)["date"];
			$from_time = strtotime($sensor);
			$to_time = strtotime($date);
			$minutes = round(abs($to_time - $from_time) / 60);
			$return = setReturnTrue($minutes);
		}
		// else if ($action == "get-last-alarm") {
		// 	$query = "SELECT date FROM `smart-home_alarm-register` ORDER BY date DESC LIMIT 1";
		// 	$alarm = getQueryResult($query, false);
		// 	if ($alarm != null) {
		// 		$return = json_encode(array("code" => 200, "info" => "Operazione eseguita con successo", "date" => $alarm["date"]));
		// 	}
		// 	else {
		// 		$return = json_encode(array("code" => 400, "info" => "Operazione fallita"));
		// 	}
		// }
		// else {
		// 	header("location: /");
		// }
		
		echo $return;
	}
		
	closeConnection();

