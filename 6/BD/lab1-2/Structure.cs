using System;
using ProtoBuf;

namespace Lab1_2
{
	[Serializable]
	[ProtoContract]
	public struct Structure
	{
		[ProtoMember(1)]
		public string Key;
		[ProtoMember(2)]
		public int Number;
		[ProtoMember(3)]
		public string Str;
	}

	[Serializable]
	[ProtoContract]
	public struct HashedStructure
	{
		[ProtoMember(1)]
		public Structure[] Packet;
	}
}
