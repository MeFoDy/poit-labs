using System;
using System.Collections.Generic;
using System.Globalization;
using System.Windows.Forms;

namespace SAMM_3
{
    public partial class Form1 : Form
    {
        private int _n;
        private double _p1;
        private double _p2;
        private Dictionary<string, int> _p;

        long _och, _block, _bl;

        public Form1()
        {
            InitializeComponent();
        }

        private void goButton_Click(object sender, EventArgs e)
        {
            _n = int.Parse(nBox.Text);
            _p1 = double.Parse(p1Box.Text, NumberFormatInfo.InvariantInfo);
            _p2 = double.Parse(p2Box.Text, NumberFormatInfo.InvariantInfo);

            _p = new Dictionary<string, int>();
            _och = 0;
            _block = _n;
            _bl = 0;

            Run();
            PrintResult();
        }

        private void PrintResult()
        {
            foreach (KeyValuePair<string, int> pair in _p)
            {
                resultTextBox.Text += String.Format("Node {0}: probability {1}\n", pair.Key, (double)pair.Value / _n);
            }

            resultTextBox.Text += String.Format("\nLоч = {0}; Pотк = {1}; Pбл = {2};\n", (double)_och / _n, (double)_block / _n, (double)_bl / _n);
        }

        private void Run()
        {
            outputTextBox.Clear();
            resultTextBox.Clear();
            var r = new Random();

            int[] cond = { 2, 0, 0, 0 };
            for (int i = 0; i < _n; i++)
            {
                _och += cond[1];

                if (i < 1000)
                    outputTextBox.Text += String.Format("{0}{1}{2}{3}\n", cond[0], cond[1], cond[2], cond[3]);
                // stat
                string key = String.Format("{0}{1}{2}{3}", cond[0], cond[1], cond[2], cond[3]);
                if (_p.ContainsKey(key))
                {
                    _p[key]++;
                }
                else
                {
                    _p.Add(key, 1);
                }

                //p2
                if (cond[3] == 1 && r.NextDouble() < _p2)
                {
                    cond[3] = 1;
                }
                else
                {
                    _block--;
                    cond[3] = 0;
                }

                //p1
                if (r.NextDouble() < _p1)
                {
                }
                else
                {
                    if (cond[3] == 1 && cond[2] == 1)
                    {
                    }
                    if (cond[3] == 0 && cond[2] == 1)
                    {
                        cond[3]++;
                    }
                    cond[2] = 0;
                }

                //N
                if (cond[1] > 0 && cond[2] == 0)
                {
                    cond[1]--;
                    cond[2]++;
                }

                //Potok
                if (cond[0] == 1)
                {
                    if (cond[1] == 2)
                    {
                        cond[0] = 0;
                    }
                    else
                    {
                        cond[0] = 2;
                        cond[1]++;
                    }
                }
                else if (cond[0] == 2)
                {
                    cond[0]--;
                }
                else if (cond[0] == 0)
                {
                    _bl++;
                    if (cond[1] == 2)
                    {

                    }
                    else
                    {
                        cond[1]++;
                        cond[0] = 2;
                    }
                }

                //N
                if (cond[1] > 0 && cond[2] == 0)
                {
                    cond[1]--;
                    cond[2]++;
                }
            }
            outputTextBox.Text += @"...";
        }
    }
}
