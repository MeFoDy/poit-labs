using System;
using System.Collections.Generic;
using System.Text;

namespace TimeMachine
{
	class Day : TimeInterval
	{
		public Day()
		{
			name = "Days";
		}

		public override DateTime SubstractUnit(DateTime sourceTime, int count, int mult)
		{
			DateTime finalTime = sourceTime;
			finalTime = finalTime.AddDays(-1 * count * mult);

			return finalTime;
		}
	}
}