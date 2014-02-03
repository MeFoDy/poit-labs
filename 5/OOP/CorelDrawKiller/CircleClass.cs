using System;
using System.Collections.Generic;
using System.Text;
using System.Drawing;

namespace CorelDrawKiller
{
	[Serializable]
	class Circle:Figure 
	{
		public Circle()
		{
			figureName = "Circle";
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
			Point leftTopPoint = new Point();
			leftTopPoint.X = Math.Min(startPoint.X, finishPoint.X);
			leftTopPoint.Y = Math.Min(startPoint.Y, finishPoint.Y);

			Pen figurePen = new Pen(color, density);
			CDKForm.graphicsField.DrawEllipse(figurePen
											, leftTopPoint.X, leftTopPoint.Y
											, Math.Abs(finishPoint.X - startPoint.X)
											, Math.Abs(finishPoint.Y - startPoint.Y));
			DrawBorder();
		}
	}
}
