rm -rf /var/www/biblioteca/database/base/dob.json
rm -rf /var/www/biblioteca/database/base/ape.json
/usr/bin/java -cp /var/www/biblioteca/vendor/interop/dist/interop.jar:/var/www/biblioteca/vendor/interop/dist/lib/JSON-java.jar:/var/www/biblioteca/vendor/interop/dist/lib/Bruma.jar org.bireme.interop.Isis2File /home/Samba/Biblioteca/Winisis/DOB/DOB.MST /var/www/biblioteca/database/base/dob.json --onefileonly
/usr/bin/java -cp /var/www/biblioteca/vendor/interop/dist/interop.jar:/var/www/biblioteca/vendor/interop/dist/lib/JSON-java.jar:/var/www/biblioteca/vendor/interop/dist/lib/Bruma.jar org.bireme.interop.Isis2File /home/Samba/Biblioteca/Winisis/APE/APE.mst /var/www/biblioteca/database/base/ape.json --onefileonly
mongoimport --db biblioteca --collection dob /var/www/biblioteca/database/base/dob.json --drop --jsonArray
mongoimport --db biblioteca --collection ape /var/www/biblioteca/database/base/ape.json --drop --jsonArray
mongo biblioteca /var/www/biblioteca/database/mongo.js
