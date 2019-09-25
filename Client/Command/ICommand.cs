using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DropperClient.Command
{
    internal interface ICommand
    {
        bool Execute();
    }
}