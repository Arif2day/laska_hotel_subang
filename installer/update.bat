@echo off
cd C:\xampp\htdocs

IF EXIST "laska_hotel_subang" (
    echo Folder laska_hotel_subang sudah ada.
    cd laska_hotel_subang
    echo Update repository...
    git pull
    mysql -u root -e "DROP DATABASE IF EXISTS laskahotel; CREATE DATABASE laskahotel;"
    echo Import database...
    mysql -u root laskahotel < C:\xampp\htdocs\laska_hotel_subang\laskahotel.sql
    echo Selesai mengupdate, jalankan install.bat untuk run aplikasi
) ELSE (
    echo Clone repository...
    git clone https://github.com/Arif2day/laska_hotel_subang.git
    cd laska_hotel_subang

    echo Jalankan composer update...
    call composer update

    echo Copy .env file...
    copy ".env.example" ".env"
    php artisan key:generate

    echo Membuat database laskahotel...
    mysql -u root -e "DROP DATABASE IF EXISTS laskahotel; CREATE DATABASE laskahotel;"

    echo Import database...
    mysql -u root laskahotel < C:\xampp\htdocs\laska_hotel_subang\laskahotel.sql

    echo Jalankan Laravel server...
    start php artisan serve
)

pause