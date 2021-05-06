FROM nginx
WORKDIR /etc/nginx
COPY nginx.conf .
COPY default.conf ./conf.d
# RUN apt update && apt install vim
# More options: COPY (. = WORKDIR), copy files from host to container; CMD/ENTRYPOINT, execute command at initialisation; ENV, enables definition of environment variable through the build
