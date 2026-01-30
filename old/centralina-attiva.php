<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/include/define.php";

    date_default_timezone_set("Europe/Rome");
    $date = date("Y-m-d H:i:s");

    $query = "SELECT date FROM `smart-home_wind-sensor` ORDER BY date DESC LIMIT 1";
    $wind_sensor = getQueryResult($query, false)["date"];
    
    $query = "SELECT date FROM `smart-home_rain-sensor` ORDER BY date DESC LIMIT 1";
    $rain_sensor = getQueryResult($query, false)["date"];

    $wind_from_time = strtotime($wind_sensor);
    $wind_to_time = strtotime($date);
    $rain_minutes = round(abs($rain_to_time - $rain_from_time) / 60);

    $rain_from_time = strtotime($rain_sensor);
    $rain_to_time = strtotime($date);
    $rain_minutes = round(abs($rain_to_time - $rain_from_time) / 60);

    if ($wind_minutes > MINUTI) {
        // Invio allarme tramite email
        $template = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/assets/emailTemplates/centralina-inattiva.html");
        echo $template;
        sendEmail("Centralina Tende Inattiva (Vento)", $template);
        // Invio allarme a Node-RED
        file_get_contents("http://kappo.ddns.net:1880/centralina-inattiva");
        // Invio allarme ad Alexa
		file_get_contents("https://www.virtualsmarthome.xyz/url_routine_trigger/activate.php?trigger=1d2bc392-67ab-4333-88e7-b4cdbbc974c8&token=3b464de9-7697-499a-872d-9760dfc426b3&response=json");
	}
    else if ($rain_minutes > MINUTI) {
        // Invio allarme tramite email
        $template = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/assets/emailTemplates/centralina-inattiva.html");
        echo $template;
        sendEmail("Centralina Tende Inattiva (Pioggia)", $template);
        // Invio allarme a Node-RED
        file_get_contents("http://kappo.ddns.net:1880/centralina-inattiva");
        // Invio allarme ad Alexa
		file_get_contents("https://www.virtualsmarthome.xyz/url_routine_trigger/activate.php?trigger=1d2bc392-67ab-4333-88e7-b4cdbbc974c8&token=3b464de9-7697-499a-872d-9760dfc426b3&response=json");
	}
    else
        echo "Centralina Tende Attiva";


?>