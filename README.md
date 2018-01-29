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

`composer install` 

`docker compose up -d --build`

`docker exec -ti zendtp_zf_1 php vendor/bin/doctrine-module orm:schema-tool:update -f`

4 - Le projet devrait se lancer sur 

http://localhost:8080

La page devrait ressembler à ça :

![alt text](https://img15.hostingpics.net/pics/833955FireShotCapture004MeetupsCRUDhttplocalhost8080.png "Page needed")

Bon CRUDage :)
