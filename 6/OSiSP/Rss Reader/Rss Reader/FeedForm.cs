using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Configuration;
using System.Diagnostics;
using System.Linq;
using System.Windows.Forms;

namespace Rss_Reader
{
    public partial class FeedForm : Form
    {
        private List<Rss.Items> _collection;
        private int _readingThreadCount;
        private int _writingThreadCount;

        public FeedForm()
        {
            InitializeComponent();

            _writingThreadCount = 2;
            _readingThreadCount = int.Parse(ConfigurationManager.AppSettings["threadCount"]);

            dataGridView.CellClick += dataGridView_CellClick;
            dataGridView.CellDoubleClick += dataGridView_CellDoubleClick;

            var rssManager = new RssManager("config.xml", _readingThreadCount, _writingThreadCount);
            var userList = rssManager.GetUsernames();
            ChangeUserComboBox(userList);
        }

        private void dataGridView_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            try
            {
                if (dataGridView.CurrentRow != null)
                {
                    int row = dataGridView.CurrentRow.Index;
                    ChangeWebBrowserText(_collection.ToList().GetRange(row, 1));
                }
            }
            catch
            {
                MessageBox.Show(@"Can't load description");
            }
        }

        private void dataGridView_CellDoubleClick(object sender, DataGridViewCellEventArgs e)
        {
            try
            {
                if (dataGridView.CurrentRow != null && dataGridView.Rows.Count > dataGridView.CurrentRow.Index)
                {
                    string sid = dataGridView.Rows[dataGridView.CurrentRow.Index].Cells["Link"].Value.ToString();
                    Process.Start(sid);
                }
            }
            catch
            {
                MessageBox.Show(@"Can't start process");
            }
        }


        private void getFeedsButton_Click(object sender, EventArgs e)
        {
            var rssManager = new RssManager("config.xml", _readingThreadCount, _writingThreadCount);

            if (userComboBox.SelectedIndex != -1)
            {
                _collection = rssManager.GetFeeds(userComboBox.SelectedItem.ToString());
                if (_collection.Count > 0)
                {
                    ChangeDataGridView(_collection);
                    ChangeWebBrowserText(_collection.ToList().GetRange(0, 10));
                }
            }
        }

        private void ChangeDataGridView(IEnumerable<Rss.Items> collection)
        {
            dataGridView.Rows.Clear();
            foreach (var itemse in collection)
            {
                dataGridView.Rows.Add(itemse.Date, itemse.Title, itemse.Link);
            }
        }

        private void ChangeWebBrowserText(IEnumerable<Rss.Items> collection)
        {
            webBrowser.Navigate("about:blank");
            string outText = collection.Aggregate(
                "<html><body>",
                (current, itemse) => current + ("<div><small>" + itemse.Date + "</small> <h3>" + itemse.Title + "</h3> "
                    + itemse.Description + " <hr>\n</div>")
            );
            outText += "</body></html>";
            webBrowser.DocumentText = outText;
        }

        private void ChangeUserComboBox(IEnumerable<string> userList)
        {
            userComboBox.Items.Clear();
            foreach (string user in userList)
            {
                userComboBox.Items.Add(user);
            }
        }
    }
}
