// A partir das 21:00, de segunda a sexta
00 21 * * 1-5 /var/www/biblioteca/database/isisBackup.sh

// A partir das 22:00, de segunda a sexta
00 22 * * 1-5 /var/www/biblioteca/database/sqlDump.sh

// A partir das 23:00, de segunda a sexta
00 23 * * 1-5 /var/www/biblioteca/database/isisImports.sh

// A partir das 03:00, de terça a sábado
00 03 * * 2-6 /var/www/biblioteca/database/backupFull.sh