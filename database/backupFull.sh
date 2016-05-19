mount /dev/sdb1 /mnt/flashbackup
/var/www/biblioteca/database/rsyncbackup.sh /home/Samba /mnt/flashbackup/Samba
/var/www/biblioteca/database/rsyncbackup.sh /var/www/biblioteca /mnt/flashbackup/biblioteca
umount /mnt/flashbackup
