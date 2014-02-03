namespace TimeMachine
{
	partial class TimeMachineForm
	{
		/// <summary>
		/// Требуется переменная конструктора.
		/// </summary>
		private System.ComponentModel.IContainer components = null;

		/// <summary>
		/// Освободить все используемые ресурсы.
		/// </summary>
		/// <param name="disposing">истинно, если управляемый ресурс должен быть удален; иначе ложно.</param>
		protected override void Dispose(bool disposing)
		{
			if (disposing && (components != null))
			{
				components.Dispose();
			}
			base.Dispose(disposing);
		}

		#region Код, автоматически созданный конструктором форм Windows

		/// <summary>
		/// Обязательный метод для поддержки конструктора - не изменяйте
		/// содержимое данного метода при помощи редактора кода.
		/// </summary>
		private void InitializeComponent()
		{
			this.components = new System.ComponentModel.Container();
			this.groupBox1 = new System.Windows.Forms.GroupBox();
			this.setDateButton = new System.Windows.Forms.Button();
			this.sourceMultiplierInput = new System.Windows.Forms.NumericUpDown();
			this.sourceCountInput = new System.Windows.Forms.NumericUpDown();
			this.groupBox2 = new System.Windows.Forms.GroupBox();
			this.convertDateButton = new System.Windows.Forms.Button();
			this.newTypeDateInput = new System.Windows.Forms.ComboBox();
			this.newMultiplierInput = new System.Windows.Forms.NumericUpDown();
			this.logTextBox = new System.Windows.Forms.RichTextBox();
			this.currentTime = new System.Windows.Forms.Label();
			this.currentTimeTimer = new System.Windows.Forms.Timer(this.components);
			this.sourceTypeDateInput = new System.Windows.Forms.ComboBox();
			this.newCountInput = new System.Windows.Forms.TextBox();
			this.groupBox1.SuspendLayout();
			((System.ComponentModel.ISupportInitialize)(this.sourceMultiplierInput)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.sourceCountInput)).BeginInit();
			this.groupBox2.SuspendLayout();
			((System.ComponentModel.ISupportInitialize)(this.newMultiplierInput)).BeginInit();
			this.SuspendLayout();
			// 
			// groupBox1
			// 
			this.groupBox1.Controls.Add(this.sourceTypeDateInput);
			this.groupBox1.Controls.Add(this.setDateButton);
			this.groupBox1.Controls.Add(this.sourceMultiplierInput);
			this.groupBox1.Controls.Add(this.sourceCountInput);
			this.groupBox1.Location = new System.Drawing.Point(12, 12);
			this.groupBox1.Name = "groupBox1";
			this.groupBox1.Size = new System.Drawing.Size(470, 76);
			this.groupBox1.TabIndex = 2;
			this.groupBox1.TabStop = false;
			this.groupBox1.Text = "Задание новой исходной даты";
			// 
			// setDateButton
			// 
			this.setDateButton.Location = new System.Drawing.Point(6, 45);
			this.setDateButton.Name = "setDateButton";
			this.setDateButton.Size = new System.Drawing.Size(120, 23);
			this.setDateButton.TabIndex = 4;
			this.setDateButton.Text = "Задать дату";
			this.setDateButton.UseVisualStyleBackColor = true;
			this.setDateButton.Click += new System.EventHandler(this.setDateButton_Click);
			// 
			// sourceMultiplierInput
			// 
			this.sourceMultiplierInput.Location = new System.Drawing.Point(133, 18);
			this.sourceMultiplierInput.Minimum = new decimal(new int[] {
            1,
            0,
            0,
            0});
			this.sourceMultiplierInput.Name = "sourceMultiplierInput";
			this.sourceMultiplierInput.Size = new System.Drawing.Size(120, 20);
			this.sourceMultiplierInput.TabIndex = 2;
			this.sourceMultiplierInput.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
			this.sourceMultiplierInput.Value = new decimal(new int[] {
            1,
            0,
            0,
            0});
			// 
			// sourceCountInput
			// 
			this.sourceCountInput.Location = new System.Drawing.Point(6, 19);
			this.sourceCountInput.Minimum = new decimal(new int[] {
            1,
            0,
            0,
            0});
			this.sourceCountInput.Name = "sourceCountInput";
			this.sourceCountInput.Size = new System.Drawing.Size(120, 20);
			this.sourceCountInput.TabIndex = 1;
			this.sourceCountInput.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
			this.sourceCountInput.Value = new decimal(new int[] {
            1,
            0,
            0,
            0});
			// 
			// groupBox2
			// 
			this.groupBox2.Controls.Add(this.newCountInput);
			this.groupBox2.Controls.Add(this.convertDateButton);
			this.groupBox2.Controls.Add(this.newTypeDateInput);
			this.groupBox2.Controls.Add(this.newMultiplierInput);
			this.groupBox2.Location = new System.Drawing.Point(12, 94);
			this.groupBox2.Name = "groupBox2";
			this.groupBox2.Size = new System.Drawing.Size(470, 81);
			this.groupBox2.TabIndex = 3;
			this.groupBox2.TabStop = false;
			this.groupBox2.Text = "Конвертирование";
			// 
			// convertDateButton
			// 
			this.convertDateButton.Enabled = false;
			this.convertDateButton.Location = new System.Drawing.Point(7, 47);
			this.convertDateButton.Name = "convertDateButton";
			this.convertDateButton.Size = new System.Drawing.Size(119, 23);
			this.convertDateButton.TabIndex = 7;
			this.convertDateButton.Text = "Конвертировать";
			this.convertDateButton.UseVisualStyleBackColor = true;
			this.convertDateButton.Click += new System.EventHandler(this.convertDateButton_Click);
			// 
			// newTypeDateInput
			// 
			this.newTypeDateInput.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
			this.newTypeDateInput.FormattingEnabled = true;
			this.newTypeDateInput.Location = new System.Drawing.Point(260, 19);
			this.newTypeDateInput.Name = "newTypeDateInput";
			this.newTypeDateInput.Size = new System.Drawing.Size(204, 21);
			this.newTypeDateInput.TabIndex = 6;
			// 
			// newMultiplierInput
			// 
			this.newMultiplierInput.Location = new System.Drawing.Point(133, 19);
			this.newMultiplierInput.Minimum = new decimal(new int[] {
            1,
            0,
            0,
            0});
			this.newMultiplierInput.Name = "newMultiplierInput";
			this.newMultiplierInput.Size = new System.Drawing.Size(120, 20);
			this.newMultiplierInput.TabIndex = 5;
			this.newMultiplierInput.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
			this.newMultiplierInput.Value = new decimal(new int[] {
            1,
            0,
            0,
            0});
			// 
			// logTextBox
			// 
			this.logTextBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.logTextBox.Location = new System.Drawing.Point(12, 181);
			this.logTextBox.Name = "logTextBox";
			this.logTextBox.ReadOnly = true;
			this.logTextBox.Size = new System.Drawing.Size(470, 130);
			this.logTextBox.TabIndex = 4;
			this.logTextBox.Text = "";
			// 
			// currentTime
			// 
			this.currentTime.Anchor = System.Windows.Forms.AnchorStyles.Right;
			this.currentTime.ForeColor = System.Drawing.SystemColors.AppWorkspace;
			this.currentTime.Location = new System.Drawing.Point(332, 323);
			this.currentTime.Name = "currentTime";
			this.currentTime.Size = new System.Drawing.Size(150, 13);
			this.currentTime.TabIndex = 5;
			this.currentTime.Text = "00:00:00";
			this.currentTime.TextAlign = System.Drawing.ContentAlignment.TopRight;
			// 
			// currentTimeTimer
			// 
			this.currentTimeTimer.Enabled = true;
			this.currentTimeTimer.Tick += new System.EventHandler(this.currentTimeTimer_Tick);
			// 
			// sourceTypeDateInput
			// 
			this.sourceTypeDateInput.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
			this.sourceTypeDateInput.FormattingEnabled = true;
			this.sourceTypeDateInput.Location = new System.Drawing.Point(260, 17);
			this.sourceTypeDateInput.Name = "sourceTypeDateInput";
			this.sourceTypeDateInput.Size = new System.Drawing.Size(204, 21);
			this.sourceTypeDateInput.TabIndex = 8;
			// 
			// newCountInput
			// 
			this.newCountInput.Location = new System.Drawing.Point(7, 19);
			this.newCountInput.Name = "newCountInput";
			this.newCountInput.ReadOnly = true;
			this.newCountInput.Size = new System.Drawing.Size(119, 20);
			this.newCountInput.TabIndex = 8;
			this.newCountInput.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
			// 
			// TimeMachineForm
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(494, 345);
			this.Controls.Add(this.currentTime);
			this.Controls.Add(this.logTextBox);
			this.Controls.Add(this.groupBox2);
			this.Controls.Add(this.groupBox1);
			this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
			this.Name = "TimeMachineForm";
			this.Text = "TimeMachine";
			this.groupBox1.ResumeLayout(false);
			((System.ComponentModel.ISupportInitialize)(this.sourceMultiplierInput)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.sourceCountInput)).EndInit();
			this.groupBox2.ResumeLayout(false);
			this.groupBox2.PerformLayout();
			((System.ComponentModel.ISupportInitialize)(this.newMultiplierInput)).EndInit();
			this.ResumeLayout(false);

		}

		#endregion

		private System.Windows.Forms.GroupBox groupBox1;
		private System.Windows.Forms.GroupBox groupBox2;
		private System.Windows.Forms.RichTextBox logTextBox;
		protected System.Windows.Forms.Label currentTime;
		private System.Windows.Forms.Timer currentTimeTimer;
		private System.Windows.Forms.NumericUpDown sourceMultiplierInput;
		private System.Windows.Forms.NumericUpDown sourceCountInput;
		private System.Windows.Forms.ComboBox newTypeDateInput;
		private System.Windows.Forms.NumericUpDown newMultiplierInput;
		private System.Windows.Forms.Button setDateButton;
		private System.Windows.Forms.Button convertDateButton;
		private System.Windows.Forms.ComboBox sourceTypeDateInput;
		private System.Windows.Forms.TextBox newCountInput;


	}
}

