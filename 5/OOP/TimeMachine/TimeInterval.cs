using System;
using System.Collections.Generic;
using System.Text;

namespace TimeMachine
{
	public class TimeInterval
	{
		protected DateTime currentTime, outTime;
		protected int sourceCount, sourceMultiplier;
		public int SourceCount
		{
			get { return sourceCount; }
		}
		public int SourceMultiplier
		{
			get { return sourceMultiplier; }
		}

		public DateTime CurrentTime
		{
			get { return currentTime; }
		}
		public DateTime OutTime
		{
			get { return outTime; }
		}

		protected int newCount;
		public int NewCount {
			get {return newCount;}
		}
		protected DateTime newDate;
		public DateTime NewDate
		{
			get { return newDate; }
		}

		protected string name;
		public string Name
		{
			get { return name; }
		}
				
		public virtual DateTime SubstractUnit(DateTime sourceTime, int count, int mult) { return new DateTime(); }

		public void SetSourceTimeInterval(int count, int multiplier) {
			sourceCount = count;
			sourceMultiplier = multiplier;
		}

		public void ResetTime()
		{
			currentTime = DateTime.Now;
		}

		public void Calculate(int multiplier, TimeInterval interval)
		{
			ResetTime();
			DateTime tempDateTime = currentTime;
			int periodsCount = 0;
			
			outTime = this.SubstractUnit(currentTime, sourceCount, sourceMultiplier);
			
			while (tempDateTime > outTime)
			{
				tempDateTime = interval.SubstractUnit(tempDateTime, 1, multiplier);
				periodsCount++;
			}

			newCount = periodsCount;
			newDate = interval.SubstractUnit(currentTime, newCount, multiplier);
		}
		
	}
}
