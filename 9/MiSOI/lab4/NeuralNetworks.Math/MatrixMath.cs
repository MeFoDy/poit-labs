namespace NeuralNetworks.Math
{
    public sealed class MatrixMath
    {
        public static Matrix Add(Matrix a, Matrix b)
        {
            var result = new double[a.Rows, a.Cols];

            for (int resultRow = 0; resultRow < a.Rows; resultRow++)
            {
                for (int resultCol = 0; resultCol < a.Cols; resultCol++)
                {
                    result[resultRow, resultCol] = a[resultRow, resultCol] + b[resultRow, resultCol];
                }
            }

            return new Matrix(result);
        }

        public static void Copy(Matrix source, Matrix target)
        {
            for (int row = 0; row < source.Rows; row++)
            {
                for (int col = 0; col < source.Cols; col++)
                {
                    target[row, col] = source[row, col];
                }
            }
        }

        public static Matrix DeleteCol(Matrix matrix, int deleted)
        {
            var newMatrix = new double[matrix.Rows, matrix.Cols - 1];

            for (int row = 0; row < matrix.Rows; row++)
            {
                int targetCol = 0;

                for (int col = 0; col < matrix.Cols; col++)
                {
                    if (col != deleted)
                    {
                        newMatrix[row, targetCol] = matrix[row, col];
                        targetCol++;
                    }
                }
            }

            return new Matrix(newMatrix);
        }

        public static Matrix DeleteRow(Matrix matrix, int deleted)
        {
            var newMatrix = new double[matrix.Rows - 1, matrix.Cols];
            int targetRow = 0;
            for (int row = 0; row < matrix.Rows; row++)
            {
                if (row != deleted)
                {
                    for (int col = 0; col < matrix.Cols; col++)
                    {
                        newMatrix[targetRow, col] = matrix[row, col];
                    }

                    targetRow++;
                }
            }

            return new Matrix(newMatrix);
        }

        public static Matrix Divide(Matrix a, double b)
        {
            var result = new double[a.Rows, a.Cols];
            for (int row = 0; row < a.Rows; row++)
            {
                for (int col = 0; col < a.Cols; col++)
                {
                    result[row, col] = a[row, col] / b;
                }
            }

            return new Matrix(result);
        }

        public static double FindMult(Matrix a, Matrix b)
        {
            double[] aArray = a.ToPackedArray();
            double[] bArray = b.ToPackedArray();

            double result = 0;
            int length = aArray.Length;

            for (int i = 0; i < length; i++)
            {
                result += aArray[i] * bArray[i];
            }

            return result;
        }

        public static Matrix CreateIdentityMatrix(int size)
        {
            var result = new Matrix(size, size);

            for (int i = 0; i < size; i++)
            {
                result[i, i] = 1;
            }

            return result;
        }

        public static Matrix Multiply(Matrix a, double b)
        {
            var result = new double[a.Rows, a.Cols];
            for (int row = 0; row < a.Rows; row++)
            {
                for (int col = 0; col < a.Cols; col++)
                {
                    result[row, col] = a[row, col] * b;
                }
            }

            return new Matrix(result);
        }

        public static Matrix Multiply(Matrix a, Matrix b)
        {
            var result = new double[a.Rows, b.Cols];

            for (int resultRow = 0; resultRow < a.Rows; resultRow++)
            {
                for (int resultCol = 0; resultCol < b.Cols; resultCol++)
                {
                    double value = 0;

                    for (int i = 0; i < a.Cols; i++)
                    {
                        value += a[resultRow, i] * b[i, resultCol];
                    }

                    result[resultRow, resultCol] = value;
                }
            }

            return new Matrix(result);
        }

        public static Matrix Subtract(Matrix a, Matrix b)
        {
            var result = new double[a.Rows, a.Cols];

            for (int resultRow = 0; resultRow < a.Rows; resultRow++)
            {
                for (int resultCol = 0; resultCol < a.Cols; resultCol++)
                {
                    result[resultRow, resultCol] = a[resultRow, resultCol] - b[resultRow, resultCol];
                }
            }

            return new Matrix(result);
        }

        public static Matrix Transpose(Matrix input)
        {
            var inverseMatrix = new double[input.Cols, input.Rows];

            for (int r = 0; r < input.Rows; r++)
            {
                for (int c = 0; c < input.Cols; c++)
                {
                    inverseMatrix[c, r] = input[r, c];
                }
            }

            return new Matrix(inverseMatrix);
        }

        public static double VectorLength(Matrix input)
        {
            double[] v = input.ToPackedArray();
            double rtn = 0.0;

            for (int i = 0; i < v.Length; i++)
            {
                rtn += System.Math.Pow(v[i], 2);
            }

            return System.Math.Sqrt(rtn);
        }
    }
}
