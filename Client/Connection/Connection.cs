using System;
using System.Net.Http;

namespace DropperClient.Connection
{
    internal class ServerConnection : IConnection, IDisposable
    {
        private readonly HttpClient _httpClient;
        public string _addres { get; private set; }

        public ServerConnection(string baseAddres)
        {
            _httpClient = new HttpClient();
            _addres = baseAddres;
        }

        public void Dispose()
        {
            _httpClient.Dispose();
        }

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

        public HttpClient GetConnection()
        {
            return _httpClient;
        }
    }
}