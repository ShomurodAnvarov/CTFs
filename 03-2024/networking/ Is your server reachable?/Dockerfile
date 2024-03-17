# Use the official PHP image with Apache
FROM php:8.0-apache

# Update package repository and install ping, nslookup (dnsutils) and whois
RUN apt-get update && \
    apt-get install -y iputils-ping dnsutils whois && \
    apt -y install netbase && \ 
    rm -rf /var/lib/apt/lists/*

# Copy the content of the current directory to the /var/www/html directory in the container
COPY . /var/www/html/

# Change the ownership of the files to the www-data user and group
RUN chown -R www-data:www-data /var/www/html

# Change the permissions so that the www-data user has read-only access
RUN find /var/www/html -type d -exec chmod 555 {} \; && \
    find /var/www/html -type f -exec chmod 444 {} \;

# Switch to the www-data user
USER www-data
