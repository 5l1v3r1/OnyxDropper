using System.Net.Http;

namespace DropperClient.Requests
{
    internal class RegisterRequest : IRequest
    {
        public string Endpoint { get; }
        public FormUrlEncodedContent Data { get; }

        public RegisterRequest(string endpoint, FormUrlEncodedContent data)
        {
            Endpoint = endpoint;
            Data = data;
        }
    }
}