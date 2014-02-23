var workText = "";
var keywords = [];

function handleFileSelect(evt) {
	evt.stopPropagation();
	evt.preventDefault();
	var files = evt.dataTransfer.files; // FileList object.
	// files is a FileList of File objects. List some properties.
	var output = document.getElementById("output");
	for (var i = 0; i < files.length; i++) {
	  var file = files[i];
        //Only plain text
        if (!file.type.match('plain')) continue;
        var picReader = new FileReader();
        picReader.addEventListener("load", function(event) {
            var textFile = event.target;
            workText = textFile.result;
            keywords = getKeywords(workText);
			
			$('#searchRequest').val(keywords.join(" "));
        });
        //Read the text file
        picReader.readAsText(file);
	}
}

function getKeywords(input) {
	input = input.toLowerCase();
    var words = getWords(input);
	var hash = calcHash(input);
	var dataVar = secondCalc(hash, words);
	var keywords = dataVar.keywords;
	var result = [], i;
	for (i=0; i < keywords.length; i++) {
		result.push(keywords[i].word);
	}
	return result;
}

function handleDragOver(evt) {
	evt.stopPropagation();
	evt.preventDefault();
	evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
}

// Setup the dnd listeners.
var dropZone = document.getElementById('drop_zone');
dropZone.addEventListener('dragover', handleDragOver, false);
dropZone.addEventListener('drop', handleFileSelect, false);

function setOutput(data) {
	$("#output").hide(400, function(){
		$("#output").html(data).show(400);
	});
}

function setOutputF(func, scrollFunc) {
	$("#output").hide(400, function(){
		func();
		$("#output").show(400, scrollFunc);
	});
}

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
	$('#runButton').attr('disabled', 'disabled');
	var spinner = loadSpinner();

	keywords = $('#searchRequest').val().split(" ");
	loadTexts(urls, keywords);

	spinner.stop();
	$('#runButton').removeAttr('disabled');
	$('#spinner').remove();
}

function scroll2output() {
	$('html, body').animate({
        scrollTop: $("#output-row").offset().top
    }, 1000);
}

function calcCount(hash) {
	var rank = [];
	for (var key in hash){
	  if(hash.hasOwnProperty(key)){
	    rank.push(hash[key].count);
	  }
	}
	rank = rank.sort(function(a, b) {
		return a - b;
	}).unique().reverse();
	return rank;
}

function calcRank(hash) {
	var rank = [];
	for (var key in hash){
	  if(hash.hasOwnProperty(key)){
	    rank.push(hash[key].rank);
	  }
	}
	rank = rank.sort(function(a, b) {
		return a - b;
	}).unique().reverse();
	return rank;
}

function calcHash(data) {
	var words = getWords(data);
	var wordsCount = words.length;
	var hash = {};
	words.forEach(function(word) {
		if (hash[word]) {
			hash[word].count++;
		}
		else {
			hash[word] = {count: 1, rank: 0, variety: 0};
		}
	});
	var rank = calcCount(hash);

	for (var key in hash){
	  if (hash.hasOwnProperty(key)){
	    hash[key].rank = rank.indexOf(hash[key].count) + 1;
	    hash[key].variety = hash[key].count / wordsCount;
	  }
	}
	return hash;
}

function secondCalc(input, words) {
	var data = {
		labels : [],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				data : []
			}
		]
	}
	var rank = calcRank(input);
	var wc = words.length;
	for (var r in rank) {
		for (key in input){
		  if(input.hasOwnProperty(key) && input[key].rank == r) {
		    data.labels.push(r);
		    var el = input[key];
		    data.datasets[0].data.push(el.count / wc);
		    break;
		  }
		}
	}
	var keywords = [];
	for (var key in input){
		if(input.hasOwnProperty(key) 
			&& stopWords.indexOf(key) == -1) 
		{
			keywords.push({word: key, variety: input[key].variety});
		}
	}
	keywords.sort(function(a, b) {
		return b.variety - a.variety;
	});
	keywords = keywords.slice(0, 15);
	var dataVar = {data: data, keywords: keywords};
	return dataVar;
}

function getWords(data) {
	var punctuationless = data.replace(/[\.,\-—\/#!$%\^&\*;:{}=\-_`~()\?\"\>\<]/g," ");
	var words = punctuationless.split(/[\s\n\r]+/);
	return words;
}

function loadTexts(urls, keywords) {
	var gets = [], i, received_data = [];
    for (i=0; i<urls.length; i++) {
        gets.push($.ajax({
            type: 'GET',
            url: 'texts/' + urls[i],
            success: function(data) {
                received_data.push(data);
            }
        }));
    };

    $.when.apply($, gets).then(function() {
    	var results = [], i, j, k;
    	for (i=0; i<received_data.length; i++) {
    		var themes = getKeywords(received_data[i]);
    		var rank = 0;
    		for (j=0; j<keywords.length; j++)
    			for (k=0; k<themes.length; k++) 
    				if (themes[k].toLowerCase() == keywords[j].toLowerCase()) {
    					rank++;
    					break;
    				}
    		if (rank > 0) 
    			results.push({text: received_data[i], rank: rank / keywords.length});
    	}

    	results.sort(function(a, b) {
			return a.rank - b.rank;
		});
		keywords.sort(function(a, b) {
			return a.length - b.length;
		});
		for (var i = results.length - 1; i >= 0; i--) {
			for (var j = keywords.length - 1; j >= 0; j--) {
				var regex = new RegExp( '(' + keywords[j] + ')', 'gi' );
				results[i].text = results[i].text.replace(regex, "<span class=\"label label-info\">$1</span>");
			};
		};

    	setOutputF(function() {
			$("#output").html('');
    		for (var i = results.length - 1; i >= 0; i--) {
    			$("#output").append('<b>Релевантность '+ Math.floor(results[i].rank * 100) +'%</b>');
				$("#output").append('<pre class="well" style="height:150px; display: block">' + results[i].text + '</pre>');
    		};
    		$('#output .well').children('.label').children().removeAttr('class');
		}, scroll2output);
    });
}







Array.prototype.unique = function() {
    var unique = [];
    for (var i = 0; i < this.length; i++) {
        if (unique.indexOf(this[i]) == -1) {
            unique.push(this[i]);
        }
    }
    return unique;
};

var urls = ["eng1.txt", "eng2.txt", "eng3.txt", "eng4.txt", "eng5.txt", "eng6.txt", "eng7.txt", 
			"rus1.txt", "rus2.txt", "rus3.txt", "rus4.txt", "rus5.txt", "rus6.txt", ];

var stopWords = ["a", "about", "above", "after", "again", "against", "all", "am", "an", "and", "any", "are", "aren't", 
				 "as", "at", "be", "because", "been", "before", "being", "below", "between", "both", "but", "by", "can't", 
				 "cannot", "could", "couldn't", "did", "didn't", "do", "does", "doesn't", "doing", "don't", "down", "during", 
				 "each", "few", "for", "from", "further", "had", "hadn't", "has", "hasn't", "have", "haven't", "having", 
				 "he", "he'd", "he'll", "he's", "her", "here", "here's", "hers", "herself", "him", "himself", "his", "how", 
				 "how's", "i", "i'd", "i'll", "i'm", "i've", "if", "in", "into", "is", "isn't", "it", "it's", "its", 
				 "itself", "let's", "me", "more", "most", "mustn't", "my", "myself", "no", "nor", "not", "of", "off", 
				 "on", "once", "only", "or", "other", "ought", "our", "ours ", "ourselves", "out", "over", "own", "same", 
				 "shan't", "she", "she'd", "she'll", "she's", "should", "shouldn't", "so", "some", "such", "than", "that", 
				 "that's", "the", "their", "theirs", "them", "themselves", "then", "there", "there's", "these", "they", 
				 "they'd", "they'll", "they're", "they've", "this", "those", "through", "to", "too", "under", "until", 
				 "up", "very", "was", "wasn't", "we", "we'd", "we'll", "we're", "we've", "were", "weren't", "what", 
				 "what's", "when", "when's", "where", "where's", "which", "while", "who", "who's", "whom", "why", "why's", 
				 "with", "won't", "would", "wouldn't", "you", "you'd", "you'll", "you're", "you've", "your", "yours", 
				 "yourself", "yourselves", "а", "е", "и", "ж", "м", "о", "на", "не", "ни", "об", "но", "он", "мне", 
				 "мои", "мож", "она", "они", "оно", "мной", "много", "многочисленное", "многочисленная", 
				 "многочисленные", "многочисленный", "мною", "мой", "мог", "могут", "можно", "может", "можхо", "мор", 
				 "моя", "моё", "мочь", "над", "нее", "оба", "нам", "нем", "нами", "ними", "мимо", "немного", "одной", 
				 "одного", "менее", "однажды", "однако", "меня", "нему", "меньше", "ней", "наверху", "него", "ниже", 
				 "мало", "надо", "один", "одиннадцать", "одиннадцатый", "назад", "наиболее", "недавно", "миллионов", 
				 "недалеко", "между", "низко", "меля", "нельзя", "нибудь", "непрерывно", "наконец", "никогда", "никуда", 
				 "нас", "наш", "нет", "нею", "неё", "них", "мира", "наша", "наше", "наши", "ничего", "начала", "нередко", 
				 "несколько", "обычно", "опять", "около", "мы", "ну", "нх", "от", "отовсюду", "особенно", "нужно", 
				 "очень", "отсюда", "в", "во", "вон", "вниз", "внизу", "вокруг", "вот", "восемнадцать", "восемнадцатый", 
				 "восемь", "восьмой", "вверх", "вам", "вами", "важное", "важная", "важные", "важный", "вдали", "везде", 
				 "ведь", "вас", "ваш", "ваша", "ваше", "ваши", "впрочем", "весь", "вдруг", "вы", "все", "второй", "всем", 
				 "всеми", "времени", "время", "всему", "всего", "всегда", "всех", "всею", "всю", "вся", "всё", "всюду", 
				 "г", "год", "говорил", "говорит", "года", "году", "где", "да", "ее", "за", "из", "ли", "же", "им", 
				 "до", "по", "ими", "под", "иногда", "довольно", "именно", "долго", "позже", "более", "должно", 
				 "пожалуйста", "значит", "иметь", "больше", "пока", "ему", "имя", "пор", "пора", "потом", "потому", 
				 "после", "почему", "почти", "посреди", "ей", "два", "две", "двенадцать", "двенадцатый", "двадцать", 
				 "двадцатый", "двух", "его", "дел", "или", "без", "день", "занят", "занята", "занято", "заняты", 
				 "действительно", "давно", "девятнадцать", "девятнадцатый", "девять", "девятый", "даже", "алло", 
				 "жизнь", "далеко", "близко", "здесь", "дальше", "для", "лет", "зато", "даром", "первый", "перед", 
				 "затем", "зачем", "лишь", "десять", "десятый", "ею", "её", "их", "бы", "еще", "при", "был", "про", 
				 "процентов", "против", "просто", "бывает", "бывь", "если", "люди", "была", "были", "было", "будем", 
				 "будет", "будете", "будешь", "прекрасно", "буду", "будь", "будто", "будут", "ещё", "пятнадцать", 
				 "пятнадцатый", "друго", "другое", "другой", "другие", "другая", "других", "есть", "пять", "быть", 
				 "лучше", "пятый", "к", "ком", "конечно", "кому", "кого", "когда", "которой", "которого", "которая", 
				 "которые", "который", "которых", "кем", "каждое", "каждая", "каждые", "каждый", "кажется", "как", 
				 "какой", "какая", "кто", "кроме", "куда", "кругом", "с", "т", "у", "я", "та", "те", "уж", "со", 
				 "то", "том", "снова", "тому", "совсем", "того", "тогда", "тоже", "собой", "тобой", "собою", "тобою", 
				 "сначала", "только", "уметь", "тот", "тою", "хорошо", "хотеть", "хочешь", "хоть", "хотя", "свое", 
				 "свои", "твой", "своей", "своего", "своих", "свою", "твоя", "твоё", "раз", "уже", "сам", "там", 
				 "тем", "чем", "сама", "сами", "теми", "само", "рано", "самом", "самому", "самой", "самого", 
				 "семнадцать", "семнадцатый", "самим", "самими", "самих", "саму", "семь", "чему", "раньше", 
				 "сейчас", "чего", "сегодня", "себе", "тебе", "сеаой", "человек", "разве", "теперь", "себя", 
				 "тебя", "седьмой", "спасибо", "слишком", "так", "такое", "такой", "такие", "также", "такая", 
				 "сих", "тех", "чаще", "четвертый", "через", "часто", "шестой", "шестнадцать", "шестнадцатый", 
				 "шесть", "четыре", "четырнадцать", "четырнадцатый", "сколько", "сказал", "сказала", "сказать", 
				 "ту", "ты", "три", "эта", "эти", "что", "это", "чтоб", "этом", "этому", "этой", "этого", "чтобы", 
				 "этот", "стал", "туда", "этим", "этими", "рядом", "тринадцать", "тринадцатый", "этих", "третий", 
				 "тут", "эту", "суть", "чуть", "тысяч", "ў", "яго", "яму", "ён", "ці", "што", "ды", "і", "дзе", "аб", "сабе",
				 "таго", "каб", "тым", "усё", "усе"];