using System;
using System.Collections.Generic;
using System.Text;

namespace TimeMachine
{
	class Hour : TimeInterval
	{
		public Hour()
		{
			name = "Hours";
		}

		public override DateTime SubstractUnit(DateTime sourceTime, int count, int mult)
		{
			DateTime finalTime = sourceTime;
			finalTime = finalTime.AddHours(-1 * count * mult);

			return finalTime;
		}
	}
}