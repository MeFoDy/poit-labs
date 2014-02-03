using System.Windows.Forms;

namespace Lab1_2
{
	public partial class ShowElementsForm : Form
	{
		public ShowElementsForm()
		{
			InitializeComponent();

			Structure[] myFile =  Data.GeneratedArray;

			showElementsGrid.Rows.Clear();
			foreach (Structure s in myFile)
			{
				object[] row = {s.Key, s.Number, s.Str};
				showElementsGrid.Rows.Add(row);
			}
		}

		public ShowElementsForm(string s, Structure[] arr)
		{
			InitializeComponent();

			Text = s;
			showElementsGrid.Rows.Clear();
			foreach (Structure q in arr)
			{
				object[] row = { q.Key, q.Number, q.Str };
				showElementsGrid.Rows.Add(row);
			}
			
		}

		public override sealed string Text
		{
			get { return base.Text; }
			set { base.Text = value; }
		}
	}
}
