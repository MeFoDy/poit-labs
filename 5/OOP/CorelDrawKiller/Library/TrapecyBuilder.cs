using System;
using System.Collections.Generic;
using System.Text;

namespace CorelDrawKiller
{
	class TrapecyBuilder : Builder
	{
		public override Figure BuildFigure()
		{
			Figure figure = new Trapecy();
			return figure;
		}
	}
}
