namespace Hopfield.WinForms
{
    partial class MainForm
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
            this.button1 = new System.Windows.Forms.Button();
            this.folderBrowserDialog = new System.Windows.Forms.FolderBrowserDialog();
            this.button2 = new System.Windows.Forms.Button();
            this.richTextBox = new System.Windows.Forms.RichTextBox();
            this.button3 = new System.Windows.Forms.Button();
            this.openFileDialog = new System.Windows.Forms.OpenFileDialog();
            this.pictureBoxSource = new System.Windows.Forms.PictureBox();
            this.pictureBoxTarget = new System.Windows.Forms.PictureBox();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBoxSource)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBoxTarget)).BeginInit();
            this.SuspendLayout();
            // 
            // button1
            // 
            this.button1.Location = new System.Drawing.Point(12, 12);
            this.button1.Name = "button1";
            this.button1.Size = new System.Drawing.Size(202, 51);
            this.button1.TabIndex = 0;
            this.button1.Text = "Generate Data";
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new System.EventHandler(this.button1_Click);
            // 
            // folderBrowserDialog
            // 
            this.folderBrowserDialog.SelectedPath = "C:\\Temp\\BSUIR.MiSOI.Lab04\\Data\\";
            // 
            // button2
            // 
            this.button2.Location = new System.Drawing.Point(220, 12);
            this.button2.Name = "button2";
            this.button2.Size = new System.Drawing.Size(203, 51);
            this.button2.TabIndex = 1;
            this.button2.Text = "Test Classification";
            this.button2.UseVisualStyleBackColor = true;
            this.button2.Click += new System.EventHandler(this.button2_Click);
            // 
            // richTextBox
            // 
            this.richTextBox.Location = new System.Drawing.Point(13, 70);
            this.richTextBox.Name = "richTextBox";
            this.richTextBox.ReadOnly = true;
            this.richTextBox.Size = new System.Drawing.Size(643, 527);
            this.richTextBox.TabIndex = 2;
            this.richTextBox.Text = "";
            // 
            // button3
            // 
            this.button3.Location = new System.Drawing.Point(429, 12);
            this.button3.Name = "button3";
            this.button3.Size = new System.Drawing.Size(227, 51);
            this.button3.TabIndex = 3;
            this.button3.Text = "Train and Classify";
            this.button3.UseVisualStyleBackColor = true;
            this.button3.Click += new System.EventHandler(this.button3_Click);
            // 
            // openFileDialog
            // 
            this.openFileDialog.FileName = "openFileDialog1";
            // 
            // pictureBoxSource
            // 
            this.pictureBoxSource.Location = new System.Drawing.Point(663, 13);
            this.pictureBoxSource.Name = "pictureBoxSource";
            this.pictureBoxSource.Size = new System.Drawing.Size(200, 200);
            this.pictureBoxSource.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage;
            this.pictureBoxSource.TabIndex = 4;
            this.pictureBoxSource.TabStop = false;
            // 
            // pictureBoxTarget
            // 
            this.pictureBoxTarget.Location = new System.Drawing.Point(939, 12);
            this.pictureBoxTarget.Name = "pictureBoxTarget";
            this.pictureBoxTarget.Size = new System.Drawing.Size(200, 200);
            this.pictureBoxTarget.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage;
            this.pictureBoxTarget.TabIndex = 5;
            this.pictureBoxTarget.TabStop = false;
            // 
            // MainForm
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(12F, 25F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1155, 609);
            this.Controls.Add(this.pictureBoxTarget);
            this.Controls.Add(this.pictureBoxSource);
            this.Controls.Add(this.button3);
            this.Controls.Add(this.richTextBox);
            this.Controls.Add(this.button2);
            this.Controls.Add(this.button1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
            this.MaximizeBox = false;
            this.Name = "MainForm";
            this.Text = "MiSOI. Lab 4";
            ((System.ComponentModel.ISupportInitialize)(this.pictureBoxSource)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBoxTarget)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Button button1;
        private System.Windows.Forms.FolderBrowserDialog folderBrowserDialog;
        private System.Windows.Forms.Button button2;
        private System.Windows.Forms.RichTextBox richTextBox;
        private System.Windows.Forms.Button button3;
        private System.Windows.Forms.OpenFileDialog openFileDialog;
        private System.Windows.Forms.PictureBox pictureBoxSource;
        private System.Windows.Forms.PictureBox pictureBoxTarget;
    }
}

