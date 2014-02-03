namespace lab1
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
            System.Windows.Forms.DataVisualization.Charting.ChartArea chartArea2 = new System.Windows.Forms.DataVisualization.Charting.ChartArea();
            System.Windows.Forms.DataVisualization.Charting.Legend legend2 = new System.Windows.Forms.DataVisualization.Charting.Legend();
            System.Windows.Forms.DataVisualization.Charting.Series series2 = new System.Windows.Forms.DataVisualization.Charting.Series();
            this.label1 = new System.Windows.Forms.Label();
            this.textBoxA = new System.Windows.Forms.TextBox();
            this.textBoxR0 = new System.Windows.Forms.TextBox();
            this.label2 = new System.Windows.Forms.Label();
            this.textBoxM = new System.Windows.Forms.TextBox();
            this.label3 = new System.Windows.Forms.Label();
            this.buttonStart = new System.Windows.Forms.Button();
            this.chartHist = new System.Windows.Forms.DataVisualization.Charting.Chart();
            this.richTextBox = new System.Windows.Forms.RichTextBox();
            ((System.ComponentModel.ISupportInitialize)(this.chartHist)).BeginInit();
            this.SuspendLayout();
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(14, 12);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(16, 13);
            this.label1.TabIndex = 0;
            this.label1.Text = "a:";
            // 
            // textBoxA
            // 
            this.textBoxA.Location = new System.Drawing.Point(33, 9);
            this.textBoxA.Name = "textBoxA";
            this.textBoxA.Size = new System.Drawing.Size(100, 20);
            this.textBoxA.TabIndex = 1;
            this.textBoxA.Text = "1234135";
            // 
            // textBoxR0
            // 
            this.textBoxR0.Location = new System.Drawing.Point(33, 35);
            this.textBoxR0.Name = "textBoxR0";
            this.textBoxR0.Size = new System.Drawing.Size(100, 20);
            this.textBoxR0.TabIndex = 3;
            this.textBoxR0.Text = "4564873";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(6, 38);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(24, 13);
            this.label2.TabIndex = 2;
            this.label2.Text = "R0:";
            // 
            // textBoxM
            // 
            this.textBoxM.Location = new System.Drawing.Point(33, 61);
            this.textBoxM.Name = "textBoxM";
            this.textBoxM.Size = new System.Drawing.Size(100, 20);
            this.textBoxM.TabIndex = 5;
            this.textBoxM.Text = "1348445";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(12, 64);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(18, 13);
            this.label3.TabIndex = 4;
            this.label3.Text = "m:";
            // 
            // buttonStart
            // 
            this.buttonStart.Location = new System.Drawing.Point(58, 87);
            this.buttonStart.Name = "buttonStart";
            this.buttonStart.Size = new System.Drawing.Size(75, 23);
            this.buttonStart.TabIndex = 6;
            this.buttonStart.Text = "Start";
            this.buttonStart.UseVisualStyleBackColor = true;
            this.buttonStart.Click += new System.EventHandler(this.buttonStart_Click);
            // 
            // chartHist
            // 
            chartArea2.Name = "ChartArea1";
            this.chartHist.ChartAreas.Add(chartArea2);
            legend2.Name = "Legend1";
            this.chartHist.Legends.Add(legend2);
            this.chartHist.Location = new System.Drawing.Point(139, 9);
            this.chartHist.Name = "chartHist";
            series2.ChartArea = "ChartArea1";
            series2.Legend = "Legend1";
            series2.Name = "Numbers";
            this.chartHist.Series.Add(series2);
            this.chartHist.Size = new System.Drawing.Size(750, 300);
            this.chartHist.TabIndex = 7;
            this.chartHist.Text = "chartHist";
            // 
            // richTextBox
            // 
            this.richTextBox.Location = new System.Drawing.Point(139, 315);
            this.richTextBox.Name = "richTextBox";
            this.richTextBox.ReadOnly = true;
            this.richTextBox.Size = new System.Drawing.Size(750, 237);
            this.richTextBox.TabIndex = 8;
            this.richTextBox.Text = "";
            // 
            // MainForm
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(901, 564);
            this.Controls.Add(this.richTextBox);
            this.Controls.Add(this.chartHist);
            this.Controls.Add(this.buttonStart);
            this.Controls.Add(this.textBoxM);
            this.Controls.Add(this.label3);
            this.Controls.Add(this.textBoxR0);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.textBoxA);
            this.Controls.Add(this.label1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
            this.MaximizeBox = false;
            this.Name = "MainForm";
            this.Text = "САММ. Лабораторная работа 1";
            ((System.ComponentModel.ISupportInitialize)(this.chartHist)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.TextBox textBoxA;
        private System.Windows.Forms.TextBox textBoxR0;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.TextBox textBoxM;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.Button buttonStart;
        private System.Windows.Forms.DataVisualization.Charting.Chart chartHist;
        private System.Windows.Forms.RichTextBox richTextBox;
    }
}

