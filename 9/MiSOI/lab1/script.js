function loadSpinner() {
	$('body').append('<div id="spinner" style="position: fixed; top: 0; left:0; width: 100%; height: 100%; background: #ccc; opacity: 0.5;"></div>');
	var opts = {
	  lines: 13, // The number of lines to draw
	  length: 20, // The length of each line
	  width: 10, // The line thickness
	  radius: 30, // The radius of the inner circle
	  corners: 1, // Corner roundness (0..1)
	  rotate: 0, // The rotation offset
	  direction: 1, // 1: clockwise, -1: counterclockwise
	  color: '#000', // #rgb or #rrggbb or array of colors
	  speed: 1, // Rounds per second
	  trail: 60, // Afterglow percentage
	  shadow: false, // Whether to render a shadow
	  hwaccel: false, // Whether to use hardware acceleration
	  className: 'spinner', // The CSS class to assign to the spinner
	  zIndex: 2e9, // The z-index (defaults to 2000000000)
	  top: 'auto', // Top position relative to parent in px
	  left: 'auto' // Left position relative to parent in px
	};
	var target = document.getElementById('spinner');
	var spinner = new Spinner(opts).spin(target);
	return spinner;
}

function run() {
	var spinner = loadSpinner();
	$.post( "script.php", { text: $('#source-text').val() }, function( data ) {
		
		$('#output').html(data);

		spinner.stop();
		$('#spinner').remove();
		scroll2output();
	});
}

function scroll2output() {
	$('html, body').animate({
        scrollTop: $("#output-row").offset().top
    }, 1000);
}
