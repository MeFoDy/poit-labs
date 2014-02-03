namespace MSSvIR
{
	partial class MayersForm
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
			this.GraphPanel = new System.Windows.Forms.PictureBox();
			this.TopsListBox = new System.Windows.Forms.ComboBox();
			this.CodOfTop = new System.Windows.Forms.RichTextBox();
			this.LabelCurrentTop = new System.Windows.Forms.Label();
			this.CodInTop = new System.Windows.Forms.Label();
			this.label1 = new System.Windows.Forms.Label();
			this.mayersCount = new System.Windows.Forms.TextBox();
			this.makkeibCount = new System.Windows.Forms.TextBox();
			this.label2 = new System.Windows.Forms.Label();
			this.comboBoxClass = new System.Windows.Forms.ComboBox();
			this.comboBoxFunction = new System.Windows.Forms.ComboBox();
			this.label3 = new System.Windows.Forms.Label();
			this.label4 = new System.Windows.Forms.Label();
			((System.ComponentModel.ISupportInitialize)(this.GraphPanel)).BeginInit();
			this.SuspendLayout();
			// 
			// GraphPanel
			// 
			this.GraphPanel.BackColor = System.Drawing.SystemColors.ButtonHighlight;
			this.GraphPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.GraphPanel.Location = new System.Drawing.Point(319, 12);
			this.GraphPanel.Name = "GraphPanel";
			this.GraphPanel.Size = new System.Drawing.Size(504, 619);
			this.GraphPanel.TabIndex = 0;
			this.GraphPanel.TabStop = false;
			// 
			// TopsListBox
			// 
			this.TopsListBox.FormattingEnabled = true;
			this.TopsListBox.Location = new System.Drawing.Point(12, 127);
			this.TopsListBox.Name = "TopsListBox";
			this.TopsListBox.Size = new System.Drawing.Size(301, 21);
			this.TopsListBox.TabIndex = 1;
			this.TopsListBox.Text = "0";
			this.TopsListBox.SelectedIndexChanged += new System.EventHandler(this.TopsListBox_SelectedIndexChanged);
			// 
			// CodOfTop
			// 
			this.CodOfTop.BackColor = System.Drawing.Color.WhiteSmoke;
			this.CodOfTop.Location = new System.Drawing.Point(12, 170);
			this.CodOfTop.Name = "CodOfTop";
			this.CodOfTop.Size = new System.Drawing.Size(301, 461);
			this.CodOfTop.TabIndex = 2;
			this.CodOfTop.Text = "";
			// 
			// LabelCurrentTop
			// 
			this.LabelCurrentTop.AutoSize = true;
			this.LabelCurrentTop.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
			this.LabelCurrentTop.Location = new System.Drawing.Point(9, 108);
			this.LabelCurrentTop.Name = "LabelCurrentTop";
			this.LabelCurrentTop.Size = new System.Drawing.Size(153, 16);
			this.LabelCurrentTop.TabIndex = 3;
			this.LabelCurrentTop.Text = "Выберите вершину:";
			// 
			// CodInTop
			// 
			this.CodInTop.AutoSize = true;
			this.CodInTop.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
			this.CodInTop.Location = new System.Drawing.Point(12, 151);
			this.CodInTop.Name = "CodInTop";
			this.CodInTop.Size = new System.Drawing.Size(172, 16);
			this.CodInTop.TabIndex = 3;
			this.CodInTop.Text = "Исходный код в вершине:";
			// 
			// label1
			// 
			this.label1.AutoSize = true;
			this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
			this.label1.Location = new System.Drawing.Point(9, 12);
			this.label1.Name = "label1";
			this.label1.Size = new System.Drawing.Size(145, 16);
			this.label1.TabIndex = 4;
			this.label1.Text = "Метрика Майерса:";
			// 
			// mayersCount
			// 
			this.mayersCount.Location = new System.Drawing.Point(12, 31);
			this.mayersCount.Name = "mayersCount";
			this.mayersCount.ReadOnly = true;
			this.mayersCount.Size = new System.Drawing.Size(142, 20);
			this.mayersCount.TabIndex = 5;
			// 
			// makkeibCount
			// 
			this.makkeibCount.Location = new System.Drawing.Point(163, 31);
			this.makkeibCount.Name = "makkeibCount";
			this.makkeibCount.ReadOnly = true;
			this.makkeibCount.Size = new System.Drawing.Size(150, 20);
			this.makkeibCount.TabIndex = 7;
			// 
			// label2
			// 
			this.label2.AutoSize = true;
			this.label2.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
			this.label2.Location = new System.Drawing.Point(160, 12);
			this.label2.Name = "label2";
			this.label2.Size = new System.Drawing.Size(153, 16);
			this.label2.TabIndex = 6;
			this.label2.Text = "Метрика Маккейба:";
			// 
			// comboBoxClass
			// 
			this.comboBoxClass.FormattingEnabled = true;
			this.comboBoxClass.Location = new System.Drawing.Point(146, 56);
			this.comboBoxClass.Name = "comboBoxClass";
			this.comboBoxClass.Size = new System.Drawing.Size(167, 21);
			this.comboBoxClass.TabIndex = 8;
			this.comboBoxClass.SelectedIndexChanged += new System.EventHandler(this.comboBoxClass_SelectedIndexChanged);
			// 
			// comboBoxFunction
			// 
			this.comboBoxFunction.FormattingEnabled = true;
			this.comboBoxFunction.Location = new System.Drawing.Point(171, 83);
			this.comboBoxFunction.Name = "comboBoxFunction";
			this.comboBoxFunction.Size = new System.Drawing.Size(142, 21);
			this.comboBoxFunction.TabIndex = 9;
			this.comboBoxFunction.SelectedIndexChanged += new System.EventHandler(this.comboBoxFunction_SelectedIndexChanged);
			// 
			// label3
			// 
			this.label3.AutoSize = true;
			this.label3.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
			this.label3.Location = new System.Drawing.Point(9, 57);
			this.label3.Name = "label3";
			this.label3.Size = new System.Drawing.Size(131, 16);
			this.label3.TabIndex = 10;
			this.label3.Text = "Выберите класс:";
			// 
			// label4
			// 
			this.label4.AutoSize = true;
			this.label4.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
			this.label4.Location = new System.Drawing.Point(9, 83);
			this.label4.Name = "label4";
			this.label4.Size = new System.Drawing.Size(156, 16);
			this.label4.TabIndex = 11;
			this.label4.Text = "Выберите функцию:";
			// 
			// MayersForm
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(835, 643);
			this.Controls.Add(this.label4);
			this.Controls.Add(this.label3);
			this.Controls.Add(this.comboBoxFunction);
			this.Controls.Add(this.comboBoxClass);
			this.Controls.Add(this.makkeibCount);
			this.Controls.Add(this.label2);
			this.Controls.Add(this.mayersCount);
			this.Controls.Add(this.label1);
			this.Controls.Add(this.CodInTop);
			this.Controls.Add(this.LabelCurrentTop);
			this.Controls.Add(this.CodOfTop);
			this.Controls.Add(this.TopsListBox);
			this.Controls.Add(this.GraphPanel);
			this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
			this.MaximizeBox = false;
			this.Name = "MayersForm";
			this.Text = "Метрика Майерса";
			((System.ComponentModel.ISupportInitialize)(this.GraphPanel)).EndInit();
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.PictureBox GraphPanel;
		private System.Windows.Forms.ComboBox TopsListBox;
		private System.Windows.Forms.RichTextBox CodOfTop;
		private System.Windows.Forms.Label LabelCurrentTop;
		private System.Windows.Forms.Label CodInTop;
		private System.Windows.Forms.Label label1;
		private System.Windows.Forms.TextBox mayersCount;
		private System.Windows.Forms.TextBox makkeibCount;
		private System.Windows.Forms.Label label2;
		private System.Windows.Forms.ComboBox comboBoxClass;
		private System.Windows.Forms.ComboBox comboBoxFunction;
		private System.Windows.Forms.Label label3;
		private System.Windows.Forms.Label label4;
	}
}