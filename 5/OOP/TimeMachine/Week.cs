using System;
using System.Collections.Generic;
using System.Text;

namespace TimeMachine
{
	class Week : TimeInterval
	{
		public Week()
		{
			name = "Week";
		}

		public override DateTime SubstractUnit(DateTime sourceTime, int count, int mult)
		{
			DateTime finalTime = sourceTime;
			finalTime = finalTime.AddDays(-7 * count * mult);

			return finalTime;
		}
	}
}