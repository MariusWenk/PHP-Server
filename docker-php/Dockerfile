FROM php:7.4-fpm
COPY Makefile .
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update -y && apt-get install -y --no-install-recommends apt-utils
RUN apt-get install -y make
RUN make standard
