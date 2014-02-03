using System;
using System.Collections.Generic;
using System.Text;
using System.Drawing;
using System.Runtime.Serialization.Formatters.Binary;

namespace CorelDrawKiller
{
	[Serializable]
	public class Figure
	{
		protected Point startPoint, finishPoint; //ограничивающие точки
		protected Color color;
		protected float density;

		public bool isBordered { get; set; }
		public bool isSelected { get; set; }

		protected string figureName;
		public string FigureName
		{
			get { return figureName; }
		}

		public virtual void Draw() { } //собственно отрисовка фигуры

		public virtual void DrawBorder() { }

		public void SetStartPoint(Point start)
		{
			startPoint = start;
		}
		public Point GetStartPoint()
		{
			return startPoint;
		}

		public void SetEndPoint(Point endPoint)
		{
			finishPoint = endPoint;
		}
		public Point GetEndPoint()
		{
			return finishPoint;
		}

		public void SetFigurePen(Pen newPen)
		{
			color = newPen.Color;
			density = newPen.Width;
		}

	}
}
