using System;
using System.Collections.Generic;
using System.Text;
using System.Drawing;

namespace CorelDrawKiller
{
	[Serializable]
	class UserFigure : Figure
	{
		private List<Figure> innerFigureList;

		public UserFigure(string userFigureName, List<Figure> figureList)
		{
			figureName = userFigureName;
			innerFigureList = new List<Figure>(figureList);
		}

		public override void DrawBorder()
		{
			if (isBordered)
			{
				Point leftTopPoint = new Point();
				leftTopPoint.X = Math.Min(startPoint.X, finishPoint.X);
				leftTopPoint.Y = Math.Min(startPoint.Y, finishPoint.Y);

				Pen figurePen = new Pen(Color.Aqua, 1);
				CDKForm.graphicsField.DrawRectangle(figurePen
												, leftTopPoint.X, leftTopPoint.Y
												, Math.Abs(finishPoint.X - startPoint.X)
												, Math.Abs(finishPoint.Y - startPoint.Y));

				if (isSelected)
				{
					SolidBrush myBrush = new SolidBrush(Color.Blue);
					CDKForm.graphicsField.FillRectangle(myBrush, startPoint.X - 2, startPoint.Y - 2, 4, 4);
					CDKForm.graphicsField.FillRectangle(myBrush, startPoint.X - 2, finishPoint.Y - 2, 4, 4);
					CDKForm.graphicsField.FillRectangle(myBrush, finishPoint.X - 2, startPoint.Y - 2, 4, 4);
					CDKForm.graphicsField.FillRectangle(myBrush, finishPoint.X - 2, finishPoint.Y - 2, 4, 4);
				}
			}
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

				Pen figurePen = new Pen(color, density);
				innerFigure.SetFigurePen(figurePen);
				innerFigure.Draw();

				innerFigure.SetStartPoint(savedStart);
				innerFigure.SetEndPoint(savedEnd);
			}
			DrawBorder();
		}
	}
}
