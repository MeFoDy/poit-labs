namespace CorelDrawKiller
{
	partial class CDKForm
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
			this.MainMenu = new System.Windows.Forms.MenuStrip();
			this.файлToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this.OpenFileMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.SaveFileMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.QuitButtonMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.правкаToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this.UndoButtonMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.RedoButtonMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.коллекцияToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this.OpenUserShapeMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.SaveUserShapeMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.инструментыToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this.LineMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.EllipsMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.RectangleMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.TriangleMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.ColorMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.BrushDensityMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.справкаToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this.AboutProgramMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.DrawWindow = new System.Windows.Forms.PictureBox();
			this.ColorDialog = new System.Windows.Forms.ColorDialog();
			this.ColorDisplayBlock = new System.Windows.Forms.PictureBox();
			this.BrushThiknessTrackBar = new System.Windows.Forms.TrackBar();
			this.BrushThiknessText = new System.Windows.Forms.TextBox();
			this.SaveAsMenuDialog = new System.Windows.Forms.SaveFileDialog();
			this.toolList = new System.Windows.Forms.ListBox();
			this.PreviewPictureBox = new System.Windows.Forms.PictureBox();
			this.groupBox1 = new System.Windows.Forms.GroupBox();
			this.ClearGraphicsButton = new System.Windows.Forms.Button();
			this.groupBox2 = new System.Windows.Forms.GroupBox();
			this.DeleteFigureButton = new System.Windows.Forms.Button();
			this.TransformFigureButton = new System.Windows.Forms.Button();
			this.SelectFigureButton = new System.Windows.Forms.Button();
			this.openFileMenuDialog = new System.Windows.Forms.OpenFileDialog();
			this.MainMenu.SuspendLayout();
			((System.ComponentModel.ISupportInitialize)(this.DrawWindow)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.ColorDisplayBlock)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.BrushThiknessTrackBar)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.PreviewPictureBox)).BeginInit();
			this.groupBox1.SuspendLayout();
			this.groupBox2.SuspendLayout();
			this.SuspendLayout();
			// 
			// MainMenu
			// 
			this.MainMenu.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.файлToolStripMenuItem,
            this.правкаToolStripMenuItem,
            this.коллекцияToolStripMenuItem,
            this.инструментыToolStripMenuItem,
            this.справкаToolStripMenuItem});
			this.MainMenu.Location = new System.Drawing.Point(0, 0);
			this.MainMenu.Name = "MainMenu";
			this.MainMenu.Size = new System.Drawing.Size(996, 24);
			this.MainMenu.TabIndex = 0;
			this.MainMenu.Text = "MainMenu";
			// 
			// файлToolStripMenuItem
			// 
			this.файлToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.OpenFileMenu,
            this.SaveFileMenu,
            this.QuitButtonMenu});
			this.файлToolStripMenuItem.Name = "файлToolStripMenuItem";
			this.файлToolStripMenuItem.Size = new System.Drawing.Size(48, 20);
			this.файлToolStripMenuItem.Text = "Файл";
			// 
			// OpenFileMenu
			// 
			this.OpenFileMenu.Name = "OpenFileMenu";
			this.OpenFileMenu.Size = new System.Drawing.Size(162, 22);
			this.OpenFileMenu.Text = "Открыть...";
			this.OpenFileMenu.Click += new System.EventHandler(this.OpenFileMenu_Click);
			// 
			// SaveFileMenu
			// 
			this.SaveFileMenu.Name = "SaveFileMenu";
			this.SaveFileMenu.Size = new System.Drawing.Size(162, 22);
			this.SaveFileMenu.Text = "Сохранить как...";
			this.SaveFileMenu.Click += new System.EventHandler(this.SaveFileMenu_Click);
			// 
			// QuitButtonMenu
			// 
			this.QuitButtonMenu.Name = "QuitButtonMenu";
			this.QuitButtonMenu.Size = new System.Drawing.Size(162, 22);
			this.QuitButtonMenu.Text = "Выход";
			this.QuitButtonMenu.Click += new System.EventHandler(this.QuitButtonMenu_Click);
			// 
			// правкаToolStripMenuItem
			// 
			this.правкаToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.UndoButtonMenu,
            this.RedoButtonMenu});
			this.правкаToolStripMenuItem.Name = "правкаToolStripMenuItem";
			this.правкаToolStripMenuItem.Size = new System.Drawing.Size(59, 20);
			this.правкаToolStripMenuItem.Text = "Правка";
			// 
			// UndoButtonMenu
			// 
			this.UndoButtonMenu.Name = "UndoButtonMenu";
			this.UndoButtonMenu.ShortcutKeys = ((System.Windows.Forms.Keys)((System.Windows.Forms.Keys.Control | System.Windows.Forms.Keys.Z)));
			this.UndoButtonMenu.Size = new System.Drawing.Size(174, 22);
			this.UndoButtonMenu.Text = "Отменить";
			this.UndoButtonMenu.Click += new System.EventHandler(this.UndoButtonMenu_Click);
			// 
			// RedoButtonMenu
			// 
			this.RedoButtonMenu.Name = "RedoButtonMenu";
			this.RedoButtonMenu.ShortcutKeys = ((System.Windows.Forms.Keys)((System.Windows.Forms.Keys.Control | System.Windows.Forms.Keys.Y)));
			this.RedoButtonMenu.Size = new System.Drawing.Size(174, 22);
			this.RedoButtonMenu.Text = "Повторить";
			this.RedoButtonMenu.Click += new System.EventHandler(this.RedoButtonMenu_Click);
			// 
			// коллекцияToolStripMenuItem
			// 
			this.коллекцияToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.OpenUserShapeMenu,
            this.SaveUserShapeMenu});
			this.коллекцияToolStripMenuItem.Name = "коллекцияToolStripMenuItem";
			this.коллекцияToolStripMenuItem.Size = new System.Drawing.Size(79, 20);
			this.коллекцияToolStripMenuItem.Text = "Коллекция";
			// 
			// OpenUserShapeMenu
			// 
			this.OpenUserShapeMenu.Name = "OpenUserShapeMenu";
			this.OpenUserShapeMenu.Size = new System.Drawing.Size(184, 22);
			this.OpenUserShapeMenu.Text = "Открыть фигуру...";
			// 
			// SaveUserShapeMenu
			// 
			this.SaveUserShapeMenu.Name = "SaveUserShapeMenu";
			this.SaveUserShapeMenu.Size = new System.Drawing.Size(184, 22);
			this.SaveUserShapeMenu.Text = "Сохранить фигуру...";
			this.SaveUserShapeMenu.Click += new System.EventHandler(this.SaveUserShapeMenu_Click);
			// 
			// инструментыToolStripMenuItem
			// 
			this.инструментыToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.LineMenu,
            this.EllipsMenu,
            this.RectangleMenu,
            this.TriangleMenu,
            this.ColorMenu,
            this.BrushDensityMenu});
			this.инструментыToolStripMenuItem.Name = "инструментыToolStripMenuItem";
			this.инструментыToolStripMenuItem.Size = new System.Drawing.Size(95, 20);
			this.инструментыToolStripMenuItem.Text = "Инструменты";
			// 
			// LineMenu
			// 
			this.LineMenu.Name = "LineMenu";
			this.LineMenu.Size = new System.Drawing.Size(169, 22);
			this.LineMenu.Text = "Линия";
			this.LineMenu.Click += new System.EventHandler(this.LineMenu_Click);
			// 
			// EllipsMenu
			// 
			this.EllipsMenu.Name = "EllipsMenu";
			this.EllipsMenu.Size = new System.Drawing.Size(169, 22);
			this.EllipsMenu.Text = "Эллипс";
			this.EllipsMenu.Click += new System.EventHandler(this.EllipsMenu_Click);
			// 
			// RectangleMenu
			// 
			this.RectangleMenu.Name = "RectangleMenu";
			this.RectangleMenu.Size = new System.Drawing.Size(169, 22);
			this.RectangleMenu.Text = "Прямоугольник";
			this.RectangleMenu.Click += new System.EventHandler(this.RectangleMenu_Click);
			// 
			// TriangleMenu
			// 
			this.TriangleMenu.Name = "TriangleMenu";
			this.TriangleMenu.Size = new System.Drawing.Size(169, 22);
			this.TriangleMenu.Text = "Треугольник";
			this.TriangleMenu.Click += new System.EventHandler(this.TriangleMenu_Click);
			// 
			// ColorMenu
			// 
			this.ColorMenu.Name = "ColorMenu";
			this.ColorMenu.Size = new System.Drawing.Size(169, 22);
			this.ColorMenu.Text = "Цвет...";
			this.ColorMenu.Click += new System.EventHandler(this.ColorMenu_Click);
			// 
			// BrushDensityMenu
			// 
			this.BrushDensityMenu.Name = "BrushDensityMenu";
			this.BrushDensityMenu.Size = new System.Drawing.Size(169, 22);
			this.BrushDensityMenu.Text = "Толщина кисти...";
			this.BrushDensityMenu.Click += new System.EventHandler(this.BrushDensityMenu_Click);
			// 
			// справкаToolStripMenuItem
			// 
			this.справкаToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.AboutProgramMenu});
			this.справкаToolStripMenuItem.Name = "справкаToolStripMenuItem";
			this.справкаToolStripMenuItem.Size = new System.Drawing.Size(65, 20);
			this.справкаToolStripMenuItem.Text = "Справка";
			// 
			// AboutProgramMenu
			// 
			this.AboutProgramMenu.Name = "AboutProgramMenu";
			this.AboutProgramMenu.Size = new System.Drawing.Size(149, 22);
			this.AboutProgramMenu.Text = "О программе";
			// 
			// DrawWindow
			// 
			this.DrawWindow.BackColor = System.Drawing.SystemColors.ButtonHighlight;
			this.DrawWindow.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.DrawWindow.Cursor = System.Windows.Forms.Cursors.Cross;
			this.DrawWindow.Location = new System.Drawing.Point(183, 27);
			this.DrawWindow.Name = "DrawWindow";
			this.DrawWindow.Size = new System.Drawing.Size(801, 499);
			this.DrawWindow.TabIndex = 1;
			this.DrawWindow.TabStop = false;
			// 
			// ColorDisplayBlock
			// 
			this.ColorDisplayBlock.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.ColorDisplayBlock.Location = new System.Drawing.Point(134, 238);
			this.ColorDisplayBlock.Name = "ColorDisplayBlock";
			this.ColorDisplayBlock.Size = new System.Drawing.Size(24, 20);
			this.ColorDisplayBlock.TabIndex = 2;
			this.ColorDisplayBlock.TabStop = false;
			this.ColorDisplayBlock.Click += new System.EventHandler(this.ColorDisplayBlock_Click);
			// 
			// BrushThiknessTrackBar
			// 
			this.BrushThiknessTrackBar.Location = new System.Drawing.Point(6, 198);
			this.BrushThiknessTrackBar.Maximum = 50;
			this.BrushThiknessTrackBar.Minimum = 1;
			this.BrushThiknessTrackBar.Name = "BrushThiknessTrackBar";
			this.BrushThiknessTrackBar.Size = new System.Drawing.Size(122, 45);
			this.BrushThiknessTrackBar.TabIndex = 3;
			this.BrushThiknessTrackBar.Value = 5;
			// 
			// BrushThiknessText
			// 
			this.BrushThiknessText.BackColor = System.Drawing.SystemColors.ButtonFace;
			this.BrushThiknessText.BorderStyle = System.Windows.Forms.BorderStyle.None;
			this.BrushThiknessText.Enabled = false;
			this.BrushThiknessText.Location = new System.Drawing.Point(134, 198);
			this.BrushThiknessText.Name = "BrushThiknessText";
			this.BrushThiknessText.ReadOnly = true;
			this.BrushThiknessText.Size = new System.Drawing.Size(24, 13);
			this.BrushThiknessText.TabIndex = 4;
			this.BrushThiknessText.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
			// 
			// SaveAsMenuDialog
			// 
			this.SaveAsMenuDialog.DefaultExt = "bmp";
			this.SaveAsMenuDialog.Filter = "JPG Files (*.jpg)|*.jpg|BMP Files (*.bmp)|*.bmp|CorelDrawKiller Files (*.cdk)|*.c" +
				"dk|All Files (*.*)|*.*";
			// 
			// toolList
			// 
			this.toolList.FormattingEnabled = true;
			this.toolList.Location = new System.Drawing.Point(19, 46);
			this.toolList.Name = "toolList";
			this.toolList.Size = new System.Drawing.Size(152, 173);
			this.toolList.TabIndex = 0;
			this.toolList.SelectedIndexChanged += new System.EventHandler(this.toolList_SelectedIndexChanged);
			// 
			// PreviewPictureBox
			// 
			this.PreviewPictureBox.BackColor = System.Drawing.SystemColors.ButtonHighlight;
			this.PreviewPictureBox.Location = new System.Drawing.Point(6, 19);
			this.PreviewPictureBox.Name = "PreviewPictureBox";
			this.PreviewPictureBox.Size = new System.Drawing.Size(152, 137);
			this.PreviewPictureBox.TabIndex = 5;
			this.PreviewPictureBox.TabStop = false;
			// 
			// groupBox1
			// 
			this.groupBox1.Controls.Add(this.ClearGraphicsButton);
			this.groupBox1.Controls.Add(this.BrushThiknessTrackBar);
			this.groupBox1.Controls.Add(this.BrushThiknessText);
			this.groupBox1.Controls.Add(this.ColorDisplayBlock);
			this.groupBox1.Location = new System.Drawing.Point(13, 27);
			this.groupBox1.Name = "groupBox1";
			this.groupBox1.Size = new System.Drawing.Size(164, 264);
			this.groupBox1.TabIndex = 8;
			this.groupBox1.TabStop = false;
			this.groupBox1.Text = "Инструменты:";
			// 
			// ClearGraphicsButton
			// 
			this.ClearGraphicsButton.Location = new System.Drawing.Point(6, 235);
			this.ClearGraphicsButton.Name = "ClearGraphicsButton";
			this.ClearGraphicsButton.Size = new System.Drawing.Size(75, 23);
			this.ClearGraphicsButton.TabIndex = 5;
			this.ClearGraphicsButton.Text = "Очистить";
			this.ClearGraphicsButton.UseVisualStyleBackColor = true;
			this.ClearGraphicsButton.Click += new System.EventHandler(this.ClearGraphicsButton_Click);
			// 
			// groupBox2
			// 
			this.groupBox2.Controls.Add(this.DeleteFigureButton);
			this.groupBox2.Controls.Add(this.TransformFigureButton);
			this.groupBox2.Controls.Add(this.SelectFigureButton);
			this.groupBox2.Controls.Add(this.PreviewPictureBox);
			this.groupBox2.Location = new System.Drawing.Point(13, 298);
			this.groupBox2.Name = "groupBox2";
			this.groupBox2.Size = new System.Drawing.Size(164, 228);
			this.groupBox2.TabIndex = 9;
			this.groupBox2.TabStop = false;
			this.groupBox2.Text = "Предпросмотр:";
			// 
			// DeleteFigureButton
			// 
			this.DeleteFigureButton.Enabled = false;
			this.DeleteFigureButton.Location = new System.Drawing.Point(83, 163);
			this.DeleteFigureButton.Name = "DeleteFigureButton";
			this.DeleteFigureButton.Size = new System.Drawing.Size(75, 23);
			this.DeleteFigureButton.TabIndex = 8;
			this.DeleteFigureButton.Text = "Удалить";
			this.DeleteFigureButton.UseVisualStyleBackColor = true;
			this.DeleteFigureButton.Click += new System.EventHandler(this.DeleteFigureButton_Click);
			// 
			// TransformFigureButton
			// 
			this.TransformFigureButton.Enabled = false;
			this.TransformFigureButton.Location = new System.Drawing.Point(7, 193);
			this.TransformFigureButton.Name = "TransformFigureButton";
			this.TransformFigureButton.Size = new System.Drawing.Size(151, 23);
			this.TransformFigureButton.TabIndex = 7;
			this.TransformFigureButton.Text = "Трансформировать";
			this.TransformFigureButton.UseVisualStyleBackColor = true;
			this.TransformFigureButton.Click += new System.EventHandler(this.TransformFigureButton_Click);
			// 
			// SelectFigureButton
			// 
			this.SelectFigureButton.Location = new System.Drawing.Point(7, 163);
			this.SelectFigureButton.Name = "SelectFigureButton";
			this.SelectFigureButton.Size = new System.Drawing.Size(74, 23);
			this.SelectFigureButton.TabIndex = 6;
			this.SelectFigureButton.Text = "Выбрать";
			this.SelectFigureButton.UseVisualStyleBackColor = true;
			this.SelectFigureButton.Click += new System.EventHandler(this.SelectFigureButton_Click);
			// 
			// openFileMenuDialog
			// 
			this.openFileMenuDialog.DefaultExt = "cdk";
			this.openFileMenuDialog.Filter = "CorelDrawKiller Files (*.cdk)|*.cdk";
			// 
			// CDKForm
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(996, 538);
			this.Controls.Add(this.groupBox2);
			this.Controls.Add(this.toolList);
			this.Controls.Add(this.groupBox1);
			this.Controls.Add(this.DrawWindow);
			this.Controls.Add(this.MainMenu);
			this.MainMenuStrip = this.MainMenu;
			this.Name = "CDKForm";
			this.Text = "CorelDraw Killer";
			this.MainMenu.ResumeLayout(false);
			this.MainMenu.PerformLayout();
			((System.ComponentModel.ISupportInitialize)(this.DrawWindow)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.ColorDisplayBlock)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.BrushThiknessTrackBar)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.PreviewPictureBox)).EndInit();
			this.groupBox1.ResumeLayout(false);
			this.groupBox1.PerformLayout();
			this.groupBox2.ResumeLayout(false);
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.MenuStrip MainMenu;
		private System.Windows.Forms.ToolStripMenuItem файлToolStripMenuItem;
		private System.Windows.Forms.ToolStripMenuItem OpenFileMenu;
		private System.Windows.Forms.ToolStripMenuItem SaveFileMenu;
		private System.Windows.Forms.ToolStripMenuItem QuitButtonMenu;
		private System.Windows.Forms.ToolStripMenuItem правкаToolStripMenuItem;
		private System.Windows.Forms.ToolStripMenuItem UndoButtonMenu;
		private System.Windows.Forms.ToolStripMenuItem RedoButtonMenu;
		private System.Windows.Forms.ToolStripMenuItem коллекцияToolStripMenuItem;
		private System.Windows.Forms.ToolStripMenuItem OpenUserShapeMenu;
		private System.Windows.Forms.ToolStripMenuItem SaveUserShapeMenu;
		private System.Windows.Forms.ToolStripMenuItem инструментыToolStripMenuItem;
		private System.Windows.Forms.ToolStripMenuItem LineMenu;
		private System.Windows.Forms.ToolStripMenuItem EllipsMenu;
		private System.Windows.Forms.ToolStripMenuItem RectangleMenu;
		private System.Windows.Forms.ToolStripMenuItem TriangleMenu;
		private System.Windows.Forms.ToolStripMenuItem ColorMenu;
		private System.Windows.Forms.ToolStripMenuItem BrushDensityMenu;
		private System.Windows.Forms.ToolStripMenuItem справкаToolStripMenuItem;
		private System.Windows.Forms.ToolStripMenuItem AboutProgramMenu;
		private System.Windows.Forms.ColorDialog ColorDialog;
		private System.Windows.Forms.PictureBox ColorDisplayBlock;
		private System.Windows.Forms.TrackBar BrushThiknessTrackBar;
		private System.Windows.Forms.TextBox BrushThiknessText;
		private System.Windows.Forms.SaveFileDialog SaveAsMenuDialog;
		private System.Windows.Forms.ListBox toolList;
		public System.Windows.Forms.PictureBox DrawWindow;
		private System.Windows.Forms.PictureBox PreviewPictureBox;
		private System.Windows.Forms.GroupBox groupBox1;
		private System.Windows.Forms.Button ClearGraphicsButton;
		private System.Windows.Forms.GroupBox groupBox2;
		private System.Windows.Forms.OpenFileDialog openFileMenuDialog;
		private System.Windows.Forms.Button TransformFigureButton;
		private System.Windows.Forms.Button SelectFigureButton;
		private System.Windows.Forms.Button DeleteFigureButton;
	}
}

