using System.Collections.Generic;
using System.Globalization;

namespace TestTracer
{
	class ConsoleView : View
	{
		const string SPACE = "|--";
		string _result;

		public ConsoleView(List<Tracer.Tracer.TracerLog> tL)
		{
			TracerLog = tL;
		}

		public override string Save()
		{
			_result = "";

			foreach (var tL in TracerLog)
			{
				_result += "Thread " + tL.TraceChilds[0].Info.ThreadId + "\n";

				CreateTree(SPACE, tL.TraceChilds);
			}

			return _result;
		}

		private void CreateTree(string space, List<Tracer.Tracer.TracerLog> curTracerLog)
		{
			foreach (var trace in curTracerLog)
			{
				_result += space + "Method {" + trace.Info.MethodName 
					+ "} {" + trace.Info.FileName 
					+ "} {" + trace.Info.ClassName 
					+ "} " + trace.Info.DeltaTime.ToString(CultureInfo.InvariantCulture) + "\n";
				
				if (trace.TraceChilds.Count > 0)
				{
					CreateTree(SPACE + space, trace.TraceChilds);
				}
			}
		}
	}
}
