using System;
using System.Collections.Generic;
using System.Drawing;
using System.Security.Cryptography;

namespace BinaryRandimizer.Core
{
    public sealed class BinaryTransformer : IBinaryTransformer, IDisposable
    {
        private readonly int _percent;
        private readonly RNGCryptoServiceProvider _rngCryptoServiceProvider;
        private readonly HashSet<int> _randomizationIndices;
        private readonly HashSet<Point> _randomizationPoints;
        private bool _disposed;

        public BinaryTransformer(int randomizationPercent)
        {
            _percent = randomizationPercent;
            _rngCryptoServiceProvider = new RNGCryptoServiceProvider();
            _randomizationIndices = new HashSet<int>();
            _randomizationPoints = new HashSet<Point>();
        }

        public void ApplyRandomization(Bitmap bitMap)
        {
            InitializeRandomizationPoints(bitMap);
            Invert(bitMap);
        }

        private void InitializeRandomizationIndices(int size)
        {
            int indicesToInvert = size * _percent / 100;
            while (_randomizationIndices.Count < indicesToInvert)
            {
                var buffer = new byte[sizeof(int)];
                _rngCryptoServiceProvider.GetBytes(buffer);
                int newIndex = Math.Abs(buffer.ToInt()) % size;
                _randomizationIndices.Add(newIndex);
            }
        }

        private void InitializeRandomizationPoints(Bitmap image)
        {
            int pointsToInvert = image.Width * image.Height * _percent / 100;
            while (_randomizationPoints.Count < pointsToInvert)
            {
                var buffer = new byte[sizeof(int)];
                _rngCryptoServiceProvider.GetBytes(buffer);
                int x = Math.Abs(buffer.ToInt()) % image.Height;
                _rngCryptoServiceProvider.GetBytes(buffer);
                int y = Math.Abs(buffer.ToInt()) % image.Width;
                _randomizationPoints.Add(new Point(x, y));
            }
        }

        private void Invert(byte[] image)
        {
            foreach (int index in _randomizationIndices)
            {
                image[index * 3] = (byte)(byte.MaxValue - image[index * 3]);
                image[(index * 3) + 1] = (byte)(byte.MaxValue - image[(index * 3) + 1]);
                image[(index * 3) + 2] = (byte)(byte.MaxValue - image[(index * 3) + 2]);
            }
        }

        private void Invert(Bitmap image)
        {
            foreach (var point in _randomizationPoints)
            {
                Color pixel = image.GetPixel(point.X, point.Y);
                image.SetPixel(point.X, point.Y, pixel == Color.Black ? Color.White : Color.Black);
            }
        }

        public static Bitmap BoolToBitmap(bool[] matrix)
        {
            var image = new Bitmap(10, 10);
            for (int i = 0; i < 10; i++)
            {
                for (int j = 0; j < 10; j++)
                {
                    image.SetPixel(i, j, matrix[i * 10 + j] ? Color.Black : Color.White);
                }
            }
            return image;
        }

        public void Dispose()
        {
            Dispose(true);
        }

        private void Dispose(bool disposing)
        {
            if (_disposed == false)
            {
                if (disposing)
                {
                    _rngCryptoServiceProvider.Dispose();
                    _disposed = true;
                }
            }
        }
    }
}
