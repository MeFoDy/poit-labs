using System;
using System.Threading;

namespace TestTracer
{
	static class Program
	{
		static void Main()
		{
			Tracer.Tracer.Start();

			Tracer.Tracer.BeginTrace();
			Tracer.Tracer.EndTrace();


			Tracer.Tracer.BeginTrace();
			Tracer.Tracer.BeginTrace();
			Tracer.Tracer.BeginTrace();

			Thread.Sleep(1000);

			var bgThread = new Thread(ThreadStart);
			bgThread.Start();

			OtherMethod();

			Mine();

			Tracer.Tracer.EndTrace();
			Tracer.Tracer.EndTrace();
			Tracer.Tracer.EndTrace();

			bgThread.Join();

			var wholeResult = Tracer.Tracer.Stop();
			View xmlView = new XmlView(wholeResult);
			Console.WriteLine("=============== XML Saving Start ===============\n");
			Console.WriteLine("Saved to file {0}",xmlView.Save());
			Console.WriteLine("\n=============== XML Saving Stop ================");

			View consoleView = new ConsoleView(wholeResult);
			Console.WriteLine("\n=============== Console Saving Start ===============");
			Console.WriteLine(consoleView.Save());
			Console.WriteLine("=============== Console Saving Stop ================");

			// Здесь должен находится код по форматированному выводу результатов.

			Console.ReadKey();

		}

		static void Mine()
		{
			Console.WriteLine("test");
		}

		static void ThreadStart()
		{
			OtherMethod();
			OneMoreMethod();
		}

		static void OtherMethod()
		{
			Tracer.Tracer.BeginTrace();
			Tracer.Tracer.BeginTrace();

			Thread.Sleep(1050);

			OneMoreMethod();

			Tracer.Tracer.EndTrace();
			Tracer.Tracer.EndTrace();
		}

		static void OneMoreMethod()
		{
			Tracer.Tracer.BeginTrace();
			Thread.Sleep(50);
			Tracer.Tracer.EndTrace();
		}
	}
}
