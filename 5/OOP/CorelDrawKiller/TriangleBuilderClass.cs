using System;
using System.Collections.Generic;
using System.Text;

namespace CorelDrawKiller
{
	class TriangleBuilder : Builder
	{
		public override Figure BuildFigure()
		{
			Figure figure = new Triangle();
			return figure;
		}
	}
}
