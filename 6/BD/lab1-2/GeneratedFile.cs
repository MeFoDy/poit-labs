using System;
using System.Globalization;
using System.IO;
using System.Runtime.Serialization;
using System.Text;
using ProtoBuf;

namespace Lab1_2
{
	[Serializable]
	public class GeneratedFile
	{
		public bool IsGenerated;

		public GeneratedFile()
		{
			Data.GeneratedArray = new Structure[Data.ItemCount];

			// генерирование записей
			var rnd = new Random();

			for (var i = 0; i < Data.ItemCount; i++)
			{
				var s = rnd.Next().ToString(CultureInfo.InvariantCulture);
				var md5 = System.Security.Cryptography.MD5.Create();
				var result = md5.ComputeHash(Encoding.Unicode.GetBytes(s));
				// конвертируем хеш из byte[16] в строку шестнадцатиричного формата
				var resultStr = BitConverter.ToString(result).Replace("-", string.Empty);

				Data.GeneratedArray[i].Str = resultStr;
				Data.GeneratedArray[i].Number = rnd.Next();
				Data.GeneratedArray[i].Key = i.ToString("X");

				while (Data.GeneratedArray[i].Key.Length < 6)
				{
					// дописываем до 6 цифр
					Data.GeneratedArray[i].Key = "0" + Data.GeneratedArray[i].Key;
				}
			}

			// открытие директории
			var newPath = "Generated Files";
			Directory.CreateDirectory(newPath);

			// генерирование имени файла
			var newFileName = Path.GetRandomFileName();
			newFileName = System.Text.RegularExpressions.Regex.Replace(newFileName, @"\.", "");
			newPath = Path.Combine(newPath, newFileName);
			// избегаем использования уже существующего файла
			while (File.Exists(newPath))
			{
				var x = rnd.Next(0, 9);
				newPath = Path.Combine(newPath, x.ToString(CultureInfo.InvariantCulture));
			}
			
			// запись в файл
			using (var fs = new FileStream(newPath, FileMode.Create))
			{
				try
				{
					Serializer.Serialize(fs, Data.GeneratedArray);
					fs.SetLength(fs.Position);
					//formatter.Serialize(fs, Data.generatedArray);
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
			OpenFile(newPath);
		}

		public GeneratedFile(bool toGen)
		{
			Data.GeneratedArray = new Structure[Data.ItemCount];
		}

		public void OpenFile(string newPath)
		{
			// пробуем читать из файла записи
			try
			{
				var fs = new FileStream(newPath, FileMode.Open);
				try
				{
					Data.GeneratedArray.Initialize();
					Data.GeneratedArray = Serializer.Deserialize<Structure[]>(fs);
					//Data.generatedArray = (Structure[])formatter.Deserialize(fs);
					Data.GeneratedFileName = newPath;
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
