# Use the official PHP image
FROM php:8.0-cli

# Copy the content of the readme directory to the /var/www directory in the container
RUN mkdir /var/www/readme
COPY ./readme /var/www/readme

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the content of the web-1 directory to the /var/www/html directory in the container
COPY ./web-1 /var/www/html/

# Expose port 80
EXPOSE 80

# Start the PHP built-in server inside the /var/www/html directory
CMD ["php", "-S", "0.0.0.0:80","router.php"]
