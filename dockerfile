# Gunakan image PHP dengan Apache sudah include
FROM php:8.2-apache

# Install ekstensi mysqli supaya bisa konek database
RUN docker-php-ext-install mysqli

# Copy semua file ke folder html Apache
COPY . /var/www/html/

# Pastikan index.php ada di /var/www/html
WORKDIR /var/www/html

# Buka port 80
EXPOSE 80

# Ini sebenarnya otomatis, tapi bisa tambahkan untuk jaga-jaga:
CMD ["apache2-foreground"]
