using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using DropperClient.Installation;
using Microsoft.Win32;

namespace DropperClient.Command
{
    internal class UninstallCommand : ICommand
    {
        public bool Execute()
        {
            var execInfo = new ExecutableInfo();

            string keyName = @"Software\Microsoft\Windows\CurrentVersion\Run";
            using (RegistryKey key = Registry.CurrentUser.OpenSubKey(execInfo.AssemblyName, true))
            {
                if (key == null)
                {
                    // Key doesn't exist. Do whatever you want to handle
                    // this case
                }
                else
                {
                    key.DeleteValue("MyApp");
                }
            }

            execInfo.StartMelt();
            Environment.Exit(0);

            return true;
        }
    }
}