# OnyxDropper
Simple dropper with web based interface

## What is OnyxDropper?
OnyxDropper is a simple webbased dropper, the aim is to provide a stable connection with your client without causing any problems with AV. The webpanel has few features and thus should be very easy to use. The client application will check the website every 2-5 min to see if there is a new command available or not.

## Availlable commands:
  * Run
    > Runs a given file, might be an image, a link, an executable. 
  * Uninstall
    > Uninstalls the dropper client

## Server setup
* Download the github repo and extract it to whereever
* In the folder, go to /server and open /database/db-config.php, edit the variables to your server's database settings
* Upload the website through FTP or a webpanel
* Go to yourwebsite.com/setup.php
* Login as root:root after going back to yourwebsite.com/login.php

## Client Setup
* Download the github repo and extract it to whereever
* In the folder, go to /server and open the solution file
* Change the information in the settings.cs to your hostname / install location etcetera
* Set build mode to release
* Build the executable
* Make sure to test the application in a sandboxed enviroment, a virtual machine or whatever.


## Warning
This is still a project which is under heavy development. I normally do not program in PHP so the code might be messy.
However the webpanel *should* work as I've tested it while developing. The client and client builder are a WIP but should come soon.
