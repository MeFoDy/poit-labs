using System.Runtime.Serialization;
using System.ServiceModel;

namespace CalculatorService
{
	[ServiceContract(Namespace = "Calculator", SessionMode = SessionMode.Required)]
	public interface ICalculatorService
	{
		[OperationContract]
		string Test(int value);

		[OperationContract]
		void ExceptionTest();

		[OperationContract]
		double Add(double a, double b);

		[OperationContract]
		double Subtract(double a, double b);

		[OperationContract]
		double Multiply(double a, double b);

		[OperationContract]
		double Divide(double a, double b);

		[OperationContract]
		[FaultContract(typeof(ExceptionData))]
		double Calculate(string expression);

		[OperationContract]
		void Save(string name, double value);

		[OperationContract]
		void Clear(string name);

		[OperationContract]
		void ClearAll();
	}

	[DataContract]
	public class ExceptionData
	{
		[DataMember]
		public string ErrorMessage { get; set; }
		[DataMember]
		public string ErrorDetails { get; set; }
	}
}
