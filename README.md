# Audio files server built with Vue.js 2.0 and Bootstrap 4

The audio files are meant to be served over a local network. Idea came from a request from a non profit wanting to serve recorded lessons to several listeners at the same time.

## Technologies used

* Vue.js 2.0 runtime cdn library
* Bootstrap 4 Beta 2 (css only)
* Google Font
* PHP

## Installation instructions for Windows

### Step 1: Download PHP

PHP runtime can be downloaded from http://windows.php.net/download

Extract the files from the zip archive into a local folder, for example `C:\php`

### Step 2: Download project

```bash
git clone https://github.com/ijklim/audio-server.git
cd audio-server
```

(Optional) You can add a folder name after the git url to specify where to store the downloaded files. Default is `audio-server`.

### Step #3: Download and install Composer

Composer is a dependency manager for PHP.

Visit https://getcomposer.org/download/ and download the Composer-Setup.exe

### Step #4: Download third party modules

```bash
composer install
```

### Step #5: Update environment settings

Rename or make a copy of the `.env.example` to create `.env`, modify settings as needed.

### Step #6: Create a shell script to launch the app

Create file `start-audio-server.cmd` in the project root folder.

```bash
c:\php\php -S 0.0.0.0:80 router.php
```

That should be it! Start the server by executing `start-audio-server.cmd`. Access the site by visiting http://{ip-address}.

## How to add and maintain audio files

Locate the folder `audio` (unless this has been changed in the `.env` file).

Delete the sample folders and files within them.

Create new folder(s) with names separated by -. For example folder `Javascript-for-Beginners` will create a group called **Javascript for Beginners**.

Audio files within the folder will be named with the same format. Currently only .mp3 and .wav audio files are supported.

v1.1.0+

Folders starting with **_** will be restricted and hidden when accessing the home page.

Restricted folders can be access via `/<folderCode>`. For example http://localhost/123456 will access folder `audio/_123456`.

Add a `.name` file to name the restricted audio group. For example `Internal-Memos.name` in the `audio/_123456` folder will create a group called **Internal Memos**.

## Troubleshoot

<table>
<thead>
<tr>
<th width='30%'>Problem</th>
<th style='vertical-align:top;'>Solution</th>
</tr>
</thead>

<tbody>
<tr>
  <td>
  The app header shows up but none of the audio folder shows up on my Android Chrome
  </td>
  <td>
  Update Chrome to version 63.0.3239.111 or above. This is available on the Google <b>Play Store</b>.
  </td>
</tr>

<tr>
  <td>
  http://localhost is working, but other computers cannot connect via ip
  </td>
  <td>
  Bash command to start server must use <b>0.0.0.0</b> and not <b>localhost</b>. Ensure port 80 is not being blocked by firewall, try another port number if necessary.
  </td>
</tr>

<tr>
  <td>
  Web page does not seem to be working on mobile phone
  </td>
  <td>
  Ensure browser is not in offline mode. Clear cache if necessary. Check the ip of the audio server to ensure it has not changed.
  </td>
</tr>
</tbody>
</table>
