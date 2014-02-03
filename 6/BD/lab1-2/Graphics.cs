using System.Globalization;
using System.Drawing;
using System.Windows.Forms;

namespace Lab1_2
{
	class Graphic
	{
		Point _lt, _rt, _lb, _rb;
		Point _currentPoint;

		Bitmap _tempBitmapHash1; 
		Graphics _graphHash1;
		readonly PictureBox _hash1Box;

		public Graphic(Bitmap tempBitmapHash1, Graphics graphHash1, PictureBox hash1Box)
		{
			_tempBitmapHash1 = tempBitmapHash1;
			_graphHash1 = graphHash1;
			_hash1Box = hash1Box;
			PrepareGraphs();
			_currentPoint = _lb;
		}

		private void PrepareGraphs()
		{
			var axiesPen = new Pen(Color.DarkBlue, 2);
			var gridPen = new Pen(Color.LightGray, 1);
			const int borderRate = 15;
			var axiesFont = new Font("Arial", 8);

			// ==== подготовка бокса
			_tempBitmapHash1 = new Bitmap(_hash1Box.Width, _hash1Box.Height);
			_graphHash1 = Graphics.FromImage(_tempBitmapHash1);

			_lt.X = borderRate; _lt.Y = borderRate;
			_rt.X = _tempBitmapHash1.Width - borderRate; _rt.Y = borderRate;
			_lb.X = borderRate; _lb.Y = _tempBitmapHash1.Height - borderRate;
			_rb.X = _tempBitmapHash1.Width - borderRate; _rb.Y = _tempBitmapHash1.Height - borderRate;
			var graphSize = new Point(_rt.X - _lt.X, _rt.Y - _lt.Y);

			// рисование сетки
			_graphHash1.DrawLine(gridPen, _rt, _rb);
			_graphHash1.DrawLine(gridPen, _rt, _lt);
			_graphHash1.DrawLine(gridPen, new Point(_lb.X + graphSize.X / 4 * 3, _lb.Y), new Point(_lb.X + graphSize.X / 4 * 3, _lt.Y));
			_graphHash1.DrawLine(gridPen, new Point(_lb.X + graphSize.X / 4 * 2, _lb.Y), new Point(_lb.X + graphSize.X / 4 * 2, _lt.Y));
			_graphHash1.DrawLine(gridPen, new Point(_lb.X + graphSize.X / 4 * 1, _lb.Y), new Point(_lb.X + graphSize.X / 4 * 1, _lt.Y));

			// рисование осей
			_graphHash1.DrawLine(axiesPen, _lb, _rb);
			_graphHash1.DrawLine(axiesPen, _lb, _lt);
			// выводим подписи осей
			var packCount = Data.MaxPackCount;
			_graphHash1.DrawString(packCount.ToString(CultureInfo.InvariantCulture), axiesFont, new SolidBrush(Color.Black), _rb.X - 25, _rb.Y);
			packCount /= 10;
			_graphHash1.DrawString(packCount.ToString(CultureInfo.InvariantCulture), axiesFont, new SolidBrush(Color.Black), _lb.X + graphSize.X / 4 * 3 - 15, _rb.Y);
			packCount /= 10;
			_graphHash1.DrawString(packCount.ToString(CultureInfo.InvariantCulture), axiesFont, new SolidBrush(Color.Black), _lb.X + graphSize.X / 4 * 2 - 10, _rb.Y);
			packCount /= 10;
			_graphHash1.DrawString(packCount.ToString(CultureInfo.InvariantCulture), axiesFont, new SolidBrush(Color.Black), _lb.X + graphSize.X / 4 * 1 - 7, _rb.Y);
			packCount /= 10;
			_graphHash1.DrawString(packCount.ToString(CultureInfo.InvariantCulture), axiesFont, new SolidBrush(Color.Black), _lb.X - 3, _rb.Y);

			// выводим на экран
			_hash1Box.Image = _tempBitmapHash1;

		}

		public void DrawNewStat(long x, double y)
		{
			_graphHash1 = Graphics.FromImage(_tempBitmapHash1);

			var linePen = new Pen(Color.Coral, 2);
			var newPoint = new Point
				{
					X = _lb.X + (int) (((double) (x + 1)/Data.PacketCountArray.Length)*(_rt.X - _lt.X)),
					Y = _lb.Y + (int) ((y/100.0)*(_lt.Y - _lb.Y))
				};
			if (_currentPoint.X == _lb.X)
			{
				_currentPoint.Y = newPoint.Y;
			}

			_graphHash1.DrawLine(linePen, _currentPoint, newPoint);

			_currentPoint = newPoint;

			_hash1Box.Image = _tempBitmapHash1;
		}

		public void DrawYMaxStat(long y)
		{
			var axiesFont = new Font("Arial", 8);
			_graphHash1.DrawString(y.ToString(CultureInfo.InvariantCulture), axiesFont, new SolidBrush(Color.Black), _lb.X + 1, _lt.Y + 1);
		}
	}
}
