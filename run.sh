export PATH=/usr/local/bin/python:$PATH
while true
do
	timeout 15m ./mtpotmysql.py mirai_conf.json
	echo "------------------- RESTART ----------------------------------------";
done
