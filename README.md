# Dropbox Public Folder Replacement (DPFR)

Dropbox are [removing support for the Public folder functionality](https://www.dropbox.com/help/files-folders/public-folder).

~~This is a drop-in script replacement for your Dropbox public folder links.~~
This works with nginx and X-Accel-Redirect header to have a caching proxy to your dropbox files so they download faster on subsequent requests

As Dropbox no longer provides the service, DPFR runs on your web host instead. Files are still fetched in real-time from Dropbox
using their [API](https://www.dropbox.com/developers/documentation/http/overview).

For example, while your old links might have looked like this:

```
https://dl.dropboxusercontent.com/u/123456/myfile.txt
```

Your new links will be sent via your web host and will look like this:

```
https://mysite.com/dropbox/myfile.txt
```

Instead of manually generating new Dropbox share links, this enables you to simply change the domain name for your links and be done with it.

### Requirements

~~This script is tailored to run on most conventional web hosts that support a modern version of PHP.~~
You need to be able to launch docker containers, or to run nginx and php-fpm

* PHP ~~5.5~~ latest
* mbstring

### Setup

~~Download the latest release version [here](https://github.com/khromov/dropbox-public-folder-replacement/releases/download/1.0/dropbox-public-folder.zip). If you don't download the release version you will need to install dependencies via Composer.~~
Clone and run `composer install` in the php folder

#### Setting up your Dropbox app

DPFR does **not** support getting files directly from your Dropbox public folder. This is for security reasons. Instead, 
we will create a special "App folder", and move our files from the Public folder to the new App folder.

* Go to ["My apps"](https://www.dropbox.com/developers/apps/create) in your Dropbox control panel.
* In step 1, create a "Dropbox API" app.
* In step 2, choose "App folder"
* In step 3, name your app to "Public folder replacement"
* You will be redirected to the app info page. Write down the `App key` and `App secret`
* In the Oauth2 section, click the "Generate" button and write down the `Generated access token`

![2017-08-19 02_21_44-developers - dropbox](https://user-images.githubusercontent.com/1207507/29482018-4c7952a0-8489-11e7-82da-25d49e30fe34.png)

App settings

![2017-08-19 02_22_20-my public folder replacement - dropbox](https://user-images.githubusercontent.com/1207507/29482019-4fba6e54-8489-11e7-88c3-55f3e39c762a.png)

Generating OAuth token

#### Configuring DPFR

* ~~Start by uploading the script to your web host.~~
* Copy the file ~~`config.sample.php` to `config.php`.~~ `php/.env.example` to `php/.env`
* Edit ~~`config.php`~~ `php/.env` with the value obtained in the previous step.
    * `appKey` = App key
    * `appSecret` = App secret
    * `accessToken` = Generated access token

* Move or copy your files from the `Public` folder to the `Apps/Public folder replacement` folder.

#### Web server: Docker

You can start the stack with `docker-compose up`, then browse your files at http://localhost:5000/

#### Web server: Manual config

Config files are provided for nginx in the `web` folder, good luck !
