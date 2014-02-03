using System;
using System.Collections.Generic;
using System.Text;
using System.IO;
using System.Text.RegularExpressions;
using System.Xml;
using System.Windows.Forms;

namespace MSSvIR
{
	public struct CodeToGraph
	{
		public List<int> input;
		public List<int> output;
		public int color;
		public string code;
	}

    public class ProgramToGraph
    {
        private StreamReader sourceFile;
        private string sourceCode = "";
		private CodeToGraph[] codeToGraphMas;
		private string fullCode = "";
		private string workPath;
		public string ololo;
		public int makkeibuMetric;
		public float chepinMetrics;
		public Dictionary<string, char> chepinLetters = new Dictionary<string,char>();
		public Dictionary<string, int> chepinMetr = new Dictionary<string, int>();
		private string sourceFilePath;
		private string formattedCode = "";
		private string mainFunction = "";
		private string stringId = "0";
		private string quoteId = "1";
		private Dictionary<string, int> spenMetrics;
		//private string variablePattern = @"\s*?([a-zA-Z_]+\w*\s+)+(,? *\*? *([a-zA-Z_]+\w*)( *\[.*\])* *(= *(.*))?)+;"; 
		//private string variablePattern = @"((<?[_a-zA-Z][_a-zA-Z0-9]*) *(<.*?>)?(\[.*?\])*?)+ +(<?[_a-zA-Z][_a-zA-Z0-9]*)\(?"; 
		private string variablePattern = @"([a-zA-Z_]\w* *(\[.*?\])*(\<.*?\>)* +)+(([a-zA-Z_]\w*)( *= *.*?)?);"; //группа 3 - имя переменной
		private string parameterPattern = @"\((,?.*? +([a-zA-Z_]\w*))+\)\s*\{"; //группа 2 - имя переменной
		private string functionPattern = @"([a-zA-Z_]\w*)\(([,\[\]\w ]*?)\)\s*{"; //группа 1 - имя функции, 2 - переменные в функции

		private string[] files = {
									 "ChepinForm.cs",
									 "MayersForm.cs",
									 "programToGraph.cs",
									 "SpenForm.cs",
									 "МССвИР.cs"
								 };

		public string[] classes;


		// подключение using и удаление комментариев
		private void ImitateInclude()
		{
			string text = sourceCode;
			string headerPattern = @"using.*?;";
			while (Regex.IsMatch(text, headerPattern) == true)
			{
				text = ClearComments(text);
				text = Regex.Replace(text, headerPattern, "");
			}
			fullCode = ClearComments(text);
		}

		// удаление комментариев из кода
		public string ClearComments(string text)
		{
			text = Regex.Replace(text, @"""//""", stringId);
			text = Regex.Replace(text, "//(.*?)\n", "");
			text = Regex.Replace(text, @"/\*(.|\s)*?\*/", "");
			return text;
		}

		// замена строк на идентифицирующую их последовательность
		private string StringReplace(string text)
		{
			text = Regex.Replace(text, @"@?""(?>\\""|.)*?""", stringId);
			text = Regex.Replace(text, @"'(?>\\\'|.)*?'", quoteId);
			return text;
		}

		// очистка от повторяющихся пробелов и табуляций
		public static string ClearDoubleTabAndSpaces(string text)
		{
			text = Regex.Replace(text, "\t+", " ");
			text = Regex.Replace(text, " +", " ");
			return text;
		}

		// добавление переводов строк, форматирование пробелов и табуляций
		public static string AddLineBreaks(string text)
		{
			text = Regex.Replace(text, @"([{}])", "\r\n$1\r\n "); //операторные скобки
			text = Regex.Replace(text, ";", ";\r\n"); //переводы строки после завешения команды
			text = Regex.Replace(text, @"for\s*\(\s*(.*?)\s*;\s*(.*?)\s*;\s*(.*)\s*\)", "for ( $1 ; $2 ; $3 )\r\n"); //исключения для for
			//долой повторяющиеся переводы строк
			text = Regex.Replace(text, @"\s*(\r\n)\s*", "\r\n");
			//красивое выравнивание
			int tabCount = 0;
			string tab;
			text = text.Insert(text.Length, " ");
			for (int i = 0; i < text.Length; i++)
			{
				tab = "";
				if (text[i] == '{')
				{
					tabCount++;
				}
				if (text[i] == '}')
				{
					tabCount--;
				}
				if (text[i] == '\n')
				{
					for (int j = 0; j < (text[i + 1] == '}' ? tabCount - 1 : tabCount); j++)
					{
						tab += "\t";
					}
					text = text.Insert(i + 1, tab);
				}
			}
			text = Regex.Replace(text, @"\( *", "(");
			text = Regex.Replace(text, @"(\w)\s*\(", "$1(");
			text = Regex.Replace(text, @" *([,;\)])", "$1");
			text = Regex.Replace(text, @"(\w)\s*((\-\-)|(\+\+))", "$1$2");
			text = Regex.Replace(text, @"(\-\-|\+\+)\s*(\w)", "$1$2");
			text = Regex.Replace(text, @"(for|while|if|switch|case|return|foreach)\(", "$1 (");
			return text;
		}

		// красивое расставление пробелов и табуляций
		public static string AddSpaceFormat(string text)
		{
			text = ClearDoubleTabAndSpaces(text);
			text = Regex.Replace(text, @"(\|\||==|>=|<=|=>|{|}|,|\&\&|!=)", " $1 "); //двойные операторы
			text = Regex.Replace(text, @"([%\^!;=<>+\-\*/\:\?\(\)\|\[\]])", " $1 "); //одиночные операторы
			//долой двойные пробелы и табуляции
			text = Regex.Replace(text, "\t", " ");
			text = Regex.Replace(text, " +", " ");
			//склеиваем двойные операторы обратно
			text = Regex.Replace(text, @"([\*=+!\^\-/\|\&|<|>])\s*=", "$1=");
			text = Regex.Replace(text, @"\+ \+", "++");
			text = Regex.Replace(text, @"\- \-", "--");
			text = Regex.Replace(text, @"\| \|", "||");
			text = Regex.Replace(text, @"\& \&", "&&");

			return text;
		}

		// получение имен всех классов
		private string[] GetClasses(string code)
		{
			string[] arr = new string[0];

			foreach (Match match in Regex.Matches(code, "class +[a-zA-Z_]*"))
			{
				Array.Resize(ref arr, arr.Length + 1);
				arr[arr.Length - 1] = Regex.Replace(match.Value, "class +([a-zA-Z_]*)", "$1");
			}

			return arr;
		}
		
		// получение тела класса
		public string GetClassBody(string text, string functionName)
		{
			int mainFunctionIndex = 0;
			string mainFunction = "";
			Regex rgx = new Regex("class *" + functionName + @".*\s+");
			foreach (Match match in rgx.Matches(text))
			{
				mainFunctionIndex = match.Index;
			}

			int endIndex = text.Length;
			int openedBrackets = 0;
			bool opened = false;
			for (int i = mainFunctionIndex; i < text.Length; i++)
			{
				if (text[i] == '{')
				{
					if (opened == false)
					{
						mainFunctionIndex = i;
					}
					openedBrackets++;
					opened = true;
				}
				if (text[i] == '}')
				{
					openedBrackets--;
				}
				if (opened && openedBrackets == 0)
				{
					endIndex = i;
					break;
				}
			}

			mainFunction = text.Substring(mainFunctionIndex, endIndex - mainFunctionIndex + 1);

			return mainFunction;
		}
		
		// установка исходного файла и чтение из него
		public ProgramToGraph()
		{
			// получаем наш код из всех файлов
			workPath = Environment.CurrentDirectory;
			workPath = workPath.Replace("bin\\Debug", "");
			foreach (string source in files)
			{
				sourceFile = new StreamReader(workPath + source);
				sourceCode += sourceFile.ReadToEnd();
				sourceFile.Close();
			}
			DoIt();
		}

		// метрика спена
		private Dictionary<string, int> SpenMetrics(string curClass)
		{
			Dictionary<string, int> variables = new Dictionary<string, int>();
			mainFunction = GetClassBody(fullCode, curClass);
			mainFunction += "\r\n";

			// получение имен переменных
			MatchCollection matchCollection = Regex.Matches(mainFunction, variablePattern);
			foreach (Match matches in matchCollection)
			{

				string varLine = matches.Value;
				if (Regex.IsMatch(varLine, "\\s*(return)\\s+")
					|| Regex.IsMatch(varLine, "\\s+(in)\\s+")
					|| Regex.IsMatch(varLine, "\\s*(if)\\s*"))
				{
					continue;
				}

				// \s*?([a-zA-Z_]+\w*\s+)+(,? *\*? *([a-zA-Z_]+\w*)( *\[.*\])* *(= *(.*))?)+;


				//Console.WriteLine("PEREM: {0}", str);
				string tempStr = Regex.Replace(varLine, @"\[.*?\]", "");
				tempStr = Regex.Replace(tempStr, @"= *(.*?)$", "");
				tempStr = tempStr.Replace(";", "");
				tempStr = Regex.Replace(tempStr, @" +", " ");
				tempStr = Regex.Replace(tempStr, @" *$", "");
				//Console.WriteLine("{0}", tempStr);
				string[] perems = tempStr.Split(new Char[] { ' ' });
				string perem = perems[perems.Length - 1];
				int key;
				if (variables.TryGetValue(perem, out key) == false)
				{
					variables.Add(perem, 0);
				}
			}
			matchCollection = Regex.Matches(mainFunction, parameterPattern);
			foreach (Match matches in matchCollection)
			{
				if (Regex.IsMatch(matches.Value, "\\s+(in)\\s+"))
				{
					continue;
				}

				string varLine1 = matches.Value;
				string[] strMas = varLine1.Split(',');

				foreach (string varLine2 in strMas)
				{
					string varLine = Regex.Replace(varLine2, parameterPattern, "$2");
					varLine = Regex.Replace(varLine2, parameterPattern, "$2");

					// \s*?([a-zA-Z_]+\w*\s+)+(,? *\*? *([a-zA-Z_]+\w*)( *\[.*\])* *(= *(.*))?)+;


					//Console.WriteLine("PEREM: {0}", str);
					
					//Console.WriteLine("{0}", tempStr);
					string[] perems = varLine.Split(new Char[] { ' ' });
					string perem = perems[perems.Length - 1];
					perem = Regex.Replace(perem, @"[^\w]", "");
					int key;
					if (perem == "false" || perem == "true")
					{
						continue;
					}
					if (variables.TryGetValue(perem, out key) == false)
					{
						variables.Add(perem, 0);
					}
				}


			}

			Dictionary<string, int> vars = new Dictionary<string, int>(variables);
			// подсчет количества вхождения для каждой переменной
			foreach (KeyValuePair<string, int> a in variables)
			{
				string pattern = @"[^a-zA-Z_0-9]" + a.Key + @"[^a-zA-Z_0-9]";
				vars[a.Key] = Regex.Matches(mainFunction, pattern).Count - 1;
			}

			/*foreach (KeyValuePair<string, int> a in vars)
			{
				Console.WriteLine("{0} : {1}", a.Key, a.Value);
			}*/
			//Console.WriteLine("**************************");
			return vars;
		}

		public Dictionary<string, int> GetSpenMetrics(string val)
		{
			return SpenMetrics(val);
		}

		internal Dictionary<string, int> GetChepMetrics(string p)
		{
			DoChepin(p);
			return chepinMetr;
		}

		// метрика Чепина
		private void DoChepin(string p)
		{
			string text = GetFullCode();
			string temp = mainFunction;

			mainFunction = GetClassBody(text, p);

			chepinMetr = SpenMetrics(p);
			foreach (KeyValuePair<string, int> val in chepinMetr)
			{
				string per = val.Key;
				chepinLetters.Add(per, 'P');

				if (Regex.IsMatch(mainFunction, per + @"\s*=\s*"))
				{
					chepinLetters[per] = 'M';
				}

				if (Regex.IsMatch(mainFunction, @"(if|for|while|switch|foreach)\s*?\(.*?" + per + @".*?\)\s*\{"))
				{
					chepinLetters[per] = 'C';
				}
			}

			mainFunction = temp;
		}

		// получение функций в классе
		public string[] GetFunctionsInClass(string className)
		{
			string[] masFunctions = { };

			string classBody = GetClassBody(fullCode, className);
			foreach (Match match in Regex.Matches(classBody, functionPattern))
			{
				string functionName = Regex.Replace(match.Value, functionPattern, "$1");
				Array.Resize<string>(ref masFunctions, masFunctions.Length + 1);
				masFunctions[masFunctions.Length - 1] = functionName;
			}

			return masFunctions;
		}
//##########################################################################################################################################
        

		// получение sourceCode
		public string GetSourceCode()
		{
			return sourceCode;
		}
		// получение fullCode
		public string GetFullCode()
		{
			return fullCode;
		}
		// получение formattedCode
		public string GetFormattedCode()
		{
			return formattedCode;
		}

		// получение массива вершина для метрики Майерса
		public CodeToGraph[] GetMayersArray()
		{
			return codeToGraphMas;
		}

		// приведение исходного кода к полному виду и парсинг
		/*
		 * Возможные развилки кода:
		 * - if (else) **** предусмотреть высокую вложенность
		 * - switch (case, default)
		 * - for
		 * - while
		 * - do ... while
		 * - foreach
		 * - try ... catch
		 * 
		 * */
		public void DoIt()
		{
			ImitateInclude();
			fullCode = StringReplace(fullCode);
			fullCode = AddSpaceFormat(fullCode);
			formattedCode = AddLineBreaks(fullCode);
			fullCode = formattedCode;

			classes = GetClasses(fullCode);
			
			//GetMayersNumber();

			//spenMetrics = SpenMetrics();

			//codeToGraphMas = DoCodeGraph(mainFunction);

			//DoChepin();

			//formattedCode = ololo;
			//formattedCode = mainFunction;
			//formattedCode = fullCode;
		}


		// получение тела функции
		private string GetFunctionBody(string text, string functionName)
		{
			int mainFunctionIndex = 0;
			string mainFunction = "";
			Regex rgx = new Regex(functionName + @"\(([,\[\]\w ]*?)\)\s*{");
			foreach (Match match in rgx.Matches(text))
			{
				mainFunctionIndex = match.Index;
			}

			int endIndex = text.Length;
			int openedBrackets = 0;
			bool opened = false;
			for (int i = mainFunctionIndex; i < text.Length; i++)
			{
				if (text[i] == '{')
				{
					if (opened == false)
					{
						mainFunctionIndex = i;
					}
					openedBrackets++;
					opened = true;
				}
				if (text[i] == '}')
				{
					openedBrackets--;
				}
				if (opened && openedBrackets == 0)
				{
					endIndex = i;
					break;
				}
			}

			mainFunction = text.Substring(mainFunctionIndex, endIndex - mainFunctionIndex + 1);

			return mainFunction;
		}
		
		// создание массива для вывода на форму Майерса
		private CodeToGraph[] DoCodeGraph(string text)
		{
			Console.WriteLine(text);
			Console.WriteLine("============================================================");
			CodeToGraph[] codeArray = new CodeToGraph[1];
			int countBrackets = 0;
			int count = 0;

			string currentCode = "";
			for (int i = 0; i < text.Length; i++)
			{
				if (text[i] == '{')
				{
					codeArray[count].color = countBrackets;
					codeArray[count].code = currentCode;
					codeArray[count].input = new List<int>();
					codeArray[count].output = new List<int>();
					Array.Resize(ref codeArray, ++count + 1);
					countBrackets++;
					currentCode = "";
					continue;
				}
				else
				{
					if (text[i] == '}')
					{
						codeArray[count].color = countBrackets;
						codeArray[count].code = currentCode;
						codeArray[count].input = new List<int>();
						codeArray[count].output = new List<int>();
						Array.Resize(ref codeArray, ++count + 1);
						countBrackets--;
						currentCode = "";
						continue;
					}
					else
					{
						currentCode += text[i];
					}
				}
			}
			codeArray[count].color = countBrackets;
			codeArray[count].code = "";
			codeArray[count].input = new List<int>();
			codeArray[count].output = new List<int>();

			codeToGraphMas = codeArray;

			// сохраняем связи между вершинами
			for (int i = 0; i < codeArray.Length-1; i++)
			{
				if (!codeArray[i].output.Contains(i + 1))
				{
					codeArray[i].output.Add(i + 1);
				}
				if (!codeArray[i].output.Contains(NextCodeNode(i, codeArray[i].color)) && (i!=0))
				{
					codeArray[i].output.Add(NextCodeNode(i, codeArray[i].color));
				}
				if (Regex.IsMatch(codeArray[i].code, @"\s*(while|for|foreach|do)\s*"))
				{
					if (!codeArray[i].input.Contains(i + 1))
					{
						codeArray[i].input.Add(i + 1);
						codeArray[i + 1].output.Clear();
					}
				}
				if (Regex.IsMatch(codeArray[i].code, @"\s*else\s*"))
				{
					codeArray[i - 1].output.Remove(i);
					if (!codeArray[i-1].output.Contains(NextCodeNode(i, codeArray[i].color)))
					{
						codeArray[i-1].output.Add(NextCodeNode(i, codeArray[i].color));
					}
				}
				if (Regex.IsMatch(codeArray[i].code, @"\s*return\s*"))
				{
					if (!codeArray[i].output.Contains(count))
					{
						codeArray[i].output.Add(count);
					}
				}
			}

			// делаем симметрию
			for (int i = 0; i < codeArray.Length - 1; i++)
			{
				foreach (int c in codeArray[i].input)
				{
					if (!codeArray[c].output.Contains(i))
					{
						codeArray[c].output.Add(i);
					}
				}
				foreach (int c in codeArray[i].output)
				{
					if (!codeArray[c].input.Contains(i))
					{
						codeArray[c].input.Add(i);
					}
				}
			}

			// убираем обратные связи для последней вершины
			codeArray[codeArray.Length - 1].output.Clear();

			// отладочная печать
			/*for (int i = 0; i < codeArray.Length - 1; i++)
			{
				Console.WriteLine("{0}======{1}=======", i, codeArray[i].color);
				foreach (int c in codeArray[i].output)
				{
					Console.Write("{0}   ", c);
				}
				Console.WriteLine(codeArray[i].code);
			}*/

			// считаем число маккейба
			int sum = 2;
			for (int i = 0; i < codeArray.Length - 1; i++)
			{
				sum += codeArray[i].output.Count - 1;
				if (Regex.IsMatch(codeArray[i].code, @"\s*(case|default)\s*"))
				{
					sum += Regex.Matches(codeArray[i].code, @"\s*(case|default)\s*").Count;
				}
			}
			makkeibuMetric = sum;

			return codeArray;
		}

		// метрика Майерса
		public int GetMayersNumber(string cl, string func) {

			string mainFunction = GetFunctionBody(GetClassBody(fullCode, cl), func);
			CodeToGraph[] codeCraph = DoCodeGraph(mainFunction);

			int sum = makkeibuMetric;
			string text = mainFunction;
			while (Regex.IsMatch(text, @"\s*(if|for|while|do|foreach)\s+"))
			{
				text = Regex.Replace(text, @"if\s*(\(.*?\))\s*\{", "<code>$1</code>");
				text = Regex.Replace(text, @"foreach\s*(\(.*?\))\s*\{", "<code>$1</code>");
				text = Regex.Replace(text, @"for\s*(\(.*?\))\s*\{", "<code>$1</code>");
				text = Regex.Replace(text, @"do\s*\{([^\{]*?)\}\s*while\s*\((.*?)\)\s*;", "<code>$2</code>");
				text = Regex.Replace(text, @"while\s*(\(.*?\))\s*\{", "<code>$1</code>");
			}
			//ololo = text;
			foreach (Match match in Regex.Matches(text, "<code>.*?</code>"))
			{
				sum += Regex.Matches(match.Value, @"((\&\&)|(\|\|))").Count;
			}

			return sum;
		}

		// следующая подобная по весу ветка
		private int NextCodeNode(int cur, int color)
		{
			do
			{
				cur++;
			} while (codeToGraphMas[cur].color > color);
			return cur;
		}

	}
}
