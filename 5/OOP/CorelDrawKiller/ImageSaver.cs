using System;
using System.Collections.Generic;
using System.Text;
using System.Drawing;
using System.Windows.Forms;
using System.IO;
using System.Runtime.Serialization.Formatters.Binary;

namespace CorelDrawKiller
{
	class ImageSaver
	{
		private PictureBox imageWindow;

		public ImageSaver(PictureBox drawingWindow)
		{
			imageWindow = drawingWindow;
		}

		public bool Save(string filename, System.Drawing.Imaging.ImageFormat format)
		{
			imageWindow.Image.Save(filename, format);
			return true;
		}

		public bool Save(string filename, List<Figure> figureList)
		{
			Stream TestFileStream = new FileStream(filename, FileMode.Create);
			
			BinaryFormatter serializer = new BinaryFormatter();
			serializer.Serialize(TestFileStream, figureList);
			TestFileStream.Close();
			return true;
		}
	}
}
