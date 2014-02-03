namespace SAMM_3
{
    partial class Form1
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
            this.nBox = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.p1Box = new System.Windows.Forms.TextBox();
            this.label3 = new System.Windows.Forms.Label();
            this.p2Box = new System.Windows.Forms.TextBox();
            this.goButton = new System.Windows.Forms.Button();
            this.outputTextBox = new System.Windows.Forms.RichTextBox();
            this.resultTextBox = new System.Windows.Forms.RichTextBox();
            this.SuspendLayout();
            // 
            // nBox
            // 
            this.nBox.Location = new System.Drawing.Point(48, 13);
            this.nBox.Name = "nBox";
            this.nBox.Size = new System.Drawing.Size(100, 20);
            this.nBox.TabIndex = 0;
            this.nBox.Text = "100000";
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(27, 16);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(15, 13);
            this.label1.TabIndex = 1;
            this.label1.Text = "N";
            this.label1.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(23, 42);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(19, 13);
            this.label2.TabIndex = 3;
            this.label2.Text = "π1";
            this.label2.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            // 
            // p1Box
            // 
            this.p1Box.Location = new System.Drawing.Point(48, 39);
            this.p1Box.Name = "p1Box";
            this.p1Box.Size = new System.Drawing.Size(100, 20);
            this.p1Box.TabIndex = 2;
            this.p1Box.Text = "0.48";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(23, 68);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(19, 13);
            this.label3.TabIndex = 5;
            this.label3.Text = "π2";
            this.label3.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            // 
            // p2Box
            // 
            this.p2Box.Location = new System.Drawing.Point(48, 65);
            this.p2Box.Name = "p2Box";
            this.p2Box.Size = new System.Drawing.Size(100, 20);
            this.p2Box.TabIndex = 4;
            this.p2Box.Text = "0.5";
            // 
            // goButton
            // 
            this.goButton.Location = new System.Drawing.Point(280, 13);
            this.goButton.Name = "goButton";
            this.goButton.Size = new System.Drawing.Size(195, 72);
            this.goButton.TabIndex = 6;
            this.goButton.Text = "Моделировать";
            this.goButton.UseVisualStyleBackColor = true;
            this.goButton.Click += new System.EventHandler(this.goButton_Click);
            // 
            // outputTextBox
            // 
            this.outputTextBox.Location = new System.Drawing.Point(13, 95);
            this.outputTextBox.Name = "outputTextBox";
            this.outputTextBox.ReadOnly = true;
            this.outputTextBox.Size = new System.Drawing.Size(135, 389);
            this.outputTextBox.TabIndex = 7;
            this.outputTextBox.Text = "";
            // 
            // resultTextBox
            // 
            this.resultTextBox.Location = new System.Drawing.Point(155, 95);
            this.resultTextBox.Name = "resultTextBox";
            this.resultTextBox.ReadOnly = true;
            this.resultTextBox.Size = new System.Drawing.Size(320, 380);
            this.resultTextBox.TabIndex = 8;
            this.resultTextBox.Text = "";
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(487, 496);
            this.Controls.Add(this.resultTextBox);
            this.Controls.Add(this.outputTextBox);
            this.Controls.Add(this.goButton);
            this.Controls.Add(this.label3);
            this.Controls.Add(this.p2Box);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.p1Box);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.nBox);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
            this.MaximizeBox = false;
            this.Name = "Form1";
            this.Text = "SAMM 3";
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.TextBox nBox;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.TextBox p1Box;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.TextBox p2Box;
        private System.Windows.Forms.Button goButton;
        private System.Windows.Forms.RichTextBox outputTextBox;
        private System.Windows.Forms.RichTextBox resultTextBox;
    }
}

