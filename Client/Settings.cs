namespace DropperClient
{
    /// <summary>
    /// Change the variables in this class to your settings.
    /// </summary>
    internal class Settings
    {
        public readonly string hostname = "http://localhost";

        // InstallLocation 0: AppData
        // InstallLocation 1: Documents
        public readonly int InstallLocation = 0;

        public readonly bool Install = true;
        public readonly bool Hide = true;
        public readonly int TimeOut = 120000;
    }
}