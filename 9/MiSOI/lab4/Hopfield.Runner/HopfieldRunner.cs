using System;
using System.Collections.Generic;
using System.Drawing;
using System.IO;
using System.Linq;
using BinaryRandimizer.Core;
using NeuralNetworks.Hopfield.Core;

namespace Hopfield.Runner
{
    public static class HopfieldRunner
    {
        private static ImageClassifier imageClassifier;
        //private const string DataDirectoryName = "Data";
        private const int Size = 10;

        public static string Run(string DataDirectoryName)
        {
            var statistics = new Dictionary<string, int>();

            IImageBinarizer binarizer = new ImageBinarizer();
            var directoryInfo = new DirectoryInfo(Environment.CurrentDirectory).Parent.Parent.Parent;
            var path = Path.Combine(directoryInfo.FullName, DataDirectoryName);
            directoryInfo = new DirectoryInfo(path);

            imageClassifier = new ImageClassifier(binarizer, Size * Size);
            //Train
            foreach (DirectoryInfo directory in directoryInfo.EnumerateDirectories())
            {
                foreach (var file in directory.EnumerateFiles("*.bmp"))
                {
                    string fileName = Path.GetFileNameWithoutExtension(file.FullName);
                    imageClassifier.Train(new ImageUnit { Id = fileName, Image = new Bitmap(file.FullName) });
                }
            }

            foreach (DirectoryInfo directory in directoryInfo.EnumerateDirectories())
            {
                foreach (var file in directory.EnumerateFiles("*.bmp"))
                {
                    string fileName = Path.GetFileNameWithoutExtension(file.FullName);
                    var patternDirectory = directory.EnumerateDirectories().FirstOrDefault(p => p.Name == ("Randomized_" + fileName));
                    foreach (var patternFile in patternDirectory.EnumerateFiles("*.bmp"))
                    {
                        string patternFileName = Path.GetFileNameWithoutExtension(patternFile.FullName);
                        string[] nameParts = patternFileName.Split(new[] { "_" }, StringSplitOptions.RemoveEmptyEntries);
                        string percentValue = nameParts[1];
                        if (statistics.ContainsKey(percentValue) == false)
                        {
                            statistics.Add(percentValue, 0);
                        }
                        string classificationResult = imageClassifier.Classify(new Bitmap(patternFile.FullName));
                        if (classificationResult.Equals(fileName, StringComparison.CurrentCulture))
                        {
                            statistics[percentValue] += 1;
                        }
                    }
                }
            }

            return statistics.Aggregate("Classification result: \n\n", (current, statistic) => current + String.Format("Noise percent: {0}\n Matched: {1}\n\n", statistic.Key, statistic.Value));
        }

        public static Bitmap CustomRun(string path)
        {
            string classificationResult = imageClassifier.Classify(new Bitmap(path));
            string fileName = Path.GetFileNameWithoutExtension(path);
            string[] nameParts = fileName.Split(new[] { "_" }, StringSplitOptions.RemoveEmptyEntries);
            fileName = nameParts[0];
            if (classificationResult.Equals(fileName, StringComparison.CurrentCulture))
            {
                return BinaryTransformer.BoolToBitmap(imageClassifier.LastPattern);
            }

            return new Bitmap(10, 10);
        }
    }
}
