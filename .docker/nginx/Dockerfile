# Use the official Nginx image as the base image
FROM nginx:stable

# Create the necessary directory
RUN mkdir -p /etc/nginx/conf.d/

# Copy the custom configuration file
COPY default.conf /etc/nginx/conf.d/default.conf
