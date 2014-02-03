function otris_table(n) {	
	var str = "<table>";
	for (i=0; i<n; i++) {
		str += "<tr>";
		str += "<td>x<sub>" + (i+1) + "</sub> = <input type='text' name='x[" + i + "]' value='" + (i+1) + "'>;</td>";
		str += "<td>y<sub>" + (i+1) + "</sub> = <input type='text' name='y[" + i + "]' value='" + rand(0,20) + "'>;</td>";
		str += "</tr>";
	}
	str += "</table>";
	$("#table").slideUp("fast").empty().html(str).slideDown("slow");
	
	h = $('#table table').height();
	
	var str = "<img src='figure.png' align='left' id='figure' width='15' height='" + h + "'>";
	$("#table").prepend(str);
};

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
	// начальная отрисовка матрицы
	var n_mer = $('#n-mer').val();
		otris_table(n_mer);
						
	// отрисовка при нажатии на кнопку			
	$('body').on('click', '#table_but', function() {
		var n_mer = $('#n-mer').val();
		otris_table(n_mer);
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