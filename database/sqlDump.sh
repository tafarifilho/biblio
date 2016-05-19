datetime=$(date +%Y%m%d.%H%M%S)
mysqldump -uroot -pSENHA --compact --databases biblioteca > "/home/Samba/SQL/${datetime}.sql"
