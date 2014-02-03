using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;

namespace CorelDrawKiller
{
	public partial class BrushThiknessForm : Form
	{
		public BrushThiknessForm()
		{
			InitializeComponent();
			ThiknessTrackBar.Value = CorelDrawKiller.CDKForm.GlobalShapeThikness;
			ThiknessValueText.Text = ThiknessTrackBar.Value.ToString();
			ThiknessTrackBar.Scroll += new System.EventHandler(TrackBarScroll);
		}

		private void TrackBarScroll(object sender, System.EventArgs e)
		{
			ThiknessValueText.Text = ThiknessTrackBar.Value.ToString();
		}

		private void CancelButton_Click(object sender, EventArgs e)
		{
			this.Close();
		}

		private void OkButton_Click(object sender, EventArgs e)
		{
			CorelDrawKiller.CDKForm.GlobalShapeThikness = ThiknessTrackBar.Value;
			this.Close();
		}
	}
}
