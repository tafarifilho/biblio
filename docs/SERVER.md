- Download Ubuntu Server 14.04.2 LTS (http://www.ubuntu.com/download/server)
- Created Virtual Machine 2048Mb and 60GB

*** Install Ubuntu Server
-- Language: Portuguese Brazil
-- Teclado
-- Location: Other/SouthAmerica/Brazil
-- Coutry Base: en_US.UTF-8
-- Keybord: US
-- Hostname: bibliotecaServer
-- Full Name: Administrator
-- User name: biblioteca
-- Password: --
-- Encrypt Home: No
-- Cyte: Sao Paulo
-- Partition: Guided - entire disk and LVM
-- Proxy: No
-- No Automatic updates
-- No Software
-- Install Grub
-- Reboot

*** Configure Network/Wireless
-- sudo vi /etc/network/interfaces
auto wlan0
iface wlan0 inet dhcp
    wpa-ssid mynetworkname
    wpa-psk mysecretpassphrase

*** Conflito do Wireless
-- vi  /etc/modprobe.d/blacklist.conf
-- add
blacklist rt2800pci
blacklist rt2800lib
blacklist rt2x00usb
blacklist rt2x00pci
blacklist rt2x00lib

*** Atualizar o sistema
-- Update/Upgrade System: apt-get update | apt-get upgrade
-- Reboot
-- Upgrade Kernel: apt-get dist-upgrade
-- Reboot
-- Install unzip: apt-get install unzip
-- Install git: apt-get install git
-- apt-get autoremove

*** Install Guest Addictions VirtualBox
-- sudo apt-get install dkms
-- mkdir /mnt/cdrom
-- mount /dev/cdrom /mnt/cdrom
-- ./mnt/cdrom/VBoxLinuxAdditions.run

*** Install Java 8 JRE
-- add-apt-repository ppa:webupd8team/java
-- sudo apt-get update
-- sudo apt-get install oracle-java8-installer

*** Install NGINX
sudo apt-get install nginx

*** Install HHVM (https://github.com/facebook/hhvm/wiki/Prebuilt-packages-on-Ubuntu-14.10)
-- apt-get install software-properties-common
-- apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0x5a16e7281be7a449
-- add-apt-repository 'deb http://dl.hhvm.com/ubuntu trusty main'
-- apt-get update
-- apt-get install hhvm
-- sudo /usr/share/hhvm/install_fastcgi.sh
-- sudo /etc/init.d/hhvm restart
-- sudo /etc/init.d/nginx restart
-- sudo update-rc.d hhvm defaults
-- sudo /usr/bin/update-alternative \ -- install /usr/bin/php php /usr/bin/hhvm 60

-- apt-get install git-core automake autoconf libtool gcc
-- apt-get install hhvm-dev

-- git clone git://github.com/mongodb/libbson.git /tmp/libbson
-- ./autogen.sh
-- make
-- make install

-- git clone https://github.com/mongofill/mongofill-hhvm
-- ./build.sh
-- mkdir -p /etc/hhvm/extensions
-- cp mongo.so /etc/hhvm/extensions/mongo.so
-- vi /etc/hhvm/php.ini
-- vi /etc/hhvm/server.ini
-- add
hhvm.dynamic_extension_path = /etc/hhvm/extensions
hhvm.dynamic_extensions[mongo] = mongo.so


*** Configure NGINX (/etc/nginx/sites-available/default)
sudo /usr/share/hhvm/install_fastcgi.sh

*** Install MongoDB (http://docs.mongodb.org/manual/tutorial/install-mongodb-on-ubuntu/)
-- sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10
-- echo "deb http://repo.mongodb.org/apt/ubuntu "$(lsb_release -sc)"/mongodb-org/3.0 multiverse" | sudo tee /etc/apt/sources.list.d/mongodb-org-3.0.list
-- sudo apt-get install -y mongodb-org
-- apt-get update
-- apt-get install mongodb-org

*** Alterar a senha do MongoDB
db.createUser(
{ user: "admin",
  pwd: "senha",
  roles: [
    "readWriteAnyDatabase", "dbAdminAnyDatabase", "userAdminAnyDatabase", "clusterAdmin"
  ]
}
);
db.createUser(
{
  user: "biblioteca",
  pwd: "senha",
  roles: [
     { role: "readWrite", db: "biblioteca" }
  ]
}
);

*** Instalar MariaDB (https://downloads.mariadb.org/mariadb/repositories/#mirror=edatel&distro=Ubuntu&version=10.0&distro_release=utopic--ubuntu_utopic)
-- sudo apt-get install software-properties-common
-- sudo apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xcbcb082a1bb943db
-- sudo add-apt-repository 'deb http://ftp.utexas.edu/mariadb/repo/10.0/ubuntu trusty main'
-- sudo apt-get update
-- sudo apt-get install mariadb-server
-- password for root

- Instalar Composer (https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
-- curl -sS https://getcomposer.org/installer | php
-- mv composer.phar /usr/local/bin/composer

-- Laravel Configuration for NGINX (/etc/nginx/sites-available/default)
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

*** Instalar NODEJS
apt-get install nodejs
apt-get instlal npm
apt-get install build-essential

*** Instalar Bower
- npm install --global bower

*** Install Gulp
npm install --global gulp

*** Install Grunt
npm install --global grunt-cli

*** Criar senha MariaDB para o Usuário biblioteca
- CREATE USER 'biblioteca'@'localhost' IDENTIFIED BY 'senha';
- GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,DROP,ALTER ON biblioteca.* TO 'biblioteca'@'localhost';
- GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,DROP,ALTER ON legado.* TO 'biblioteca'@'localhost';


*** Instalar Servidor de Aquivos Samba
-- apt-get install samba
-- vi /etc/samba/smb.conf
-- update-rc.d -f nmbd remove
-- editar visudo para dar acessos aos comandos sem senhas...
www-data ALL=(ALL:ALL) NOPASSWD:/bin/cat
www-data ALL=(ALL:ALL) NOPASSWD:/usr/sbin/groupadd
www-data ALL=(ALL:ALL) NOPASSWD:/usr/sbin/groupdel
www-data ALL=(ALL:ALL) NOPASSWD:/usr/sbin/useradd
www-data ALL=(ALL:ALL) NOPASSWD:/usr/sbin/userdel
www-data ALL=(ALL:ALL) NOPASSWD:/usr/bin/passwd
www-data ALL=(ALL:ALL) NOPASSWD:/usr/bin/smbpasswd
www-data ALL=(ALL:ALL) NOPASSWD:/usr/bin/groups
www-data ALL=(ALL:ALL) NOPASSWD:/usr/sbin/usermod

*****************************
*** Criar a pasta do programa
-- mkdir /var/www
-- mv /mnt/pendrive/biblioteca /var/www/biblioteca
-- cd /var/www/biblioteca
-- composer update
-- bower update --allow-root
-- npm update

*** ISIS / BIREME / INTEROP
-- cd /biblioteca/vendor
-- git clone https://github.com/bireme/interop

*** Dar permissão
-- chown -R www-data:www-data /var/www/biblioteca
-- chmod -R 775 /var/www/biblioteca/storage

*** Importação
-- ./isisImports.sh
-- mariaDB
-- SET GLOBAL foreign_key_checks=0;
-- ./migrate.sh
-- ./seed.sh > importacao.log

apt-get install php5-imagick

-=-=-=-=-=-=-=-=-=- 