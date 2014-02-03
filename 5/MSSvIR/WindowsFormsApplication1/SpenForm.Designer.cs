namespace MSSvIR
{
	partial class SpenForm
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
			this.dataGridView1 = new System.Windows.Forms.DataGridView();
			this.varName = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.spenCount = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.label1 = new System.Windows.Forms.Label();
			this.SpenClassSelect = new System.Windows.Forms.ComboBox();
			this.sourceCode = new System.Windows.Forms.RichTextBox();
			((System.ComponentModel.ISupportInitialize)(this.dataGridView1)).BeginInit();
			this.SuspendLayout();
			// 
			// dataGridView1
			// 
			this.dataGridView1.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
			this.dataGridView1.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.varName,
            this.spenCount});
			this.dataGridView1.Location = new System.Drawing.Point(12, 52);
			this.dataGridView1.Name = "dataGridView1";
			this.dataGridView1.Size = new System.Drawing.Size(276, 198);
			this.dataGridView1.TabIndex = 0;
			// 
			// varName
			// 
			this.varName.HeaderText = "Имя переменной";
			this.varName.Name = "varName";
			this.varName.ReadOnly = true;
			// 
			// spenCount
			// 
			this.spenCount.HeaderText = "Число спена";
			this.spenCount.Name = "spenCount";
			this.spenCount.ReadOnly = true;
			// 
			// label1
			// 
			this.label1.AutoSize = true;
			this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
			this.label1.Location = new System.Drawing.Point(12, 7);
			this.label1.Name = "label1";
			this.label1.Size = new System.Drawing.Size(199, 16);
			this.label1.TabIndex = 1;
			this.label1.Text = "Числа спена для переменных";
			// 
			// SpenClassSelect
			// 
			this.SpenClassSelect.FormattingEnabled = true;
			this.SpenClassSelect.Location = new System.Drawing.Point(12, 27);
			this.SpenClassSelect.Name = "SpenClassSelect";
			this.SpenClassSelect.Size = new System.Drawing.Size(276, 21);
			this.SpenClassSelect.TabIndex = 2;
			this.SpenClassSelect.SelectedIndexChanged += new System.EventHandler(this.SpenClassSelect_SelectedIndexChanged);
			// 
			// sourceCode
			// 
			this.sourceCode.Location = new System.Drawing.Point(294, 7);
			this.sourceCode.Name = "sourceCode";
			this.sourceCode.Size = new System.Drawing.Size(780, 243);
			this.sourceCode.TabIndex = 3;
			this.sourceCode.Text = "";
			// 
			// SpenForm
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(1086, 262);
			this.Controls.Add(this.sourceCode);
			this.Controls.Add(this.SpenClassSelect);
			this.Controls.Add(this.label1);
			this.Controls.Add(this.dataGridView1);
			this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
			this.MaximizeBox = false;
			this.Name = "SpenForm";
			this.Text = "Подсчет спена";
			((System.ComponentModel.ISupportInitialize)(this.dataGridView1)).EndInit();
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.DataGridView dataGridView1;
		private System.Windows.Forms.DataGridViewTextBoxColumn varName;
		private System.Windows.Forms.DataGridViewTextBoxColumn spenCount;
		private System.Windows.Forms.Label label1;
		private System.Windows.Forms.ComboBox SpenClassSelect;
		private System.Windows.Forms.RichTextBox sourceCode;
	}
}