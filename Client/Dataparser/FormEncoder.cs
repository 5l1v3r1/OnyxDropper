using System.Collections.Generic;
using System.Net.Http;

namespace DropperClient.Dataparser
{
    internal class FormEncoder
    {
        /// <summary>
        /// Creates a FormUrlEncodedContent instance with the necessary information to register the client
        /// </summary>
        /// <param name="cpu">Client's cpu </param>
        /// <param name="ram">Client's ram </param>
        /// <param name="ip">Client's IP</param>
        /// <param name="macaddres">Client's mac?</param>
        /// <param name="antivirus">Client's av</param>
        /// <returns></returns>
        public FormUrlEncodedContent CreateRegisterData(string cpu, string ram, string ip, string macaddres, string antivirus)
        {
            return CreatEncodedContent(new Dictionary<string, string>()
            {
                {"cpu", cpu },
                {"ram", ram },
                {"ip", ip },
                {"mac", macaddres },
                {"av", antivirus },
            });
        }

        /// <summary>
        /// Creates a FormUrlEncodedContent instance with the necessary information to login the client
        /// </summary>
        /// <param name="macaddress">Client's mac</param>
        /// <returns></returns>
        public FormUrlEncodedContent CreateLoginData(string macaddress)
        {
            return CreatEncodedContent(new Dictionary<string, string>()
            {
                {"mac", macaddress }
            });
        }

        private FormUrlEncodedContent CreatEncodedContent(Dictionary<string, string> formdata)
        {
            return new FormUrlEncodedContent(formdata);
        }
    }
}