# Audio files server built with Vue.js 2.0 and Bootstrap 4

The audio files are meant to be served over a local network. Idea came from a request from a non profit wanting to serve recorded lessons to several listeners at the same time.

## Technologies used

* Vue.js 2.0 runtime cdn library
* Bootstrap 4 Beta 2 (css only)
* Google Font
* PHP

## Installation instructions for Windows

### Step 1: Download PHP

PHP runtime can be downloaded from https://windows.php.net/download/

Extract the files from the zip archive into a local folder, for example `C:\php`

### Step 2: Download project

(Optional) You can specify a folder after the git url to store the downloaded files

```bash
git clone https://github.com/ijklim/audio-server.git
```

### Step #3: Update environment settings

Rename or make a copy of the `.env.example` to create `.env`, modify settings as needed.

### Step #4: Create a shell script to launch the server

Create file `start-audio-server.cmd` in the project root folder

```bash
c:\php\php -S localhost:80 router.php
```

That should be it! The server is now available at http://localhost

## How to add and maintain audio files

Locate the folder `audio` (unless this has been changed in the `.env` file).

Delete the sample folders and files within them.

Create new folder(s) with names separated by -. For example folder `Javascript-for-Beginners` will create a group called **Javascript for Beginners**.

Audio files within the folder will be named with the same format. Currently only mp3 audio files are supported.