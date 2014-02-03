using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.Timers;

namespace TimeMachine
{
	public partial class TimeMachineForm : Form
	{
		private List<TimeInterval> intervalTypesList = new List<TimeInterval>();
		private int logCounter = 0;

		private TimeInterval sourceTimeInterval;

		public TimeMachineForm()
		{
			InitializeComponent();

			intervalTypesList.Insert(0, new Year());
			intervalTypesList.Insert(1, new HalfYear());
			intervalTypesList.Insert(2, new Month());
			intervalTypesList.Insert(3, new Week());
			intervalTypesList.Insert(4, new Day());
			intervalTypesList.Insert(5, new Hour());

			foreach (TimeInterval ti in intervalTypesList)
			{
				sourceTypeDateInput.Items.Add(ti.Name);
				newTypeDateInput.Items.Add(ti.Name);
			}
			sourceTypeDateInput.SelectedIndex = 0;
			newTypeDateInput.SelectedIndex = 0;



		}

		private void currentTimeTimer_Tick(object sender, EventArgs e)
		{
			currentTime.Text = DateTime.Now.ToString("dd.MM.yyyy HH:mm:ss");
		}

		private void setDateButton_Click(object sender, EventArgs e)
		{
			sourceTimeInterval = intervalTypesList[sourceTypeDateInput.SelectedIndex];
			sourceTimeInterval.SetSourceTimeInterval((int) sourceCountInput.Value, (int) sourceMultiplierInput.Value);
			convertDateButton.Enabled = true;
		}

		private void convertDateButton_Click(object sender, EventArgs e)
		{
			sourceTimeInterval.Calculate((int) newMultiplierInput.Value, intervalTypesList[newTypeDateInput.SelectedIndex]);

			newCountInput.Text = sourceTimeInterval.NewCount.ToString();
			logCounter++;
			logTextBox.Text += logCounter.ToString() + ". Время запроса: " + sourceTimeInterval.CurrentTime.ToString() 
							+ "\n"
							+ sourceTimeInterval.SourceCount.ToString() + "*[" + sourceTimeInterval.SourceMultiplier.ToString() + " " + sourceTimeInterval.Name + "]"
							+ " ---> [" + newMultiplierInput.Value.ToString() + " " + intervalTypesList[newTypeDateInput.SelectedIndex].Name + "]"
							+ "  =  " + sourceTimeInterval.NewCount.ToString() + "*[" + newMultiplierInput.Value.ToString() + " " + intervalTypesList[newTypeDateInput.SelectedIndex].Name + "]"
							+ "\n"
							+ sourceTimeInterval.NewDate.ToString() + " --- " + sourceTimeInterval.CurrentTime.ToString()
							+ "\n====================================================================\n";

			logTextBox.SelectionStart = logTextBox.Text.Length;
			logTextBox.ScrollToCaret();
		}
		
	}
}
