using System.Collections.Generic;

namespace TestTracer
{
	abstract class View
	{
		protected List<Tracer.Tracer.TracerLog> TracerLog;

		public abstract string Save();

	}
}
