using System;
using System.Collections.Generic;
using System.Text;

namespace CorelDrawKiller
{
	class RectangleBuilder : Builder
	{
		public override Figure BuildFigure()
		{
			Figure figure = new Rectangle();
			return figure;
		}
	}
}
