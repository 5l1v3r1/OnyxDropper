using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DropperClient.Logger
{
    internal class ConsoleLogger : ILogger
    {
        /// <summary>
        /// Logs the message to the console.
        /// </summary>
        /// <param name="message"></param>
        public void LogMessage(string message)
        {
            Console.WriteLine($"{DateTime.Now.ToShortTimeString()} | {message}");
        }
    }
}