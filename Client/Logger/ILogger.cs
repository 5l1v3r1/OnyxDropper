using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DropperClient.Logger
{
    internal interface ILogger
    {
        void LogMessage(string message);
    }
}