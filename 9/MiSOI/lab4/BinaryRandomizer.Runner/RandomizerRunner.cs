using System;
using System.IO;

namespace BinaryRandomizer.Runner
{
    public static class RandomizerRunner
    {
        private const string DataDirectoryName = "Data";

        public static void GenerateHopfield(string path)
        {
            var directoryInfo = new DirectoryInfo(path);
            foreach (var directory in directoryInfo.EnumerateDirectories())
            {
                foreach (var file in directory.EnumerateFiles("*.bmp"))
                {
                    var randomizer = new BinaryRandimizer.Core.BinaryRandomizer(file.FullName);
                    randomizer.ApplyRandomization();
                }
            }
        }
    }
}
