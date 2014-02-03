function otris_table(n) {
	n = Number(n);	
	var str = "<br><b>Класс 1</b><table>";
	for (i=0; i<n; i++) {
		str += "<tr>";
		str += "<td>";
		str += "x<sub>1," + (i+1) + "</sub> = (<input type='number' name='x[" + i + "]'>, <input type='number' name='y[" + i + "]'>)";
		str += "</td></tr>";
	}
	str += "</table>";
	
	str += "<b>Класс 2</b><table>";
	for (i=0; i<n; i++) {
		str += "<tr><td>";
		var j =i+n;
		str += "x<sub>2," + (i+1) + "</sub> = (<input type='number' name='x[" + j + "]'>, <input type='number' name='y[" + j + "]'>)";
		str += "</td></tr>";
	}
	str += "</table>";
	$("#table").slideUp("fast").empty().html(str).slideDown("slow");
};

function gener_table() {
	$("#table").find("input").each(function(index, element) {
		$(element).attr("value", rand(-30, 30));
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
	var kolvo = $('#kolvo').val();
	otris_table(kolvo);
	gener_table();
	
	// отрисовка при нажатии на кнопку			
	$('body').on('click', '#table_but', function() {
		var kolvo = $('#kolvo').val();
		otris_table(kolvo);		
		gener_table();
	});
	$('body').on('change', '#kolvo', function() {
		var kolvo = $('#kolvo').val();
		otris_table(kolvo);
		gener_table();
	});
	
	// заполнение таблицы случайными числами
	$('body').on('click', '#gener_but', function() {
		gener_table();
	});
	
	$('body').on('click', '#set-point', function() {
		var x = new Array();
		
		x[0] = $('#x').val();
		x[1] = $('#y').val();
		var sum = 0;
		sum += k[0];
		sum += k[1] * x[0];
		sum += k[2] * x[1];
		sum += k[3] * x[0] * x[1];
		var str = '';
		if (sum > 0) {
			str = "Тестовая точка принадлежит 1 классу";
		}
		else if (sum < 0) {
			str = "Тестовая точка принадлежит 2 классу";
		}
		else {
			str = "Тестовая точка лежит на границе";
		}
		str += "\nD(x) = " + sum;
		alert(str);
	});

	// скрытие/отображение решения матрицы
	$('body').on('click', '#hide-accept', function() {
		$('#accept').hide("slow");
	});
	$('body').on('click', '#show-accept', function() {
		$('#accept').show("slow");
		scroll_to_elem('top',300);
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