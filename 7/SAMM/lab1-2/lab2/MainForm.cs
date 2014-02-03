using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using System.Windows.Forms;

namespace lab2
{
    public partial class MainForm : Form
    {
        private const int K = 20;
        private const Int64 N = 1000000;
        private readonly Random _rGenerator = new Random();

        public MainForm()
        {
            InitializeComponent();
        }

        #region Helpers
        private static IEnumerable<double> HistX(List<double> x)
        {
            var xMin = x.Min();
            var xMax = x.Max();
            var rVar = xMax - xMin;
            var delta = rVar / K;
            var histX = new double[K];
            for (int i = 0; i < K; i++)
            {
                histX[i] = xMin + (delta * i);
            }
            return histX;
        }

        private static IEnumerable<long> HistY(List<double> x)
        {
            var xMin = x.Min();
            var xMax = x.Max();
            var rVar = xMax - xMin;
            var delta = rVar / K;
            var popadCount = new long[K];
            foreach (var elem in x)
            {
                popadCount[(int)(((elem - xMin) / delta) < K ? (elem - xMin) / delta : (K - 1))]++;
            }
            return popadCount;
        }

        private static double MathWaiting(List<double> x)
        {
            var sum = x.Sum();
            var matOzh = sum / x.Count;
            return matOzh;
        }

        private static double Dispersy(List<double> x)
        {
            var matOzh = MathWaiting(x);
            var dSum = x.Sum(t => Math.Pow(t - matOzh, 2));
            var disp = dSum / x.Count;
            return disp;
        }

        private double SrKvadrOtkl(List<double> x)
        {
            return Math.Sqrt(Dispersy(x));
        }
        #endregion

        private void ravnButton_Click(object sender, EventArgs e)
        {
            chartRavn.ResetAutoValues();
            ravnRichTextBox.Text = "";

            var x = new List<double>();
            var a = Double.Parse(ravnATextBox.Text);
            var b = Double.Parse(ravnBTextBox.Text);

            for (var i = 0; i < N; i++)
            {
                var r = _rGenerator.NextDouble();
                x.Add(a + (b - a) * r);
            }

            chartRavn.Series[0].Points.DataBindXY(HistX(x), HistY(x));

            ravnRichTextBox.Text += @"m = " + MathWaiting(x) + '\n';
            ravnRichTextBox.Text += @"D = " + Dispersy(x) + '\n';
            ravnRichTextBox.Text += @"Sigma = " + SrKvadrOtkl(x) + "\n\n";
        }

        private void haussButton_Click(object sender, EventArgs e)
        {
            haussChart.ResetAutoValues();
            haussRichTextBox.Text = "";

            var x = new List<double>();
            var n = haussNTrackBar.Value;
            var m = Double.Parse(haussMTextBox.Text);
            var s = Double.Parse(haussSTextBox.Text);

            for (var i = 0; i < N; i++)
            {
                var sum = 0.0;
                for (var j = 0; j < n; j++)
                {
                    sum += _rGenerator.NextDouble();
                }
                x.Add(m + s * Math.Sqrt(12.0 / n) * (sum - n / 2.0));
            }

            haussChart.Series[0].Points.DataBindXY(HistX(x), HistY(x));

            haussRichTextBox.Text += @"m = " + MathWaiting(x) + '\n';
            haussRichTextBox.Text += @"D = " + Dispersy(x) + '\n';
            haussRichTextBox.Text += @"Sigma = " + SrKvadrOtkl(x) + "\n\n";
        }

        private void haussNTrackBar_Scroll(object sender, EventArgs e)
        {
            label6.Text = haussNTrackBar.Value.ToString(CultureInfo.InvariantCulture);
        }

        private void ekspButton_Click(object sender, EventArgs e)
        {
            ekspChart.ResetAutoValues();
            ekspRichTextBox.Text = "";

            var x = new List<double>();
            var l = Double.Parse(ekspLTextBox.Text.Replace(',', '.'), CultureInfo.InvariantCulture);

            if (Math.Abs(l - 0) < double.Epsilon)
            {
                MessageBox.Show(@"Lambda cannot be nullable", @"Error");
                return;
            }

            for (var i = 0; i < N; i++)
            {
                var r = _rGenerator.NextDouble();
                x.Add(-1 / l * Math.Log(r, Math.E));
            }

            ekspChart.Series[0].Points.DataBindXY(HistX(x), HistY(x));

            ekspRichTextBox.Text += @"m = " + MathWaiting(x) + '\n';
            ekspRichTextBox.Text += @"D = " + Dispersy(x) + '\n';
            ekspRichTextBox.Text += @"Sigma = " + SrKvadrOtkl(x) + "\n\n";
        }

        private void hammaButton_Click(object sender, EventArgs e)
        {
            hammaChart.ResetAutoValues();
            hammaRichTextBox.Text = "";

            var x = new List<double>();
            var l = Double.Parse(hammaLTextBox.Text.Replace(',', '.'), CultureInfo.InvariantCulture);
            var n = Int64.Parse(hammaNTextBox.Text, NumberStyles.Any);

            if (Math.Abs(l - 0) < double.Epsilon)
            {
                MessageBox.Show(@"Lambda cannot be nullable", @"Error");
                return;
            }

            for (var i = 0; i < N; i++)
            {
                var pr = 1.0;
                for (var j = 0; j < n; j++)
                {
                    pr *= _rGenerator.NextDouble();
                }
                x.Add(-1 / l * Math.Log(pr, Math.E));
            }

            hammaChart.Series[0].Points.DataBindXY(HistX(x), HistY(x));

            hammaRichTextBox.Text += @"m = " + MathWaiting(x) + '\n';
            hammaRichTextBox.Text += @"D = " + Dispersy(x) + '\n';
            hammaRichTextBox.Text += @"Sigma = " + SrKvadrOtkl(x) + "\n\n";
        }

        private void trButton_Click(object sender, EventArgs e)
        {
            trChartMin.ResetAutoValues();
            trChartMax.ResetAutoValues();
            trRichTextBox.Text = "";

            var xMin = new List<double>();
            var xMax = new List<double>();
            var a = Double.Parse(trATextBox.Text);
            var b = Double.Parse(trBTextBox.Text);

            for (var i = 0; i < N; i++)
            {
                var r1 = _rGenerator.NextDouble();
                var r2 = _rGenerator.NextDouble();
                xMax.Add(a + (b - a) * (r1 > r2 ? r1 : r2));
                xMin.Add(a + (b - a) * (r1 < r2 ? r1 : r2));
            }

            trChartMin.Series[0].Points.DataBindXY(HistX(xMin), HistY(xMin));
            trChartMax.Series[0].Points.DataBindXY(HistX(xMax), HistY(xMax));

            trRichTextBox.Text += @"Min:" + '\n';
            trRichTextBox.Text += @"m = " + MathWaiting(xMin) + '\n';
            trRichTextBox.Text += @"D = " + Dispersy(xMin) + '\n';
            trRichTextBox.Text += @"Sigma = " + SrKvadrOtkl(xMin) + "\n\n";
            trRichTextBox.Text += @"Max:" + '\n';
            trRichTextBox.Text += @"m = " + MathWaiting(xMax) + '\n';
            trRichTextBox.Text += @"D = " + Dispersy(xMax) + '\n';
            trRichTextBox.Text += @"Sigma = " + SrKvadrOtkl(xMax) + "\n\n";
        }

        private void simpsonButton_Click(object sender, EventArgs e)
        {
            simpsonChart.ResetAutoValues();
            simpsonRichTextBox.Text = "";

            var x = new List<double>();
            var a = Double.Parse(simpsonAtextBox.Text);
            var b = Double.Parse(simpsonBtextBox.Text);

            for (var i = 0; i < N; i++)
            {
                var z = _rGenerator.NextDouble();
                var y = _rGenerator.NextDouble();

                z *= (b/2.0 - a/2.0);
                y *= (b/2.0 - a/2.0);
                z += a/2.0;
                y += a/2.0;

                x.Add(z + y);
            }

            simpsonChart.Series[0].Points.DataBindXY(HistX(x), HistY(x));

            simpsonRichTextBox.Text += @"m = " + MathWaiting(x) + '\n';
            simpsonRichTextBox.Text += @"D = " + Dispersy(x) + '\n';
            simpsonRichTextBox.Text += @"Sigma = " + SrKvadrOtkl(x) + "\n\n";
        }
    }
}
