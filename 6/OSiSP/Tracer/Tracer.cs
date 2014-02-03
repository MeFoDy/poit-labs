using System;
using System.Collections.Generic;
using System.Threading;
using System.Diagnostics;

namespace Tracer
{
	public static class Tracer
	{
		public struct CurrentTraceInfo
		{
			public int ThreadId;
			public DateTime TraceTime;
			public double DeltaTime;
			public string MethodName;
			public string ClassName;
			public string FileName;
			public bool IsOpened;
		}

		public struct TracerLog
		{
			public CurrentTraceInfo Info;
			public List<TracerLog> TraceChilds;
		}

		private struct TimeLaps
		{
			public int BeginCount;
			public int EndCount;
		}

		static List<CurrentTraceInfo> _traceStack;
		static Dictionary<int, List<CurrentTraceInfo>> _traceStackDict;
		static Dictionary<int, TimeLaps> _traceStackCount;
		static List<TracerLog> _traceLog;

		static readonly object Locker = new object();
		static bool _isStarted;

		

		public static void Start()
		{
			lock (Locker)
			{
				if (!_isStarted)
				{
					_isStarted = true;
					Console.WriteLine("Start");
					_traceStack = new List<CurrentTraceInfo>();
					_traceLog = new List<TracerLog>();
				}
				else
					throw new Exception("Вызов старта профайлера до окончания работы предудыщего");
			}
		}

		public static List<TracerLog> Stop()
		{
			Console.WriteLine("Stop");

			lock (Locker)
			{
				_traceStackDict = new Dictionary<int, List<CurrentTraceInfo>>();
				_traceStackCount = new Dictionary<int, TimeLaps>();
				// выбираем все номера потоков
				foreach (CurrentTraceInfo cti in _traceStack)
				{
					List<CurrentTraceInfo> obj;
					if (!_traceStackDict.TryGetValue(cti.ThreadId, out obj))
					{
						_traceStackDict.Add(cti.ThreadId, new List<CurrentTraceInfo>());
						_traceStackCount.Add(cti.ThreadId, new TimeLaps());
					}
				}
				// считаем "операторные" скобки
				foreach (CurrentTraceInfo cti in _traceStack)
				{
					_traceStackDict[cti.ThreadId].Add(cti);
					if (cti.IsOpened)
					{
						TimeLaps tempTl = new TimeLaps
							{
								BeginCount = _traceStackCount[cti.ThreadId].BeginCount + 1,
								EndCount = _traceStackCount[cti.ThreadId].EndCount
							};
						_traceStackCount[cti.ThreadId] = tempTl;
					}
					else
					{
						TimeLaps tempTl = new TimeLaps
							{
								BeginCount = _traceStackCount[cti.ThreadId].BeginCount,
								EndCount = _traceStackCount[cti.ThreadId].EndCount + 1
							};
						_traceStackCount[cti.ThreadId] = tempTl;
					}
				}
				// балансируем "скобки"
				foreach (KeyValuePair<int, List<CurrentTraceInfo>> cti in _traceStackDict)
				{
					if (_traceStackCount[cti.Key].BeginCount != _traceStackCount[cti.Key].EndCount)
					{
						for (var i = 0; i < Math.Abs(_traceStackCount[cti.Key].EndCount - _traceStackCount[cti.Key].BeginCount); i++)
						{
							var temp = new CurrentTraceInfo {IsOpened = false, ThreadId = Thread.CurrentThread.ManagedThreadId};
							_traceStackDict[cti.Key].Add(temp);
						}
					}
				}

				// собственно построение дерево
				_traceLog = new List<TracerLog>();
				foreach (KeyValuePair<int, List<CurrentTraceInfo>> kvp in _traceStackDict)
				{
					var j = 0;
					var x = new TracerLog {TraceChilds = new List<TracerLog>()};
					AddTreeElement(ref x.TraceChilds, kvp.Value, ref j);
					_traceLog.Add(x);
				}
				_isStarted = false;
			}
			return _traceLog;
		}

		private static void AddTreeElement(ref List<TracerLog> tempLog, List<CurrentTraceInfo> traceInfo, ref int i) {
			int j;
			while (i < traceInfo.Count)
			{
				if (traceInfo[i].IsOpened)
				{
					j = i;
					TracerLog x = new TracerLog();
					x.Info = traceInfo[i];
					x.TraceChilds = new List<TracerLog>();
					i++;
					AddTreeElement(ref x.TraceChilds, traceInfo, ref i);
					x.Info.DeltaTime = (traceInfo[i-1].TraceTime - traceInfo[j].TraceTime).TotalMilliseconds;
					tempLog.Add(x);
				}
				else
				{
					i++;
					return;
				}
			}
		}

		public static void BeginTrace()
		{
			lock (Locker)
			{
				CurrentTraceInfo traceInfo = GetMethodDescription();
				traceInfo.IsOpened = true;
				_traceStack.Add(traceInfo);
				//Console.WriteLine("BeginTrace {0} {1} {2} {3} {4}", traceInfo.threadId, traceInfo.traceTime.Millisecond, traceInfo.methodName, traceInfo.className, traceInfo.fileName);
			}
		}

		public static void EndTrace()
		{
			lock (Locker)
			{
				CurrentTraceInfo traceInfo = GetMethodDescription();
				traceInfo.IsOpened = false;
				_traceStack.Add(traceInfo);
			}
			//Console.WriteLine("EndTrace {0}", Thread.CurrentThread.ManagedThreadId);
		}

		private static CurrentTraceInfo GetMethodDescription()
		{
			CurrentTraceInfo tempInfo = new CurrentTraceInfo();
			tempInfo.TraceTime = DateTime.UtcNow;
			tempInfo.ThreadId = Thread.CurrentThread.ManagedThreadId;

			try
			{
				StackTrace st = new StackTrace(true);
				StackFrame frame;

				for (int i = 0; i < st.FrameCount; i++)
				{
					frame = st.GetFrame(i);
					var declaringType = frame.GetMethod().DeclaringType;
					if (declaringType != null)
					{
						string name = declaringType.Name;
						if (name != typeof(Tracer).Name)
						{
							//tempInfo.fileName = frame.GetFileName();
							tempInfo.FileName = frame.GetMethod().Module.Name;
							//tempInfo.methodName = frame.GetMethod().ToString();
							tempInfo.MethodName = frame.GetMethod().Name;
							tempInfo.ClassName = declaringType.FullName;
							return tempInfo;
						}
					}
				}
				return tempInfo;
			}
			catch (Exception ex)
			{
				Console.WriteLine(ex);
				return tempInfo;
			}
		}
	}
}
