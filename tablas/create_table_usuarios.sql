#\. /var/www/html/lanzarote.lan/tablas/create_table_usuarios.sql

DROP TABLE usuarios;
CREATE TABLE usuarios(
     id            INT NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,nick          VARCHAR(255) NOT NULL
    ,nombre        VARCHAR(255)
    ,apellidos     VARCHAR(255)
    ,email         VARCHAR(255)
    ,password      VARCHAR(255)
    ,fecha_alta    DATE DEFAULT (CURRENT_DATE)
    ,fecha_baja    DATE DEFAULT ("99991231")

    #DATOS AUDITORÍA
    ,usuario_alta      VARCHAR(255)
    ,ip_alta           CHAR(15)
    ,fecha_sis_alta    TIMESTAMP

    ,usuario_modi  VARCHAR(255)
    ,ip_modi       CHAR(15)
    ,fecha_modi    TIMESTAMP

    ,KEY (email)

);


INSERT INTO usuarios (nick, nombre, apellidos, email, password) VALUES
('andres','Andrés','Calamaro','jaime@andresin.com','andres.pass'),
('luna23','Luna','Martínez López','luna.martinez@gmail.com','luna123'),
('felipex','Felipe','Gómez Ruiz','felipex@correo.com','felipe2024'),
('marcela_90','Marcela','Santos Pérez','marcela90@hotmail.com','marce!90'),
('tomasito','Tomás','Herrera Díaz','tomas.herrera@yahoo.com','therrera01'),
('carlita','Carla','Jiménez Rojas','carlita.jimenez@outlook.com','carla321'),
('sofi_g','Sofía','García Torres','sofi.garcia@gmail.com','sofiaGT@22'),
('diego_m','Diego','Morales Núñez','diego.m@live.com','diegopass'),
('vane_r','Vanessa','Ramírez Solís','vane.ramirez@gmail.com','vane2023'),
('juanca','Juan Carlos','Ortega Vélez','juanca@correo.com','jcpass2023'),
('nati_love','Natalia','López Fernández','natilo@gmail.com','nati!2024'),
('rodrigo7','Rodrigo','Muñoz Álvarez','rodrigo7@hotmail.com','rodrigo77'),
('caro_p','Carolina','Paredes Castillo','caro.p@gmail.com','caroP@pass'),
('elena_sky','Elena','Suárez Molina','elena.sky@icloud.com','elena*123'),
('gabo89','Gabriel','Pinto Duarte','gabo89@yahoo.com','gabito89'),
('alejo_dev','Alejandro','Rivas Soto','alejo.dev@gmail.com','devPass123'),
('pablo_mx','Pablo','Mendoza Cruz','pablo.mx@correo.com','p4blomx'),
('valenq','Valentina','Quintero León','valenq@gmail.com','valenq@pass'),
('maria_j','María José','Romero Gil','maria.jose@gmail.com','mariaJ23'),
('edu_rock','Eduardo','Cortés Silva','edu.rock@live.com','rockpass!'),
('franlo','Francisco','López Aranda','franlo@correo.com','fran2022'),
('cami_b','Camila','Bustamante Ruiz','cami.b@gmail.com','camiBR'),
('ricardo_p','Ricardo','Pérez Torres','ricardo_p@hotmail.com','rickyPT'),
('daniella_21','Daniella','Reyes Camacho','daniella21@gmail.com','daniella!'),
('oscarito','Óscar','Vega Moreno','oscarito@correo.com','oscarV12'),
('juli_s','Julieta','Serrano Fuentes','juli.s@hotmail.com','julis@pass'),
('mateo_r','Mateo','Ramírez Navarro','mateo.r@gmail.com','mramirez'),
('angie92','Angélica','Castro Méndez','angie92@correo.com','angel92'),
('sebass','Sebastián','Ibarra Luna','sebass@gmail.com','sebas_2023'),
('rosa_b','Rosa','Benítez Ochoa','rosa.benitez@gmail.com','rosaB88');



