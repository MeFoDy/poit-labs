using System;
using System.Collections.Generic;
using System.Text;

namespace CorelDrawKiller
{
	class UserFigureBuilder: Builder
	{
		private string figureName;
		private List<Figure> innerFigureList;

		public UserFigureBuilder(string userFigureName, List<Figure> figureList)
		{
			figureName = userFigureName;
			innerFigureList = new List<Figure>(figureList);
		}

		public override Figure BuildFigure()
		{
			Figure figure = new UserFigure(figureName, innerFigureList);

			return figure;
		}
	}
}
