using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Globalization;
using System.IO;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using ProtoBuf;

namespace Lab1_2
{
	class Finder
	{
		private static readonly object Locker = new object();
		private string _filePath;

		public void DoIt()
		{
			while (Data.Files.Count != 0)
			{
				lock (Locker)
				{
					GC.Collect();
					if (Data.Files.Count != 0)
					{
						_filePath = Data.Files.Last();
						Data.Files.RemoveAt(Data.Files.Count - 1);
					}
					else return;
				}

				HashWorker hw;
				using (var fs = new FileStream(_filePath, FileMode.Open))
				{
					hw = Serializer.Deserialize<HashWorker>(fs);
				}
				

				var sw = new Stopwatch();
				sw.Start();
				hw.DoFindAnalise();
				sw.Stop();

				lock (Locker)
				{
					Console.WriteLine(_filePath + @" " + sw.ElapsedMilliseconds);
					if (hw.IsMiddle)
					{
						Data.GraphMidTime.Add(hw.CountOfPackets, sw.ElapsedMilliseconds);
					}
					else
					{
						Data.GraphNotTime.Add(hw.CountOfPackets, sw.ElapsedMilliseconds);
					}
				}
			}
		}
	}
}
