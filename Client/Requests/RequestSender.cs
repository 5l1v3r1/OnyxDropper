using System;
using DropperClient.Connection;

namespace DropperClient.Requests
{
    internal class RequestSender
    {
        private readonly ServerConnection _connection;

        public RequestSender(ServerConnection connection)
        {
            _connection = connection;
        }

        /// <summary>
        /// Sends the request to the webserver and returns a response as string
        /// </summary>
        /// <param name="request"></param>
        /// <returns></returns>
        public string SendRequest(IRequest request)
        {
            var httpClient = _connection.GetConnection();
            try
            {
                var formData = request.Data;
                var requestUri = BuildUri(request.Endpoint);
                var requestResult = httpClient.PostAsync(requestUri, formData).Result;
                if (requestResult.IsSuccessStatusCode)
                {
                    var requestData = requestResult.Content.ReadAsStringAsync().Result;
                    return requestData;
                }

                return null;
            }
            catch
            {
#if DEBUG
                throw;
#endif

                return null;
            }
        }

        private Uri BuildUri(string endpoint)
        {
            return new Uri(_connection._addres + endpoint);
        }
    }
}