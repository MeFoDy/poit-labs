using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using Microsoft.Glee.Drawing;
using System.Text;
using System.Windows.Forms;

namespace MSSvIR
{
	public partial class MayersForm : Form
	{
		private CodeToGraph[] arrayInput; /// массив,который ты передаешь\
		private CodeToGraph[] arrayInputCopy;                                  /// 
		private int[,] adjancyMatrix;// = new int[3,3] {{1,1,1},{2,3,4},{5,6,7}}; матрица смежности
		private int nodesCount; // количество вершин
		private Microsoft.Glee.Drawing.Graph graph;
		private string[] nodes;
		public ProgramToGraph code;


		public MayersForm(string[] classes)
		{
			InitializeComponent();

			code = new ProgramToGraph();
			comboBoxClass.DropDownStyle = ComboBoxStyle.DropDownList;
			comboBoxFunction.DropDownStyle = ComboBoxStyle.DropDownList;

			foreach (string cl in classes)
			{
				comboBoxClass.Items.Add(cl);
			}
			comboBoxClass.SelectedIndex = 0;
		} 

		//отрисовка графа
		private void DrawGraph(int currentTop)
		{
            this.GraphPanel.Controls.Clear();
            Microsoft.Glee.GraphViewerGdi.GViewer viewer = new Microsoft.Glee.GraphViewerGdi.GViewer();
            viewer.AsyncLayout = false;
            viewer.AutoScroll = true;
			nodes = new string[nodesCount];
			for (int i = 0; i < nodesCount; ++i)
			{
				nodes[i] = (i + 1).ToString();
			}

			graph = new Microsoft.Glee.Drawing.Graph("Graph");
			for (int i = 0; i < nodesCount; ++i)
			{
				for (int j = 0; j < nodesCount; ++j)
				{
					if (adjancyMatrix[i, j] != 0)
					{
						graph.AddEdge(nodes[i], ""/*adjancyMatrix[i, j].ToString()*/, nodes[j]);
					}
				}
			}
			for (int i = 0; i < nodesCount; ++i)
			{
				Microsoft.Glee.Drawing.Node currentNode = graph.FindNode(nodes[i]);
				if (i == currentTop)
				{
					currentNode.Attr.Fillcolor = Microsoft.Glee.Drawing.Color.Green;
				}
				else
				{
					currentNode.Attr.Fillcolor = Microsoft.Glee.Drawing.Color.Yellow;
				}
				currentNode.Attr.Shape = Microsoft.Glee.Drawing.Shape.DoubleCircle;
			}
			Microsoft.Glee.GraphViewerGdi.GraphRenderer renderer = new Microsoft.Glee.GraphViewerGdi.GraphRenderer(graph);
            viewer.Graph = graph;
            this.GraphPanel.SuspendLayout();
            viewer.Dock = System.Windows.Forms.DockStyle.Fill;
            this.GraphPanel.Controls.Add(viewer);
            this.GraphPanel.ResumeLayout();

            //Bitmap graphImage = new Bitmap(GraphPanel.Width, GraphPanel.Height);
            //renderer.Render(graphImage);
            //GraphPanel.Image = graphImage;
		}

		//перегон из массива в матрицу
		public void ConvertArrayToMatrix()
		{

			arrayInput = code.GetMayersArray();
			//for (int i = 0; i < arrayInputCopy.Length; i++)
			//{

			//}
			//   arrayInput = arrayInputCopy;
			nodesCount = arrayInput.Length;

			// for (int i = 0; i < arrayInput.Length; i++)
			//    TopsListBox.Items.Add(i+1);
			adjancyMatrix = new int[arrayInput.Length, arrayInput.Length];
			for (int i = 0; i < arrayInput.Length; i++)
			{
				for (int j = 0; j < arrayInput[i].output.Count; j++)
				{
					adjancyMatrix[i, arrayInput[i].output[j]] = 1;
				}
			}
		}
		// действия при выборе вершины
		private void TopsListBox_SelectedIndexChanged(object sender, EventArgs e)
		{
            string textOut = arrayInput[TopsListBox.SelectedIndex].code;
            string textGo = "";
			//CodOfTop.Text = arrayInput[TopsListBox.SelectedIndex].code;
            for (int i = 0; i < textOut.Length - 1; ++i)
            {
                if (textOut[i] == '/' && textOut[i + 1] == 's')
                {
                    textGo += textOut[i + 2];
                    i += 2;
                }
                else
                {
                    textGo += textOut[i];
                }
            }

                /* сюда вставить обработку строк для вывода, чтобы перед текстом не было много пробелов и табуляций*/

                /*======================================================================= */

            CodOfTop.Text = textGo;
                DrawGraph(TopsListBox.SelectedIndex);
		}

		private void comboBoxClass_SelectedIndexChanged(object sender, EventArgs e)
		{
			string source = code.GetFullCode();
			string[] variables = code.GetFunctionsInClass(comboBoxClass.SelectedItem.ToString());

			comboBoxFunction.Items.Clear();
			foreach (string a in variables)
			{
				comboBoxFunction.Items.Add(a);
			}
			comboBoxFunction.SelectedIndex = 0;
		}

		private void comboBoxFunction_SelectedIndexChanged(object sender, EventArgs e)
		{
			mayersCount.Text = code.GetMayersNumber(comboBoxClass.SelectedItem.ToString(), comboBoxFunction.SelectedItem.ToString()).ToString();
			makkeibCount.Text = code.makkeibuMetric.ToString();


			ConvertArrayToMatrix();
			TopsListBox.Text = "1";
			//CodOfTop.Text = arrayInput[0].code.ToString();
			TopsListBox.DropDownStyle = ComboBoxStyle.DropDownList;
			//		DrawGraph(0);

			CodeToGraph[] ar = code.GetMayersArray();
			int i = 0;
			TopsListBox.Items.Clear();
			foreach (CodeToGraph a in ar)
			{
				TopsListBox.Items.Add(i + 1);
				i++;
			}
		}
	}
}
