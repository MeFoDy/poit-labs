using System;

namespace Lab1_2
{
	static class Hasher
	{
		// метод средних квадратов
		public static int MiddleRectangle(string hexValue) {
			var x = int.Parse(hexValue, System.Globalization.NumberStyles.HexNumber);
			Int64 kvadr = x * x;
			int l;
			for (l = 0; kvadr >> l > 0; l++)
			{
			}

			kvadr >>= l > 21 ? (l - 21) / 2 : 0;
			var ans = Math.Abs(kvadr % (1 << 21));
			return (int)ans;
			kvadr >>= l > 10 ? (l - 10) / 2 : 0;
			return (int)(kvadr % (1 << 10));
		}

		// метод преобразования системы счисления
		public static int NewNotation(string hexValue)
		{
			var val = int.Parse(hexValue, System.Globalization.NumberStyles.HexNumber);
			Int64 des = 1;
			Int64 p = 0;
			while (val != 0)
			{
				var z = val % 10;
				val = val / 10;
				p = p + z * des;
	//			des = des * 13;
				des = des * 19;
			}
			return (int)p;
		}
	}
}
