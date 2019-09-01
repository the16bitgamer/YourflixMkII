### Yourflix Mk.II Install Guide
## Preparing Your Pi

Yourflix runs on a Raspberry Pi, runing Raspbian this will work on other linux installs but I cannot guarantee that it'll work.

Yourflix comes with the website and code ready and configured, what you'll need installed on your machine is the following

1. OS
   - Raspbian is my recomendation and what I'll be using in this demonstration

2. Python
   - I will be using Python 2.7.16 & 3 but any python should work

3. Python MySQLdb
   - This will allow us to connect to a Database where all of our video data will be stored
   
4. MySQL
   - We need to install any MySQL compatible Database software since Yourflix assumes it exists. In Raspbian you need to install MariaDB but MySQL should work too
  
5. Apache
   - Web Hosting software. This will allow us to stream video in a web browser
   
6. MiniDlna [Optional]
   - This will allow us to stream to systems like a PS3 and Xbox 360, or some smartphones
   
7. DNSMasq [Optional]
   - This will allow us to type in custom url's like yourflix.tv instead of the ip address
   
8. SSH [Optional]
   - This is so we can code and test on a more powerful machine and move files over easier. 
   
9. Mounting External Storage [Optional]
   - Adding more space than what is limited by a MicroSD is for the best. I can show you how to add an external storage to be visable over the web.
   
## Configuring the OS (1, 8, 9)

Follow the instructions to install [Raspbian here](https://www.raspberrypi.org/downloads/raspbian/)

Once you get your Pi setup and you are on the Desktop follow the inital settup info and bam we are ready to go!

### Making sure we are up to date

If your pi doesn't do this automatically or if you are using an existing install make sure you are up to date with

```
sudo apt update
sudo apt upgrade
sudo apt update
```

Now we are up to date we should configure the Pi to have a static IP address

This will make it easier to find later on and if you wanted to add the DNS Server (7) then it'll make your life easier.

### Change IP via Desktop

If you choose to install Raspbian with the Desktop enviroment, all you need to do is right click on your connections icon (wifi or 2 arrows pointing in oposite direction) and click on "Wired & Wireless Network Setting"

A new menu will open and there change the IPv4 to your local ip ending with 155 (typically your local IP will look like 192.168.0.XXX we are changing it to 192.168.0.155), why 155 cuz you'll never have more than 155 devices on 1 wifi network.  

You can also add a DNS Server here as well.

### Change IP via Command line

If you are using a console with Raspbian, we need to ```sudo nano /etc/dhcpcd.conf```

At the bottom we need to add:

```
interface [INSERT INTERFACE HERE]
inform [XXX.XXX.XXX].155
```

[INSERT INTERFACE HERE] is the interface you are using. For example if you want to use your ethernet type in eth0. You can add any device

[XXX.XXX.XXX] is your local ip typically it's 192.168.0

if you want to add a static DNS add the line

```static domain_name_servers=[INSERT DNS SERVER HERE]```

### Adding SSH (8)

To turn on Raspbian SSH [Follow the instructions here](https://www.raspberrypi.org/documentation/remote-access/ssh/). This will make things a lot easier and moving files over easier too

### Setting up External Storage (9)

Adding external storage is highly recomended. But doing so is a bit convoluted since we are basically mounting the drive to a folder.

First we need to get the UUID of the drive we are using with the command:

```sudo lsblk -o UUID,NAME```

Next we need to modify the fstab file to auto mount the drive.

```sudo nano /etc/fstab```

We need to add the following

```UUID=[**YOU UUID**] [**YOUR FILE LOCATION**] [**THE DRIVES FILE FORMATE**] defaults,auto,nofail,umask=000,user0,users,Susers,rw,0,0```

the **file format** need to be **__lowercase__** and for the **File Location** I will be placing it on ```/home/pi/Videos/``` you can place it anywhere just keep in mind where it is located for later in the instructions.

***NOTE FOR NTFS DRIVES***

if you have a drive which uses NTFS, you need to install ntfs-3g first with:

```sudo apt-get install ntfs-3g```

### Yourflix File Structure.

Yourflix has code which can differentiate from a Movie and a TV Show, it does this in code and it's based off of the file structure.

In your Videos folder (or where ever you want your content to live) your videos show look like:

```
->ROOT
    -> DIR
        -> Star Wars IV.png
        -> Star Wars Rebels.png
    -> Star Wars IV
        -> Star Wars episode IV A New Hope.mp4
    -> Star Wars Rebels
      -> Season 01
        -> E01.mp4
        -> E02.mp4
        -> ...
        -> E'n'.mp4
      -> Season 02
        -> E01.mp4
        -> E02.mp4
        -> ...
        -> E'n'.mp4
```

As you can see a Movie will live in it's own folder

A TV show will live in a folder inside a folder based on it's season. If there is only 1 season you just have 1 folder. i.e. /TV SHOW/SEASON 01/EXX.mp4

If you want thumbnails for the videos create a dir folder with the images in it. The current way it works is it will look for the root forlder's name, and see if there is a *.png for it.

If you file folder structor is not like this. Yourflix will break or become buggy. Planning on improving it later

## Installing Apache and configure for Yourflix (5)

[I am following this tutorial if you wanted more details](https://howtoraspberrypi.com/how-to-install-web-server-raspberry-pi-lamp/)

Apache is my webserver of choice. Mostly because it is what I started using when testing this. Primarly because it can stream video.

To install type in ```sudo apt-get install apache2```

Congrats your Pi is now a website. Go to your Pi's IP address in any browser to check.

We can't do much with the website until we give back our permissions. To do this we need to take back ownership of the folder which the Apache website lives.

```sudo chown -R pi:www-data /var/www/html/``` - pi is my current user. If you have another user change pi to that user.

and don't forget to change the folder permissions

```sudo chmod -R 770 /war/www/html/```

Now we need to give access of the Videos. I've placed my video in the Videos folder in /home/pi/

to do this we need to symlink /home/pi/Videos into /var/www/html/ with ```ln -sf /home/pi/Videos /var/www/html```

to test if this worked. Place a Video into /home/pi/Videos and on a web browser visit ```[YOUR PI's IP ADDRESS]/Videos``` and click the link, you should see a little video player with your video in it!

Congrats the back Bone of Yourflix has been implemented!

## Installing Python (2)

Typically Python 2 and 3 are already installed with the Raspberry Pi. However if for whatever reason it isn't installed just type in:

```sudo apt-get install python``` or ```sudo apt-get install python3```

To test if Python is working type in:

```
python
print("Hello World\nThis is a Python Test)
```

Python should return:

```
Hello World
This is a Python Test
```

## Installing PHP

[I am following this tutorial if you wanted more details](https://howtoraspberrypi.com/how-to-install-web-server-raspberry-pi-lamp/)

We need a way to access the database and do some on server computation, like calling python code, accessing the database and generating webpages.

to install call ```sudo apt-get install php phpmbstring```

add the following to your index.html in /var/www/html/ ```<?php echo phpinfo(); ?>```

### Adding MySQL Support

To access the database we need to install ```sudo apt-get install php-mysql```

If you are getting and Error: 500 or "PHP Fatal error:  Uncaught Error: Call to undefined function mysqli_connect()" you need to enable mysqli. To enable it open

```
cd /etc/php/7.3/apache2
sudo nano php.ini
```

The reason we cd into apache2 instead of just editing the file is because your php version might be different from mine. If you are having trouble finding the folder, try navigating to it one folder at a time. when you find the missing link type ls to find the correct folder.

When you edit php.ini, find the lines ```;extension=mbstring``` and ```;extension=mysqli```. Once found remove the ';' and make sure mbstring is above mysqli.

Once done mysqli will now allow you to download.



## Installing Python's MySQLdb (3)

Yourflix requires the use of a Database to allow us to build the data structures for Yourflix to work. And a lot of the leg work is done with python.

To install MySQLdb type in ```sudo apt-get install python-mysqldb```

if you want to test to make sure MySQLdb works just type in

```
python
import MySQLdb
```

if any error show up MySQLdb didn't install correctly

## Installing MySQL (4)

[I am following this tutorial for setting my MySQL if you wanted more details!](https://r00t4bl3.com/post/how-to-install-mysql-mariadb-server-on-raspberry-pi) I will include the important commands if you want to just follow allong

MySQL db is the Brains of the operation. It stores the locations for all the videos and more.

To install type in:

```sudo apt-get install mysql-server``` on Raspbian you might get an error asking to install MariaDN so type in

```sudo apt-get install mariadb-server```

Once installed you need to configure your Database. Type ```sudo mysql_secure_installation``` to begin, add a password and set up your enviroment they way you want.

To test if your database is installed correctly just type in ```mysql -u root -p``` and type in your password

If you see a **Access denied for user 'root'@'localhost'**, you can try to disable MySQL from trying to authenticate root user using plugin:

```
$ sudo mysql -u root

[none] use mysql;
[mysql] update user set plugin='' where User='root';
[mysql] flush privileges;
[mysql] \q
```

We are not done with the Database quite yet. But we need to install other items first to make things easier.

### Adding Remote User

If you want to connect your database to a external client like MySQL and not rely on the command line. You are going to need to do a bit of work.

First we need to make mariadb listen to external connections. [Following this tutorial](https://websiteforstudents.com/configure-remote-access-mysql-mariadb-databases/)

First open this file ```sudo nano /etc/mysql/mariadb.conf.d/50-server.cnf``` and comment out ```bind-address = 127.0.0.1```.

Next reset server. ```sudo systemctl restart mariadb.service```

Now we need to add a new user to remote into out database

```
$mysql -u root -p

//Creating local user
MariaDB> CREATE USER '[INSERT_USERNAME]'@'localhost' IDENTIFIED BY '[INSERT_PASSWORD]';
MariaDB> GRANT ALL PRIVILEGES ON *.* TO '[INSERT_USERNAME]'@'localhost' WITH GRANT OPTION;

//Creating Remote User
MariaDB> CREATE USER '[INSERT_USERNAME]'@'%' IDENTIFIED BY '[INSERT_PASSWORD]';
MariaDB> GRANT ALL PRIVILEGES ON *.* TO '[INSERT_USERNAME]'@'%' WITH GRANT OPTION;
```

Now you can use any software to manage and modify the database instead of using the command line. I will assume though we are still using command line for the remainder of the install but all sql commands will work.

## Configureing Yourflix

Congrats the hard part is done and Yourflix is ready to be setup.

There are 2 thing which we need to do first before we can start streaming videos.

1. Setup the Database

2. Download Yourflix

### Setting up the Database

We will need the Following:

1. A Database called "Pi_YourFlix_Data"

2. 3 Tables
   - "YourFlix_VideoInfo"
   - "YourFlix_ShowInfo"
   - "YourFlix_ShowSeasons"
   
3. A user called pi

So lets create this Database and use it

```
CREATE DATABASE Pi_YourFlix_Data;
USE Pi_YourFlix_Data;
```

Now let's Create the Tables

YourFlix_VideoInfo
```
CREATE TABLE `Pi_YourFlix_Data`.`YourFlix_VideoInfo` (
  `VideoId` INT(11) NOT NULL AUTO_INCREMENT,
  `VideoLoc` VARCHAR(155) NOT NULL,
  `VideoName` VARCHAR(255) NOT NULL,
  `VideoDescription` VARCHAR(1000) NULL,
  `ShowId` INT NOT NULL,
  `SeasonId` VARCHAR(255) NULL,
  PRIMARY KEY (`VideoId`, `VideoLoc`));
```

YourFlix_ShowInfo
```
CREATE TABLE `Pi_YourFlix_Data`.`YourFlix_ShowInfo` (
  `ShowId` INT(11) NOT NULL AUTO_INCREMENT,
  `ShowType` VARCHAR(3) NOT NULL,
  `ShowName` VARCHAR(155) NOT NULL,
  `ShowDescription` VARCHAR(3000) NULL,
  PRIMARY KEY (`ShowId`, `ShowName`));
```

YourFlix_ShowSeasons
```
CREATE TABLE `Pi_YourFlix_Data`.`YourFlix_ShowSeasons` (
  `ShowId` INT NOT NULL,
  `SeasonName` VARCHAR(155) NOT NULL,
  `SeasonID` VARCHAR(155) NOT NULL,
  PRIMARY KEY (`SeasonID`));
```

Adding the user pi (if you want to change it you need to change YourflixDbManager.python

```
MariaDB> CREATE USER 'pi'@'localhost' IDENTIFIED BY 'raspberry';
MariaDB> GRANT INSERT ON Pi_YourFlix_Data.* TO '[INSERT_USERNAME]'@'localhost';
MariaDB> GRANT SELECT ON Pi_YourFlix_Data.* TO '[INSERT_USERNAME]'@'localhost';
MariaDB> GRANT DELETE ON Pi_YourFlix_Data.* TO '[INSERT_USERNAME]'@'localhost';
```

### Downloading Yourflix

You can clone/download this repository or [just download a premade zip file here]()

Unzip repository and move the files into ```/var/www/html/```. Now that you are done just load up your IP address and let Yourflix do it's thing.
