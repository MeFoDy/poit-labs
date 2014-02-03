using System;
using System.Collections.Generic;
using System.Text;

namespace CorelDrawKiller
{
	class CircleBuilder:Builder
	{
		public override Figure BuildFigure()
		{
			Figure figure = new Circle();
			return figure;
		}
	}
}
