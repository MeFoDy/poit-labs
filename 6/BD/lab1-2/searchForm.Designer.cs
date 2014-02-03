namespace Lab1_2
{
	partial class SearchForm
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
			this.label1 = new System.Windows.Forms.Label();
			this.KeyTextBox = new System.Windows.Forms.TextBox();
			this.button1 = new System.Windows.Forms.Button();
			this.label2 = new System.Windows.Forms.Label();
			this.showElementsGrid = new System.Windows.Forms.DataGridView();
			this.key = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.number = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.str = new System.Windows.Forms.DataGridViewTextBoxColumn();
			((System.ComponentModel.ISupportInitialize)(this.showElementsGrid)).BeginInit();
			this.SuspendLayout();
			// 
			// label1
			// 
			this.label1.AutoSize = true;
			this.label1.Location = new System.Drawing.Point(13, 13);
			this.label1.Name = "label1";
			this.label1.Size = new System.Drawing.Size(80, 13);
			this.label1.TabIndex = 0;
			this.label1.Text = "Введите ключ:";
			// 
			// KeyTextBox
			// 
			this.KeyTextBox.Location = new System.Drawing.Point(16, 30);
			this.KeyTextBox.Name = "KeyTextBox";
			this.KeyTextBox.Size = new System.Drawing.Size(221, 20);
			this.KeyTextBox.TabIndex = 1;
			// 
			// button1
			// 
			this.button1.Location = new System.Drawing.Point(16, 153);
			this.button1.Name = "button1";
			this.button1.Size = new System.Drawing.Size(101, 23);
			this.button1.TabIndex = 2;
			this.button1.Text = "Найти";
			this.button1.UseVisualStyleBackColor = true;
			this.button1.Click += new System.EventHandler(this.button1_Click);
			// 
			// label2
			// 
			this.label2.AutoSize = true;
			this.label2.Location = new System.Drawing.Point(16, 57);
			this.label2.Name = "label2";
			this.label2.Size = new System.Drawing.Size(62, 13);
			this.label2.TabIndex = 3;
			this.label2.Text = "Результат:";
			// 
			// showElementsGrid
			// 
			this.showElementsGrid.AllowUserToAddRows = false;
			this.showElementsGrid.AllowUserToDeleteRows = false;
			this.showElementsGrid.AllowUserToResizeColumns = false;
			this.showElementsGrid.AllowUserToResizeRows = false;
			this.showElementsGrid.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
			this.showElementsGrid.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.key,
            this.number,
            this.str});
			this.showElementsGrid.Location = new System.Drawing.Point(16, 73);
			this.showElementsGrid.Name = "showElementsGrid";
			this.showElementsGrid.ReadOnly = true;
			this.showElementsGrid.RowHeadersWidthSizeMode = System.Windows.Forms.DataGridViewRowHeadersWidthSizeMode.DisableResizing;
			this.showElementsGrid.Size = new System.Drawing.Size(383, 74);
			this.showElementsGrid.TabIndex = 4;
			// 
			// key
			// 
			this.key.Frozen = true;
			this.key.HeaderText = "Ключ";
			this.key.Name = "key";
			this.key.ReadOnly = true;
			this.key.Resizable = System.Windows.Forms.DataGridViewTriState.False;
			this.key.Width = 50;
			// 
			// number
			// 
			this.number.Frozen = true;
			this.number.HeaderText = "Число";
			this.number.Name = "number";
			this.number.ReadOnly = true;
			this.number.Resizable = System.Windows.Forms.DataGridViewTriState.False;
			// 
			// str
			// 
			this.str.AutoSizeMode = System.Windows.Forms.DataGridViewAutoSizeColumnMode.Fill;
			this.str.HeaderText = "Строка";
			this.str.Name = "str";
			this.str.ReadOnly = true;
			this.str.Resizable = System.Windows.Forms.DataGridViewTriState.False;
			// 
			// searchForm
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(411, 188);
			this.Controls.Add(this.showElementsGrid);
			this.Controls.Add(this.label2);
			this.Controls.Add(this.button1);
			this.Controls.Add(this.KeyTextBox);
			this.Controls.Add(this.label1);
			this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
			this.Name = "SearchForm";
			this.Text = "Поиск по ключу";
			((System.ComponentModel.ISupportInitialize)(this.showElementsGrid)).EndInit();
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.Label label1;
		private System.Windows.Forms.TextBox KeyTextBox;
		private System.Windows.Forms.Button button1;
		private System.Windows.Forms.Label label2;
		private System.Windows.Forms.DataGridView showElementsGrid;
		private System.Windows.Forms.DataGridViewTextBoxColumn key;
		private System.Windows.Forms.DataGridViewTextBoxColumn number;
		private System.Windows.Forms.DataGridViewTextBoxColumn str;
	}
}