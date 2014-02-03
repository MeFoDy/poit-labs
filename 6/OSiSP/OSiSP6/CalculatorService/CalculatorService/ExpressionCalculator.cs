using System;
using System.Collections.Generic;

namespace CalculatorService
{
	static class ExpressionCalculator
	{
		private static Dictionary<string, double> _variables;

		public static double Calculate(string expression, Dictionary<string, double> variables = null)
		{
			_variables = variables ?? new Dictionary<string, double>();
			return Calc(expression);
		}

		private static double Calc(string s)
		{
			s = '(' + s + ')';
			var operands = new Stack<double>();
			var operations = new Stack<char>();
			var pos = 0;
			object token;
			do
			{
				token = GetToken(s, ref pos);

				if (token is double) // Если операнд
				{
					operands.Push((double)token); // то просто кидаем в стек
				}
				else if (token is char) // Если операция
				{
					if ((char)token == ')')
					{
						// Скобка - исключение из правил. выталкивает все операции до первой открывающейся
						while (operations.Count > 0 && operations.Peek() != '(')
							PopFunction(operands, operations);
						operations.Pop(); // Удаляем саму скобку "("
					}
					else
					{
						while (CanPop((char)token, operations)) // Если можно вытолкнуть
							PopFunction(operands, operations); // то выталкиваем
						operations.Push((char)token); // Кидаем новую операцию в стек
					}
				}
			}
			while (token != null);

			if (operands.Count > 1 || operations.Count > 0)
				throw new Exception("Error parsing expression");

			return operands.Pop();
		}

		private static void PopFunction(Stack<double> operands, Stack<char> functions)
		{
			var b = operands.Pop();
			var a = operands.Pop();
			switch (functions.Pop())
			{
				case '+': operands.Push(a + b);
					break;
				case '-': operands.Push(a - b);
					break;
				case '*': operands.Push(a * b);
					break;
				case '/': operands.Push(a / b);
					break;
			}
		}
		private static bool CanPop(char op1, Stack<char> functions)
		{
			if (functions.Count == 0)
				return false;
			var p1 = GetPriority(op1);
			var p2 = GetPriority(functions.Peek());

			return p1 >= 0 && p2 >= 0 && p1 >= p2;
		}
		private static int GetPriority(char op)
		{
			switch (op)
			{
				case '(':
					return -1; // не выталкивает сам и не дает вытолкнуть себя другим
				case '*':
				case '/':
					return 1;
				case '+':
				case '-':
					return 2;
				default:
					throw new Exception("Unsupported operation");
			}
		}

		private static object GetToken(string s, ref int pos)
		{
			ReadWhiteSpace(s, ref pos);

			if (pos == s.Length) // конец строки
				return null;
			if (char.IsDigit(s[pos]))
				return Convert.ToDouble(ReadDouble(s, ref pos));
			if (char.IsLetter(s[pos]))
				return ReadVariable(s, ref pos);
			return ReadFunction(s, ref pos);
		}

		private static double ReadVariable(string s, ref int pos)
		{
			var variable = "";
			while (pos < s.Length && (char.IsLetterOrDigit(s[pos])))
				variable += s[pos++];

			if (!_variables.ContainsKey(variable))
				throw new Exception(string.Format("Variable '{0}' isn't exist", variable));
			return _variables[variable];
		}
		private static char ReadFunction(string s, ref int pos)
		{
			return s[pos++];
		}
		private static string ReadDouble(string s, ref int pos)
		{
			var result = "";
			while (pos < s.Length && (char.IsDigit(s[pos]) || s[pos] == '.'))
				result += s[pos++];

			return result;
		}
		private static void ReadWhiteSpace(string s, ref int pos)
		{
			while (pos < s.Length && char.IsWhiteSpace(s[pos]))
				pos++;
		}
	}

}
