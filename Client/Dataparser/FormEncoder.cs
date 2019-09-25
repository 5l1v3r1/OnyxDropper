using System.Collections.Generic;
using System.Net.Http;

namespace DropperClient.Dataparser
{
    internal class FormEncoder
    {
        public FormUrlEncodedContent CreateGetCommandData(string macaddress)
        {
            return CreatEncodedContent(new Dictionary<string, string>()
            {
                {"Mac", macaddress }
            });
        }

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