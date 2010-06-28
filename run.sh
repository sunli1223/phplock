#! /bin/sh
CP=.:bin/
for file in lib/*;
do CP=${CP}:$file;
done
echo $CP 
java  -Xms3G -Xmx4G  -cp $CP com.ifeng.netbdb.StartServer >>logs/log.log &
