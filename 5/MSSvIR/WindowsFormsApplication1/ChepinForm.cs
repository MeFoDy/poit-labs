using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;

namespace MSSvIR
{
	public partial class ChepinForm : Form
	{
		Dictionary<string, char> letters;
		ProgramToGraph code;

		public ChepinForm(string[] classes)
		{
			InitializeComponent();
			code = new ProgramToGraph();
			ChepClassSelect.DropDownStyle = ComboBoxStyle.DropDownList;

			foreach (string cl in classes)
			{
				ChepClassSelect.Items.Add(cl);
			}
		}

		private void ChepClassSelect_SelectedIndexChanged(object sender, EventArgs e)
		{
			Dictionary<string, int> variables = new Dictionary<string, int>();
			code.chepinLetters.Clear();
			string source = code.GetFullCode();
			variables = code.GetChepMetrics(ChepClassSelect.SelectedItem.ToString());
			letters = code.chepinLetters;
			
			int p;
			int m;
			int c;
			int t;
			p = m = c = t = 0;
			dataGridView1.Rows.Clear();
			foreach (KeyValuePair<string, int> a in variables)
			{
				//Console.WriteLine("{0} : {1}", a.Key, a.Value);
				if (a.Value >= 0)
				{
					char o = letters[a.Key];
					if (a.Value == 0)
					{
						o = 'T';
					}
					switch (o)
					{
						case 'T': t++;
							break;
						case 'M': m++;
							break;
						case 'C': c++;
							break;
						case 'P': p++;
							break;
					}
					string[] row = { a.Key, o.ToString(), a.Value.ToString() };
					dataGridView1.Rows.Add(row);
				}
				chepinCount.Text = (p + 2 * m + 3 * c + 0.5 * t).ToString();
				formula.Text = "p + 2*m + 3*c + 0.5*t = " + p.ToString() + " + 2*" + m.ToString() + " + 3*" + c.ToString() + " + 0.5*" + t.ToString();
			}

		}

	}
}
