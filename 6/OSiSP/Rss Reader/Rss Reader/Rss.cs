using System;

namespace Rss_Reader
{
    public class Rss
    {
        /// <summary>
        /// A structure to hold the RSS Feed items
        /// </summary>
        [Serializable]
        public class Items
        {
            /// <summary>
            /// The publishing date.
            /// </summary>
            public DateTime Date;

            /// <summary>
            /// The title of the feed
            /// </summary>
            public string Title;

            /// <summary>
            /// A description of the content (or the feed itself)
            /// </summary>
            public string Description;

            /// <summary>
            /// The link to the feed
            /// </summary>
            public string Link;
        }
    }
}
