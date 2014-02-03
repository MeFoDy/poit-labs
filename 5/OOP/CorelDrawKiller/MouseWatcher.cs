using System;
using System.Collections.Generic;
using System.Text;
using System.Windows.Forms;
using System.Drawing;

namespace CorelDrawKiller
{
	class MouseWatcher
	{
		public short Mode {
			get;
			set;
		}
		private bool isMouseDown = false;
		private List<Figure> figureList;
		public int currentFigure
		{
			get;
			set;
		}
		public Cursor cursor
		{
			set;
			get;
		}
		private Point setPoint = new Point();

		// 0 - move, 1 - leftTop, 2 - rightTop, 3 - leftBottom, 4 - rightBottom
		private int tranformMode = 0;

		public MouseWatcher(short curMode, List<Figure> curFigureList)
		{
			Mode = curMode;
			figureList = curFigureList;
			currentFigure = -1;
			cursor = Cursors.Cross;
		}

		public void MouseMove(object sender, MouseEventArgs e)
		{
			switch (Mode)
			{
				case CDKForm.MOUSE_WATCHER_SELECT:
					if (isMouseDown)
					{
						currentFigure = SearchSelectedFigure(sender, e);
						if (currentFigure != -1)
						{
							figureList[currentFigure].isBordered = true;
						}
					}
					break;
				case CDKForm.MOUSE_WATCHER_DELETE:
					break;
				case CDKForm.MOUSE_WATCHER_TRANSFORM:
					if (!isMouseDown)
					{
						cursor = SetCursor(sender, e);
					}
					if (isMouseDown && currentFigure > -1)
					{
						Figure figure = figureList[currentFigure];
						figureList[currentFigure] = SetFigurePoints(figure, sender, e);
					}
					break;
				default:
					break;
			}
		}

		private Figure SetFigurePoints(Figure figure, object sender, MouseEventArgs e)
		{
			// 0 - move, 1 - leftTop, 2 - rightTop, 3 - leftBottom, 4 - rightBottom
			Point oldSPoint;
			Point oldEPoint;


			switch (tranformMode)
			{
				case 0:

					oldSPoint = figure.GetStartPoint();
					oldEPoint = figure.GetEndPoint();
					figure.SetStartPoint(new Point(oldSPoint.X + e.X - setPoint.X, oldSPoint.Y + e.Y - setPoint.Y));
					figure.SetEndPoint(new Point(oldEPoint.X + e.X - setPoint.X, oldEPoint.Y + e.Y - setPoint.Y));
					setPoint.X = e.X;
					setPoint.Y = e.Y;

					break;
				case 1:
					oldSPoint = figure.GetStartPoint();
					oldEPoint = figure.GetEndPoint();
					if (oldSPoint.X < oldEPoint.X)
					{
						oldSPoint.X = e.X;
					}
					else
					{
						oldEPoint.X = e.X;
					}
					if (oldSPoint.Y < oldEPoint.Y)
					{
						oldSPoint.Y = e.Y;
					}
					else
					{
						oldEPoint.Y = e.Y;
					}
					figure.SetStartPoint(oldSPoint);
					figure.SetEndPoint(oldEPoint);

					break;
				case 2:
					oldSPoint = figure.GetStartPoint();
					oldEPoint = figure.GetEndPoint();
					if (oldSPoint.X > oldEPoint.X)
					{
						oldSPoint.X = e.X;
					}
					else
					{
						oldEPoint.X = e.X;
					}
					if (oldSPoint.Y < oldEPoint.Y)
					{
						oldSPoint.Y = e.Y;
					}
					else
					{
						oldEPoint.Y = e.Y;
					}
					figure.SetStartPoint(oldSPoint);
					figure.SetEndPoint(oldEPoint);
					break;
				case 3:
					oldSPoint = figure.GetStartPoint();
					oldEPoint = figure.GetEndPoint();
					if (oldSPoint.X < oldEPoint.X)
					{
						oldSPoint.X = e.X;
					}
					else
					{
						oldEPoint.X = e.X;
					}
					if (oldSPoint.Y > oldEPoint.Y)
					{
						oldSPoint.Y = e.Y;
					}
					else
					{
						oldEPoint.Y = e.Y;
					}
					figure.SetStartPoint(oldSPoint);
					figure.SetEndPoint(oldEPoint);
					break;
				case 4:
					oldSPoint = figure.GetStartPoint();
					oldEPoint = figure.GetEndPoint();
					if (oldSPoint.X > oldEPoint.X)
					{
						oldSPoint.X = e.X;
					}
					else
					{
						oldEPoint.X = e.X;
					}
					if (oldSPoint.Y > oldEPoint.Y)
					{
						oldSPoint.Y = e.Y;
					}
					else
					{
						oldEPoint.Y = e.Y;
					}
					figure.SetStartPoint(oldSPoint);
					figure.SetEndPoint(oldEPoint);
					break;
				default:
					break;
			}

			return figure;
		}

		public void MouseUp(object sender, MouseEventArgs e)
		{
			isMouseDown = false;
			switch (Mode)
			{
				// выбор фигуры на полотне
				case CDKForm.MOUSE_WATCHER_SELECT:
					currentFigure = SearchSelectedFigure(sender, e);
					if (currentFigure != -1)
					{
						figureList[currentFigure].isBordered = true;
						figureList[currentFigure].isSelected = true;
					}
					break;
				case CDKForm.MOUSE_WATCHER_DELETE:
					break;
				case CDKForm.MOUSE_WATCHER_TRANSFORM:
					cursor = SetCursor(sender, e);
					break;
				default:
					break;
			}
		}

		public void MouseDown(object sender, MouseEventArgs e)
		{
			isMouseDown = true;
			setPoint.X = e.X;
			setPoint.Y = e.Y;
			switch (Mode)
			{
				case CDKForm.MOUSE_WATCHER_SELECT:
					break;
				case CDKForm.MOUSE_WATCHER_DELETE:
					break;
				case CDKForm.MOUSE_WATCHER_TRANSFORM:
					cursor = SetCursor(sender, e);
					break;
				default:
					break;
			}
		}

		private int SearchSelectedFigure(object sender, MouseEventArgs e)
		{
			foreach (Figure figure in figureList)
			{
				figure.isBordered = false;
				figure.isSelected = false;
			}
			for (int i = figureList.Count - 1; i >= 0; i--)
			{
				if (((figureList[i].GetStartPoint().X < e.X && figureList[i].GetEndPoint().X > e.X)
					|| (figureList[i].GetStartPoint().X > e.X && figureList[i].GetEndPoint().X < e.X))
					&&
					((figureList[i].GetStartPoint().Y < e.Y && figureList[i].GetEndPoint().Y > e.Y)
					|| (figureList[i].GetStartPoint().Y > e.Y && figureList[i].GetEndPoint().Y < e.Y)))
				{
					return i;
				}
			}
			return -1;
		}

		private Cursor SetCursor(object sender, MouseEventArgs e)
		{
			if (currentFigure != -1)
			{
				Figure figure = figureList[currentFigure];
				Point startPoint = figure.GetStartPoint();
				Point finishPoint = figure.GetEndPoint();

				Point leftTopPoint = new Point();
				leftTopPoint.X = Math.Min(startPoint.X, finishPoint.X);
				leftTopPoint.Y = Math.Min(startPoint.Y, finishPoint.Y);
				Point rightBottomPoint = new Point();
				rightBottomPoint.X = Math.Max(startPoint.X, finishPoint.X);
				rightBottomPoint.Y = Math.Max(startPoint.Y, finishPoint.Y);

				cursor = Cursors.SizeAll;
				tranformMode = 0;

				if (e.X < leftTopPoint.X + 5 && e.X > leftTopPoint.X - 5 && e.Y < leftTopPoint.Y + 5 && e.Y > leftTopPoint.Y - 5)
				{
					cursor = Cursors.SizeNWSE;
					tranformMode = 1;
				}
				if (e.X < rightBottomPoint.X + 5 && e.X > rightBottomPoint.X - 5 && e.Y < leftTopPoint.Y + 5 && e.Y > leftTopPoint.Y - 5)
				{
					cursor = Cursors.SizeNESW;
					tranformMode = 2;
				}
				if (e.X < leftTopPoint.X + 5 && e.X > leftTopPoint.X - 5 && e.Y < rightBottomPoint.Y + 5 && e.Y > rightBottomPoint.Y - 5)
				{
					cursor = Cursors.SizeNESW;
					tranformMode = 3;
				}
				if (e.X < rightBottomPoint.X + 5 && e.X > rightBottomPoint.X - 5 && e.Y < rightBottomPoint.Y + 5 && e.Y > rightBottomPoint.Y - 5)
				{
					cursor = Cursors.SizeNWSE;
					tranformMode = 4;
				}

				return cursor;
			}
			return Cursors.SizeAll;
		}
	}
}
