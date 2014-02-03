namespace WindowsForms
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
			this.components = new System.ComponentModel.Container();
			this.MainMenu = new System.Windows.Forms.MenuStrip();
			this.OpenStripMenu = new System.Windows.Forms.ToolStripMenuItem();
			this.showXmlButton = new System.Windows.Forms.ToolStripMenuItem();
			this.tabControl = new System.Windows.Forms.TabControl();
			this.openFileDialog = new System.Windows.Forms.OpenFileDialog();
			this.contextMenuStrip = new System.Windows.Forms.ContextMenuStrip(this.components);
			this.oLOLOToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this.яТкнулПростоТакToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this.xmlTextBox = new System.Windows.Forms.RichTextBox();
			this.MainMenu.SuspendLayout();
			this.contextMenuStrip.SuspendLayout();
			this.SuspendLayout();
			// 
			// MainMenu
			// 
			this.MainMenu.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.OpenStripMenu,
            this.showXmlButton});
			this.MainMenu.Location = new System.Drawing.Point(0, 0);
			this.MainMenu.Name = "MainMenu";
			this.MainMenu.Size = new System.Drawing.Size(1089, 24);
			this.MainMenu.TabIndex = 0;
			this.MainMenu.Text = "MainMenu";
			// 
			// OpenStripMenu
			// 
			this.OpenStripMenu.Name = "OpenStripMenu";
			this.OpenStripMenu.Size = new System.Drawing.Size(66, 20);
			this.OpenStripMenu.Text = "Открыть";
			this.OpenStripMenu.Click += new System.EventHandler(this.OpenStripMenu_Click);
			// 
			// showXmlButton
			// 
			this.showXmlButton.Name = "showXmlButton";
			this.showXmlButton.Size = new System.Drawing.Size(96, 20);
			this.showXmlButton.Text = "Показать XML";
			this.showXmlButton.Click += new System.EventHandler(this.showXmlButton_Click);
			// 
			// tabControl
			// 
			this.tabControl.Location = new System.Drawing.Point(13, 28);
			this.tabControl.Name = "tabControl";
			this.tabControl.SelectedIndex = 0;
			this.tabControl.Size = new System.Drawing.Size(396, 422);
			this.tabControl.TabIndex = 1;
			// 
			// openFileDialog
			// 
			this.openFileDialog.FileName = "openFileDialog";
			this.openFileDialog.Filter = "XML-файлы|*.xml";
			this.openFileDialog.InitialDirectory = "./";
			// 
			// contextMenuStrip
			// 
			this.contextMenuStrip.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.oLOLOToolStripMenuItem,
            this.яТкнулПростоТакToolStripMenuItem});
			this.contextMenuStrip.Name = "contextMenuStrip";
			this.contextMenuStrip.Size = new System.Drawing.Size(265, 70);
			// 
			// oLOLOToolStripMenuItem
			// 
			this.oLOLOToolStripMenuItem.Name = "oLOLOToolStripMenuItem";
			this.oLOLOToolStripMenuItem.Size = new System.Drawing.Size(264, 22);
			this.oLOLOToolStripMenuItem.Text = "Просмотреть в отдельной вкладке";
			this.oLOLOToolStripMenuItem.Click += new System.EventHandler(this.oLOLOToolStripMenuItem_Click);
			// 
			// яТкнулПростоТакToolStripMenuItem
			// 
			this.яТкнулПростоТакToolStripMenuItem.Name = "яТкнулПростоТакToolStripMenuItem";
			this.яТкнулПростоТакToolStripMenuItem.Size = new System.Drawing.Size(264, 22);
			this.яТкнулПростоТакToolStripMenuItem.Text = "Я ткнул просто так :)";
			// 
			// xmlTextBox
			// 
			this.xmlTextBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.xmlTextBox.Location = new System.Drawing.Point(416, 28);
			this.xmlTextBox.Name = "xmlTextBox";
			this.xmlTextBox.ReadOnly = true;
			this.xmlTextBox.Size = new System.Drawing.Size(661, 422);
			this.xmlTextBox.TabIndex = 2;
			this.xmlTextBox.Text = "";
			// 
			// MainForm
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(1089, 462);
			this.Controls.Add(this.xmlTextBox);
			this.Controls.Add(this.tabControl);
			this.Controls.Add(this.MainMenu);
			this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
			this.MainMenuStrip = this.MainMenu;
			this.MaximizeBox = false;
			this.Name = "MainForm";
			this.Text = "WindowsForms";
			this.MainMenu.ResumeLayout(false);
			this.MainMenu.PerformLayout();
			this.contextMenuStrip.ResumeLayout(false);
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.MenuStrip MainMenu;
		private System.Windows.Forms.ToolStripMenuItem OpenStripMenu;
		private System.Windows.Forms.ToolStripMenuItem showXmlButton;
		private System.Windows.Forms.TabControl tabControl;
		private System.Windows.Forms.OpenFileDialog openFileDialog;
		private System.Windows.Forms.ContextMenuStrip contextMenuStrip;
		private System.Windows.Forms.ToolStripMenuItem oLOLOToolStripMenuItem;
		private System.Windows.Forms.ToolStripMenuItem яТкнулПростоТакToolStripMenuItem;
		private System.Windows.Forms.RichTextBox xmlTextBox;
	}
}

