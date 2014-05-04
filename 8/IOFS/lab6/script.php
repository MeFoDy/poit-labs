<?php

define('KEYWORDS_COUNT', 10);

function getKeywords($text) {
	$stopWords = Array("a", "—", "about", "above", "after", "again", "against", "all", "am", "an", "and", "any", "are", "aren't", 
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
					 "таго", "каб", "тым", "усё", "усе");

	// SPLIT ONTO SENTENCES AND WORDS
	$sentences = preg_split('/(?<=[.?!])\s+(?=[a-zйцукенгшщзхъфывапролджэячсмитьбю])/i', $text);
	$words = preg_split('/([\s\-_,:;?!\/\(\)\[\]{}<>\r\n"]|(?<!\d)\.(?!\d))/',
	               $text, null, PREG_SPLIT_NO_EMPTY);
	foreach ($words as $key => $value) {
		$words[$key] = mb_strtolower($value, mb_detect_encoding($value));
	}

	// GET RANK OF EVERY WORD
	$dictionary = array_count_values($words);
	asort($dictionary);
	$counts = array_values($dictionary);
	$counts = array_unique($counts);
	sort($counts);
	$counts = array_reverse($counts);

	foreach ($dictionary as $key => $value) {
		$dictionary[$key] = Array(
			'rank' => array_search($value, $counts) 
			);
	}

	if (count($words) == 0)
		exit;

	$keywords = Array();
	$ranks = array_keys($counts);
	$ranks = array_chunk(array_reverse($ranks), round(count($ranks) * 3 / 4))[0];
	$ranks = array_reverse($ranks);

	for ($i=0; $i < count($ranks); $i++) { 
		foreach ($dictionary as $key => $value) {
			if ($value['rank'] == $ranks[$i] && !in_array($key, $stopWords)) 
				array_push($keywords, $key);
		}
	}
	$keywords = array_chunk($keywords, KEYWORDS_COUNT)[0];
	return $keywords;
}

$texts = json_decode(file_get_contents('texts.json'), true);
$categories = Array();
foreach ($texts as $text) {
	array_push($categories, $text['theme']);
}
$categories = array_unique($categories);

$keywords = Array();
$catKeywords = array_flip($categories);
foreach ($catKeywords as $key => $value) {
	$catKeywords[$key] = Array();
}
foreach ($texts as $key => $text) {
	$texts[$key]['keywords'] = getKeywords($text['text']);
	$catKeywords[$text['theme']] = array_merge(
		$catKeywords[$text['theme']], $texts[$key]['keywords']
		);
	$keywords = array_merge($keywords, $catKeywords[$text['theme']]);
}

$keywords = array_unique($keywords);
sort($keywords);

$w = Array();
foreach ($categories as $key => $category) {
	$w[$category] = Array();
	for ($i=0; $i <= count($keywords); $i++) { 
		$w[$category][$i] = 0;
	}
}

$flag = true;
while ($flag) {
	$flag = false;
	foreach ($texts as $text) {
		$vector = Array();
		for ($i=0; $i < count($keywords); $i++) { 
			if (array_search($keywords[$i], $text['keywords']) !== FALSE) {
				$vector[$i] = 1;
			} else {
				$vector[$i] = 0;
			}
		}
		$vector[count($keywords)] = 1;

		$theme = $text['theme'];
		$results = Array();
		foreach ($w as $key => $value) {
			$results[$key] = 0;
			for ($i=0; $i < count($vector); $i++) { 
				$results[$key] += $value[$i] * $vector[$i];
			}
		}
		foreach ($results as $key => $value) {
			if ($key != $theme && $value >= $results[$theme]) {
				$flag = true;
				for ($i=0; $i < count($vector); $i++) { 
					$w[$key][$i] -= $vector[$i];
				}
			}
			if ($flag) {
				for ($i=0; $i < count($vector); $i++) { 
					$w[$theme][$i] += $vector[$i];
				}
			}
		}
	}
}

$text = $_REQUEST['text'];
$keys = getKeywords($text);
$vector = Array();
for ($i=0; $i < count($keywords); $i++) { 
	if (array_search($keywords[$i], $keys) !== FALSE) {
		$vector[$i] = 1;
	} else {
		$vector[$i] = 0;
	}
}
$results = Array();
foreach ($w as $key => $value) {
	$results[$key] = 0;
	for ($i=0; $i < count($vector); $i++) { 
		$results[$key] += $value[$i] * $vector[$i];
	}
}
$max = array_values($results)[0];
$answer = array_keys($results)[0];
foreach ($results as $key => $value) {
	if ($value >= $max) {
		$answer = $key;
		$max = $value;
	}
}

echo $answer;
