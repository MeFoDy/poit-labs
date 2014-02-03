namespace MSSvIR
{
    partial class MSSvIR
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
			this.outText = new System.Windows.Forms.RichTextBox();
			this.spenMetrButton = new System.Windows.Forms.Button();
			this.mayersMetrButton = new System.Windows.Forms.Button();
			this.chepinMetrButton = new System.Windows.Forms.Button();
			this.quitButton = new System.Windows.Forms.Button();
			this.SuspendLayout();
			// 
			// outText
			// 
			this.outText.Font = new System.Drawing.Font("Courier New", 8.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
			this.outText.Location = new System.Drawing.Point(12, 12);
			this.outText.Name = "outText";
			this.outText.ReadOnly = true;
			this.outText.Size = new System.Drawing.Size(688, 491);
			this.outText.TabIndex = 1;
			this.outText.Text = "";
			// 
			// spenMetrButton
			// 
			this.spenMetrButton.Location = new System.Drawing.Point(706, 12);
			this.spenMetrButton.Name = "spenMetrButton";
			this.spenMetrButton.Size = new System.Drawing.Size(133, 23);
			this.spenMetrButton.TabIndex = 2;
			this.spenMetrButton.Text = "Подсчет спена";
			this.spenMetrButton.UseVisualStyleBackColor = true;
			this.spenMetrButton.Click += new System.EventHandler(this.spenMetrButton_Click);
			// 
			// mayersMetrButton
			// 
			this.mayersMetrButton.Location = new System.Drawing.Point(706, 41);
			this.mayersMetrButton.Name = "mayersMetrButton";
			this.mayersMetrButton.Size = new System.Drawing.Size(133, 23);
			this.mayersMetrButton.TabIndex = 3;
			this.mayersMetrButton.Text = "Метрика Майерса";
			this.mayersMetrButton.UseVisualStyleBackColor = true;
			this.mayersMetrButton.Click += new System.EventHandler(this.mayersMetrButton_Click);
			// 
			// chepinMetrButton
			// 
			this.chepinMetrButton.Location = new System.Drawing.Point(706, 70);
			this.chepinMetrButton.Name = "chepinMetrButton";
			this.chepinMetrButton.Size = new System.Drawing.Size(133, 23);
			this.chepinMetrButton.TabIndex = 4;
			this.chepinMetrButton.Text = "Метрика Чепина";
			this.chepinMetrButton.UseVisualStyleBackColor = true;
			this.chepinMetrButton.Click += new System.EventHandler(this.chepinMetrButton_Click);
			// 
			// quitButton
			// 
			this.quitButton.Location = new System.Drawing.Point(706, 480);
			this.quitButton.Name = "quitButton";
			this.quitButton.Size = new System.Drawing.Size(133, 23);
			this.quitButton.TabIndex = 5;
			this.quitButton.Text = "Выход";
			this.quitButton.UseVisualStyleBackColor = true;
			this.quitButton.Click += new System.EventHandler(this.quitButton_Click);
			// 
			// MSSvIR
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(851, 515);
			this.Controls.Add(this.quitButton);
			this.Controls.Add(this.chepinMetrButton);
			this.Controls.Add(this.mayersMetrButton);
			this.Controls.Add(this.spenMetrButton);
			this.Controls.Add(this.outText);
			this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
			this.MaximizeBox = false;
			this.Name = "MSSvIR";
			this.Text = "МССвИР";
			this.ResumeLayout(false);

        }

        #endregion

		private System.Windows.Forms.RichTextBox outText;
		private System.Windows.Forms.Button spenMetrButton;
		private System.Windows.Forms.Button mayersMetrButton;
		private System.Windows.Forms.Button chepinMetrButton;
		private System.Windows.Forms.Button quitButton;
    }
}

