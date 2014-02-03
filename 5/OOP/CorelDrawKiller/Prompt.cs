using System;
using System.Collections.Generic;
using System.Text;
using System.Windows.Forms;

namespace CorelDrawKiller
{
	public static class Prompt
	{
		static Form prompt = new Form();
		static Label textLabel = new Label() { Left = 50, Top = 20, Width = 400 };
		static TextBox textBox = new TextBox() { Left = 50, Top = 50, Width = 400, TabIndex = 0 };
		static Button confirmation = new Button() { Text = "OK", Left = 350, Width = 100, Top = 70, TabIndex = 1 };

		public static string ShowDialog(string text, string caption)
		{
			
			prompt.Width = 500;
			prompt.Height = 150;
			prompt.Text = caption;
			prompt.MaximizeBox = false;
			prompt.FormBorderStyle = FormBorderStyle.FixedSingle;
			
			textBox.KeyUp += new KeyEventHandler(textBox_KeyUp);

			textLabel.Text = text;

			textBox.TabIndex = 0;
			confirmation.TabIndex = 1;

			confirmation.Click += (sender, e) => { prompt.Close(); };
			prompt.Controls.Add(confirmation);
			prompt.Controls.Add(textLabel);
			prompt.Controls.Add(textBox);
			prompt.ShowDialog();
			return textBox.Text;
		}

		static void textBox_KeyUp(object sender, KeyEventArgs e)
		{
			if (e.KeyCode == Keys.Enter)
			{
				confirmation.PerformClick();
			}
		}
	}
}
