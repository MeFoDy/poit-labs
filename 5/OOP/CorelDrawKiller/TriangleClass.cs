using System;
using System.Collections.Generic;
using System.Text;
using System.Drawing;

namespace CorelDrawKiller
{
	[Serializable]
	class Triangle : Figure
	{
		public Triangle()
		{
			figureName = "Triangle";
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
			Point firstPoint = new Point();
			Point secondPoint = new Point();
			Point thirdPoint = new Point();

			firstPoint = startPoint;
			secondPoint.Y = startPoint.Y;
			secondPoint.X = finishPoint.X;
			thirdPoint.X = startPoint.X + (secondPoint.X - firstPoint.X)/2;
			thirdPoint.Y = finishPoint.Y;
			Pen figurePen = new Pen(color, density);
			CDKForm.graphicsField.DrawPolygon(figurePen, new Point[] { firstPoint, secondPoint, thirdPoint });
			DrawBorder();
		}
	}
}
