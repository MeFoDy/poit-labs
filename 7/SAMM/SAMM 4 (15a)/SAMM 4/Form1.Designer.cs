namespace SAMM_4
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
            this.lambdaBox = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.muBox = new System.Windows.Forms.TextBox();
            this.label3 = new System.Windows.Forms.Label();
            this.timeBox = new System.Windows.Forms.TextBox();
            this.goButton = new System.Windows.Forms.Button();
            this.outputBox = new System.Windows.Forms.RichTextBox();
            this.SuspendLayout();
            // 
            // lambdaBox
            // 
            this.lambdaBox.Location = new System.Drawing.Point(47, 13);
            this.lambdaBox.Name = "lambdaBox";
            this.lambdaBox.Size = new System.Drawing.Size(100, 20);
            this.lambdaBox.TabIndex = 0;
            this.lambdaBox.Text = "3";
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(29, 16);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(12, 13);
            this.label1.TabIndex = 1;
            this.label1.Text = "λ";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(28, 42);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(13, 13);
            this.label2.TabIndex = 3;
            this.label2.Text = "μ";
            // 
            // muBox
            // 
            this.muBox.Location = new System.Drawing.Point(47, 39);
            this.muBox.Name = "muBox";
            this.muBox.Size = new System.Drawing.Size(100, 20);
            this.muBox.TabIndex = 2;
            this.muBox.Text = "1";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(13, 68);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(28, 13);
            this.label3.TabIndex = 5;
            this.label3.Text = "Тож";
            // 
            // timeBox
            // 
            this.timeBox.Location = new System.Drawing.Point(47, 65);
            this.timeBox.Name = "timeBox";
            this.timeBox.Size = new System.Drawing.Size(100, 20);
            this.timeBox.TabIndex = 4;
            this.timeBox.Text = "0.5";
            // 
            // goButton
            // 
            this.goButton.Location = new System.Drawing.Point(154, 13);
            this.goButton.Name = "goButton";
            this.goButton.Size = new System.Drawing.Size(137, 72);
            this.goButton.TabIndex = 6;
            this.goButton.Text = "Моделировать";
            this.goButton.UseVisualStyleBackColor = true;
            this.goButton.Click += new System.EventHandler(this.goButton_Click);
            // 
            // outputBox
            // 
            this.outputBox.Location = new System.Drawing.Point(12, 91);
            this.outputBox.Name = "outputBox";
            this.outputBox.ReadOnly = true;
            this.outputBox.Size = new System.Drawing.Size(279, 224);
            this.outputBox.TabIndex = 7;
            this.outputBox.Text = "";
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(303, 327);
            this.Controls.Add(this.outputBox);
            this.Controls.Add(this.goButton);
            this.Controls.Add(this.label3);
            this.Controls.Add(this.timeBox);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.muBox);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.lambdaBox);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
            this.MaximizeBox = false;
            this.Name = "Form1";
            this.Text = "SAMM 4";
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.TextBox lambdaBox;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.TextBox muBox;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.TextBox timeBox;
        private System.Windows.Forms.Button goButton;
        private System.Windows.Forms.RichTextBox outputBox;
    }
}

