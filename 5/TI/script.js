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

	// переключение вкладок
	$('body').on('click', '#set-shifr', function() {
		$('#set-shifr h2').css("border-bottom-color", "white");
		$('#set-deshifr h2').css("border-bottom-color", "#036");
		$('#set-analise h2').css("border-bottom-color", "#036");
		$('#deshifr').hide();
		$('#analise').hide();
		$('#shifr').show();
		
		return false;
	});
	$('body').on('click', '#set-deshifr', function() {
		$('#set-shifr h2').css("border-bottom-color", "#036");
		$('#set-deshifr h2').css("border-bottom-color", "white");
		$('#set-analise h2').css("border-bottom-color", "#036");
		$('#shifr').hide();
		$('#analise').hide();
		$('#deshifr').show();
		return false;
	});
	$('body').on('click', '#set-analise', function() {
		$('#set-shifr h2').css("border-bottom-color", "#036");
		$('#set-deshifr h2').css("border-bottom-color", "#036");
		$('#set-analise h2').css("border-bottom-color", "white");
		$('#shifr').hide();
		$('#deshifr').hide();
		$('#analise').show();
		return false;
	});
	
	// закрытие всплывающего окна
	$('body').on('click', '#close-popup', function() {
		$('p.popup').parent().fadeOut("fast", function() {
			$(this).remove();
		});
		return false;
	});
	
	// при смене метода шифрования
	$('body').on('change', '#method', function() {
		met = $('#method').val();
		if (met == "method_caesar") {
			var old = $('#key').remove();
			$('#label-key').after("<input type=\"number\" name=\"key\" id=\"key\" value=\"3\" min=\"1\">");
			//type="number" name="key" id="key" value="3" min="1"
		}
		else {
			var old = $('#key').remove();
			$('#label-key').after("<input type=\"text\" name=\"key\" id=\"key\" required>");
		}
	});
	
	// генерация текста 
	$('body').on('click', '#text-generate-eng', function() {
		$.ajax({
			url: "ajax-lab1.php",
			data: {
				language: "eng",
				method: "generate"
			},
			success: function(status) {
				$('#text').val(status);
			},
			type: "POST",
			dataType: "text"
		});
	});
	$('body').on('click', '#text-generate-rus', function() {
		$.ajax({
			url: "ajax-lab1.php",
			data: {
				language: "rus",
				method: "generate"
			},
			success: function(status) {
				$('#text').val(status);
			},
			type: "POST",
			dataType: "text"
		});
	});
	
	// генерация значений
	$('body').on('click', '#gen-slozh', function() {
		$('#slozh-result').empty();
		$('#first-slozh').empty();
		var count = $('#slozh-num').val();
		for (var i=0; i<count; i++) {
			$('#first-slozh').append(Math.floor(Math.random() * 10));
		}
		$('#second-slozh').empty();
		for (var i=0; i<count; i++) {
			$('#second-slozh').append(Math.floor(Math.random() * 10));
		}
	});
	$('body').on('click', '#clear-slozh', function() {
		$('#first-slozh').empty();
		$('#second-slozh').empty();
		$('#slozh-result').empty();
	});
	$('body').on('click', '#gen-mult', function() {
		$('#mult-result').empty();
		$('#first-mult').empty();
		var count = $('#mult-num').val();
		for (var i=0; i<count; i++) {
			$('#first-mult').append(Math.floor(Math.random() * 10));
		}
		$('#second-mult').empty();
		for (var i=0; i<count; i++) {
			$('#second-mult').append(Math.floor(Math.random() * 10));
		}
	});
	$('body').on('click', '#clear-mult', function() {
		$('#first-mult').empty();
		$('#second-mult').empty();
		$('#mult-result').empty();
	});
	$('body').on('click', '#gen-div', function() {
		$('#div-result').empty();
		$('#first-div').empty();
		var count = $('#div-num').val();
		for (var i=0; i<count; i++) {
			$('#first-div').append(Math.floor(Math.random() * 10));
		}
		$('#second-div').empty();
		for (var i=0; i<count/2; i++) {
			$('#second-div').append(Math.floor(Math.random() * 10));
		}
	});
	$('body').on('click', '#clear-div', function() {
		$('#first-div').empty();
		$('#second-div').empty();
		$('#div-result').empty();
	});
	
	// при смене метода шифрования
	$('body').on('click', '#show-source-but', function() {
		$('#show-source').toggle("slow");
	});

});