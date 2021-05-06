# PHP-Server
Complete Setup of Server including PHP-Application using Docker

To setup this application clone repository and:
- cd into the folder PHP-Server.
- Install docker and docker-compose
- If desired change files first (further documentation below)
- run: docker-compose up

Content of this project:
- docker-compose.yml for setting up docker containers with adequat configuration
- docker-% folders containig Dockerfiles, for building the necessary docker-images
- php-files folder: Place your code project (php, etc.) in here. The content of this folder will be coppied into the containers and executed starting at index.php

Editing the containers during runtime (does not change the image and is lost, when container is removed (rm):
- run: docker exec -it <container-name> /bin/dash
<container-name> can be used as name or first 4 signs of ID

Database content:
The database content would be saved in folder data (so it is not lost, when mysql container is deleted)

In docker-compose.yml are some more comments on the functionalities of docker
