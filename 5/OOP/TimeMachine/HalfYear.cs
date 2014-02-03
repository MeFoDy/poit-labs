using System;
using System.Collections.Generic;
using System.Text;

namespace TimeMachine
{
	class HalfYear : TimeInterval
	{
		public HalfYear()
		{
			name = "HalfYears";
		}

		public override DateTime SubstractUnit(DateTime sourceTime, int count, int mult)
		{
			DateTime finalTime = sourceTime;
			finalTime = finalTime.AddMonths(-6 * count * mult);

			return finalTime;
		}
	}
}