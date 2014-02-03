using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Threading;
using System.Windows.Forms;
using System.Xml;
using System.Xml.Serialization;

namespace Rss_Reader
{
    /// <summary>
    /// Class to parse and display RSS Feeds
    /// </summary>
    [Serializable]
    public class RssManager : IDisposable
    {
        private string _url;
        private string _feedTitle;
        private string _feedDescription;
        private List<Rss.Items> _rssItems = new List<Rss.Items>();
        private List<Rss.Items> _unfilteredRssItems = new List<Rss.Items>();
        private List<List<Rss.Items>> _xmlItems = new List<List<Rss.Items>>();
        private bool _isDisposed;
        private bool _isFinished;
        private readonly int _readingThreadCount;
        private readonly int _writingThreadCount;
        private UserSettings _currentUser;
        private List<UserSettings> _userSettings = new List<UserSettings>();
        private List<string> _siteList;
        private object readerLock = new object(), writerLock = new object(), filterLock = new object(), locker = new object();

        public RssManager()
        {
            _url = string.Empty;
        }

        public RssManager(string feedUrl)
        {
            _url = feedUrl;
        }

        public RssManager(string configXmlPath, int readingThreadCount, int writingThreadCount)
        {
            _readingThreadCount = readingThreadCount;
            _writingThreadCount = writingThreadCount;
            InitXmlConfig(configXmlPath);
        }

        private void InitXmlConfig(string configXmlPath)
        {
            var doc = new XmlDocument();
            doc.Load(configXmlPath);

            XmlNodeList xmlNodes = doc.SelectNodes("//users/user");
            if (xmlNodes != null)
                foreach (XmlNode xmlNode in xmlNodes)
                {
                    int threadCount = int.Parse(xmlNode.SelectSingleNode("filtering/threadCount/text()").Value);
                    XmlNodeList sitesXml = xmlNode.SelectNodes("sites/site/text()");
                    List<string> siteList = (from XmlNode site in sitesXml select site.Value).ToList();
                    Dictionary<string, string> filterDict = new Dictionary<string, string>();
                    var includes = xmlNode.SelectSingleNode("filtering/include/text()");
                    if (includes != null)
                        filterDict.Add("include", includes.Value);
                    var excludes = xmlNode.SelectSingleNode("filtering/exclude/text()");
                    if (excludes != null)
                        filterDict.Add("exclude", excludes.Value);

                    _userSettings.Add(new UserSettings(
                        xmlNode.Attributes["name"].Value,
                        siteList,
                        threadCount,
                        filterDict));
                }
        }

        /// <summary>
        /// Gets or sets the URL of the RSS feed to parse.
        /// </summary>
        public string Url
        {
            get { return _url; }
            set { _url = value; }
        }


        /// <summary>
        /// Gets all the items in the RSS feed.
        /// </summary>
        public List<Rss.Items> RssItems
        {
            get { return _unfilteredRssItems; }
        }

        /// <summary>
        /// Gets the title of the RSS feed.
        /// </summary>
        public string FeedTitle
        {
            get { return _feedTitle; }
        }

        /// <summary>
        /// Gets the description of the RSS feed.
        /// </summary>
        public string FeedDescription
        {
            get { return _feedDescription; }
        }




        public List<string> GetUsernames()
        {
            if (_userSettings != null)
            {
                return _userSettings.Select(userSettingse => userSettingse.Name).ToList();
            }
            return new List<string>();
        }

        public void GetFeed()
        {
            while (_siteList.Count != 0)
            {
                string url = null;
                lock (locker)
                {
                    if (_siteList.Count != 0)
                    {
                        url = _siteList[0];
                        _siteList.RemoveAt(0);
                    }
                }
                if (url != null)
                {
                    try
                    {
                        using (XmlReader reader = XmlReader.Create(url))
                        {
                            var xmlDoc = new XmlDocument();
                            xmlDoc.Load(reader);

                            var items = ParseRssItems(xmlDoc);
                            lock (readerLock)
                            {
                                _unfilteredRssItems.AddRange(items);
                            }
                        }
                    }
                    catch
                    {
                        MessageBox.Show(@"Нет Интернет-соединения. Повторите попытку.");
                    }
                }
            }
            lock (filterLock)
            {
                _isFinished = true;
            }
        }

        public void WriteFeed()
        {
            while (_xmlItems.Count != 0)
            {
                List<Rss.Items> xmlItem = null;
                lock (writerLock)
                {
                    if (_xmlItems.Count != 0)
                    {
                        xmlItem = new List<Rss.Items>(_xmlItems[0]);
                        _xmlItems.RemoveAt(0);
                    } 
                }
                if (xmlItem != null)
                {
                    string path = xmlItem[0].Link.Split('/')[2];
                    using (TextWriter textWriter = new StreamWriter(@"xml\" +_currentUser.Name + ".xml"))
                    {
                        var serializer = new XmlSerializer(typeof (List<Rss.Items>));
                        serializer.Serialize(textWriter, xmlItem);
                    }
                }
            }
            
        }

        public List<Rss.Items> GetFeeds(string selectedUser)
        {
            bool isUserSet = false;
            UserSettings user = new UserSettings("", new List<string>(), 0, new Dictionary<string, string>());

            foreach (var userSettingse in _userSettings)
            {
                _unfilteredRssItems = new List<Rss.Items>();
                _rssItems = new List<Rss.Items>();
                _xmlItems = new List<List<Rss.Items>>();
                _siteList = new List<string>(userSettingse.SiteList);
                _currentUser = userSettingse;
                _isFinished = false;

                ReadFeed(userSettingse.ThreadCount);
                _xmlItems.Add(new List<Rss.Items>(_rssItems));

                WriteFeedToXml();
            }

            foreach (UserSettings userSetting in _userSettings.Where(userSetting => userSetting.Name.Equals(selectedUser)))
            {
                isUserSet = true;
                user = userSetting;
                break;
            }
            if (isUserSet)
            {
                _unfilteredRssItems = new List<Rss.Items>();
                _rssItems = new List<Rss.Items>();
                _xmlItems = new List<List<Rss.Items>>();
                _siteList = new List<string>(user.SiteList);
                _currentUser = user;
                _isFinished = false;

                ReadFeed(user.ThreadCount);
                _xmlItems.Add(new List<Rss.Items>(_rssItems));

                WriteFeedToXml();
            }
            return _rssItems;
        }

        private void ReadFeed(int threadCount)
        {
            List<Thread> threads = new List<Thread>();
            for (int i = 0; i < _readingThreadCount; i++)
            {
                var thread = new Thread(GetFeed);
                thread.Start();
                threads.Add(thread);
            }
            for (int i = 0; i < threadCount; i++)
            {
                var thread = new Thread(GetFilteredFeed);
                thread.Start();
                threads.Add(thread);
            }
            foreach (var thread in threads)
            {
                thread.Join();
            }
        }

        private void GetFilteredFeed()
        {
            while (!_isFinished || _unfilteredRssItems.Count != 0)
            {
                Rss.Items rssItem = null;
                lock (readerLock)
                {
                    if (_unfilteredRssItems.Count != 0)
                    {
                        rssItem = _unfilteredRssItems[0];
                        _unfilteredRssItems.RemoveAt(0);
                    }
                }
                if (rssItem != null && AcceptedByFilter(rssItem))
                {
                    lock (filterLock)
                    {
                        _rssItems.Add(rssItem);
                    }
                }
            }
        }

        private bool AcceptedByFilter(Rss.Items rssItem)
        {
            var filterDict = _currentUser.FilterDict;
            if (filterDict.ContainsKey("exclude"))
            {
                var excludes = filterDict["exclude"].Split('|');
                foreach (var exclude in excludes)
                {
                    var excludeElems = exclude.Split('&');
                    bool isSet = excludeElems.All(elem => rssItem.Description.Contains(elem));
                    if (isSet)
                        return false;
                    isSet = excludeElems.All(elem => rssItem.Title.Contains(elem));
                    if (isSet)
                        return false;
                }
            }
            if (filterDict.ContainsKey("include"))
            {
                var includes = filterDict["include"].Split('|');
                foreach (var include in includes)
                {
                    var includeElems = include.Split('&');
                    bool isSet = includeElems.All(elem => rssItem.Description.Contains(elem));
                    if (isSet)
                        return true;
                    isSet = includeElems.All(elem => rssItem.Title.Contains(elem));
                    if (isSet)
                        return true;
                }
                return false;
            }
            return true;
        }

        private void WriteFeedToXml()
        {
            List<Thread> threads = new List<Thread>();
            for (int i = 0; i < _writingThreadCount; i++)
            {
                var thread = new Thread(WriteFeed);
                thread.Start();
                threads.Add(thread);
            }
            foreach (var thread in threads)
            {
                thread.Join();
            }
        }

        /// <summary>
        /// Parses the xml document in order to retrieve the RSS items.
        /// </summary>
        private List<Rss.Items> ParseRssItems(XmlDocument xmlDoc)
        {
            var rssItems = new List<Rss.Items>();
            rssItems.Clear();
            XmlNodeList nodes = xmlDoc.SelectNodes("rss/channel/item");

            if (nodes != null)
                foreach (XmlNode node in nodes)
                {
                    var item = new Rss.Items();
                    ParseDocElements(node, "title", ref item.Title);
                    ParseDocElements(node, "description", ref item.Description);
                    ParseDocElements(node, "link", ref item.Link);

                    string date = null;
                    ParseDocElements(node, "pubDate", ref date);
                    DateTime.TryParse(date, out item.Date);

                    rssItems.Add(item);
                }
            return rssItems;
        }

        /// <summary>
        /// Parses the XmlNode with the specified XPath query 
        /// and assigns the value to the property parameter.
        /// </summary>
        /// <exception cref="ArgumentNullException"></exception>
        private void ParseDocElements(XmlNode parent, string xPath, ref string property)
        {
            XmlNode node = parent.SelectSingleNode(xPath);
            property = node != null ? node.InnerText : "Unresolvable";
        }

        /// <summary>
        /// Performs the disposal.
        /// </summary>
        private void Dispose(bool disposing)
        {
            if (disposing && !_isDisposed)
            {
                _unfilteredRssItems.Clear();
                _url = null;
                _feedTitle = null;
                _feedDescription = null;
            }

            _isDisposed = true;
        }

        /// <summary>
        /// Releases the object to the garbage collector
        /// </summary>
        public void Dispose()
        {
            Dispose(true);
            GC.SuppressFinalize(this);
        }
    }
}