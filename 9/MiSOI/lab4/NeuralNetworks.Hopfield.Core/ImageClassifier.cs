using System.Collections.Generic;
using System.Drawing;
using System.Linq;

namespace NeuralNetworks.Hopfield.Core
{
    public sealed class ImageClassifier
    {
        private readonly HopfieldNetwork _hopfieldNetwork;
        private readonly IImageBinarizer _imageBinarizer;
        public readonly IList<TrainPattern> TrainPatterns;
        public bool[] LastPattern = new bool[100];

        public ImageClassifier(IImageBinarizer imageBinazer, int size)
        {
            _hopfieldNetwork = new HopfieldNetwork(size);
            TrainPatterns = new List<TrainPattern>();
            _imageBinarizer = imageBinazer;
        }

        public void Train(ImageUnit imageUnit)
        {
            var trainPattern = new TrainPattern(imageUnit) { BinarizedRepresentation = _imageBinarizer.ApplyBinarization(imageUnit.Image) };
            TrainPatterns.Add(trainPattern);
            _hopfieldNetwork.Train(trainPattern.BinarizedRepresentation);
        }

        public string Classify(Bitmap image)
        {
            string result = string.Empty;
            bool[] binarizedImage = _imageBinarizer.ApplyBinarization(image);
            bool[] trainPattern = _hopfieldNetwork.Present(binarizedImage);
            foreach (var pattern in TrainPatterns)
            {
                if (trainPattern.SequenceEqual(pattern.BinarizedRepresentation))
                {
                    result = pattern.Id;
                    LastPattern = new bool[100];
                    trainPattern.CopyTo(LastPattern, 0);
                    break;
                }
            }

            return result;
        }
    }
}
