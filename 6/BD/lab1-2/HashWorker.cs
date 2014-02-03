using System;
using System.IO;
using System.Linq;
using System.Runtime.Serialization;
using System.Windows.Forms;
using ProtoBuf;

namespace Lab1_2
{
	[Serializable]
	[ProtoContract]
	public class HashWorker
	{
		[ProtoMember(1)] 
		public readonly int CountOfPackets; //число пакетов
		[ProtoMember(2)] 
		readonly int _packetLimit; //количество записей в пакете
		[ProtoMember(3)] 
		readonly double _koef; //коэффициент индексирования
		[ProtoMember(4)] 
		readonly HashedStructure[] _stream;
		[ProtoMember(5)] 
		readonly Structure[] _inputArray;
		[ProtoMember(6)] 
		readonly int[] _cursorPosition; //позиция курсора в пакете
		[ProtoMember(7)] 
		private readonly Structure _null;
		[ProtoMember(8)] 
		public bool IsMiddle;

		private delegate int HasherOperation(String hexValue);
		[ProtoMember(9)]
		private HasherOperation _hasher;
		[ProtoMember(10)]
		private int _overflowPosition;
		

		public HashWorker(int count, int limit, Structure[] input, double k) : this()
		{
			CountOfPackets = count;
			_packetLimit = limit;
			_inputArray = input;
			_koef = k;

			_stream = new HashedStructure[CountOfPackets];
			_cursorPosition = new int[CountOfPackets];
			for (var i = 0; i < CountOfPackets; i++)
			{
				_stream[i].Packet = new Structure[_packetLimit];
			}
		}

		public HashWorker()
		{
			_null.Key = "-1";
			_null.Number = -1;
			_null.Str = "-1";
		}

		public void RepresentMiddle()
		{
			foreach (Structure structure in _inputArray)
			{
				var middleRectangleIndex = (int)(Hasher.MiddleRectangle(structure.Key) * _koef);
				middleRectangleIndex += middleRectangleIndex / (Data.OverflowPositionMid - 1) + 1;
				if (middleRectangleIndex != 0 && middleRectangleIndex % Data.OverflowPositionMid == 0)
				{
					middleRectangleIndex++;
				}
				middleRectangleIndex = (middleRectangleIndex + CountOfPackets) % CountOfPackets;

				_overflowPosition = Data.OverflowPositionMid;
				var counter = CountOfPackets / _overflowPosition + 2;
				while (_cursorPosition[middleRectangleIndex] >= _packetLimit)
				{
					if (counter < 0)
					{
						MessageBox.Show(@"Too few steps - Mid", @"Error", MessageBoxButtons.OK);
						return;
					}
					if (middleRectangleIndex % Data.OverflowPositionMid != 0)
					{
						middleRectangleIndex = middleRectangleIndex 
												- middleRectangleIndex % Data.OverflowPositionMid 
												+ Data.OverflowPositionMid;
					}
					else
					{
						middleRectangleIndex = middleRectangleIndex + Data.OverflowPositionMid;
					}
					middleRectangleIndex %= CountOfPackets;
					counter--;
				}
				_stream[middleRectangleIndex].Packet[_cursorPosition[middleRectangleIndex]] = structure;
				_cursorPosition[middleRectangleIndex]++;
			}
			IsMiddle = true;
		}

		public void RepresentNotation()
		{
			foreach (Structure structure in _inputArray)
			{
				var notationIndex = (int)(Hasher.NewNotation(structure.Key) * _koef);
				notationIndex += notationIndex / (Data.OverflowPositionNot - 1) + 1;
				if (notationIndex != 0 && notationIndex % Data.OverflowPositionNot == 0)
				{
					notationIndex++;
				}
				notationIndex = (notationIndex + CountOfPackets) % CountOfPackets;

				_overflowPosition = Data.OverflowPositionNot;
				var counter = CountOfPackets / _overflowPosition + 2;
				while (_cursorPosition[notationIndex] >= _packetLimit)
				{
					if (counter < 0)
					{
						MessageBox.Show(@"Too few steps - Not", @"Error", MessageBoxButtons.OK);
						return;
					}
					if (notationIndex % Data.OverflowPositionNot != 0)
					{
						notationIndex = notationIndex
												- notationIndex % Data.OverflowPositionNot
												+ Data.OverflowPositionNot;
					}
					else
					{
						notationIndex = notationIndex + Data.OverflowPositionNot;
					}
					notationIndex %= CountOfPackets; 
					counter--;
				}
				_stream[notationIndex].Packet[_cursorPosition[notationIndex]] = structure;
				_cursorPosition[notationIndex]++;
			}
			IsMiddle = false;
		}

		public void DoFindAnalise()
		{
			if (IsMiddle)
			{
				_hasher = Hasher.MiddleRectangle;
				_overflowPosition = Data.OverflowPositionMid;
			}
			else
			{
				_hasher = Hasher.NewNotation;
				_overflowPosition = Data.OverflowPositionNot;
			}

			if (Data.GeneratedArray.Select(structure => Find(structure.Key)).Contains(this.Null))
			{
				MessageBox.Show(@"DANGER", @"DANGER", MessageBoxButtons.OK);
				return;
			}

			if (Data.DopArray.Select(structure => Find(structure.Key)).Any(found => !found.Equals(this.Null)))
			{
				MessageBox.Show(@"DANGER DOP", @"DANGER DOP", MessageBoxButtons.OK);
				return;
			}
		}

		private Structure Find(string key)
		{
			var currentIndex = (int) (_hasher(key)*_koef);
			currentIndex += currentIndex/(_overflowPosition - 1) + 1;
			if (currentIndex != 0 && currentIndex % _overflowPosition == 0)
			{
				currentIndex++;
			}
			currentIndex = (currentIndex + CountOfPackets)%CountOfPackets;

			var counter = CountOfPackets / _overflowPosition + 2;

			while (true)
			{
				foreach (var structure in _stream[currentIndex].Packet)
				{
					if (structure.Key == null)
					{
						break;
					}
					if (structure.Key == key)
					{
						return structure;
					}
				}

				if (_cursorPosition[currentIndex] >= _packetLimit && counter >= 0)
				{
					var pos = currentIndex % _overflowPosition;
					if (pos != 0)
					{
						currentIndex = currentIndex - pos + _overflowPosition;
					}
					else
					{
						currentIndex += _overflowPosition;
					}

					if (currentIndex >= CountOfPackets)
					{
						currentIndex %= CountOfPackets;
					}
				}
				else
				{
					break;
				}
				counter--;
			}
			
			return this.Null;
		}

		public Structure Null
		{
			get { return _null; }
		}

		public void SaveMiddle()
		{
			// запись в файл
			var newPath = Data.GeneratedFileName + "_";
			Directory.CreateDirectory(newPath);
			using (var fs = new FileStream(Data.GeneratedFileName + @"_\Middle_" + CountOfPackets, FileMode.Create))
			{
				try
				{
					Serializer.Serialize(fs, this);
					fs.SetLength(fs.Position);
					//formatter.Serialize(fs, this);
				}
				catch (SerializationException ex)
				{
					System.Windows.Forms.MessageBox.Show(@"Ошибка сериализации после хеширования: " + ex.Message,
														@"Ошибка", System.Windows.Forms.MessageBoxButtons.OK,
														System.Windows.Forms.MessageBoxIcon.Warning);
					throw;
				}
			}
		}

		public void SaveNotation()
		{
			// запись в файл
			var newPath = Data.GeneratedFileName + "_";
			Directory.CreateDirectory(newPath);
			using (var fs = new FileStream(Data.GeneratedFileName + @"_\Notation_" + CountOfPackets, FileMode.Create))
			{
				try
				{
					Serializer.Serialize(fs, this);
					fs.SetLength(fs.Position);
					//formatter.Serialize(fs, this);
				}
				catch (SerializationException ex)
				{
					System.Windows.Forms.MessageBox.Show(@"Ошибка сериализации после хеширования: " + ex.Message,
														@"Ошибка", System.Windows.Forms.MessageBoxButtons.OK,
														System.Windows.Forms.MessageBoxIcon.Warning);
					throw;
				}
			}
		}

		public double GetStatMid()
		{
			var sum = 0;

			for (var i = Data.OverflowPositionMid; i < CountOfPackets; i = i + Data.OverflowPositionMid)
			{
				sum += _cursorPosition[i];
			}
			var ans = (double)(Data.ItemCount - sum) / Data.ItemCount * 100;

			return ans;
		}

		public double GetStatNot()
		{
			var sum = 0;

			for (var i = Data.OverflowPositionNot; i < CountOfPackets; i = i + Data.OverflowPositionNot)
			{
				sum += _cursorPosition[i];
			}
			var ans = (double)(Data.ItemCount - sum) / Data.ItemCount * 100;

			return ans;
		}
	}
}
