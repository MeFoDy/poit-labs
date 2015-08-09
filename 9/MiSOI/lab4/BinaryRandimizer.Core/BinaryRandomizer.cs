using System.Drawing;
using System.IO;

namespace BinaryRandimizer.Core
{
    public sealed class BinaryRandomizer
    {
        private const string FolderName = "Randomized";
        private static readonly int[] RandomizationPercents = { 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90 };
        private readonly string _sourceImagePath;

        public BinaryRandomizer(string filePath)
        {
            _sourceImagePath = filePath;
        }

        public void ApplyRandomization()
        {
            var fileInfo = new FileInfo(_sourceImagePath);
            var targetDirectory = fileInfo.Directory.CreateSubdirectory(FolderName + "_" + Path.GetFileNameWithoutExtension(fileInfo.Name));

            foreach (var randomizationPercent in RandomizationPercents)
            {
                using (var image = new Bitmap(_sourceImagePath))
                {
                    using (var transformer = new BinaryTransformer(randomizationPercent))
                    {
                        transformer.ApplyRandomization(image);
                    }
                    var path = Path.Combine(targetDirectory.FullName, Path.GetFileNameWithoutExtension(fileInfo.Name) + "_" + randomizationPercent + fileInfo.Extension);
                    image.Save(path);
                }
            }
        }
    }
}
