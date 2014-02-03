namespace Rss_Reader
{
    partial class FeedForm
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
            this.getFeedsButton = new System.Windows.Forms.Button();
            this.webBrowser = new System.Windows.Forms.WebBrowser();
            this.userComboBox = new System.Windows.Forms.ComboBox();
            this.dataGridView = new System.Windows.Forms.DataGridView();
            this.Date = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.Title = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.Link = new System.Windows.Forms.DataGridViewTextBoxColumn();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView)).BeginInit();
            this.SuspendLayout();
            // 
            // getFeedsButton
            // 
            this.getFeedsButton.Location = new System.Drawing.Point(198, 8);
            this.getFeedsButton.Name = "getFeedsButton";
            this.getFeedsButton.Size = new System.Drawing.Size(142, 26);
            this.getFeedsButton.TabIndex = 0;
            this.getFeedsButton.Text = "Получить новости";
            this.getFeedsButton.UseVisualStyleBackColor = true;
            this.getFeedsButton.Click += new System.EventHandler(this.getFeedsButton_Click);
            // 
            // webBrowser
            // 
            this.webBrowser.AllowWebBrowserDrop = false;
            this.webBrowser.IsWebBrowserContextMenuEnabled = false;
            this.webBrowser.Location = new System.Drawing.Point(12, 281);
            this.webBrowser.MinimumSize = new System.Drawing.Size(20, 20);
            this.webBrowser.Name = "webBrowser";
            this.webBrowser.Size = new System.Drawing.Size(955, 261);
            this.webBrowser.TabIndex = 2;
            // 
            // userComboBox
            // 
            this.userComboBox.Location = new System.Drawing.Point(13, 12);
            this.userComboBox.Name = "userComboBox";
            this.userComboBox.Size = new System.Drawing.Size(179, 21);
            this.userComboBox.Sorted = true;
            this.userComboBox.TabIndex = 3;
            // 
            // dataGridView
            // 
            this.dataGridView.AllowUserToAddRows = false;
            this.dataGridView.AllowUserToDeleteRows = false;
            this.dataGridView.AutoSizeColumnsMode = System.Windows.Forms.DataGridViewAutoSizeColumnsMode.Fill;
            this.dataGridView.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dataGridView.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.Date,
            this.Title,
            this.Link});
            this.dataGridView.EditMode = System.Windows.Forms.DataGridViewEditMode.EditProgrammatically;
            this.dataGridView.Location = new System.Drawing.Point(13, 40);
            this.dataGridView.Name = "dataGridView";
            this.dataGridView.Size = new System.Drawing.Size(954, 235);
            this.dataGridView.TabIndex = 4;
            // 
            // Date
            // 
            this.Date.FillWeight = 2.5F;
            this.Date.HeaderText = "Дата";
            this.Date.Name = "Date";
            // 
            // Title
            // 
            this.Title.FillWeight = 7.614212F;
            this.Title.HeaderText = "Заголовок";
            this.Title.Name = "Title";
            // 
            // Link
            // 
            this.Link.FillWeight = 3.4F;
            this.Link.HeaderText = "Ссылка";
            this.Link.Name = "Link";
            // 
            // FeedForm
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(980, 554);
            this.Controls.Add(this.dataGridView);
            this.Controls.Add(this.userComboBox);
            this.Controls.Add(this.webBrowser);
            this.Controls.Add(this.getFeedsButton);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
            this.MaximizeBox = false;
            this.Name = "FeedForm";
            this.Text = "RSS Reader";
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Button getFeedsButton;
        private System.Windows.Forms.WebBrowser webBrowser;
        private System.Windows.Forms.ComboBox userComboBox;
        private System.Windows.Forms.DataGridView dataGridView;
        private System.Windows.Forms.DataGridViewTextBoxColumn Date;
        private System.Windows.Forms.DataGridViewTextBoxColumn Title;
        private System.Windows.Forms.DataGridViewTextBoxColumn Link;
    }
}

