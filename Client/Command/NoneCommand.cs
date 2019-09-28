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