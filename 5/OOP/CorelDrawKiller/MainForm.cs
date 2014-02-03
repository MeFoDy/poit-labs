using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.IO;
using System.Runtime.Serialization.Formatters.Binary;
using System.Reflection;

namespace CorelDrawKiller
{
	public partial class CDKForm : Form
	{
		public const short MOUSE_WATCHER_SELECT = 0;
		public const short MOUSE_WATCHER_TRANSFORM = 1;
		public const short MOUSE_WATCHER_DELETE = -1;

		MouseWatcher mouseWatcher = new MouseWatcher(MOUSE_WATCHER_SELECT, new List<Figure>());

		private static Pen currentPen;
		public static Graphics graphicsField;

		private static Color globalShapeColor;
		public static Color GlobalShapeColor 
		{
			get { return globalShapeColor; }
			set { globalShapeColor = value; }
		} //цвет фигуры

		private static int globalShapeThikness;
		public static int GlobalShapeThikness
		{
			get { return globalShapeThikness; }
			set { globalShapeThikness = value; }
		} //толщина линии

		private Figure currentFigure = new Circle(); //текущая фигура
		private int currentIndexOfBuilder = 0;

		private bool isMouseDown = false;
		private bool isMouseWatcherMode = false;

		private Builder[] buildersSet = new Builder[4]; //набор билдеров для создания каждой фигуры отдельно

		private List<Figure> figureList = new List<Figure>();
		private MyMemento myMemento = new MyMemento();

		private Bitmap tempBitmap;

		public CDKForm()
		{
			InitializeComponent();

			tempBitmap = new Bitmap(DrawWindow.Width, DrawWindow.Height);

			graphicsField = Graphics.FromImage(tempBitmap);
			DrawWindow.MouseDown += new MouseEventHandler(DrawWindow_MouseDown);
			DrawWindow.MouseUp += new MouseEventHandler(DrawWindow_MouseUp);
			DrawWindow.MouseMove += new MouseEventHandler(DrawWindow_MouseMove);

			GlobalShapeColor = Color.Black;
			GlobalShapeThikness = 5;
			currentPen = new Pen(GlobalShapeColor, GlobalShapeThikness);

			ColorDisplayBlock.BackColor = GlobalShapeColor;
			BrushThiknessTrackBar.Value = GlobalShapeThikness;
			BrushThiknessText.Text = BrushThiknessTrackBar.Value.ToString();
			BrushThiknessTrackBar.Scroll += new System.EventHandler(TrackBarScroll);

			toolList.Items.Insert(0, "Circle");
			toolList.Items.Insert(1, "Line");
			toolList.Items.Insert(2, "Rectangle");
			toolList.Items.Insert(3, "Triangle");

			buildersSet[0] = new CircleBuilder();
			buildersSet[1] = new LineBuilder();
			buildersSet[2] = new RectangleBuilder();
			buildersSet[3] = new TriangleBuilder();

			toolList.SelectedIndex = 0;

			LoadingLibraryProc();
		}

		// отрисовка уже нарисованного изображения
		private void PaintSavedImage()
		{
			graphicsField.Clear(Color.White);
			foreach (Figure figure in figureList)
			{
				figure.Draw();
				//Console.WriteLine(figure.FigureName);
			}
			DrawWindow.Invalidate();
		}

		void DrawWindow_MouseMove(object sender, MouseEventArgs e)
		{
			graphicsField = Graphics.FromImage(tempBitmap);
			if (isMouseDown)
			{
				if (!isMouseWatcherMode)
				{
					Point endPoint = new Point(e.X, e.Y);
					currentFigure.SetEndPoint(endPoint);

					PaintSavedImage();

					currentFigure.Draw();
				}
				else
				{
					mouseWatcher.MouseMove(sender, e);
					PaintSavedImage();
				}
			}
			else
			{
				if (isMouseWatcherMode)
				{
					mouseWatcher.MouseMove(sender, e);
					PaintSavedImage();
				}
			}
			DrawWindow.Cursor = mouseWatcher.cursor;
			DrawWindow.Image = tempBitmap;
		}
		
		void DrawWindow_MouseUp(object sender, MouseEventArgs e)
		{
			graphicsField = Graphics.FromImage(tempBitmap);

			isMouseDown = false;

			if (!isMouseWatcherMode)
			{
				Point endPoint = new Point(e.X, e.Y);
				currentFigure.SetEndPoint(endPoint);
				figureList.Add(currentFigure);
			}
			else
			{
				mouseWatcher.MouseUp(sender, e);
			}

			if (!isMouseWatcherMode || (isMouseWatcherMode && mouseWatcher.Mode != MOUSE_WATCHER_SELECT))
			{
				UndoButtonMenu.Enabled = true;
				RedoButtonMenu.Enabled = false;
				myMemento.PushState(new List<Figure>(figureList));
			}

			PaintSavedImage();
			DrawWindow.Cursor = mouseWatcher.cursor;
			DrawWindow.Image = tempBitmap;
		}

		void DrawWindow_MouseDown(object sender, MouseEventArgs e)
		{
			isMouseDown = true;
			graphicsField = Graphics.FromImage(tempBitmap);
			if (!isMouseWatcherMode)
			{
				currentFigure = buildersSet[currentIndexOfBuilder].BuildFigure();
				currentFigure.SetFigurePen(currentPen);

				Point startPoint = new Point(e.X, e.Y);
				currentFigure.SetStartPoint(startPoint);
				currentFigure.SetEndPoint(startPoint);
				currentFigure.Draw();
			}
			else
			{
				mouseWatcher.MouseDown(sender, e);
			}

			DrawWindow.Cursor = mouseWatcher.cursor;
			DrawWindow.Image = tempBitmap;
		}

		private void TrackBarScroll(object sender, System.EventArgs e)
		{
			BrushThiknessText.Text = BrushThiknessTrackBar.Value.ToString();
			GlobalShapeThikness = BrushThiknessTrackBar.Value;

			currentPen = new Pen(GlobalShapeColor, GlobalShapeThikness); 
			if (isMouseWatcherMode)
			{
				figureList[mouseWatcher.currentFigure].SetFigurePen(currentPen);
			}

			LoadPreviewImage();
		}

		// установка цвета кисти
		private void ColorMenu_Click(object sender, EventArgs e)
		{
			ColorDialog.Color = GlobalShapeColor;
			if (ColorDialog.ShowDialog() == DialogResult.OK) {
				GlobalShapeColor = ColorDialog.Color;
				ColorDisplayBlock.BackColor = GlobalShapeColor;

				currentPen = new Pen(GlobalShapeColor, GlobalShapeThikness);
			}
			if (isMouseWatcherMode)
			{
				figureList[mouseWatcher.currentFigure].SetFigurePen(currentPen);
			}

			LoadPreviewImage();
		}
		private void ColorDisplayBlock_Click(object sender, EventArgs e)
		{
			ColorMenu_Click(sender, e);
		}

		// выход из приложения
		private void QuitButtonMenu_Click(object sender, EventArgs e)
		{
			Application.Exit();
		}

		// установка толщины кисти
		private void BrushDensityMenu_Click(object sender, EventArgs e)
		{
			BrushThiknessForm thiknessForm = new BrushThiknessForm();
			thiknessForm.Show();
			thiknessForm.Disposed += new System.EventHandler(ResetTrackBar);
		}

		// установка значения толщины кисти
		private void ResetTrackBar(object sender, EventArgs e) {
			BrushThiknessTrackBar.Value = GlobalShapeThikness;
			BrushThiknessText.Text = BrushThiknessTrackBar.Value.ToString();
			currentPen = new Pen(GlobalShapeColor, GlobalShapeThikness);
			if (isMouseWatcherMode)
			{
				figureList[mouseWatcher.currentFigure].SetFigurePen(currentPen);
			}
		}

		// сохранение в файл
		private void SaveFileMenu_Click(object sender, EventArgs e)
		{
			SaveAsMenuDialog.AddExtension = true;
			if (SaveAsMenuDialog.ShowDialog() == DialogResult.OK)
			{
				string filename = SaveAsMenuDialog.FileName;
				int index = SaveAsMenuDialog.FilterIndex;

				System.Drawing.Imaging.ImageFormat im;
				ImageSaver imageSaver = new ImageSaver(DrawWindow);

				switch (index)
				{
					case 3:
						imageSaver.Save(filename, figureList);
						return;
					case 2:
						im = System.Drawing.Imaging.ImageFormat.Bmp;
						break;
					case 1:
						im = System.Drawing.Imaging.ImageFormat.Jpeg;
						break;
					default:
						imageSaver.Save(filename, figureList);
						return;
				}
				imageSaver.Save(filename, im);
			}
		}

		// смена инструмента
		private void toolList_SelectedIndexChanged(object sender, EventArgs e)
		{
			currentIndexOfBuilder = toolList.SelectedIndex;

			isMouseWatcherMode = false;
			DeleteFigureButton.Enabled = false;
			TransformFigureButton.Enabled = false;
			foreach (Figure figure in figureList)
			{
				figure.isBordered = false;
			}
			PaintSavedImage();
			// MessageBox.Show(currentFigure.FigureName);
			LoadPreviewImage();

			DrawWindow.Image = tempBitmap;
		}

		// предпросмотр инструмента
		private void LoadPreviewImage()
		{
			graphicsField = Graphics.FromImage(tempBitmap);

			Graphics previewBlock = graphicsField;
			graphicsField = PreviewPictureBox.CreateGraphics();
			graphicsField.Clear(Color.White);

			Figure currentFigure = buildersSet[currentIndexOfBuilder].BuildFigure();
			currentFigure.SetFigurePen(currentPen);

			currentFigure.SetStartPoint(new Point(10 + GlobalShapeThikness / 2, 10 + GlobalShapeThikness / 2));
			currentFigure.SetEndPoint(new Point(PreviewPictureBox.Width - 10 - GlobalShapeThikness / 2, PreviewPictureBox.Height - 10 - GlobalShapeThikness / 2));

			currentFigure.Draw();

			graphicsField = previewBlock;
		}

		// сохранение пользовательского инструмента
		private void SaveUserShapeMenu_Click(object sender, EventArgs e)
		{
			if (figureList.Count == 0)
			{
				MessageBox.Show("Вы пытаетесь сохранить пустую фигуру. Атата!");
				return;
			}

			string promptValue = Prompt.ShowDialog("Введите название новой пользовательской фигуры:", "Создание новой фигуры");

			List<Figure> tempFigureList = figureList;
			
			Array.Resize<Builder>(ref buildersSet, buildersSet.Length + 1);
			buildersSet[buildersSet.Length - 1] = new UserFigureBuilder(promptValue, tempFigureList);
			toolList.Items.Add(promptValue);

			ClearGraphicsButton_Click(sender, e);
		}

		// смена инструмента
		private void LineMenu_Click(object sender, EventArgs e)
		{
			toolList.SelectedIndex = 1;
		}
		private void EllipsMenu_Click(object sender, EventArgs e)
		{
			toolList.SelectedIndex = 0;
		}
		private void RectangleMenu_Click(object sender, EventArgs e)
		{
			toolList.SelectedIndex = 2;
		}
		private void TriangleMenu_Click(object sender, EventArgs e)
		{
			toolList.SelectedIndex = 3;
		}

		// очистка поля для рисования
		private void ClearGraphicsButton_Click(object sender, EventArgs e)
		{

			figureList.Clear(); 
			myMemento.PushState(figureList);

			PaintSavedImage();
		}

		private void OpenFileMenu_Click(object sender, EventArgs e)
		{
			if (openFileMenuDialog.ShowDialog() == DialogResult.OK)
			{
				graphicsField = Graphics.FromImage(tempBitmap);
				figureList.Clear();

				string filename = openFileMenuDialog.FileName;
				Stream SerializeFileStream = File.OpenRead(filename);
				BinaryFormatter deserializer = new BinaryFormatter();

				figureList = (List<Figure>)deserializer.Deserialize(SerializeFileStream);
				SerializeFileStream.Close();

				PaintSavedImage();
				DrawWindow.Image = tempBitmap;
			}
		}

		// undo - redo
		private void UndoButtonMenu_Click(object sender, EventArgs e)
		{
			graphicsField = Graphics.FromImage(tempBitmap);

			List<Figure> tempList = myMemento.Undo();
			if (tempList != null)
			{
				figureList = new List<Figure>(tempList);
				RedoButtonMenu.Enabled = true;
			}
			else
			{
				UndoButtonMenu.Enabled = false;
			}

			PaintSavedImage();
			DrawWindow.Image = tempBitmap;
		}
		private void RedoButtonMenu_Click(object sender, EventArgs e)
		{
			graphicsField = Graphics.FromImage(tempBitmap);

			List<Figure> tempList = myMemento.Redo();
			if (tempList != null)
			{
				figureList = new List<Figure>(tempList);
				UndoButtonMenu.Enabled = true;
			}
			else
			{
				RedoButtonMenu.Enabled = false;
			}

			PaintSavedImage();
			DrawWindow.Image = tempBitmap;
		}


		// select - transform - delete
		private void SelectFigureButton_Click(object sender, EventArgs e)
		{
			mouseWatcher = new MouseWatcher(MOUSE_WATCHER_SELECT, figureList);
			isMouseWatcherMode = true;
			DeleteFigureButton.Enabled = true;
			TransformFigureButton.Enabled = true;
		}

		private void DeleteFigureButton_Click(object sender, EventArgs e)
		{
			mouseWatcher.Mode = MOUSE_WATCHER_DELETE;

			graphicsField = Graphics.FromImage(tempBitmap);
						
			if (mouseWatcher.currentFigure != -1)
			{
				figureList.RemoveAt(mouseWatcher.currentFigure);
			} 
			
			UndoButtonMenu.Enabled = true;
			RedoButtonMenu.Enabled = false;
			myMemento.PushState(figureList);

			PaintSavedImage();

			DrawWindow.Image = tempBitmap;
			mouseWatcher = new MouseWatcher(MOUSE_WATCHER_SELECT, figureList);
		}

		private void TransformFigureButton_Click(object sender, EventArgs e)
		{
			mouseWatcher.Mode = MOUSE_WATCHER_TRANSFORM;
			mouseWatcher.cursor = Cursors.SizeAll;
			DrawWindow.Cursor = Cursors.SizeAll;
		}

		private void LoadingLibraryProc()
		{
			DirectoryInfo dirInfo = new DirectoryInfo(@".");
			FileInfo[] fileFigures = dirInfo.GetFiles("*.dll", SearchOption.TopDirectoryOnly);
			foreach (FileInfo fInfo in fileFigures)
			{
				string source = "";
				for (int i = 0; i < fInfo.Name.Length - 4; i++)
					source += fInfo.Name[i];
				Assembly asm = Assembly.Load(source);
				Type[] loadedTypes = asm.GetTypes();
				for (int i = 0; i < loadedTypes.Length; i++)
				{
					if (loadedTypes[i].BaseType == typeof(Builder))
					{
						object obj = Activator.CreateInstance(loadedTypes[i]);
						Array.Resize<Builder>(ref buildersSet, buildersSet.Length + 1);
						buildersSet[buildersSet.Length - 1] = (Builder)obj;
						toolList.Items.Add(loadedTypes[i].Name);
					}
				}

			}
		}
	}
}
