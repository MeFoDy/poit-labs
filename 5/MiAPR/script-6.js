function otris_table(n) {
	n = Number(n);	
	
	var str = "<table><tr><td></td>";
	for (i=0; i<n; i++) {
		str += "<td>x<sub>" + (i+1) + "</sub></td>";
	}
	str += "</tr>";
	for (i=0; i<n; i++) {
		str += "<tr><td>";
		str += "x<sub>" + (i+1) + "</sub></td>";
		for (j=0; j<n; j++)
			str += "<td><input type='number' name='x[" + i + "][" + j + "]' title='x" + i + "-" + j + "'></td>";
		str += "</tr>";
	}
	str += "</table>";
	
	$("#table").slideUp("fast").empty().html(str).slideDown("slow");
};

function gener_table() {
	var kolvo = $('#kolvo').val();
	for (i=0; i<kolvo; i++) {
		for (j=0; j<kolvo; j++) {
			if (i == j) 
				r = 0;
			else
				r = rand(1, 100);
			$('#table input[title="x' + i + '-' + j + '"]').attr("value", r);
			$('#table input[title="x' + j + '-' + i + '"]').attr("value", r);
		}
	}
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
	
});