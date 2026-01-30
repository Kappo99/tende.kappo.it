<!DOCTYPE html>
<html lang="it">
<head>
	<?php require_once $_SERVER["DOCUMENT_ROOT"]."/include/define.php" ?>
	
	<title><?=NAME?> - Centralina Tende</title>
	
	<?php require_once $_SERVER["DOCUMENT_ROOT"]."/include/head.php" ?>
</head>

<body class="bg-light-1 m-0">	
	<?php
	$today = date("Y/m/d");
	$todaySQL = date("Y-m-d");
	$windMin = 150;
	$windMax = 1500;
	
	// LEGGO parametri GET
	if (isset($_GET["date"]))
		$dateGet = $_GET["date"];
	else
		$dateGet = 0;

	if (isset($_GET["wind-limit"]))
		$windLimit = $_GET["wind-limit"];
	else
		$windLimit = 5000;

	if (isset($_GET["rain-limit"]))
		$rainLimit = $_GET["rain-limit"];
	else
		$rainLimit = 5000;

	if (isset($_GET["register-limit"]))
		$registerLimit = $_GET["register-limit"];
	else
		$registerLimit = 50;
	
	if (isset($_GET["min-value"]))
		$minValue = $_GET["min-value"];
	else
		$minValue = 0;
	
	if (isset($_GET["cons-value"]))
		$consValue = $_GET["cons-value"];
	else 
		$consValue = 0;
	?>
	
	<div class="container text-center mt-3">
		<h1 class="text-uppercase">Centralina tende</h1>
	</div>
	<div class="container clearfix">
		<div class="font-4 float-left">
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="txtData">Data</span>
				</div>
				<input type="date" class="form-control focusOutHandle valueToGet" name="date" min="2020/07/23" max="<?=$today?>" value="<?=$dateGet?>" aria-label="Data" aria-describedby="txtData" />
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="txtValoreMin">Minimo</span>
				</div>
				<input type="number" class="form-control focusOutHandle valueToGet" name="min-value" min="0" value="<?=$minValue?>" aria-label="Minimo" aria-describedby="txtValoreMin" />
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="txtValoriConsecutivi">Consecutivi</span>
				</div>
				<input type="number" class="form-control focusOutHandle valueToGet" name="cons-value" min="0" value="<?=$consValue?>" aria-label="Consecutivi" aria-describedby="txtValoriConsecutivi" />
			</div>
		</div>
		<a href="/"><button type="button" class="btn btn-outline-danger float-right">Reset</button></a>
	</div>
	
	<div class="my-5 container">
		<div class="clearfix">
			<span id="table-wind-show-hide" class="fa-stack my-link btn-show-hide">
				<i class="fa fa-square-o fa-stack-2x"></i>
				<i class="fa fa-minus fa-stack-1x"></i>
			</span>
			<h3 class="text-uppercase d-inline"><div class="d-none d-sm-inline">Sensore</div> Vento</h3>
			<div class="input-group input-group-sm w-20 mt-3 float-right">
				<div class="input-group-prepend d-none d-sm-block">
					<span class="input-group-text" id="txtLimiteVento">Righe</span>
				</div>
				<input type="number" class="form-control valueToGet" name="wind-limit" min="0" value="<?=$windLimit?>" aria-label="Limite righe" aria-describedby="txtLimiteVento" />
			</div>
		</div>
		<div id="table-wind" class="bg-white text-center border border-dark shadow">
			<div class="row no-gutters font-weight-bold">
				<div class="col-lg-4 d-none d-lg-block">ID</div>
				<div class="col-lg-4 col-8">Data</div>
				<div class="col-lg-4 col-4">Frequenza</div>
			</div>
	<?php
		$whereSQL = "";
		if ($dateGet != 0)
			$whereSQL .= "WHERE date LIKE '$dateGet%'";
		if ($minValue != 0)
			$whereSQL .= ($whereSQL == "" ? "WHERE" : "AND")." frequency >= $minValue";
		$query = "SELECT id, date, frequency FROM `smart-home_wind-sensor` $whereSQL ORDER BY date DESC LIMIT $windLimit";
		$wind = getQueryResult($query);
		if ($wind != null) {
			$_id = null;
			$id = null;
			$freq = -1;
			$date = null;
			foreach ($wind as $wd) {
				if ($wd["frequency"] != 0 && $freq == 0) { // ultimo valore 0
					if ($_id != $id + 1) {
						print_serie_0($id, $date, $freq);
					}
					print_vento($wd["id"], $wd["date"], $wd["frequency"]);
				}
				else if ($wd["frequency"] != 0 || $freq != 0) { // valori normali (primo 0 o valori != 0)
					print_vento($wd["id"], $wd["date"], $wd["frequency"]);
					if ($wd["frequency"] == 0)
						$_id = $id;
				}
				$id = $wd["id"];
				$date = $wd["date"];
				$freq = $wd["frequency"];
			}
			if ($freq == 0) {
				print_serie_0($id, $date, $freq);
			}
		}
		else {
	?>
			<div class="row no-gutters">
				<div class="col-12 font-italic text-muted">Non sono presenti valori per la data selezionata</div>
			</div>
	<?php
		}
	?>
		</div>
	</div>
	
	<?php
	if ($consValue > 0) {
	?>
	<div class="my-5 container">
		<div class="clearfix">
			<span id="table-consecutivi-show-hide" class="fa-stack my-link btn-show-hide">
				<i class="fa fa-square-o fa-stack-2x"></i>
				<i class="fa fa-minus fa-stack-1x"></i>
			</span>
			<h3 class="text-uppercase d-inline"><div class="d-none d-sm-inline">Valori</div> Consecutivi</h3>
		</div>
		<div id="table-consecutivi" class="bg-white text-center border border-dark shadow">
			<div class="row no-gutters font-weight-bold">
				<div class="col-4">ID</div>
				<div class="col-8">Data</div>
			</div>
	<?php
		$dateWhere = $dateGet != 0 ? $dateGet : $todaySQL;
		$whereSQL = "WHERE date LIKE '$dateWhere%'";
		$query = "SELECT id, date, frequency FROM `smart-home_wind-sensor` $whereSQL ORDER BY date DESC";
		$wind = getQueryResult($query);
		$countConsecutivi = 0;
		if ($wind != null) {
			$consecutivi = 0;
			foreach ($wind as $wd) {
				if ($wd["frequency"] < $windMax) {
					if ($wd["frequency"] >= $windMin) {
						$consecutivi++;
						if ($consecutivi == $consValue) {
							$countConsecutivi++;
							print_consecutivi($wd["id"], $wd["date"]);
						}
					}
					else {
						$consecutivi = 0;
					}
				}
			}
		}
		if ($countConsecutivi == 0) {
	?>
			<div class="row no-gutters">
				<div class="col-12 font-italic text-muted">Non sono presenti <?=$consValue?> valori consecutivi di vento (tra <?=$windMin?> e <?=$windMax?>) per la data selezionata</div>
			</div>
	<?php
		}
	?>
		</div>
	</div>
	<?php
	}
	?>
	
	<div class="my-5 container">
		<div class="clearfix">
			<span id="table-rain-show-hide" class="fa-stack my-link btn-show-hide">
				<i class="fa fa-square-o fa-stack-2x"></i>
				<i class="fa fa-minus fa-stack-1x"></i>
			</span>
			<h3 class="text-uppercase d-inline"><div class="d-none d-sm-inline">Sensore</div> Pioggia</h3>
			<div class="input-group input-group-sm w-20 mt-3 float-right">
				<div class="input-group-prepend d-none d-sm-block">
					<span class="input-group-text" id="txtLimitePioggia">Righe</span>
				</div>
				<input type="number" class="form-control valueToGet" name="rain-limit" min="0" value="<?=$rainLimit?>" aria-label="Limite righe" aria-describedby="txtLimitePioggia" />
			</div>
		</div>
		<div id="table-rain" class="bg-white text-center border border-dark shadow">
			<div class="row no-gutters font-weight-bold">
				<div class="col-lg-4 d-none d-lg-block">ID</div>
				<div class="col-lg-4 col-8">Data</div>
				<div class="col-lg-4 col-4">Pioggia</div>
			</div>
	<?php
		$whereSQL = "";
		if ($dateGet != 0)
			$whereSQL .= "WHERE date LIKE '$dateGet%'";
		$query = "SELECT id, date, rain FROM `smart-home_rain-sensor` $whereSQL ORDER BY date DESC LIMIT $rainLimit";
		$rainSQL = getQueryResult($query);
		if ($rainSQL != null) {
			$_id = null;
			$id = null;
			$_rain = -1;
			$date = null;
			foreach ($rainSQL as $rn) {
				$rain = $rn["rain"] ? "Sì" : "No";
				if ($rain != $_rain) { // valore diverso, scrivo normale
					if ($_rain != -1 && $_id != $id + 1)
						print_serie_rain($id, $date, $_rain);
					print_rain($rn["id"], $rn["date"], $rain);
					$_id = $id;
				}
				$id = $rn["id"];
				$date = $rn["date"];
				$_rain = $rain;
			}
			if ($_id != $id + 1)
				print_serie_rain($id, $date, $_rain);
		}
		else {
	?>
			<div class="row no-gutters">
				<div class="col-12 font-italic text-muted">Non sono presenti valori per la data selezionata</div>
			</div>
	<?php
		}
	?>
		</div>
	</div>
	
	<div class="my-5 container">
		<div class="clearfix">
			<span id="table-register-show-hide" class="fa-stack my-link btn-show-hide">
				<i class="fa fa-square-o fa-stack-2x"></i>
				<i class="fa fa-minus fa-stack-1x"></i>
			</span>
			<h3 class="text-uppercase d-inline"><div class="d-none d-sm-inline">Registro</div> Allarmi</h3>
			<div class="input-group input-group-sm w-20 mt-3 float-right">
				<div class="input-group-prepend d-none d-sm-block">
					<span class="input-group-text" id="txtLimiteRegistro">Righe</span>
				</div>
				<input type="number" class="form-control valueToGet" name="register-limit" min="0" value="<?=$registerLimit?>" aria-label="Limite righe" aria-describedby="txtLimiteRegistro" />
			</div>
		</div>
		<div id="table-register" class="bg-white text-center border border-dark shadow">
			<div class="row no-gutters font-weight-bold">
				<div class="col-lg-4 d-none d-lg-block">ID</div>
				<div class="col-lg-4 col-8">Data</div>
				<div class="col-lg-4 col-4">Allarme</div>
			</div>
	<?php
		$whereSQL = "";
		if ($dateGet != 0)
			$whereSQL .= "WHERE date LIKE '$dateGet%'";
		$query = "SELECT `smart-home_alarm-register`.id AS id, date, alarm, active 
					FROM `smart-home_alarm-register` 
						INNER JOIN `smart-home_alarm-type` ON `smart-home_alarm-register`.`idAlarm` = `smart-home_alarm-type`.`id` 
					$whereSQL 
					ORDER BY date DESC 
					LIMIT $registerLimit
			";
		$alarm = getQueryResult($query);
		if ($alarm != null) {
			$count = count($alarm);
			// ****** CREO Array valori SQL ******
			$register = array();
			foreach ($alarm as $al) {
				$register[] = $al;
			}
			// ****** IMPOSTO isAlarmed True o False ******
			// $lastPos = $count-1;
			// $_date = strtotime($register[$lastPos]["date"]);
			// for ($i = $lastPos; $i >= 0; $i--) {
			// 	$date = strtotime($register[$i]["date"]);
			// 	$diff = ($date - $_date) / 60; // DA secondi A minuti
			// 	if ($diff >= 30) {
			// 		$_date = $date;
			// 		$register[$i]["isAlarmed"] = true;
			// 	}
			// 	else {
			// 		$register[$i]["isAlarmed"] = false;
			// 	}
			// }
			// $register[$lastPos]["isAlarmed"] = true;
			// ****** STAMPO a video tutti i valori ******
			foreach ($register as $rg) {
				print_register($rg["id"], $rg["date"], $rg["alarm"], $rg["active"]);
			}
		}
		else {
	?>
			<div class="row no-gutters">
				<div class="col-12 font-italic text-muted">Non sono presenti valori per la data selezionata</div>
			</div>
	<?php
		}
	?>
		</div>
	</div>
	
	<?php require_once $_SERVER["DOCUMENT_ROOT"]."/include/bottom.php" ?>
</body>
</html>

<?php
function print_serie_0 ($id, $date, $freq) {
?>
	<div class="row no-gutters">
		<div class="col-lg-4 d-none d-lg-block">...</div>
		<div class="col-lg-4 col-8">...</div>
		<div class="col-lg-4 col-4 font-weight-bold text-success">...</div>
	</div>
<?php
	print_vento($id, $date, $freq);
}
	
function print_vento ($id, $date, $freq) {
	global $windMin;
	global $windMax;
?>
	<div class="row no-gutters">
		<div class="col-lg-4 d-none d-lg-block"><?=$id?></div>
		<div class="col-lg-4 col-8"><?=$date?></div>
		<div class="col-lg-4 col-4 <?=$freq >= $windMin ? ($freq >= $windMax ? "font-weight-bold text-muted" : "font-weight-bold text-danger") : ($freq == 0 ? "font-weight-bold text-success" : "")?>"><?=$freq?></div>
	</div>
<?php
}
	
function print_consecutivi ($id, $date) {
?>
	<div class="row no-gutters">
		<div class="col-4"><?=$id?></div>
		<div class="col-8"><?=$date?></div>
	</div>
<?php
}

function print_serie_rain ($id, $date, $rain) {
?>
	<div class="row no-gutters">
		<div class="col-lg-4 d-none d-lg-block">...</div>
		<div class="col-lg-4 col-8">...</div>
		<div class="col-lg-4 col-4 font-weight-bold <?=$rain == "Sì" ? "text-danger" : "text-success"?>">...</div>
	</div>
<?php
	print_rain($id, $date, $rain);
}
	
function print_rain ($id, $date, $rain) {
?>
	<div class="row no-gutters">
		<div class="col-lg-4 d-none d-lg-block"><?=$id?></div>
		<div class="col-lg-4 col-8"><?=$date?></div>
		<div class="col-lg-4 col-4 font-weight-bold <?=$rain == "Sì" ? "text-danger" : "text-success"?>"><?=$rain?></div>
	</div>
<?php
}

function print_register ($id, $date, $alarm, $active) {
?>
	<div class="row no-gutters">
		<div class="col-lg-4 d-none d-lg-block"><?=$id?></div>
		<div class="col-lg-4 col-8"><?=$date?></div>
		<div class="col-lg-4 col-4 <?=$active ? "font-weight-bold text-danger" : ""?>"><?=$alarm?></div>
	</div>
<?php
}
?>















