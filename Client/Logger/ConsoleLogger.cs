using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DropperClient.Logger
{
    internal class ConsoleLogger : ILogger
    {
        public void LogMessage(string message)
        {
            Console.WriteLine($"{DateTime.Now.ToShortTimeString()} | {message}");
        }
    }
}