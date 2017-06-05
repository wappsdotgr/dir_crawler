$(document).ready(function(){
	// kane kati
	$('#scan').click( function() {
		$.ajax({
			url: 'system/scan.php',
			data: 'bp=' + $('#path').val(),
			type: 'POST',
			success: function(data) {
				// console.log(data);
				$('pre').text(data);
			},
			complete: function(data) {
				// console.log(data);
			}
		});
	});
	$('#rbase').click( function() {
		var ot = $('pre').text().split("\n");
		var op = $('#path').val();
		// console.log(ot);
		for (var i = 0; i < ot.length; i++) {
			ot[i] = ot[i].replace(op+"\\","");
		};
		ot = ot.join("\n");
		// console.log(ot);
		$('pre').text(ot);
	});
	$('#save').click( function() {
		var saveData = (function () {
			var a = document.createElement("a");
			document.body.appendChild(a);
			a.style = "display:none";
			return function (data, fileName) {
				blob = new Blob([data], {type: "text/plain"}),
				url = window.URL.createObjectURL(blob);
				a.href = url;
				a.download = fileName;
				a.click();
				window.URL.revokeObjectURL(url);
				a.remove();
			};
		}());
		var data = $('pre').text(),
			fileName = "dir-contents.txt";
		saveData(data, fileName);
	});
	$('#zip').click( function() {
		var zn;
		$.ajax({
			url: 'system/zip.php',
			data: 'bp=' + $('#path').val(),
			type: 'POST',
			success: function(data) {
				// console.log(data);
				zn = data;
				window.open('system/'+ data, '_blank');
			},
			complete: function(data) {
				// console.log(data);
				window.open('system/dzip.php?zn='+ zn, '_blank');
			}
		});
	});
});
