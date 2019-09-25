using System.Net.Http;

namespace DropperClient.Requests
{
    internal class GetCommandRequest : IRequest
    {
        public string Endpoint { get; }
        public FormUrlEncodedContent Data { get; }

        public GetCommandRequest(string endpoint, FormUrlEncodedContent data)
        {
            Endpoint = endpoint;
            Data = data;
        }
    }
}