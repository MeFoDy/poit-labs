using System;
using System.Collections.Generic;
using System.Text;

namespace CorelDrawKiller
{
	class LineBuilder : Builder
	{
		public override Figure BuildFigure()
		{
			Figure figure = new Line();
			return figure;
		}
	}
}
