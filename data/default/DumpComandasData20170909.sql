
LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (5,'Pardo bar');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `aplicacion` WRITE;
/*!40000 ALTER TABLE `aplicacion` DISABLE KEYS */;
INSERT INTO `aplicacion` VALUES (7,'Pardo bar',5,'pardo','1');
/*!40000 ALTER TABLE `aplicacion` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'diego','diego','sanabria','diego@diego.com','7da4377e7b6f53149ed5914ae092a733b8dcdf8f',5,1),(16,'dsanchez','Daniel','Sanchez','dsanchez@paraisotropical.com','57ff528626ad71b5b893bbdb8b373a6af96d8536',5,1),(17,'esanchez','Esteban','Sanchez','esanchez@paraisotropical.com','39a318bf83d1935f54cde2f05e03aea0880f72f1',5,1),(18,'asanchez','Alejandro','Sanchez','asanchez@paraisotropical.com','e7b33aaf142e1c45f1e39ba0bf366a316433ebdf',5,1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `usuarios_aplicacion` WRITE;
/*!40000 ALTER TABLE `usuarios_aplicacion` DISABLE KEYS */;
INSERT INTO `usuarios_aplicacion` VALUES (16,7),(17,7),(18,7);
/*!40000 ALTER TABLE `usuarios_aplicacion` ENABLE KEYS */;
UNLOCK TABLES;


LOCK TABLES `mesas` WRITE;
/*!40000 ALTER TABLE `mesas` DISABLE KEYS */;
INSERT INTO `mesas` VALUES (1,0,7,NULL),(2,2,7,'{\"top\":129,\"left\":31}'),(3,3,7,'{\"top\":79,\"left\":-424}'),(4,4,7,'{\"top\":29,\"left\":-373}'),(5,5,7,'{\"top\":46,\"left\":-494}');
/*!40000 ALTER TABLE `mesas` ENABLE KEYS */;
UNLOCK TABLES;


LOCK TABLES `pedidos_estados` WRITE;
/*!40000 ALTER TABLE `pedidos_estados` DISABLE KEYS */;
INSERT INTO `pedidos_estados` VALUES (1,'Disponible'),(2,'Activo'),(3,'Cancelado'),(4,'Pagado');
/*!40000 ALTER TABLE `pedidos_estados` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Bocadillos','Finger Food',7),(2,'Emparedados','',7),(3,'Comidas mexicanas','',7),(4,'Postres','',7),(5,'Batidos de frutas','',7),(6,'Gaseosas','',7),(7,'Bebidas calientes','',7),(8,'Licores','',7),(9,'Vinos','',7),(10,'Cocteles','',7);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'superadmin',1),(2,'admin',2),(3,'encargado',3),(5,'cocina',4),(6,'camarero',5),(7,'recepcionista',6),(8,'comensal',7),(9,'comensal1',8);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `pedidos_has_productos_estados` WRITE;
/*!40000 ALTER TABLE `pedidos_has_productos_estados` DISABLE KEYS */;
INSERT INTO `pedidos_has_productos_estados` VALUES (1,'Seleccionado'),(2,'Confirmado'),(3,'En preparación'),(4,'Entregado'),(5,'Cancelado');
/*!40000 ALTER TABLE `pedidos_has_productos_estados` ENABLE KEYS */;
UNLOCK TABLES;


LOCK TABLES `usuarios_roles` WRITE;
/*!40000 ALTER TABLE `usuarios_roles` DISABLE KEYS */;
INSERT INTO `usuarios_roles` VALUES (1,1),(16,2),(17,3),(18,6);
/*!40000 ALTER TABLE `usuarios_roles` ENABLE KEYS */;
UNLOCK TABLES;


LOCK TABLES `tbl_migration` WRITE;
/*!40000 ALTER TABLE `tbl_migration` DISABLE KEYS */;
INSERT INTO `tbl_migration` VALUES ('m000000_000000_base',1504897167),('m170908_184756_compo_fecha_entrega_pedido',1504897170);
/*!40000 ALTER TABLE `tbl_migration` ENABLE KEYS */;
UNLOCK TABLES;
