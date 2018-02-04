# Meetup CRUD TP with ZF3

## Introduction

Utilisation de : 
 - FlashMessenger
 - InputFilter
 - var-dumper (dev)
 - php-cs-fixer (dev)
 
### Installation

1 - Cloner le projet

2 - Se rendre à la racine du projet avec le terminal

3 - Lancer les commandes suivantes : 

`docker compose up -d --build`

`docker exec -ti composer install && zendtp_zf_1 php vendor/bin/doctrine-module orm:schema-tool:update -f`

4 - Le projet devrait se lancer sur 

http://localhost:8080

La page devrait ressembler à ça :

![alt text](https://img15.hostingpics.net/pics/833955FireShotCapture004MeetupsCRUDhttplocalhost8080.png "Page needed")

### Tests fonctionnels

1 - Installez Firefox Version 39.0 à 52.0

2 - Ajoutez firefox au path

On linux :
`export SLIMERJSLAUNCHER=/usr/bin/firefox`

On Windows :
`SET SLIMERJSLAUNCHER="c:\Program Files\Mozilla Firefox\firefox.exe`

On Windows with cygwin :
`export SLIMERJSLAUNCHER="/cygdrive/c/program files/mozilla firefox/firefox.exe"`

On MacOS :
`export SLIMERJSLAUNCHER=/Applications/Firefox.app/Contents/MacOS/firefox`

3 - Ajoutez au path le chemin absolu du dossier "node_modules/slimerjs/src"

4 - Placez vous dans le module Zend Tests

5 - lancez les commandes suivantes :

`npm install`

Pour lancer le test sur l'ajout de meetup :
`node_modules/casperjs/bin/casperjs test steps/add-meetup.js --engine=slimerjs`

Bon CRUDage :)
