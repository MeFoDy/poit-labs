namespace Lab1_2
{
	partial class ShowElementsForm
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
			this.showElementsGrid = new System.Windows.Forms.DataGridView();
			this.key = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.number = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.str = new System.Windows.Forms.DataGridViewTextBoxColumn();
			((System.ComponentModel.ISupportInitialize)(this.showElementsGrid)).BeginInit();
			this.SuspendLayout();
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
			this.showElementsGrid.Dock = System.Windows.Forms.DockStyle.Fill;
			this.showElementsGrid.Location = new System.Drawing.Point(0, 0);
			this.showElementsGrid.Name = "showElementsGrid";
			this.showElementsGrid.ReadOnly = true;
			this.showElementsGrid.RowHeadersWidthSizeMode = System.Windows.Forms.DataGridViewRowHeadersWidthSizeMode.DisableResizing;
			this.showElementsGrid.Size = new System.Drawing.Size(457, 262);
			this.showElementsGrid.TabIndex = 0;
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
			// ShowElementsForm
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(457, 262);
			this.Controls.Add(this.showElementsGrid);
			this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
			this.MaximizeBox = false;
			this.Name = "ShowElementsForm";
			this.ShowIcon = false;
			this.Text = "Отображение элементов";
			((System.ComponentModel.ISupportInitialize)(this.showElementsGrid)).EndInit();
			this.ResumeLayout(false);

		}

		#endregion

		private System.Windows.Forms.DataGridView showElementsGrid;
		private System.Windows.Forms.DataGridViewTextBoxColumn key;
		private System.Windows.Forms.DataGridViewTextBoxColumn number;
		private System.Windows.Forms.DataGridViewTextBoxColumn str;



	}
}