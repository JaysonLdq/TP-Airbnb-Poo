#!/bin/sh

mariadb-dump -uroot -pHJVH628h-BIIBUé3-biibuHbé! Airbnb > /root/Backup-$(date +%F).sql

echo "Sauvegarde terminée"
