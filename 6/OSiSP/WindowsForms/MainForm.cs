using System;
using System.Globalization;
using System.IO;
using System.Windows.Forms;
using System.Xml;

namespace WindowsForms
{
	public partial class MainForm : Form
	{
		string _pathToXml = "";
		XmlDocument _dom = new XmlDocument();
		private bool _isStopped;

		public MainForm()
		{
			InitializeComponent();
			openFileDialog.InitialDirectory = Application.StartupPath;
		}

		private void OpenStripMenu_Click(object sender, EventArgs e)
		{
			if (openFileDialog.ShowDialog() == DialogResult.OK)
			{
				_pathToXml = openFileDialog.FileName;
				xmlTextBox.LoadFile(_pathToXml, RichTextBoxStreamType.PlainText);

				_dom.Load(_pathToXml);
				_dom = PrepareXml(_dom);

				tabControl.TabPages.Clear();
				tabControl.TabPages.Add(NewTabPage(_dom.DocumentElement, true));
			}
		}

		private XmlDocument PrepareXml(XmlDocument inDom)
		{
			XmlDocument xmlDocument = inDom;

			var documentElement = _dom.DocumentElement;

			_isStopped = true;
			do
			{
				_isStopped = false;
				if (documentElement != null)
				{
					foreach (XmlNode xmlElement in documentElement.ChildNodes)
					{
						if (!_isStopped)
						{
							AddXmlChildAndClearCalls(xmlElement);
						}
					}
				}
			} while (_isStopped);

			_isStopped = true;
			do
			{
				_isStopped = false;
				if (documentElement != null)
				{
					foreach (XmlNode xmlElement in documentElement.ChildNodes)
					{
						if (!_isStopped)
						{
							AddXmlChildAndClearNestedCalls(xmlElement);
						}
					}
				}
			} while (_isStopped); 

			return xmlDocument;
		}

		private void AddXmlChildAndClearCalls(XmlNode inXmlNode)
		{
			if (inXmlNode.HasChildNodes && !_isStopped)
			{
				foreach (XmlNode xmlElement in inXmlNode.ChildNodes)
				{
					AddXmlChildAndClearCalls(xmlElement);
					if (xmlElement.Name.Equals("call"))
					{
						_isStopped = true;
						foreach (XmlNode childElement in xmlElement.ChildNodes)
						{
							if (xmlElement.ParentNode != null) 
								xmlElement.ParentNode.AppendChild(childElement.CloneNode(true));
						}
						if (xmlElement.ParentNode != null) 
							xmlElement.ParentNode.RemoveChild(xmlElement);
					}
					if (_isStopped)
					{
						break;
					}
				}
			}

		}

		private void AddXmlChildAndClearNestedCalls(XmlNode inXmlNode)
		{
			if (inXmlNode.HasChildNodes && !_isStopped)
			{
				foreach (XmlNode xmlElement in inXmlNode.ChildNodes)
				{
					AddXmlChildAndClearNestedCalls(xmlElement);
					if (xmlElement.Name.Equals("nestedCalls"))
					{
						_isStopped = true;
						foreach (XmlNode childElement in xmlElement.ChildNodes)
						{
							if (xmlElement.PreviousSibling != null)
								xmlElement.PreviousSibling.AppendChild(childElement.CloneNode(true));
						}
						if (xmlElement.ParentNode != null)
							xmlElement.ParentNode.RemoveChild(xmlElement);
					}
					if (_isStopped)
					{
						break;
					}
				}
			}

		}

		private void SetMillisecondsIntoXml(XmlNode xmlNode)
		{
			if (xmlNode.Attributes != null && xmlNode.Attributes["elapsedMilliseconds"] == null)
			{
				XmlAttribute attr = _dom.CreateAttribute("elapsedMilliseconds");
				attr.Value = SetElapsedMillisecondsIntoXml(xmlNode).ToString(CultureInfo.InvariantCulture).Replace(".", ",");
				xmlNode.Attributes.Append(attr);
			}
			if (xmlNode.HasChildNodes)
			{
				foreach (XmlNode childXmlNode in xmlNode)
				{
					SetMillisecondsIntoXml(childXmlNode);
				}
			}
		}

		private double SetElapsedMillisecondsIntoXml(XmlNode xmlNode)
		{
			double elapsedMilliseconds = 0.0;
			if (xmlNode.Attributes != null && xmlNode.Attributes["elapsedMilliseconds"] == null)
			{
				foreach (XmlNode childXmlNode in xmlNode.ChildNodes)
				{
					elapsedMilliseconds += SetElapsedMillisecondsIntoXml(childXmlNode);
				}
			}
			else if (xmlNode.Attributes != null && xmlNode.Attributes["elapsedMilliseconds"] != null)
			{
				elapsedMilliseconds = double.Parse(xmlNode.Attributes["elapsedMilliseconds"].Value);
			}
			return elapsedMilliseconds;
		}

		private void SetPercentIntoXml(XmlNode xmlNode, double rootTime)
		{
			if (xmlNode.Attributes != null)
			{
				if (xmlNode.Name.Equals("thread"))
				{
					rootTime = double.Parse(xmlNode.Attributes["elapsedMilliseconds"].Value);
				}
				double percent = double.Parse(xmlNode.Attributes["elapsedMilliseconds"].Value) / rootTime * 100;

				XmlAttribute attr = _dom.CreateAttribute("percent");
				attr.Value = percent.ToString(CultureInfo.InvariantCulture);
				xmlNode.Attributes.Append(attr);
			}
			if (xmlNode.HasChildNodes)
			{
				foreach (XmlNode inXmlNode in xmlNode)
				{
					SetPercentIntoXml(inXmlNode, rootTime);
				}
			}
		}

		private TabPage NewTabPage(XmlNode xmlNode, bool isMain)
		{
			XmlNode inXmlNode = xmlNode.CloneNode(true);

			SetMillisecondsIntoXml(inXmlNode);
			if (inXmlNode.Attributes != null)
			{
				string s = inXmlNode.Attributes["elapsedMilliseconds"].Value.Replace(".", ",");
				SetPercentIntoXml(inXmlNode, double.Parse(s));
			}

			var treePage = new TabPage {Height = tabControl.Height - 15, Width = tabControl.Width, Text = xmlNode.Name};

			var treeView = new TreeView {Width = treePage.Width - 10, Height = treePage.Height - 10};

			if (_dom.DocumentElement != null && isMain)
			{
				treeView.Nodes.Add(new TreeNode(_dom.DocumentElement.Name));
			}
			else
			{
				treeView.Nodes.Add(new TreeNode(xmlNode.Name));
			}

			TreeNode tNode = treeView.Nodes[0];

			treeView.MouseClick += defTreeView_Click;
			AddNode(inXmlNode, tNode);
			treeView.ExpandAll();

			treePage.Controls.Add(treeView);

			return treePage;
		}

		private void AddNode(XmlNode inXmlNode, TreeNode inTreeNode)
		{
			// Loop through the XML nodes until the leaf is reached.
			// Add the nodes to the TreeView during the looping process.
			if (inXmlNode.HasChildNodes)
			{
				XmlNodeList nodeList = inXmlNode.ChildNodes;
				for (var i = 0; i <= nodeList.Count - 1; i++)
				{
					XmlNode xNode = inXmlNode.ChildNodes[i];

					string s = "";
					if (xNode.Attributes != null && xNode.Attributes["id"] != null)
					{
						s = xNode.Attributes["id"].Value + @" - " + xNode.Attributes["elapsedMilliseconds"].Value;
						TreeNode treeNode = new TreeNode(xNode.Name + s);
						treeNode.Tag = xNode;
						inTreeNode.Nodes.Add(treeNode);
					}
					else if (xNode.Attributes != null && xNode.Attributes["name"] != null)
					{
						s = xNode.Attributes["name"].Value + @" - "
						    + xNode.Attributes["elapsedMilliseconds"].Value
						    + @" (" + xNode.Attributes["percent"].Value + @"%)";
						TreeNode treeNode = new TreeNode(s);
						treeNode.Tag = xNode;
						inTreeNode.Nodes.Add(treeNode);
					}
					else
					{
						TreeNode treeNode = new TreeNode(xNode.Name + s);
						treeNode.Tag = xNode;
						inTreeNode.Nodes.Add(treeNode);
					}
					TreeNode tNode = inTreeNode.Nodes[i];
					AddNode(xNode, tNode);
				}
			}
			else
			{
				// Here you need to pull the data from the XmlNode based on the
				// type of node, whether attribute values are required, and so forth.
				// inTreeNode.Text = (inXmlNode.OuterXml).Trim();
				if (inXmlNode.Attributes != null)
				{
					string s = inXmlNode.Attributes["name"].Value + @" - " 
							+ inXmlNode.Attributes["elapsedMilliseconds"].Value
							+ @" (" + inXmlNode.Attributes["percent"].Value + @"%)";
					inTreeNode.Text = s;
					inTreeNode.Tag = inXmlNode;
				}
			}
		}             

		void defTreeView_Click(object sender, MouseEventArgs e)
		{
			if (e.Button == MouseButtons.Right)
			{
				contextMenuStrip.Show(MousePosition);
			}
		}

		private void oLOLOToolStripMenuItem_Click(object sender, EventArgs e)
		{
			var curTreeView =  (TreeView) tabControl.SelectedTab.Controls[0];
			TreeNode selectedTreeNode = curTreeView.SelectedNode;
			tabControl.TabPages.Add(NewTabPage((XmlNode)selectedTreeNode.Tag, false));
		}

		private void showXmlButton_Click(object sender, EventArgs e)
		{
			if (_pathToXml != "")
			{
				xmlTextBox.LoadFile(_pathToXml, RichTextBoxStreamType.PlainText);
			}
		}

	}
}
