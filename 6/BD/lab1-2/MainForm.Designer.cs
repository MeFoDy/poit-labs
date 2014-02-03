namespace Lab1_2
{
	partial class MainForm
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
			this.generateFileButton = new System.Windows.Forms.Button();
			this.showStructureButton = new System.Windows.Forms.Button();
			this.hash1box = new System.Windows.Forms.PictureBox();
			this.hash2box = new System.Windows.Forms.PictureBox();
			this.openGeneratedFileButton = new System.Windows.Forms.Button();
			this.openGeneratedFileDialog = new System.Windows.Forms.OpenFileDialog();
			this.search2box = new System.Windows.Forms.PictureBox();
			this.search1box = new System.Windows.Forms.PictureBox();
			this.hashAnaliseButton = new System.Windows.Forms.Button();
			this.searchAnaliseButton = new System.Windows.Forms.Button();
			this.leftTopLabel = new System.Windows.Forms.Label();
			this.rightTopLabel = new System.Windows.Forms.Label();
			this.leftBottomLabel = new System.Windows.Forms.Label();
			this.rightBottomLabel = new System.Windows.Forms.Label();
			this.showDopArrayButton = new System.Windows.Forms.Button();
			this.generateDopArrayButton = new System.Windows.Forms.Button();
			this.openDopArrayButton = new System.Windows.Forms.Button();
			this.openDopArrayDialog = new System.Windows.Forms.OpenFileDialog();
			this.KeySearchButton = new System.Windows.Forms.Button();
			this.label1 = new System.Windows.Forms.Label();
			((System.ComponentModel.ISupportInitialize)(this.hash1box)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.hash2box)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.search2box)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.search1box)).BeginInit();
			this.SuspendLayout();
			// 
			// generateFileButton
			// 
			this.generateFileButton.Location = new System.Drawing.Point(12, 42);
			this.generateFileButton.Name = "generateFileButton";
			this.generateFileButton.Size = new System.Drawing.Size(137, 23);
			this.generateFileButton.TabIndex = 0;
			this.generateFileButton.Text = "Сгенерировать";
			this.generateFileButton.UseVisualStyleBackColor = true;
			this.generateFileButton.Click += new System.EventHandler(this.generateFileButton_Click);
			// 
			// showStructureButton
			// 
			this.showStructureButton.Location = new System.Drawing.Point(12, 70);
			this.showStructureButton.Name = "showStructureButton";
			this.showStructureButton.Size = new System.Drawing.Size(137, 23);
			this.showStructureButton.TabIndex = 1;
			this.showStructureButton.Text = "Показать";
			this.showStructureButton.UseVisualStyleBackColor = true;
			this.showStructureButton.Click += new System.EventHandler(this.showStructureButton_Click);
			// 
			// hash1box
			// 
			this.hash1box.BackColor = System.Drawing.SystemColors.ButtonHighlight;
			this.hash1box.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.hash1box.Location = new System.Drawing.Point(156, 13);
			this.hash1box.Name = "hash1box";
			this.hash1box.Size = new System.Drawing.Size(450, 246);
			this.hash1box.TabIndex = 2;
			this.hash1box.TabStop = false;
			// 
			// hash2box
			// 
			this.hash2box.BackColor = System.Drawing.SystemColors.ButtonHighlight;
			this.hash2box.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.hash2box.Location = new System.Drawing.Point(613, 13);
			this.hash2box.Name = "hash2box";
			this.hash2box.Size = new System.Drawing.Size(450, 246);
			this.hash2box.TabIndex = 3;
			this.hash2box.TabStop = false;
			// 
			// openGeneratedFileButton
			// 
			this.openGeneratedFileButton.Location = new System.Drawing.Point(12, 13);
			this.openGeneratedFileButton.Name = "openGeneratedFileButton";
			this.openGeneratedFileButton.Size = new System.Drawing.Size(137, 23);
			this.openGeneratedFileButton.TabIndex = 4;
			this.openGeneratedFileButton.Text = "Открыть...";
			this.openGeneratedFileButton.UseVisualStyleBackColor = true;
			this.openGeneratedFileButton.Click += new System.EventHandler(this.openGeneratedFileButton_Click);
			// 
			// openGeneratedFileDialog
			// 
			this.openGeneratedFileDialog.AddExtension = false;
			this.openGeneratedFileDialog.InitialDirectory = "D:\\БГУИР\\6 семестр\\БД\\Lab1-2\\bin\\Debug\\Generated Files\\";
			// 
			// search2box
			// 
			this.search2box.BackColor = System.Drawing.SystemColors.ButtonHighlight;
			this.search2box.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.search2box.Location = new System.Drawing.Point(613, 265);
			this.search2box.Name = "search2box";
			this.search2box.Size = new System.Drawing.Size(450, 246);
			this.search2box.TabIndex = 6;
			this.search2box.TabStop = false;
			// 
			// search1box
			// 
			this.search1box.BackColor = System.Drawing.SystemColors.ButtonHighlight;
			this.search1box.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.search1box.Location = new System.Drawing.Point(156, 265);
			this.search1box.Name = "search1box";
			this.search1box.Size = new System.Drawing.Size(450, 246);
			this.search1box.TabIndex = 5;
			this.search1box.TabStop = false;
			// 
			// hashAnaliseButton
			// 
			this.hashAnaliseButton.Enabled = false;
			this.hashAnaliseButton.Location = new System.Drawing.Point(12, 99);
			this.hashAnaliseButton.Name = "hashAnaliseButton";
			this.hashAnaliseButton.Size = new System.Drawing.Size(136, 23);
			this.hashAnaliseButton.TabIndex = 7;
			this.hashAnaliseButton.Text = "Анализ хеширования";
			this.hashAnaliseButton.UseVisualStyleBackColor = true;
			this.hashAnaliseButton.Click += new System.EventHandler(this.hashAnaliseButton_Click);
			// 
			// searchAnaliseButton
			// 
			this.searchAnaliseButton.Enabled = false;
			this.searchAnaliseButton.Location = new System.Drawing.Point(13, 265);
			this.searchAnaliseButton.Name = "searchAnaliseButton";
			this.searchAnaliseButton.Size = new System.Drawing.Size(136, 23);
			this.searchAnaliseButton.TabIndex = 8;
			this.searchAnaliseButton.Text = "Анализ поиска";
			this.searchAnaliseButton.UseVisualStyleBackColor = true;
			this.searchAnaliseButton.Click += new System.EventHandler(this.searchAnaliseButton_Click);
			// 
			// leftTopLabel
			// 
			this.leftTopLabel.AutoSize = true;
			this.leftTopLabel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.leftTopLabel.Location = new System.Drawing.Point(156, 13);
			this.leftTopLabel.Name = "leftTopLabel";
			this.leftTopLabel.Size = new System.Drawing.Size(318, 15);
			this.leftTopLabel.TabIndex = 9;
			this.leftTopLabel.Text = "Эффективность хеширования методом \"средних квадратов\"";
			// 
			// rightTopLabel
			// 
			this.rightTopLabel.AutoSize = true;
			this.rightTopLabel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.rightTopLabel.Location = new System.Drawing.Point(613, 13);
			this.rightTopLabel.Name = "rightTopLabel";
			this.rightTopLabel.Size = new System.Drawing.Size(322, 15);
			this.rightTopLabel.TabIndex = 10;
			this.rightTopLabel.Text = "Эффективность хеширования методом \"преобразования СС\"";
			// 
			// leftBottomLabel
			// 
			this.leftBottomLabel.AutoSize = true;
			this.leftBottomLabel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.leftBottomLabel.Location = new System.Drawing.Point(156, 265);
			this.leftBottomLabel.Name = "leftBottomLabel";
			this.leftBottomLabel.Size = new System.Drawing.Size(239, 15);
			this.leftBottomLabel.TabIndex = 11;
			this.leftBottomLabel.Text = "Время поиска методом \"средних квадратов\"";
			// 
			// rightBottomLabel
			// 
			this.rightBottomLabel.AutoSize = true;
			this.rightBottomLabel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.rightBottomLabel.Location = new System.Drawing.Point(613, 265);
			this.rightBottomLabel.Name = "rightBottomLabel";
			this.rightBottomLabel.Size = new System.Drawing.Size(243, 15);
			this.rightBottomLabel.TabIndex = 12;
			this.rightBottomLabel.Text = "Время поиска методом \"преобразования СС\"";
			// 
			// showDopArrayButton
			// 
			this.showDopArrayButton.Enabled = false;
			this.showDopArrayButton.Location = new System.Drawing.Point(13, 352);
			this.showDopArrayButton.Name = "showDopArrayButton";
			this.showDopArrayButton.Size = new System.Drawing.Size(137, 23);
			this.showDopArrayButton.TabIndex = 14;
			this.showDopArrayButton.Text = "Показать";
			this.showDopArrayButton.UseVisualStyleBackColor = true;
			this.showDopArrayButton.Click += new System.EventHandler(this.showDopArrayButton_Click);
			// 
			// generateDopArrayButton
			// 
			this.generateDopArrayButton.Enabled = false;
			this.generateDopArrayButton.Location = new System.Drawing.Point(13, 294);
			this.generateDopArrayButton.Name = "generateDopArrayButton";
			this.generateDopArrayButton.Size = new System.Drawing.Size(137, 23);
			this.generateDopArrayButton.TabIndex = 13;
			this.generateDopArrayButton.Text = "Сгенерировать";
			this.generateDopArrayButton.UseVisualStyleBackColor = true;
			this.generateDopArrayButton.Click += new System.EventHandler(this.generateDopArrayButton_Click);
			// 
			// openDopArrayButton
			// 
			this.openDopArrayButton.Enabled = false;
			this.openDopArrayButton.Location = new System.Drawing.Point(13, 323);
			this.openDopArrayButton.Name = "openDopArrayButton";
			this.openDopArrayButton.Size = new System.Drawing.Size(137, 23);
			this.openDopArrayButton.TabIndex = 15;
			this.openDopArrayButton.Text = "Открыть...";
			this.openDopArrayButton.UseVisualStyleBackColor = true;
			this.openDopArrayButton.Click += new System.EventHandler(this.openDopArrayButton_Click);
			// 
			// openDopArrayDialog
			// 
			this.openDopArrayDialog.AddExtension = false;
			this.openDopArrayDialog.InitialDirectory = "D:\\БГУИР\\6 семестр\\БД\\Lab1-2\\bin\\Debug\\Generated Files\\";
			// 
			// KeySearchButton
			// 
			this.KeySearchButton.Enabled = false;
			this.KeySearchButton.Location = new System.Drawing.Point(13, 486);
			this.KeySearchButton.Name = "KeySearchButton";
			this.KeySearchButton.Size = new System.Drawing.Size(137, 23);
			this.KeySearchButton.TabIndex = 16;
			this.KeySearchButton.Text = "Поиск по ключу";
			this.KeySearchButton.UseVisualStyleBackColor = true;
			this.KeySearchButton.Click += new System.EventHandler(this.KeySearchButton_Click);
			// 
			// label1
			// 
			this.label1.AutoSize = true;
			this.label1.Location = new System.Drawing.Point(12, 246);
			this.label1.Name = "label1";
			this.label1.Size = new System.Drawing.Size(0, 13);
			this.label1.TabIndex = 17;
			// 
			// MainForm
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(1075, 521);
			this.Controls.Add(this.label1);
			this.Controls.Add(this.KeySearchButton);
			this.Controls.Add(this.openDopArrayButton);
			this.Controls.Add(this.showDopArrayButton);
			this.Controls.Add(this.generateDopArrayButton);
			this.Controls.Add(this.rightBottomLabel);
			this.Controls.Add(this.leftBottomLabel);
			this.Controls.Add(this.rightTopLabel);
			this.Controls.Add(this.leftTopLabel);
			this.Controls.Add(this.searchAnaliseButton);
			this.Controls.Add(this.hashAnaliseButton);
			this.Controls.Add(this.search2box);
			this.Controls.Add(this.search1box);
			this.Controls.Add(this.openGeneratedFileButton);
			this.Controls.Add(this.hash2box);
			this.Controls.Add(this.hash1box);
			this.Controls.Add(this.showStructureButton);
			this.Controls.Add(this.generateFileButton);
			this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
			this.MaximizeBox = false;
			this.Name = "MainForm";
			this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
			this.Text = "Анализ хеширования и поиска";
			((System.ComponentModel.ISupportInitialize)(this.hash1box)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.hash2box)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.search2box)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.search1box)).EndInit();
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.Button generateFileButton;
		private System.Windows.Forms.Button showStructureButton;
		private System.Windows.Forms.PictureBox hash1box;
		private System.Windows.Forms.PictureBox hash2box;
		private System.Windows.Forms.Button openGeneratedFileButton;
		private System.Windows.Forms.OpenFileDialog openGeneratedFileDialog;
		private System.Windows.Forms.PictureBox search2box;
		private System.Windows.Forms.PictureBox search1box;
		private System.Windows.Forms.Button hashAnaliseButton;
		private System.Windows.Forms.Button searchAnaliseButton;
		private System.Windows.Forms.Label leftTopLabel;
		private System.Windows.Forms.Label rightTopLabel;
		private System.Windows.Forms.Label leftBottomLabel;
		private System.Windows.Forms.Label rightBottomLabel;
		private System.Windows.Forms.Button showDopArrayButton;
		private System.Windows.Forms.Button generateDopArrayButton;
		private System.Windows.Forms.Button openDopArrayButton;
		private System.Windows.Forms.OpenFileDialog openDopArrayDialog;
		private System.Windows.Forms.Button KeySearchButton;
		public System.Windows.Forms.Label label1;
	}
}

