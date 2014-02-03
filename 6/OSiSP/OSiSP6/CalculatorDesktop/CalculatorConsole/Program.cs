using System;
using System.Collections.Generic;
using System.ServiceModel;
using CalculatorConsole.Calculator;

namespace CalculatorConsole
{
	static class Program
	{
		private delegate void ActionDelegate(ICalculatorService calculator);
		private static int RunMenu(IEnumerable<string> menu)
		{
			Console.WriteLine("\nPlease, choice:");
			var i = 0;
			foreach (var mn in menu)
			{
				Console.WriteLine("{0}. {1}", ++i, mn);
			}
			Console.Write('>');
			char key;
			do
			{
				key = Console.ReadKey(true).KeyChar;
			}
			while ((key < '1') || (key > i + 48));
			Console.WriteLine();
			return key - 49;
		}

		private static double ReadDouble()
		{
			double value;
			string str;
			do
			{
				str = Console.ReadLine();
			}
			while (!Double.TryParse(str, out value));
			return value;
		}
		private static void Add(ICalculatorService calculator)
		{
			Console.WriteLine("Enter a:");
			var a = ReadDouble();
			Console.WriteLine("Enter b:");
			var b = ReadDouble();
			var result = calculator.Add(a, b);
			Console.WriteLine("Result: " + result);
		}
		private static void Subtract(ICalculatorService calculator)
		{
			Console.WriteLine("Enter a:");
			var a = ReadDouble();
			Console.WriteLine("Enter b:");
			var b = ReadDouble();
			var result = calculator.Subtract(a, b);
			Console.WriteLine("Result: " + result);
		}
		private static void Multiply(ICalculatorService calculator)
		{
			Console.WriteLine("Enter a:");
			var a = ReadDouble();
			Console.WriteLine("Enter b:");
			var b = ReadDouble();
			var result = calculator.Multiply(a, b);
			Console.WriteLine("Result: " + result);
		}
		private static void Divide(ICalculatorService calculator)
		{
			Console.WriteLine("Enter a:");
			var a = ReadDouble();
			Console.WriteLine("Enter b:");
			var b = ReadDouble();
			var result = calculator.Divide(a, b);
			Console.WriteLine("Result: " + (Double.IsInfinity(result) ? "infinity" : Convert.ToString(result)));
		}

		private static void SaveVarInMemory(ICalculatorService calculator)
		{
			Console.WriteLine("Enter name:");
			var name = Console.ReadLine();
			Console.WriteLine("Enter value:");
			var value = ReadDouble();
			calculator.Save(name, value);
		}
		private static void RemoveVarFromMemory(ICalculatorService calculator)
		{
			Console.WriteLine("Enter name:");
			var name = Console.ReadLine();
			calculator.Clear(name);
		}
		private static void RemoveAllVarsFromMemory(ICalculatorService calculator)
		{
			calculator.ClearAll();
		}

		private static void Calculate(ICalculatorService calculator)
		{
			Console.WriteLine("Enter expression:");
			var name = Console.ReadLine();
			var result = calculator.Calculate(name);
			Console.WriteLine("Result: {0}", result);
		}

		private static bool _willClose;
		private static void Close(ICalculatorService calculator)
		{
			_willClose = true;
		}

		static void Main()
		{
			var actionsNames = new[] { "Add", "Subtract", "Multiply", "Divide", "Save", "Remove", "Remove All", "Calculate", "Exit" };
			var actions = new ActionDelegate[] {Add, Subtract, Multiply, Divide, SaveVarInMemory, RemoveVarFromMemory,
												RemoveAllVarsFromMemory, Calculate, Close};
			using (var calculator = new CalculatorServiceClient())
			{
				do
				{
					Console.Clear();
					var choice = RunMenu(actionsNames);
					try
					{
						actions[choice](calculator);
					}
					catch (FaultException fe)
					{
						Console.WriteLine("FaultException {0} with reason {1}", fe.Message, fe.Reason);
					}
					catch (Exception e)
					{
						Console.WriteLine("Error: " + e.Message);
					}
					Console.Write("\nPress any key to continue... ");
					Console.ReadKey(true);
				}
				while (!_willClose);
			}
		}
	}

}
