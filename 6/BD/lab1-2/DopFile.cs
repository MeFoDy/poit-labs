using System;
using System.Globalization;
using System.IO;
using System.Runtime.Serialization;
using System.Text;
using ProtoBuf;

namespace Lab1_2
{
	[Serializable]
	public class DopFile
	{
		private readonly bool _toGen;
		public bool IsGenerated;

		public DopFile()
		{
			Data.DopArray = new Structure[Data.DopItemCount];

			// генерирование записей
			var rnd = new Random();

			for (var i = 0; i < Data.DopItemCount; i++)
			{
				var s = rnd.Next().ToString(CultureInfo.InvariantCulture);
				var md5 = System.Security.Cryptography.MD5.Create();
				var result = md5.ComputeHash(Encoding.Unicode.GetBytes(s));
				// конвертируем хеш из byte[16] в строку шестнадцатиричного формата
				var resultStr = BitConverter.ToString(result).Replace("-", string.Empty);

				Data.DopArray[i].Str = resultStr;
				Data.DopArray[i].Number = rnd.Next();
				Data.DopArray[i].Key = (Data.FullItemCount + i).ToString("X");

				while (Data.DopArray[i].Key.Length < 6)
				{
					// дописываем до 6 цифр
					Data.DopArray[i].Key = "0" + Data.DopArray[i].Key;
				}
			}

			// открытие директории
			const string newPath = "Generated Files";
			Directory.CreateDirectory(newPath);

			// генерирование имени файла
			var newFileName = Data.GeneratedFileName + "_DopArray_";

			// запись в файл
			using (var fs = new FileStream(newFileName, FileMode.Create))
			{
				try
				{
					Serializer.Serialize(fs, Data.DopArray);
					fs.SetLength(fs.Position);
					//formatter.Serialize(fs, Data.DopArray);
				}
				catch (SerializationException ex)
				{
					System.Windows.Forms.MessageBox.Show(@"Ошибка сериализации: " + ex.Message,
														@"Ошибка", System.Windows.Forms.MessageBoxButtons.OK,
														System.Windows.Forms.MessageBoxIcon.Warning);
					throw;
				}
			}

			// читаем записи из сгенерированного файла
			OpenFile(newFileName);
		}

		public DopFile(bool toGen)
		{
			_toGen = toGen;
			Data.DopArray = new Structure[Data.DopItemCount];
		}

		public void OpenFile(string newPath)
		{
			// пробуем читать из файла записи
			try
			{
				var fs = new FileStream(newPath, FileMode.Open);
				try
				{
					Data.DopArray.Initialize();
					Data.DopArray = Serializer.Deserialize<Structure[]>(fs);
					//Data.DopArray = (Structure[])formatter.Deserialize(fs);
					Data.DopFileName = newPath;
					IsGenerated = true;
					System.Windows.Forms.MessageBox.Show("Файл \n" + newPath + "\nуспешно загружен в память",
														@"Файл загружен", System.Windows.Forms.MessageBoxButtons.OK, System.Windows.Forms.MessageBoxIcon.Information);
				}
				catch (SerializationException ex)
				{
					System.Windows.Forms.MessageBox.Show(@"Ошибка: " + ex.Message,
														@"Ошибка десериализации", System.Windows.Forms.MessageBoxButtons.OK, System.Windows.Forms.MessageBoxIcon.Warning);
					throw;
				}
				finally
				{
					fs.Close();
				}
			}
			catch (IOException ex)
			{
				System.Windows.Forms.MessageBox.Show(@"Ошибка: " + ex.Message,
														@"Ошибка чтения", System.Windows.Forms.MessageBoxButtons.OK, System.Windows.Forms.MessageBoxIcon.Warning);
				throw;
			}
		}
	}
}
