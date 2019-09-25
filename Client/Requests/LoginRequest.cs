using System.Net.Http;

namespace DropperClient.Requests
{
    internal class LoginRequest : IRequest
    {
        public string Endpoint { get; }
        public FormUrlEncodedContent Data { get; }

        public LoginRequest(string endpoint, FormUrlEncodedContent data)
        {
            Endpoint = endpoint;
            Data = data;
        }
    }
}