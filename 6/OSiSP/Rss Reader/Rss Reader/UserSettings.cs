using System.Collections.Generic;

namespace Rss_Reader
{
    class UserSettings
    {
        private readonly string _name;
        private readonly List<string> _siteList = new List<string>();
        private readonly int _threadCount;
        private readonly Dictionary<string, string> _filterDict = new Dictionary<string, string>();

        public string Name
        {
            get { return _name; }
        }

        public List<string> SiteList
        {
            get { return _siteList; }
        }

        public int ThreadCount
        {
            get { return _threadCount; }
        }

        public Dictionary<string, string> FilterDict
        {
            get { return _filterDict; }
        }

        public UserSettings(string name, IEnumerable<string> siteList, int threadCount, Dictionary<string, string> dictionary)
        {
            _name = name;
            _siteList = new List<string>(siteList);
            _threadCount = threadCount;
            _filterDict = new Dictionary<string, string>(dictionary);
        }
    }
}
