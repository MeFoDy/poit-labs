using System;
using System.Collections.Generic;
using System.Text;

namespace TimeMachine
{
	class Month : TimeInterval
	{
		public Month()
		{
			name = "Months";
		}

		public override DateTime SubstractUnit(DateTime sourceTime, int count, int mult)
		{
			DateTime finalTime = sourceTime;
			finalTime = finalTime.AddMonths(-1 * count * mult);

			return finalTime;
		}
	}
}