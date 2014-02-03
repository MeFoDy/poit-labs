using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using System.Windows.Forms;

namespace SAMM_4
{
    public partial class Form1 : Form
    {
        private double _lambda;
        private double _mu;
        private double _v;
        private double _timeOzh;
        private Random _rand = new Random();

        public Form1()
        {
            InitializeComponent();
        }

        private void goButton_Click(object sender, EventArgs e)
        {
            const int n = 10000;

            outputBox.Clear();
            _lambda = Double.Parse(lambdaBox.Text, NumberFormatInfo.InvariantInfo) / 60.0;
            _mu = Double.Parse(muBox.Text, NumberFormatInfo.InvariantInfo) / 60.0;
            _timeOzh = Double.Parse(timeBox.Text, NumberFormatInfo.InvariantInfo) * 60; //в минутах
            _v = 1.0 / _timeOzh;

            Double t = 0, to1 = 0, to2 = 0, tn, tj;
            int kOtk = 0, kObr = 0;
            var tInOch = new List<double>();
            var tOutOch = new List<double>();
            var tInCh = new List<Double>();
            var tOutCh = new List<Double>();

            Double avTimeObr = 0, avTimeOtk = 0;
            for (int i = 0; i < n; i++)
            {
                t += GetRandom(_lambda);
                if (t < to1 && t < to2)
                {
                    tInOch.Add(t);
                    tj = t + GetRandom(_v);
                    if (tj < to2 && tj < to1)
                    {
                        tOutOch.Add(tj);
                        avTimeOtk += tj - t;
                        kOtk++;
                        continue;
                    }
                    else
                    {
                        if (to2 < to1)
                        {
                            tn = to2;
                            avTimeObr += tn - t;
                            tInCh.Add(tn);
                            tOutOch.Add(to2);
                            to2 = tn + GetRandom(_mu);
                            tOutCh.Add(to2);
                        }
                        else
                        {
                            tn = to1;
                            avTimeObr += tn - t;
                            tInCh.Add(tn);
                            tOutOch.Add(to1);
                            to1 = tn + GetRandom(_mu);
                            tOutCh.Add(to1);
                        }
                    }
                }
                else
                {
                    tn = t;
                    avTimeObr += tn - t;
                    tInCh.Add(tn);
                    if (to1 <= to2)
                    {
                        to1 = tn + GetRandom(_mu);
                        tOutCh.Add(to1);
                    }
                    else
                    {
                        to2 = tn + GetRandom(_mu);
                        tOutCh.Add(to2);
                    }
                }
                kObr++;
            }
            outputBox.Text = String.Format("Заявок отклонено: {0}\nЗаявок обработано: {1}\n\n\n", kOtk, kObr);

            // среднее время нахождения в очереди
            outputBox.Text += String.Format("Средняя длина очереди: {0}\nСреднее число занятых каналов: {1}\n\n", Average(tInOch, tOutOch), Average(tInCh, tOutCh));
            outputBox.Text += String.Format("Среднее время ожидания обр. заявок: {0} ч.\nСреднее время ожидания откл. заявок: {1} ч.", avTimeObr / kObr / 60, avTimeOtk / kOtk / 60);
        }

        private Double GetRandom(Double lambda)
        {
            return Math.Ceiling(-(1 / lambda) * Math.Log(_rand.NextDouble()));
        }

        private static Double Pereschet(double oldValue, double oldTime, double newValue, double newTime)
        {
            double sum = oldTime + newTime;
            double k1 = oldTime/sum;
            double k2 = newTime/sum;
            return (oldValue*k1 + newValue*k2);
        }

        private double Average(List<Double> tInOch, List<Double> tOutOch)
        {
            tInOch.Sort();
            tOutOch.Sort();
            int current = 0;
            double prevTime = 0, av = 0;
            while (true)
            {
                if (tInOch.Count == 0 && tOutOch.Count == 0)
                {
                    break;
                }
                double stTime;
                if (tInOch.Count > 0 && tInOch.First() < tOutOch.First())
                {
                    stTime = tInOch.First();
                    if (stTime > 0)
                    {
                        av = Pereschet(av, prevTime, current, stTime - prevTime);
                    }
                    current++;
                    prevTime = stTime;
                    tInOch.RemoveAt(0);
                }
                else
                {
                    stTime = tOutOch.First();
                    if (stTime > 0)
                    {
                        av = Pereschet(av, prevTime, current, stTime - prevTime);
                    }
                    current--;
                    prevTime = stTime;
                    tOutOch.RemoveAt(0);
                }
            }
            return av;
        }
    }
}
