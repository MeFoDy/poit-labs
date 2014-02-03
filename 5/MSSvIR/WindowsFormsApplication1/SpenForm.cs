using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;

namespace MSSvIR
{
	public partial class SpenForm : Form
	{
		public ProgramToGraph code;
		public string source;

		public SpenForm(string[] classes)
		{
			InitializeComponent();
			code = new ProgramToGraph();
			SpenClassSelect.DropDownStyle = ComboBoxStyle.DropDownList;

			foreach (string cl in classes)
			{
				SpenClassSelect.Items.Add(cl);
			}
		}
		
		private void SpenClassSelect_SelectedIndexChanged(object sender, EventArgs e)
		{
			Dictionary<string, int> variables = new Dictionary<string,int>();
			source = code.GetFullCode();
		//	sourceCode.Text = ProgramToGraph.AddLineBreaks(code.GetClassBody(source, SpenClassSelect.SelectedItem.ToString()));
            MSSvIR.HightLightCode(ProgramToGraph.AddLineBreaks(code.GetClassBody(source, SpenClassSelect.SelectedItem.ToString())), sourceCode);
            variables = code.GetSpenMetrics(SpenClassSelect.SelectedItem.ToString());

			dataGridView1.Rows.Clear();
			foreach (KeyValuePair<string, int> a in variables)
			{
				Console.WriteLine("{0} : {1}", a.Key, a.Value);
				if (a.Value >= 0)
				{
					string[] row = { a.Key, a.Value.ToString() };
					dataGridView1.Rows.Add(row);
				}
			}
		}
	}
}
