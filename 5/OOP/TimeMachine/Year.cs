using System;
using System.Collections.Generic;
using System.Text;

namespace TimeMachine
{
	class Year : TimeInterval
	{
		public Year()
		{
			name = "Years";
		}

		public override DateTime SubstractUnit(DateTime sourceTime, int count, int mult)
		{
			DateTime finalTime = sourceTime;
			finalTime = finalTime.AddYears(-1 * count * mult);

			return finalTime;
		}
	}
}