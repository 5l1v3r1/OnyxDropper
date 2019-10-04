using System;
using System.Net.Http;

namespace DropperClient.Connection
{
    internal class ServerConnection : IDisposable
    {
        private readonly HttpClient _httpClient;
        public string _addres { get; private set; }

        /// <summary>
        /// Provides functions to check the connection to the webserver
        /// </summary>
        /// <param name="baseAddres">Adress to connect to, for example http://localhost </param>
        public ServerConnection(string baseAddres)
        {
            _httpClient = new HttpClient();
            _addres = baseAddres;
        }

        public void Dispose()
        {
            _httpClient.Dispose();
        }

        /// <summary>
        /// Pings the webserver to see if a connection is possible
        /// </summary>
        /// <returns></returns>
        public bool CanConnect()
        {
            try
            {
                var res = _httpClient.GetAsync(new Uri(_addres)).Result;
            }
            catch
            {
                return false;
            }

            return true;
        }

        /// <summary>
        /// Returns the HttpClient instance
        /// </summary>
        /// <returns></returns>
        public HttpClient GetConnection()
        {
            return _httpClient;
        }
    }
}