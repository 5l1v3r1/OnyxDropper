using System.Collections.Generic;
using System.Web.Script.Serialization;

namespace OnyxDropper.Requests
{
    internal static class JsonParser
    {
        /// <summary>
        /// Deserializes the json input string into a object
        /// </summary>
        /// <param name="input">JSON input</param>
        /// <returns></returns>
        public static Dictionary<string, object> Deserialize(string input)
        {
            var jsSerializer = new JavaScriptSerializer();
            var output = jsSerializer.DeserializeObject(input);

            return (Dictionary<string, object>)output;
        }
    }
}