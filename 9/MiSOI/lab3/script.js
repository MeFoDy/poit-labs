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
    $.post("script.php", {
        text: $('#source-text').val()
    }, function(data) {

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

function beforeSubmit() {
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        if (!$('#imageInput').val()) {
            $("#output").html("Шутите?");
            return false
        }

        var fsize = $('#imageInput')[0].files[0].size;
        var ftype = $('#imageInput')[0].files[0].type;

        switch (ftype) {
            case 'image/png':
            case 'image/gif':
            case 'image/jpeg':
            case 'image/pjpeg':
                break;
            default:
                $("#output").html("<b>" + ftype + "</b> Можно загружать только png, gif, jpeg!");
                return false
        }

        if (fsize > 10485760) {
            $("#output").html("<b>" + fsize + "</b> Ошена бальщой файл! <br />Уменьшите, пожалуйста, изображение.");
            return false
        }

        $('#submit-btn').hide();
        $('#loading-img').show();
        $("#output").html("");
    } else {
        $("#output").html("Обновите браузер, для работы необходим HTML5");
        return false;
    }
}

function changeMethod() {
    var method = $('#method').val();
    $('.params').hide();
    $('#' + method).show();
}

function afterSubmit() {
    $('#methods').show();
    changeMethod();
}

$(document).ready(function() {
    var options = {
        target: '#output',
        beforeSubmit: beforeSubmit,
        success: afterSubmit,
        resetForm: true
    };

    $('#MyUploadForm').submit(function() {
        $(this).ajaxSubmit(options);
        return false;
    });

    $('#methods').on('change', changeMethod);

    $('#justDoIt').on('click', function() {
        $('#loader-wrapper').fadeIn("fast");
        var method = $('#method').val();
        //var method = 'klaster';
        var imgPar = '';
        switch (method) {
            case 'histogram':
                imgPar = 'method=histogram';
                break;
            case 'gaussian':
                imgPar = 'method=gaussian&minMax=' + $('#param-minMax').val();
                break;
            case 'klaster':
                imgPar = 'method=klaster&c=' + $('#param-cKlaster').val() + '&grey=' + $('#param-greyKlaster').val();
                break;
            case 'gammaCorrect':
                imgPar = 'method=gammaCorrect&q=' + $('#param-q').val() + '&c=' + $('#param-c').val();
                break;
            case 'logCorrect':
                imgPar = 'method=logCorrect&cLog=' + $('#param-cLog').val();
                break;
            case 'lineContrastCorrect':
                imgPar = 'method=lineContrastCorrect&gmin=' + $('#param-gmin').val() + '&gmax=' + $('#param-gmax').val();
                break;
            case 'hfFilter':
                imgPar = 'method=hfFilter';
                break;
            case 'lfFilter':
                imgPar = 'method=lfFilter';
                break;
            case 'robertsFilter':
                imgPar = 'method=robertsFilter';
                break;
            default:
                imgPar = 'method=src';
                break;
        }
        $('#fksistagram').html("<img src='script.php?" + imgPar + "' width='500'>");
        $('#fksistagram img').on('load', function() {
            $('#loader-wrapper').fadeOut("fast");
        });
    });
});