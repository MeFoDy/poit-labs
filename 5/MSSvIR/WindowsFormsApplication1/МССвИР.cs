using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.Text.RegularExpressions;

namespace MSSvIR
{
    public partial class MSSvIR : Form
    {
		public ProgramToGraph globalCode;
		public string[] classesList;

        public MSSvIR()
        {
			InitializeComponent();
			ProgramToGraph globalCode = new ProgramToGraph();
			classesList = globalCode.classes;
			HightLightCode(globalCode.GetFullCode(), outText);
        }

		private void mayersMetrButton_Click(object sender, EventArgs e)
		{
			MayersForm mayersForm = new MayersForm(classesList);
			mayersForm.Show();
		}

		private void chepinMetrButton_Click(object sender, EventArgs e)
		{
			ChepinForm chepinForm = new ChepinForm(classesList);
			chepinForm.Show();
		}

		private void spenMetrButton_Click(object sender, EventArgs e)
		{
			SpenForm spenForm = new SpenForm(classesList);
			spenForm.Show();
		}

		private void quitButton_Click(object sender, EventArgs e)
		{
			Application.Exit();
		}

		public static void HightLightCode(string inputString,RichTextBox textBox)
		{
			// string outputString;
			Regex r = new Regex(@"\r\n");
			String[] lines = r.Split(inputString);
			foreach (string l in lines)
			{
				ParseLine(l,textBox);
			}
			//   return outputString;
		}

		private static void ParseLine(string line,RichTextBox textBox)
		{
			//Regex r = new Regex("([ \\t{}():;])");
			Regex r = new Regex(@"([ \t[\*!&<>\{\}\(\):;])");
			String[] tokens = r.Split(line);
			foreach (string token in tokens)
			{
				// Set the tokens default color and font.
				textBox.SelectionColor = Color.Black;
                textBox.SelectionFont = new Font("Courier New", 10, FontStyle.Regular);
				// Check whether the token is a keyword. 
				// Check for a comment.
				if (token == "//" )
				{
					// Find the start of the comment and then extract the whole comment.
					int index = line.IndexOf( "//" );
					string comment = line.Substring(index, line.Length - index);
                    textBox.SelectionColor = Color.DarkGreen;
                    textBox.SelectionFont = new Font("Courier New", 10, FontStyle.Regular);
                    textBox.SelectedText = comment;
					break;
				}
				if ( token.StartsWith( "//" ) )
				{
					// Find the start of the comment and then extract the whole comment.
					int index = line.IndexOf( "//" );
					string comment = line.Substring(index, line.Length - index);
                    textBox.SelectionColor = Color.DarkGreen;
                    textBox.SelectionFont = new Font("Courier New", 10, FontStyle.Regular);
                    textBox.SelectedText = comment;
					break;
				}
				String[] keywords = { "extern", 
										"void", "static", "register", 
										"public", "private", "protected",
										"class", "struct", "using", "namespace",
										"int", "char", "float", "double", "unsigned", "bool", "long", "short", "string", "Dictionary", "String", "Regex", 
										"const"};
				String[] keywords2 = { "#include", "#define", "#if", "#ifdef", "#else" };
				String[] keywords3 = { "while", "for", "do", "foreach", "in", "as",
										 "try", "catch", "new",
										 "return", 
										 "switch", "case", "default",
										 "if", "else", 
										 "break", "continue"};
				String[] keywords4 = { "get", "gets", "printf", "scanf", "strcpy", "strlen", "open", "close", "strcat", "strcmp" };
				for (int i = 0; i < keywords.Length; i++)
				{
					if (keywords[i] == token)
					{
						// Apply alternative color and font to highlight keyword.
                        textBox.SelectionColor = Color.DarkViolet;
                        textBox.SelectionFont = new Font("Courier New", 10, FontStyle.Bold);
						//   break;
					}
				}
				for (int i = 0; i < keywords2.Length; i++)
				{
					if (keywords2[i] == token)
					{
                        textBox.SelectionColor = Color.DarkRed;
                        textBox.SelectionFont = new Font("Courier New", 10, FontStyle.Bold);
						//  break;
					}
				}
				for (int i = 0; i < keywords3.Length; i++)
				{
					if (keywords3[i] == token)
					{
                        textBox.SelectionColor = Color.Blue;
                        textBox.SelectionFont = new Font("Courier New", 10, FontStyle.Bold);
						//    break;
					}
				}
				for (int i = 0; i < keywords4.Length; i++)
				{
					if (keywords4[i] == token)
					{
                        textBox.SelectionColor = Color.DarkBlue;
                        textBox.SelectionFont = new Font("Courier New", 10, FontStyle.Bold);
						//    break;
					}
				}
                textBox.SelectedText = token;
			}
            textBox.SelectedText = "\n";
		}
    }
}
