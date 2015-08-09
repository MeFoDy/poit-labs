using System;
using System.Drawing;
using System.Windows.Forms;
using BinaryRandomizer.Runner;
using Hopfield.Runner;

namespace Hopfield.WinForms
{
    public partial class MainForm : Form
    {
        public MainForm()
        {
            InitializeComponent();
        }


        private void button1_Click(object sender, EventArgs e)
        {
            var result = folderBrowserDialog.ShowDialog();
            if (result == DialogResult.OK)
            {
                RandomizerRunner.GenerateHopfield(folderBrowserDialog.SelectedPath);
                MessageBox.Show(@"Noised images were generated successfully");
            }
        }

        private void button2_Click(object sender, EventArgs e)
        {
            var result = folderBrowserDialog.ShowDialog();
            if (result == DialogResult.OK)
            {
                string text = HopfieldRunner.Run(folderBrowserDialog.SelectedPath);
                richTextBox.Text = text;
                MessageBox.Show(@"Analysing - completed");
            }
        }

        private void button3_Click(object sender, EventArgs e)
        {
            var result = openFileDialog.ShowDialog();
            if (result == DialogResult.OK)
            {
                var source = new Bitmap(openFileDialog.FileName);
                pictureBoxSource.Image = source;
                //int count = HopfieldRunner.Train(folderBrowserDialog.SelectedPath);
                Bitmap target = HopfieldRunner.CustomRun(openFileDialog.FileName);
                pictureBoxTarget.Image = target;
            }
        }
    }
}
