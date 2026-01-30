var get, input;

$(document).ready(main);

function main () {
	get = window.location.search.substring(1);
	input = $("input.valueToGet");
	
	$(".btn-show-hide").click(function() {
		clickShowHide(this);
	});
	
	$("input").keyup(keyUpHandler);
	$("input.focusOutHandle").focusout(invioValori);
	
	window.setInterval(function () {
		window.location.reload();
	}, 1000 * 60 * 15); // 15 minuti
}

function keyUpHandler (e) {
	console.log("Tasto: " + e.which);
	if (e.which == 13) { //CLICK Invio
		invioValori();
	}
}

function clickShowHide (t) {
	var el = $("#" + t.id + " i.fa").get(1);
	if ($(el).attr("class").includes("minus")) { // ELENCO già aperto, va CHIUSO
		$("#table-" + t.id.split("-")[1]).hide();
		$(el).attr("class", $(el).attr("class").replace("minus", "plus"));
	}
	else if ($(el).attr("class").includes("plus")) { // ELENCO già chiuso, va APERTO
		$("#table-" + t.id.split("-")[1]).show();
		$(el).attr("class", $(el).attr("class").replace("plus", "minus"));
	}
}

function invioValori () {
	var value, name, newGet = "?" + get, fineGet;
	for (var i = 0; i < input.length; i++) {
		console.log(input[i]);
		if ($(input[i]).attr("type") == "checkbox") {
			value = $(input[i]).prop("checked");
		}
		else {
			value = $(input[i]).val();
		}
		if (value == "")
			value = 0;
		name = $(input[i]).attr('name');
		console.log("*** Valore " + name + ": " + value);
		if (newGet.includes(name)) {
			allFineGet = newGet.split(name + "=")[1].split("&");
			fineGet = "";
			for (var j = 1; j < allFineGet.length; j++)
				fineGet += "&" + allFineGet[j];
			newGet = newGet.split(name + "=")[0] + name + "=" + value + (fineGet == null ? "" : fineGet);
		}
		else {
			newGet += "&" + name + "=" + value;
		}
		newGet = newGet.replace("?&", "?");
	}
	var path = window.location.pathname + (window.location.pathname.endsWith("/") ? "index.php" : "");
	console.log(path + newGet);
	window.location.replace(path + newGet);
}


