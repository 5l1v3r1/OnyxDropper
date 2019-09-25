using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

namespace DropperClient.Requests
{
    internal interface IRequest
    {
        string Endpoint { get; }
        FormUrlEncodedContent Data { get; }
    }
}