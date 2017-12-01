# Audio files server built with runtime Vue.js 2.0 and Bootstrap 4

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

<script src="https://gist.github.com/ijklim/3f391f0756ee5b70785c12bbfb834944.js"></script>

