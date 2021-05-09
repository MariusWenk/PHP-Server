# PHP-Server
Complete Setup of Server including PHP-Application using Docker

To setup this application clone repository and:
- cd into the folder PHP-Server.
- Install docker and docker-compose
- If desired change files first (further documentation below)
- Copy Program-Code into php-files and make an index.php in php-files/php, where the port 8080 of the host would be pointing to
- run: docker-compose up -d

Content of this project:
- docker-compose.yml for setting up docker containers with adequat configuration
- docker-% folders containig Dockerfiles, for building the necessary docker-images
- php-files folder: Place your code project (php, etc.) in here. The content of this folder will be coppied into the containers and executed starting at index.php

Editing the containers during runtime (does not change the image and is lost, when container is removed (rm):
- run: docker exec -it <container-name> /bin/dash
<container-name> can be used as name or first 4 signs of ID (could be php-server_nginx_1, etc. )

Database content:
The database content would be saved in folder data (so it is not lost, when mysql container is deleted).

In docker-compose.yml are some more comments on the functionalities of docker. For customizing the Ports on the host system, to what the containers are mapped and for changing the mysql root password go to docker-compose.yml as well.
