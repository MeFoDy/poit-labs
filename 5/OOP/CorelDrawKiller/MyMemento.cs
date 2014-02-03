using System;
using System.Collections.Generic;
using System.Text;
using System.Runtime.Serialization.Formatters.Binary;
using System.IO;

namespace CorelDrawKiller
{
	class MyMemento
	{
		private List<List<Figure>> stateList;
		private int currentPosition;

		public MyMemento()
		{
			stateList = new List<List<Figure>>();
			currentPosition = 0;
			stateList.Insert(currentPosition, new List<Figure>());
		}

		public void PushState(List<Figure> pushedList) {
			int count = stateList.Count;
			if (currentPosition < count)
			{
				for (int i = count - 1; i > currentPosition; i--)
				{
					stateList.RemoveAt(i);
				}
			}

			stateList.Insert(++currentPosition, new List<Figure>(pushedList));
		}

		public List<Figure> Undo()
		{
			if (currentPosition > 0)
			{
				currentPosition--;
				foreach (Figure figure in stateList[currentPosition])
				{
					figure.isBordered = false;
				}
				
				return new List<Figure>(stateList[currentPosition]);
			}
			else
			{
				return null;
			}
		}

		public List<Figure> Redo()
		{
			if (currentPosition < stateList.Count - 1)
			{
				currentPosition++; 
				foreach (Figure figure in stateList[currentPosition])
				{
					figure.isBordered = false;
				}
				return new List<Figure>(stateList[currentPosition]);
			}
			else
			{
				return null;
			}
		}
	}
}
