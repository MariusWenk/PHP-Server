# Use of Variable: Define VAR = ... somewhere and use $(VAR)
standard:
	mkdir sites-available
	apt-get update -y
	apt-get install -y vim
	# apt-get update -y && apt-get upgrade -y
	# apt-get install -y php-fpm
	service nginx restart

# DOM should be domain name
DOM = domain-name.com
domain:
	apt-get update
	apt-get install python-certbot-nginx
	certbot --nginx -d $(DOM) -d www.$(DOM)
	service nginx restart	
