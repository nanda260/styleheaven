# Menggunakan image resmi PHP dengan Apache
FROM php:8.2-apache

# Install ekstensi mysqli agar bisa konek ke MySQL
RUN docker-php-ext-install mysqli

# Salin semua file dari folder lokal ke dalam container
COPY . /var/www/html/

# Buka port 80 untuk web server
EXPOSE 80
