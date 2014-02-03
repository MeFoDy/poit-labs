using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using CalculatorService;

namespace WcfRunner
{
	static class Program
	{
		private static ICalculatorService myServiceHost = null;

        static void Main(string[] args)
        {
            StartService();
            Console.WriteLine("Service at your service");
            Console.ReadKey();
            StopService();
        }

		private static void StartService()
        {
            myServiceHost = new ServiceHost(typeof(CalculatorService.CalculatorService));
            myServiceHost.Open();
        }

		private static void StopService()
        {
            //Call StopService from your shutdown logic (i.e. dispose method)
            if (myServiceHost.State != CommunicationState.Closed)
                myServiceHost.Close();
        }
	}
}
