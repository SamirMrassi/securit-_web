# securit-_web
This repository contains an implemented program for an authentification webpage. 
The goal is to have a secure authentification process. 

## programming languages:
- php
- html

## prerequisite
In order to execute this program, you should have :
- an Apache-Server.
- a MySQL-server.

If not, you can install MAMP for Windows and MacOS : 
https://www.mamp.info/en/downloads/
or XAMPP for linux : 
https://www.apachefriends.org/fr/download.html


## Setup
After installing the prerequisites, you can clone this repository in you Apache-folder : 
```sh
git clone https://github.com/SamirMrassi/securit-_web.git
```

Then open your localhost in the browser. 
You can now open  the file `connexion.php` and navigate between the different pages to test the project. 

## Database
In the MySQL-server, a database named 'securite_web' should be created.

A table named 'users' should also be created. You can find an SQL_script (in file `SQL_Table_creation.txt`) that you can execute in your database to create the table.

> Note: think about changing the data for the database-connection in the file `config.php` if needed.

## Documentation
in the file `Doc_mesures_de_securite.pdf` you will find a documentation about : 
- how we can navigate between the webpages (page for the connection, an other for the inscription, and a homepage)
- Which security measurements where implemented.
- How we can improve the program with other security measurements.

