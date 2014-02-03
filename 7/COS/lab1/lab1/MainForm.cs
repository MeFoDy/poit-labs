using System;
using System.Windows.Forms;

namespace lab1
{
    public partial class MainForm : Form
    {
        private double[] fis =
            {
                Math.PI/3,
                3*Math.PI/4,
                2*Math.PI,
                Math.PI,
                Math.PI/6
            };
        private int[] fs = { 4, 8, 2, 1, 9 };
        private int[] As = { 4, 5, 3, 1, 7 };

        private double[] DefFijs =
            {
                Math.PI,
                Math.PI/4,
                0,
                3*Math.PI/4,
                Math.PI/2
            };

        private double[] fijs;

        int N = 512;

        public MainForm()
        {
            InitializeComponent();
            fijs = CopyArray(DefFijs);
        }

        public double FirstFunctionA(double fi, int n)
        {
            int A = 9;
            int f = 4;
            n = n % N;
            return A * Math.Sin(2 * Math.PI * f * n / N + fi);
        }

        public double FirstFunctionB(int f, int n)
        {
            int A = 7;
            double fi = Math.PI / 6;
            n = n % N;
            return A * Math.Sin(2 * Math.PI * f * n / N + fi);
        }

        public double FirstFunctionC(int A, int n)
        {
            int f = 7;
            double fi = Math.PI / 6;
            n = n % N;
            return A * Math.Sin(2 * Math.PI * f * n / N + fi);
        }

        private void FFA()
        {
            for (int i = 0; i < 5; i++)
            {
                FirstFunctionChart.Series[i].Points.Clear();
                FirstFunctionChart.Series[i].Name = "φ" + (i + 1).ToString() + ": " + Math.Round(fis[i], 5).ToString();
                var fi = fis[i];
                for (int n = 0; n < N; n++)
                {
                    FirstFunctionChart.Series[i].Points.AddXY(n, FirstFunctionA(fi, n));
                }
            }
            FirstFunctionChart.Refresh();
        }

        private void FFB()
        {
            for (int i = 0; i < 5; i++)
            {
                FirstFunctionChart.Series[i].Points.Clear();
                FirstFunctionChart.Series[i].Name = "f" + (i + 1).ToString() + ": " + Math.Round((double)fs[i], 5).ToString();
                var f = fs[i];
                for (int n = 0; n < N; n++)
                {
                    FirstFunctionChart.Series[i].Points.AddXY(n, FirstFunctionB(f, n));
                }
            }
            FirstFunctionChart.Refresh();
        }

        private void FFC()
        {
            for (int i = 0; i < 5; i++)
            {
                FirstFunctionChart.Series[i].Points.Clear();
                FirstFunctionChart.Series[i].Name = "A" + (i + 1).ToString() + ": " + Math.Round((double)As[i], 5).ToString();
                var A = As[i];
                for (int n = 0; n < N; n++)
                {
                    FirstFunctionChart.Series[i].Points.AddXY(n, FirstFunctionC(A, n));
                }
            }
            FirstFunctionChart.Refresh();
        }

        private void FirstFunctionButton_Click(object sender, EventArgs e)
        {
            FFA();
        }

        private void FirstFunctionBbutton_Click(object sender, EventArgs e)
        {
            FFB();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            FFC();
        }

        private double[] CopyArray(double[] ar)
        {
            var res = new double[ar.Length];
            for (int i = 0; i < ar.Length; i++)
            {
                res[i] = ar[i];
            }
            return res;
        }

        private void FunctionCButton_Click(object sender, EventArgs e)
        {
            fijs = CopyArray(DefFijs);
            trackBar1.Value = (int)Math.Round(fijs[0]) * 50;
            label1.Text = Math.Round(fijs[0], 2).ToString();
            trackBar2.Value = (int)Math.Round(fijs[1]) * 50;
            label2.Text = Math.Round(fijs[1], 2).ToString();
            trackBar3.Value = (int)Math.Round(fijs[2]) * 50;
            label3.Text = Math.Round(fijs[2], 2).ToString();
            trackBar4.Value = (int)Math.Round(fijs[3]) * 50;
            label4.Text = Math.Round(fijs[3], 2).ToString();
            trackBar5.Value = (int)Math.Round(fijs[4]) * 50;
            label5.Text = Math.Round(fijs[4], 2).ToString();
            SecondGraphDisplay();
        }

        private void SecondGraphDisplay()
        {
            for (int i = 0; i < 5; i++)
            {
                FirstFunctionChart.Series[i].Points.Clear();
                FirstFunctionChart.Series[i].Name = "φ" + (i + 1).ToString() + ": " + Math.Round(fijs[i], 5).ToString();
            }
            for (int n = 0; n < 3 * N; n++)
            {
                FirstFunctionChart.Series[0].Points.AddXY(n, SecondFunction(n));
            }
            FirstFunctionChart.Refresh();
        }

        private double SecondFunction(int n)
        {
            int A = 7;
            double sum = 0;
            n = n % N;
            for (int i = 0; i < 5; i++)
            {
                sum += A * Math.Sin(2 * Math.PI * (i + 1) * n / N + fijs[i]);
            }
            return sum;
        }

        private void trackBar1_Scroll(object sender, EventArgs e)
        {
            fijs[0] = trackBar1.Value / 50.0;
            label1.Text = Math.Round(fijs[0], 2).ToString();
            SecondGraphDisplay();
        }

        private void trackBar2_Scroll(object sender, EventArgs e)
        {
            fijs[1] = trackBar2.Value / 50.0;
            label2.Text = Math.Round(fijs[1], 2).ToString();
            SecondGraphDisplay();
        }

        private void trackBar3_Scroll(object sender, EventArgs e)
        {
            fijs[2] = trackBar3.Value / 50.0;
            label3.Text = Math.Round(fijs[2], 2).ToString();
            SecondGraphDisplay();
        }

        private void trackBar4_Scroll(object sender, EventArgs e)
        {
            fijs[3] = trackBar4.Value / 50.0;
            label4.Text = Math.Round(fijs[3], 2).ToString();
            SecondGraphDisplay();
        }

        private void trackBar5_Scroll(object sender, EventArgs e)
        {
            fijs[4] = trackBar5.Value / 50.0;
            label5.Text = Math.Round(fijs[4], 2).ToString();
            SecondGraphDisplay();
        }

        private void DefaultsButton_Click(object sender, EventArgs e)
        {
            trackBar10.Value = 7;
            label10.Text = trackBar10.Value.ToString();
            trackBar9.Value = 1;
            label9.Text = trackBar9.Value.ToString();
            trackBar7.Value = 100;
            label7.Text = (trackBar7.Value / 50.0).ToString();
            trackBar6.Value = 150;
            label6.Text = (trackBar6.Value / 50.0).ToString();
            DisplayThirdGraph();
        }

        private void ThirdGraphDisplay(int A, double f, double fi1, double fi2)
        {
            for (int i = 0; i < 5; i++)
                FirstFunctionChart.Series[i].Points.Clear();

            FirstFunctionChart.Series[0].Name = "A: " + A.ToString();
            FirstFunctionChart.Series[1].Name = "f: " + f.ToString();
            FirstFunctionChart.Series[3].Name = "φ1: " + fi1.ToString();
            FirstFunctionChart.Series[4].Name = "φ2: " + fi2.ToString();
            FirstFunctionChart.Series[2].Name = "";

            double[] fis = { fi1, fi2 };
            for (int n = 0; n < 3 * N; n++)
            {
                FirstFunctionChart.Series[2].Points.AddXY(n, MyFunction(A, f, fis, n));
            }
            FirstFunctionChart.Refresh();
        }

        private double MyFunction(double A, double f, double[] fi, int n)
        {
            double sum = 0;
            n = n % N;
            A += 0.2 * n / N;
            f -= 0.1 * n / N;
            fi[0] += 0.05 * n / N;
            fi[1] -= 0.05 * n / N;
            for (int i = 0; i < 2; i++)
            {
                sum += A * Math.Sin(2 * Math.PI * f * n / N + fi[i]);
            }
            return sum;
        }

        private void DisplayThirdGraph()
        {
            int A = trackBar10.Value;
            double f = trackBar9.Value;
            double fi1 = trackBar7.Value / 50.0;
            double fi2 = trackBar6.Value / 50.0;
            ThirdGraphDisplay(A, f, fi1, fi2);
        }

        private void trackBar10_Scroll(object sender, EventArgs e)
        {
            label10.Text = trackBar10.Value.ToString();
            DisplayThirdGraph();
        }

        private void trackBar9_Scroll(object sender, EventArgs e)
        {
            label9.Text = trackBar9.Value.ToString();
            DisplayThirdGraph();
        }

        private void trackBar7_Scroll(object sender, EventArgs e)
        {
            label7.Text = (trackBar7.Value / 50.0).ToString();
            DisplayThirdGraph();
        }

        private void trackBar6_Scroll(object sender, EventArgs e)
        {
            label6.Text = (trackBar6.Value / 50.0).ToString();
            DisplayThirdGraph();
        }


    }
}
