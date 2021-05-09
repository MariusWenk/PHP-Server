FROM nginx
WORKDIR /home
COPY Makefile .
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update -y && apt-get install -y --no-install-recommends apt-utils
RUN apt-get install -y make
RUN make standard
WORKDIR /etc/nginx
COPY nginx.conf .
COPY default.conf ./conf.d
# In case ther would be a domain: (domain.conf should be editted first, as well as certification should be implemented in Makefile)
# COPY domain.conf ./sites-available
# RUN make -f /home/Makefile domain

# More options: COPY (. = WORKDIR), copy files from host to container; CMD/ENTRYPOINT, execute command at initialisation; ENV, enables definition of environment variable through the build
