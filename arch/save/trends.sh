while ! ping -c 1 -n 192.168.0.111 &> /dev/null 
do
	sleep 0.1
done
	echo "ON"
	scp -rp /home/maks/projects/web/webdriver/trends2.0/build/libs/trends.jar maks@192.168.0.111:/home/maks/trends/trends.jar
	scp -rp /home/maks/projects/web/webdriver/trends2.0/src/main/resources/config.properties maks@192.168.0.111:/home/maks/trends/config.properties
	
