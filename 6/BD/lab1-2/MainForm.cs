using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Drawing;
using System.Globalization;
using System.IO;
using System.Linq;
using System.Threading;
using System.Windows.Forms;

namespace Lab1_2
{
	public partial class MainForm : Form
	{
		private GeneratedFile _generatedFile;
		private DopFile _dopFile;

		private Bitmap tempBitmapHash1, tempBitmapHash2;
		private Bitmap tempBitmapSearch1, tempBitmapSearch2;
		private Graphics graphHash1, graphHash2;
		private Graphics graphAnalise1, graphAnalise2;

		private Graphic _g1, _g2, _g3, _g4;

		public MainForm()
		{
			InitializeComponent();
			// сокрытие кнопок
			showStructureButton.Enabled = false;

			_g1 = new Graphic(tempBitmapHash1, graphHash1, hash1box);
			_g2 = new Graphic(tempBitmapHash2, graphHash2, hash2box);
		}

		// ============= Хеширование ================

		private void generateFileButton_Click(object sender, EventArgs e)
		{
			var splashScreen = new SplashScreen();
			splashScreen.Show();
			splashScreen.Update();

			_generatedFile = new GeneratedFile();
			if (_generatedFile.IsGenerated)
			{
				showStructureButton.Enabled = true;
				hashAnaliseButton.Enabled = true;
				searchAnaliseButton.Enabled = false;
				KeySearchButton.Enabled = true;
				openDopArrayButton.Enabled = true;
				generateDopArrayButton.Enabled = true;
			}

			splashScreen.Close();

			//for (int i = 0; i < Data.generatedArray.Length; i++)
			//{
			//    Console.WriteLine("{0} - {1}", Data.generatedArray[i].key, Hasher.NewNotation(Data.generatedArray[i].key));
			//}
		}

		private void showStructureButton_Click(object sender, EventArgs e)
		{
			var f1 = new ShowElementsForm(Data.GeneratedFileName, Data.GeneratedArray) {Owner = this};
			f1.ShowDialog();
		}

		private void openGeneratedFileButton_Click(object sender, EventArgs e)
		{
			var splashScreen = new SplashScreen();
			splashScreen.Show();
			splashScreen.Update();

			if (openGeneratedFileDialog.ShowDialog() == DialogResult.OK)
			{
				var filename = openGeneratedFileDialog.FileName;
				if (_generatedFile == null)
				{
					_generatedFile = new GeneratedFile(true);
				}
				_generatedFile.OpenFile(filename);

				if (_generatedFile.IsGenerated)
				{
					showStructureButton.Enabled = true;
					hashAnaliseButton.Enabled = true;
					searchAnaliseButton.Enabled = false;
					KeySearchButton.Enabled = true;
					openDopArrayButton.Enabled = true;
					generateDopArrayButton.Enabled = true;
				}
			}

			splashScreen.Close();
		}

		private void hashAnaliseButton_Click(object sender, EventArgs e)
		{
			var splashScreen = new SplashScreen();
			splashScreen.Show();
			splashScreen.Update();

			HashWorker hashWorker;
			_g1 = new Graphic(tempBitmapHash1, graphHash1, hash1box);
			_g2 = new Graphic(tempBitmapHash2, graphHash2, hash2box);

			for (var i = 0; i < Data.PacketCountArray.Length; i++)
			{
				hashWorker = new HashWorker(Data.PacketCountArray[i]
											, Data.FullItemCount / Data.PacketCountArray[i] + (Data.FullItemCount % Data.PacketCountArray[i] > 0 ? 1 : 0)
											, Data.GeneratedArray
											, Data.KoefArray[i]);
				hashWorker.RepresentMiddle();
				hashWorker.SaveMiddle();
				//Console.WriteLine("{0} => {1}", Data.packetCountArray[i], hashWorker.GetStat());
				_g1.DrawNewStat(i, hashWorker.GetStatMid());
				hash1box.Update();
				Refresh();
			}

			for (var i = 0; i < Data.PacketCountArray.Length; i++)
			{
				hashWorker = new HashWorker(Data.PacketCountArray[i]
											, Data.FullItemCount / Data.PacketCountArray[i] + (Data.FullItemCount % Data.PacketCountArray[i] > 0 ? 1 : 0)
											, Data.GeneratedArray
											, Data.KoefArray[i]);
				hashWorker.RepresentNotation();
				hashWorker.SaveNotation();
				//Console.WriteLine("{0} => {1}", Data.packetCountArray[i], hashWorker.GetStat());
				_g2.DrawNewStat(i, hashWorker.GetStatNot());
				hash2box.Update();
				Refresh();
			}

			MessageBox.Show(@"Анализ хеширования успешно завершен",
														@"Успех", MessageBoxButtons.OK,
														MessageBoxIcon.Information);

			splashScreen.Close();

		}

		// ============= Поиск  ======================

		private void searchAnaliseButton_Click(object sender, EventArgs e)
		{
			if (Data.GeneratedFileName != null && Directory.Exists(Data.GeneratedFileName + "_"))
			{
				var dir = new DirectoryInfo(Data.GeneratedFileName + "_"); // папка с файлами 
				Data.Files = dir.GetFiles().Select(file => file.FullName).ToList(); // список для имен файлов 
				Data.CountOfFiles = Data.Files.Count;
			}
			else
			{
				MessageBox.Show(@"Path not found", @"Error", MessageBoxButtons.OK);
				return;
			}

			Data.GraphMidTime = new Dictionary<long, long>();
			Data.GraphNotTime = new Dictionary<long, long>();

			var stopwatch = new Stopwatch();
			stopwatch.Start();

			label1.Text = @"Осталось: " + Data.Files.Count.ToString(CultureInfo.InvariantCulture) 
							+ @" из " + Data.CountOfFiles.ToString(CultureInfo.InvariantCulture);
			if (ActiveForm != null) {
				ActiveForm.Refresh();
				ActiveForm.Enabled = false;
			}

			var t = new Thread(new Finder().DoIt); 
			var t2 = new Thread(new Finder().DoIt);

			t.Start();
			t2.Start();
			//new Finder().DoIt();
			while (t.IsAlive || t2.IsAlive)
			{
				Thread.Sleep(5000);
				label1.Text = @"Осталось: " + Data.Files.Count.ToString(CultureInfo.InvariantCulture)
											+ @" из " + Data.CountOfFiles.ToString(CultureInfo.InvariantCulture);
				Refresh();
			}
			t.Join();
			t2.Join();
			stopwatch.Stop();

			// выводим графику
			_g3 = new Graphic(tempBitmapSearch1, graphAnalise1, search1box);
			_g4 = new Graphic(tempBitmapSearch2, graphAnalise2, search2box);
			// график первого метода хеширования
			var maxYSelector = from d in Data.GraphMidTime orderby d.Value select d.Value;
			long maxY = maxYSelector.Last();

			var result = Data.GraphMidTime.OrderBy(pair => pair.Key);
			int i = 0;
			foreach (KeyValuePair<long, long> keyValuePair in result)
			{
				_g3.DrawNewStat(i++, keyValuePair.Value / (double) maxY * 100);
			}
			_g3.DrawYMaxStat(maxY);

			// график второго метода хеширования
			maxYSelector = from d in Data.GraphNotTime orderby d.Value select d.Value;
			maxY = maxYSelector.Last();

			result = Data.GraphNotTime.OrderBy(pair => pair.Key);
			i = 0;
			foreach (KeyValuePair<long, long> keyValuePair in result)
			{
				_g4.DrawNewStat(i++, keyValuePair.Value / (double)maxY * 100);
			}
			_g4.DrawYMaxStat(maxY);

			MessageBox.Show("Поиск выполнен успешно.\nЗатрачено " + stopwatch.Elapsed, @"Success", MessageBoxButtons.OK);


			label1.Text = @"Осталось: " + Data.Files.Count.ToString(CultureInfo.InvariantCulture)
			              + @" из " + Data.CountOfFiles.ToString(CultureInfo.InvariantCulture);
			Refresh();
			Enabled = true;
		}

		private void generateDopArrayButton_Click(object sender, EventArgs e)
		{
			var splashScreen = new SplashScreen();
			splashScreen.Show();
			splashScreen.Update();

			_dopFile = new DopFile();
			if (_dopFile.IsGenerated)
			{
				showDopArrayButton.Enabled = true;
				searchAnaliseButton.Enabled = true;
				KeySearchButton.Enabled = true;
			}

			splashScreen.Close();
		}

		private void openDopArrayButton_Click(object sender, EventArgs e)
		{
			var splashScreen = new SplashScreen();
			splashScreen.Show();
			splashScreen.Update();

			if (openDopArrayDialog.ShowDialog() == DialogResult.OK)
			{
				var filename = openDopArrayDialog.FileName;
				if (_dopFile == null)
				{
					_dopFile = new DopFile(true);
				}
				_dopFile.OpenFile(filename);

				if (_dopFile.IsGenerated)
				{
					showDopArrayButton.Enabled = true;
					searchAnaliseButton.Enabled = true;
					KeySearchButton.Enabled = true;
				}
			}

			splashScreen.Close();
		}

		private void showDopArrayButton_Click(object sender, EventArgs e)
		{
			var f1 = new ShowElementsForm(Data.DopFileName, Data.DopArray) { Owner = this };
			f1.ShowDialog();
		}

		private void KeySearchButton_Click(object sender, EventArgs e)
		{
			var sf = new SearchForm();
			sf.Show();
		}

	}
}
