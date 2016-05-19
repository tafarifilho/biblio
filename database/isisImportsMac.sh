rm -rf ./base/dob.json
rm -rf ./base/ape.json
/Library/Internet\ Plug-Ins/JavaAppletPlugin.plugin/Contents/Home/bin/java -cp ./base/isis/interop/dist/interop.jar:./base/isis/interop/dist/lib/JSON-java.jar:./base/isis/interop/dist/lib/Bruma.jar org.bireme.interop.Isis2File ./base/DOB/DOB.MST ./base/dob.json --onefileonly
/Library/Internet\ Plug-Ins/JavaAppletPlugin.plugin/Contents/Home/bin/java -cp ./base/isis/interop/dist/interop.jar:./base/isis/interop/dist/lib/JSON-java.jar:./base/isis/interop/dist/lib/Bruma.jar org.bireme.interop.Isis2File ./base/APE/APE.mst ./base/ape.json --onefileonly
mongoimport --db biblioteca --collection dob ./base/dob.json --drop --jsonArray
mongoimport --db biblioteca --collection ape ./base/ape.json --drop --jsonArray
mongo mongo.js
