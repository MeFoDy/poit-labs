namespace CorelDrawKiller
{
	partial class BrushThiknessForm
	{
		/// <summary>
		/// Required designer variable.
		/// </summary>
		private System.ComponentModel.IContainer components = null;

		/// <summary>
		/// Clean up any resources being used.
		/// </summary>
		/// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
		protected override void Dispose(bool disposing)
		{
			if (disposing && (components != null))
			{
				components.Dispose();
			}
			base.Dispose(disposing);
		}

		#region Windows Form Designer generated code

		/// <summary>
		/// Required method for Designer support - do not modify
		/// the contents of this method with the code editor.
		/// </summary>
		private void InitializeComponent()
		{
			this.ThiknessTrackBar = new System.Windows.Forms.TrackBar();
			this.OkButton = new System.Windows.Forms.Button();
			this.CancelButton = new System.Windows.Forms.Button();
			this.ThiknessValueText = new System.Windows.Forms.TextBox();
			((System.ComponentModel.ISupportInitialize)(this.ThiknessTrackBar)).BeginInit();
			this.SuspendLayout();
			// 
			// ThiknessTrackBar
			// 
			this.ThiknessTrackBar.Location = new System.Drawing.Point(13, 13);
			this.ThiknessTrackBar.Maximum = 50;
			this.ThiknessTrackBar.Minimum = 1;
			this.ThiknessTrackBar.Name = "ThiknessTrackBar";
			this.ThiknessTrackBar.Size = new System.Drawing.Size(170, 45);
			this.ThiknessTrackBar.TabIndex = 0;
			this.ThiknessTrackBar.Value = 1;
			// 
			// OkButton
			// 
			this.OkButton.Location = new System.Drawing.Point(13, 60);
			this.OkButton.Name = "OkButton";
			this.OkButton.Size = new System.Drawing.Size(112, 23);
			this.OkButton.TabIndex = 1;
			this.OkButton.Text = "OK";
			this.OkButton.UseVisualStyleBackColor = true;
			this.OkButton.Click += new System.EventHandler(this.OkButton_Click);
			// 
			// CancelButton
			// 
			this.CancelButton.Location = new System.Drawing.Point(131, 60);
			this.CancelButton.Name = "CancelButton";
			this.CancelButton.Size = new System.Drawing.Size(103, 23);
			this.CancelButton.TabIndex = 2;
			this.CancelButton.Text = "Отмена";
			this.CancelButton.UseVisualStyleBackColor = true;
			this.CancelButton.Click += new System.EventHandler(this.CancelButton_Click);
			// 
			// ThiknessValueText
			// 
			this.ThiknessValueText.BackColor = System.Drawing.SystemColors.ButtonFace;
			this.ThiknessValueText.BorderStyle = System.Windows.Forms.BorderStyle.None;
			this.ThiknessValueText.Location = new System.Drawing.Point(189, 13);
			this.ThiknessValueText.Name = "ThiknessValueText";
			this.ThiknessValueText.Size = new System.Drawing.Size(45, 13);
			this.ThiknessValueText.TabIndex = 3;
			// 
			// BrushThiknessForm
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(246, 95);
			this.Controls.Add(this.ThiknessValueText);
			this.Controls.Add(this.CancelButton);
			this.Controls.Add(this.OkButton);
			this.Controls.Add(this.ThiknessTrackBar);
			this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
			this.MaximizeBox = false;
			this.Name = "BrushThiknessForm";
			this.Text = "Толщина кисти";
			((System.ComponentModel.ISupportInitialize)(this.ThiknessTrackBar)).EndInit();
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.TrackBar ThiknessTrackBar;
		private System.Windows.Forms.Button OkButton;
		private System.Windows.Forms.Button CancelButton;
		private System.Windows.Forms.TextBox ThiknessValueText;
	}
}