using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DropperClient
{
    internal static class Settings
    {
        public static readonly string hostname = "http://localhost";

        // InstallLocation 0: AppData
        // InstallLocation 1: Documents
        public static readonly int InstallLocation = 0;

        public static readonly bool Install = true;
        public static readonly bool Hide = true;
        public static readonly int TimeOut = 120000;
    }
}