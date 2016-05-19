mount -t cifs //0.0.0.0/Biblioteca/Winisis/Bases /mnt/acervosrv -o username=biblioteca,password=SENHA
rsync -r -a -v /mnt/acervosrv/ /home/Samba/Biblioteca/Winisis
umount /mnt/acervosrv
