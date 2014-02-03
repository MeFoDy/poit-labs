namespace MSSvIR
{
	partial class ChepinForm
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
			this.peremName = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.peremType = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.peremCount = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.label1 = new System.Windows.Forms.Label();
			this.chepinCount = new System.Windows.Forms.TextBox();
			this.formula = new System.Windows.Forms.Label();
			this.ChepClassSelect = new System.Windows.Forms.ComboBox();
			((System.ComponentModel.ISupportInitialize)(this.dataGridView1)).BeginInit();
			this.SuspendLayout();
			// 
			// dataGridView1
			// 
			this.dataGridView1.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
			this.dataGridView1.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.peremName,
            this.peremType,
            this.peremCount});
			this.dataGridView1.Location = new System.Drawing.Point(13, 39);
			this.dataGridView1.Name = "dataGridView1";
			this.dataGridView1.Size = new System.Drawing.Size(372, 124);
			this.dataGridView1.TabIndex = 0;
			// 
			// peremName
			// 
			this.peremName.HeaderText = "Имя переменной";
			this.peremName.Name = "peremName";
			this.peremName.ReadOnly = true;
			// 
			// peremType
			// 
			this.peremType.HeaderText = "Тип переменной";
			this.peremType.Name = "peremType";
			this.peremType.ReadOnly = true;
			// 
			// peremCount
			// 
			this.peremCount.HeaderText = "Количество встречаемости";
			this.peremCount.Name = "peremCount";
			this.peremCount.ReadOnly = true;
			// 
			// label1
			// 
			this.label1.AutoSize = true;
			this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
			this.label1.Location = new System.Drawing.Point(13, 170);
			this.label1.Name = "label1";
			this.label1.Size = new System.Drawing.Size(135, 16);
			this.label1.TabIndex = 1;
			this.label1.Text = "Метрика Чепина:";
			// 
			// chepinCount
			// 
			this.chepinCount.Location = new System.Drawing.Point(16, 190);
			this.chepinCount.Name = "chepinCount";
			this.chepinCount.ReadOnly = true;
			this.chepinCount.Size = new System.Drawing.Size(100, 20);
			this.chepinCount.TabIndex = 2;
			// 
			// formula
			// 
			this.formula.AutoSize = true;
			this.formula.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
			this.formula.Location = new System.Drawing.Point(12, 213);
			this.formula.Name = "formula";
			this.formula.Size = new System.Drawing.Size(0, 20);
			this.formula.TabIndex = 3;
			// 
			// ChepClassSelect
			// 
			this.ChepClassSelect.FormattingEnabled = true;
			this.ChepClassSelect.Location = new System.Drawing.Point(12, 12);
			this.ChepClassSelect.Name = "ChepClassSelect";
			this.ChepClassSelect.Size = new System.Drawing.Size(373, 21);
			this.ChepClassSelect.TabIndex = 4;
			this.ChepClassSelect.SelectedIndexChanged += new System.EventHandler(this.ChepClassSelect_SelectedIndexChanged);
			// 
			// ChepinForm
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(397, 246);
			this.Controls.Add(this.ChepClassSelect);
			this.Controls.Add(this.formula);
			this.Controls.Add(this.chepinCount);
			this.Controls.Add(this.label1);
			this.Controls.Add(this.dataGridView1);
			this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
			this.MaximizeBox = false;
			this.Name = "ChepinForm";
			this.Text = "Метрика Чепина";
			((System.ComponentModel.ISupportInitialize)(this.dataGridView1)).EndInit();
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.DataGridView dataGridView1;
		private System.Windows.Forms.DataGridViewTextBoxColumn peremName;
		private System.Windows.Forms.DataGridViewTextBoxColumn peremType;
		private System.Windows.Forms.DataGridViewTextBoxColumn peremCount;
		private System.Windows.Forms.Label label1;
		private System.Windows.Forms.TextBox chepinCount;
		private System.Windows.Forms.Label formula;
		private System.Windows.Forms.ComboBox ChepClassSelect;
	}
}