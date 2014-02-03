using System;
using System.Windows.Forms;

namespace Lab1_2
{
	public partial class SearchForm : Form
	{

		public SearchForm()
		{
			InitializeComponent();
		}

		private void button1_Click(object sender, EventArgs e)
		{
			showElementsGrid.Rows.Clear();

			if (KeyTextBox.Text != string.Empty)
			{
				string stringEntered = KeyTextBox.Text;

				foreach (Structure s in Data.GeneratedArray)
				{
					if (s.Key.Equals(stringEntered))
					{
						object[] row = { s.Key, s.Number, s.Str };
						showElementsGrid.Rows.Add(row);
						return;
					}
				}

				MessageBox.Show(@"Not found", @"Not found", MessageBoxButtons.OK);

			}

		}
	}
}
