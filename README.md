# comandas

1. obtener los contenedores de docker hub:
```
sudo docker pull diegohsanabria/ubuntu:comandas
sudo docker pull diegohsanabria/mysql:comandas
```

2. crear una red de ips para docker:
```
docker network create --subnet=172.18.0.0/16 mynet
```

3. correr docker apache-ubuntu:
```
docker run -v /var/www/Comandas/comandas:/var/www/html --net mynet --ip 172.18.0.3 -p 8080:80 -it diegohsanabria/ubuntu:comandas
service apache2 start
```

4. correr docker mysql:
```
docker run --net mynet --ip 172.18.0.2 -it diegohsanabria/mysql:comandas
```

5. crear la base de datos dentro del contenedor de mysql:
```
mysql -uroot -proot -h 172.18.0.2 < /<app_code>/data/default/DumpComandas20170909.sql
mysql -uroot -proot -h 172.18.0.2 comandas < /<app_code>/data/default/DumpComandasData20170909.sql
```
