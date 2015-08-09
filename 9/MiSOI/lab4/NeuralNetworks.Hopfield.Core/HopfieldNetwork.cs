using NeuralNetworks.Math;

namespace NeuralNetworks.Hopfield.Core
{
    public sealed class HopfieldNetwork
    {
        private Matrix _weightMatrix;

        public HopfieldNetwork(int size)
        {
            _weightMatrix = new Matrix(size, size);
        }

        public Matrix LayerMatrix
        {
            get
            {
                return _weightMatrix;
            }
        }

        public int Size
        {
            get
            {
                return _weightMatrix.Rows;
            }
        }

        public bool[] Present(bool[] pattern)
        {
            var output = new bool[pattern.Length];

            Matrix inputMatrix = Matrix.CreateRowMatrix(BiPolarUtil.Bipolar2Double(pattern));

            for (int col = 0; col < pattern.Length; col++)
            {
                Matrix columnMatrix = _weightMatrix.GetCol(col);
                columnMatrix = MatrixMath.Transpose(columnMatrix);

                double dotProduct = MatrixMath.FindMult(inputMatrix, columnMatrix);

                if (dotProduct > 0)
                {
                    output[col] = true;
                }
                else
                {
                    output[col] = false;
                }
            }

            return output;
        }

        public void Train(bool[] pattern)
        {
            Matrix m2 = Matrix.CreateRowMatrix(BiPolarUtil.Bipolar2Double(pattern));

            Matrix m1 = MatrixMath.Transpose(m2);
            Matrix m3 = MatrixMath.Multiply(m1, m2);

            Matrix identity = MatrixMath.CreateIdentityMatrix(m3.Rows);

            Matrix m4 = MatrixMath.Subtract(m3, identity);
            _weightMatrix = MatrixMath.Add(_weightMatrix, m4);
        }
    }
}
