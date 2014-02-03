function otris_table(n, pr, kol, kolP) {	
	var str = "<table>";
	for (i=0; i<n; i++) {
		str += "<tr>";
		for (j=0; j<kol; j++) {
			str += "<td>";
			if (j==0)
				str += "C<sub>" + (i+1) + "</sub> = {";
			else 
				str += ", ";
			for (k=0; k<pr; k++) {
				if (k==0)
					str += "(";
				else 
					str += ",";
				str += "<input type='text' name='x[" + i + "][" + j + "][" + k + "]'>";
				if (k==pr-1)
					str += ")";
			}
			//"<input type='text' name='x[" + i + "][k]'>"
			if (j==kol-1)
				str += "}";
			str += "</td>";
		}
		str += "</tr>";
	}
	str += "</table>";
	$("#table").slideUp("fast").empty().html(str).slideDown("slow");
};

function gener_table() {
	$("#table").find("input").each(function(index, element) {
		$(element).attr("value", rand(-10, 10));
	});;
}

function rand(min/* max */, max) {
    return Math.floor(arguments.length > 1 ? (max - min + 1) * Math.random() + min : (min + 1) * Math.random());
};

// POPUP
(function($) {
	$.fn.popup = function(color, msg) {
		if (color === "error")
			color = "#C00"
		else if (color === "success")
			color = "#0C0";
		$('<div></div>')
		.appendTo('body')
		.hide()
		.html("<p class='popup'>" + msg + " <a href='' id='close-popup'>+</a></p>")
		.css({
			"position":"fixed",
			"width":"99%",
			"background-color":color,
			"color":"white",
			"text-align":"center",
			"top":"0",
			"vertical-align":"central",
			"border-radius":"0 0 30px 30px"
		})
		.fadeIn("fast");
	};
})(jQuery);

// скроллинг к нужному элементу
function scroll_to_elem(elem,speed) {
	if(document.getElementById(elem)) {
		var destination = jQuery('#'+elem).offset().top;
		jQuery("html,body").animate({scrollTop: destination}, speed);
	}
}

$(document).ready(function() {
	var n_mer = $('#core').val();
	var prizn = $('#priznak').val();
	var kolvo = $('#kolvo').val();
	otris_table(n_mer, prizn, kolvo);
	gener_table();
	
	// отрисовка при нажатии на кнопку			
	$('body').on('click', '#table_but', function() {
		var n_mer = $('#core').val();
		var prizn = $('#priznak').val();
		var kolvo = $('#kolvo').val();
		otris_table(n_mer, prizn, kolvo);
	});
	$('body').on('change', '#kolvo', function() {
		var n_mer = $('#core').val();
		var prizn = $('#priznak').val();
		var kolvo = $('#kolvo').val();
		otris_table(n_mer, prizn, kolvo);
		gener_table();
	});
	$('body').on('change', '#priznak', function() {
		var n_mer = $('#core').val();
		var prizn = $('#priznak').val();
		var kolvo = $('#kolvo').val();
		otris_table(n_mer, prizn, kolvo);
		gener_table();
	});
	$('body').on('change', '#core', function() {
		var n_mer = $('#core').val();
		var prizn = $('#priznak').val();
		var kolvo = $('#kolvo').val();
		otris_table(n_mer, prizn, kolvo);
		gener_table();
	});
	
	// заполнение таблицы случайными числами
	$('body').on('click', '#gener_but', function() {
		gener_table();
	});
	
	$('body').on('click', '#set-point', function() {
		var x = new Array();
		
		for (i=0; i<countP; i++) {
			x[i] = $('*.x:eq(' + i + ')').val();
		}
		x[countP] = 1;
		var z = 1;
		var etalon = "para";
		var cl = -1;
		var k, sum;
		for (k=0; k<countW; k++) {
			sum = 0;
			for (q=0; q<=countP; q++) {
				sum += w[k][q]*x[q];
			}
			if (etalon == "para" || sum > etalon) {
				cl = k;
				etalon = sum;
			}
		}
		alert("Тестовая точка принадлежит " + (cl+1) + " классу");
	});

	// скрытие/отображение решения матрицы
	$('body').on('click', '#hide-accept', function() {
		$('#accept').hide("slow");
	});
	$('body').on('click', '#show-accept', function() {
		$('#accept').show("slow");
		scroll_to_elem('top',300);
	});
	
	$('body').on('change', '#ver1', function() {
		$('#ver2').val(1 - $('#ver1').val());
	});
	$('body').on('change', '#ver2', function() {
		$('#ver1').val(1 - $('#ver2').val());
	});
	
	// переключение вкладок
	$('body').on('click', '#set-new', function() {
		$('#set-new h2').css("border-bottom-color", "white");
		$('#set-resh h2').css("border-bottom-color", "#036");
		$('#accept-cont').hide();
		$('#new').show();
		
		return false;
	});
	$('body').on('click', '#set-resh', function() {
		$('#set-new h2').css("border-bottom-color", "#036");
		$('#set-resh h2').css("border-bottom-color", "white");
		$('#new').hide();
		$('#accept-cont').show();
		return false;
	});
	
	// закрытие всплывающего окна
	$('body').on('click', '#close-popup', function() {
		$('p.popup').parent().fadeOut("fast", function() {
			$(this).remove();
		});
		return false;
	});
	
	$('#accept a').lightBox();
	//alert("Операция завершена успешно!");
});