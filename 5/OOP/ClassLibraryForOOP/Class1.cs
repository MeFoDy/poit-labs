using System;
using System.Collections.Generic;
using System.Text;

namespace CorelDrawKiller
{
	class UserFigure : Figure
	{
		private List<Figure> innerFigureList;

		public UserFigure(string userFigureName, List<Figure> figureList)
		{
			figureName = userFigureName;
			innerFigureList = new List<Figure>(figureList);
		}

		public override void Draw()
		{
			Point leftTop = new Point(99999999, 99999999), rightBottom = new Point(-99999999, -99999999);
			foreach (Figure innerFigure in innerFigureList)
			{
				leftTop.X = Math.Min(innerFigure.GetStartPoint().X, leftTop.X);
				leftTop.X = Math.Min(innerFigure.GetEndPoint().X, leftTop.X);
				leftTop.Y = Math.Min(innerFigure.GetStartPoint().Y, leftTop.Y);
				leftTop.Y = Math.Min(innerFigure.GetEndPoint().Y, leftTop.Y);
				rightBottom.X = Math.Max(innerFigure.GetStartPoint().X, rightBottom.X);
				rightBottom.X = Math.Max(innerFigure.GetEndPoint().X, rightBottom.X);
				rightBottom.Y = Math.Max(innerFigure.GetStartPoint().Y, rightBottom.Y);
				rightBottom.Y = Math.Max(innerFigure.GetEndPoint().Y, rightBottom.Y);
			}

			foreach (Figure innerFigure in innerFigureList)
			{
				//Console.WriteLine(innerFigure.FigureName);
				Point tempStartPoint = innerFigure.GetStartPoint(), tempEndPoint = innerFigure.GetEndPoint();

				tempStartPoint.X -= leftTop.X;
				tempStartPoint.Y -= leftTop.Y;
				tempEndPoint.X -= leftTop.X;
				tempEndPoint.Y -= leftTop.Y;

				float scaleX = (float)(finishPoint.X - startPoint.X) / (rightBottom.X - leftTop.X);
				float scaleY = (float)(finishPoint.Y - startPoint.Y) / (rightBottom.Y - leftTop.Y);

				tempStartPoint.X = (int)(startPoint.X + scaleX * tempStartPoint.X);
				tempStartPoint.Y = (int)(startPoint.Y + scaleY * tempStartPoint.Y);

				tempEndPoint.X = (int)(startPoint.X + scaleX * tempEndPoint.X);
				tempEndPoint.Y = (int)(startPoint.Y + scaleY * tempEndPoint.Y);

				Point savedStart = innerFigure.GetStartPoint();
				Point savedEnd = innerFigure.GetEndPoint();

				innerFigure.SetStartPoint(tempStartPoint);
				innerFigure.SetEndPoint(tempEndPoint);

				innerFigure.SetFigurePen(figurePen);
				innerFigure.Draw();

				innerFigure.SetStartPoint(savedStart);
				innerFigure.SetEndPoint(savedEnd);
			}
		}
	}
}
