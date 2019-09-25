using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DropperClient.Command
{
    internal class UninstallCommand : ICommand
    {
        public string Parameters { get; }

        public bool Execute()
        {
            throw new NotImplementedException();
        }
    }
}