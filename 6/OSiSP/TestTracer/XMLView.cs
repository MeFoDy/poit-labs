using System;
using System.Collections.Generic;
using System.Globalization;
using System.Text;
using System.Xml;

namespace TestTracer
{
	class XmlView : View
	{
		XmlDocument _document;

		public XmlView(List<Tracer.Tracer.TracerLog> tL)
		{
			TracerLog = tL;
		}

		public override string Save()
		{
			string pathToXml = DateTime.UtcNow.ToFileTimeUtc().ToString(CultureInfo.InvariantCulture) + ".xml";

			XmlTextWriter textWritter = new XmlTextWriter(pathToXml, Encoding.UTF8);
			textWritter.WriteStartDocument();
			textWritter.WriteStartElement("tracing");
			textWritter.WriteEndElement();
			textWritter.Close();


			_document = new XmlDocument();
			_document.Load(pathToXml);
			foreach (Tracer.Tracer.TracerLog tL in TracerLog)
			{
				XmlNode trhreadEl = _document.CreateElement("thread");
				if (_document.DocumentElement != null) _document.DocumentElement.AppendChild(trhreadEl);
				var attribute = _document.CreateAttribute("id");
				attribute.Value = tL.TraceChilds[0].Info.ThreadId.ToString(CultureInfo.InvariantCulture);
				if (trhreadEl.Attributes != null) trhreadEl.Attributes.Append(attribute);

				CreateXmlTree(ref trhreadEl, tL.TraceChilds);
			}

			_document.Save(pathToXml);
			return pathToXml;
		}

		private void CreateXmlTree(ref XmlNode node, List<Tracer.Tracer.TracerLog> curTracerLog)
		{
			foreach (Tracer.Tracer.TracerLog trace in curTracerLog)
			{
				XmlNode callEl = _document.CreateElement("call");
				node.AppendChild(callEl);

				XmlNode method = _document.CreateElement("method");
				callEl.AppendChild(method);

				XmlAttribute nameAttr = _document.CreateAttribute("name");
				nameAttr.Value = trace.Info.MethodName;
				if (method.Attributes != null) method.Attributes.Append(nameAttr);
				XmlAttribute moduleAttr = _document.CreateAttribute("module");
				moduleAttr.Value = trace.Info.FileName;
				if (method.Attributes != null) method.Attributes.Append(moduleAttr);
				XmlAttribute classAttr = _document.CreateAttribute("class");
				classAttr.Value = trace.Info.ClassName;
				if (method.Attributes != null) method.Attributes.Append(classAttr);
				XmlAttribute elapsedMillisecondsAttr = _document.CreateAttribute("elapsedMilliseconds");
				elapsedMillisecondsAttr.Value = trace.Info.DeltaTime.ToString(CultureInfo.InvariantCulture);
				if (method.Attributes != null) method.Attributes.Append(elapsedMillisecondsAttr);

				if (trace.TraceChilds.Count <= 0) continue;
				XmlNode nestedCalls = _document.CreateElement("nestedCalls");
				callEl.AppendChild(nestedCalls);
				CreateXmlTree(ref nestedCalls, trace.TraceChilds);
			}
		}
	}
}
