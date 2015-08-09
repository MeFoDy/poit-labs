using System.Drawing;

namespace NeuralNetworks.Hopfield.Core
{
    public sealed class ImageBinarizer : IImageBinarizer
    {
        private const int Threshold = 128;

        public bool[] ApplyBinarization(Bitmap bitMap)
        {
            var result = new bool[bitMap.Width * bitMap.Height];
            int index = 0;

            for (int i = 0; i < bitMap.Height; ++i)
            {
                for (int j = 0; j < bitMap.Width; ++j)
                {
                    Color pixel = bitMap.GetPixel(i, j);
                    int byteValue = ((int)pixel.R + pixel.B + pixel.G) / 3;
                    result[index++] = byteValue < Threshold;
                }
            }

            return result;
        }
    }
}
