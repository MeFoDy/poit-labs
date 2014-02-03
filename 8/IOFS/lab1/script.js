function loadEnglish() {
	loadSrc("texts/eng.txt");
}

function loadRus() {
	loadSrc("texts/rus.txt");
}

function loadBel() {
	loadSrc("texts/bel.txt");
}

function loadSrc(url) {
	setOutput("Нажмите \"Тест\" для расчета");
	var spinner = loadSpinner();
	$('#spinner').css('display', 'block');
	$.get( url, function( data ) {
	  $( "#source-text" ).val( data );
	})
	.done(function(){
		spinner.stop();
		$('#spinner').remove();
	});
}

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
	var spinner = loadSpinner();

	var input = $("#source-text").val().toLowerCase();
	var words = getWords(input);
	var hash = calcHash(input);
	var data = firstCalc(hash);
	var c = 0.0, i;
	for (var i=0; i<data.labels.length; i++) {
		c += data.datasets[0].data[i];
	}
	c /= data.labels.length;

	var dataVar = secondCalc(hash, words);

	setOutputF(function() {
		$("#output").html('<small><p>C = ' + c + '</p><p>График зависимости С от ранга:</p></small>');
		$("#output").append('<canvas id="myChart" width="800" height="200"></canvas>');
		var ctx = document.getElementById("myChart").getContext("2d");
		var myNewChart = new Chart(ctx).Line(data, {
			scaleFontSize : 10, 
			bezierCurve : false, 
			scaleOverride : true, 
			scaleStartValue : 0, 
			scaleSteps : 10, 
			scaleStepWidth : 0.05
		});

		$("#output").append('<small><p>График зависимости частоты от ранга:</p></small>');
		$("#output").append('<canvas id="myChart2" width="800" height="200"></canvas>');
		var ctx2 = document.getElementById("myChart2").getContext("2d");
		var myNewChart = new Chart(ctx2).Line(dataVar.data, {
			scaleFontSize : 10, 
			bezierCurve : false
		});
		var keywords = "<div class='twoCols well'><ul><strong>Ключевые слова:</strong>";
		for (var i=0; i<dataVar.keywords.length; i++) {
			var word = dataVar.keywords[i];
			if (stopWords.indexOf(word.word) == -1)
				keywords += "<li><small>" + word.word + " (" + (Math.floor(word.variety * 10000) / 10000) + ")</small></li>";
		}
		keywords += "</ul></div>";
		$("#output").append(keywords);
	}, scroll2output);

	spinner.stop();
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

function firstCalc(input) {
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
	for (var r in rank) {
		for (key in input){
		  if(input.hasOwnProperty(key) && input[key].rank == r) {
		    data.labels.push(r);
		    var el = input[key];
		    data.datasets[0].data.push(el.rank * el.variety);
		    break;
		  }
		}
	}
	return data;
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
	var subrankSize = Math.floor(rank.length / 2);
	var subRank = rank.slice(Math.floor(rank.length / 5), Math.floor(rank.length / 5) + subrankSize);
	for (var key in input){
		if(input.hasOwnProperty(key) && subRank.indexOf(input[key].rank) !== -1) {
			keywords.push({word: key, variety: input[key].variety});
		}
	}
	keywords.sort(function(a, b) {
		return b.variety - a.variety;
	});
	var dataVar = {data: data, keywords: keywords};
	return dataVar;
}


function getWords(data) {
	var punctuationless = data.replace(/[\.,-\/#!$%\^&\*;:{}=\-_`~()\?\"]/g," ");
	var words = punctuationless.split(/[\s\n\r]+/);
	return words;
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