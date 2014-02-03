using System;
using System.Collections.Generic;
using System.Linq;
using System.Windows.Forms;

namespace lab1
{
    public partial class MainForm : Form
    {
        public MainForm()
        {
            InitializeComponent();
        }

        private void buttonStart_Click(object sender, EventArgs e)
        {
            ClearGraphs();

            var x = new List<double>();
            Int64 r = Int64.Parse(textBoxR0.Text);
            Int64 a = Int64.Parse(textBoxA.Text);
            Int64 m = Int64.Parse(textBoxM.Text);
            const Int64 n = 1000000;
            const int k = 20;

            // генерация псевдослучайных чисел
            for (int i = 0; i < n; i++)
            {
                r = (r * a) % m;
                x.Add((double) r/m);
            }

            // построение гистограммы
            var xMin = x.Min();
            var xMax = x.Max();
            var rVar = xMax - xMin;
            double delta = rVar/k;
            var popadCount = new long[k];
            var histX = new double[k];
            foreach (var elem in x)
            {
                popadCount[(int) (((elem - xMin)/delta) < 20 ? (elem - xMin)/delta : 19)]++;
            }
            for (int i = 0; i < k; i++)
            {
                histX[i] = xMin + (delta*i);
            }
            chartHist.Series[0].Points.DataBindXY(histX, popadCount);
            
            //мат. ожидание, дисперсия и сигма
            var sum = x.Sum();
            var matOzh = sum/x.Count;
            richTextBox.Text += @"m = " + matOzh + '\n';
            var dSum = x.Sum(t => Math.Pow(t - matOzh, 2));
            var disp = dSum/x.Count;
            richTextBox.Text += @"D = " + disp + '\n';
            richTextBox.Text += @"Sigma = " + Math.Sqrt(disp) + "\n\n";

            //оценка равномерности по косвенным признакам
            var innerCount = 0;
            for (int i = 0; i + 1 < x.Count; i += 2)
            {
                if (x[i]*x[i] + x[i + 1]*x[i + 1] < 1)
                {
                    innerCount++;
                }
            }
            richTextBox.Text += @"Pi / 4 = " + Math.PI / 4.0 + '\n';
            richTextBox.Text += @"2K / N = " + innerCount * 2.0 / x.Count + "\n\n";

            //длина периода и длина отрезка апериодичности
            var xv = x.Last();
            var pos = new int[2];
            bool isFirst = false;
            const double epsilon = double.Epsilon;
            for(int i=0; i<x.Count; i++)
            {
                if (Math.Abs(x[i] - xv) < epsilon)
                {
                    if (isFirst)
                    {
                        pos[1] = i;
                        break;
                    }
                    isFirst = true;
                    pos[0] = i;
                }
            }
            var l = pos[1] - pos[0];
            var pos0 = 0;
            for (int i = 0; i + l < x.Count; i++)
            {
                if (Math.Abs(x[i] - x[i + l]) < epsilon)
                {
                    pos0 = i;
                    break;
                }
            }
            richTextBox.Text += @"Длина периода = " + l + '\n';
            richTextBox.Text += @"Длина участка апериодичности = " + (l + pos0) + '\n';
        }

        private void ClearGraphs()
        {
            //chartHist.Series.Clear();
            chartHist.ResetAutoValues();
            richTextBox.Text = "";
        }
    }
}
