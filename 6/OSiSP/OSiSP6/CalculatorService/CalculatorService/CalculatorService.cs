using System;
using System.Collections.Generic;
using System.Linq;
using System.ServiceModel;

namespace CalculatorService
{
	public class CalculatorService : ICalculatorService
	{
		private int _value;
		public string Test(int value)
		{
			return "Your value: " + ++_value;
		}

		public void ExceptionTest()
		{
			throw new FaultException("Test exception");
		}

		private readonly Dictionary<string, double> _vars = new Dictionary<string, double>(); 

		public double Add(double a, double b)
		{
			return a + b;
		}
		public double Subtract(double a, double b)
		{
			return a - b;
		}
		public double Multiply(double a, double b)
		{
			return a*b;
		}
		public double Divide(double a, double b)
		{
			return a/b;
		}

		public void Save(string name, double value)
		{
			if (!char.IsLetter(name[0]) || name.Count(symbol => !char.IsLetterOrDigit(symbol)) != 0)
				throw new FaultException("Wrong variable name", 
					new FaultCode("Save exception"));
			_vars.Add(name, value);
		}
		public void Clear(string name)
		{
			_vars.Remove(name);
		}
		public void ClearAll()
		{
			_vars.Clear();
		}

		public double Calculate(string expression)
		{
			try
			{
				return ExpressionCalculator.Calculate(expression, _vars);
			}
			catch (Exception e)
			{
				throw new FaultException(e.Message, new FaultCode("Calculate Exception"));
			}
		}

	}
}
