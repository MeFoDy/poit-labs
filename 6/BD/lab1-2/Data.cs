using System.Collections.Generic;

namespace Lab1_2
{
	static class Data
	{
		public const int ItemCount = 1000000;
		public const int DopItemCount = (int)(ItemCount * 0.2);
		public const int FullItemCount = ItemCount + DopItemCount;
		public const int MaxPackCount = 200000;
		public const int OverflowPositionMid = /*4*/4;
		public const int OverflowPositionNot = /*5*/5;
		public static readonly int[] PacketCountArray = {
												20, 40, 60, 80, 100, 120, 140, 160, 180, 200
												, 400, 600, 800, 1000, 1200, 1400, 1600, 1800, 2000
												, 4000, 6000, 8000, 10000, 12000, 14000, 16000, 18000, 20000
												, 40000, 60000, 80000, 100000, 120000, 140000, 160000, 180000, 200000
											  };
		public static readonly double[] KoefArray;
		public static Dictionary<long, long> GraphMidTime = new Dictionary<long, long>();
		public static Dictionary<long, long> GraphNotTime = new Dictionary<long, long>(); 

		public static Structure[] GeneratedArray = new Structure[FullItemCount];
		public static Structure[] DopArray = new Structure[DopItemCount];

		public static string GeneratedFileName = "";
		public static string DopFileName = "";
		
		public static List<string> Files;
		public static int CountOfFiles;

		static Data()
		{
			KoefArray = new double[PacketCountArray.Length];
			for (var i = 0; i < PacketCountArray.Length; i++)
			{
				KoefArray[i] = PacketCountArray[i] / (double)ItemCount;
			}
		}
	}
}
