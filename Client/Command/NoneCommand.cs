using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DropperClient.Command
{
    internal class NoneCommand : ICommand
    {
        public string Parameters { get; }

        public bool Execute()
        {
            return true;
        }
    }
}