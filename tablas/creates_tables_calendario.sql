#\. /var/www/html/lanzarote.lan/tablas/creates_tables_calendario.sql

# ==========================================================
# 1. CREACIÓN DE TABLAS
# ==========================================================

DROP TABLE IF EXISTS horarios;
DROP TABLE IF EXISTS modulos;
DROP TABLE IF EXISTS aulas;
DROP TABLE IF EXISTS cursos;
DROP TABLE IF EXISTS personas;

# 1. TABLA PERSONAS 
CREATE TABLE personas (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100) NOT NULL,
    apellidos   VARCHAR(100) NOT NULL,
    email       VARCHAR(150) UNIQUE,
    tipo        CHAR(01) NOT NULL,        # [P]rofesor, [A]lumno
    creado_en   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    # DATOS AUDITORÍA
    usuario_alta      VARCHAR(255),
    ip_alta           CHAR(15),
    fecha_sis_alta    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    usuario_modi      VARCHAR(255),
    ip_modi           CHAR(15),
    fecha_modi        TIMESTAMP
);

# 2. TABLA CURSOS
CREATE TABLE cursos (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nombre_grado    VARCHAR(50) NOT NULL,           # Ej: "DAW", "SMR"
    curso_numero    INT NOT NULL,                   # Ej: 1, 2
    letra           CHAR(1) NOT NULL,               # Ej: 'A'
    UNIQUE(nombre_grado, curso_numero, letra),

    # DATOS AUDITORÍA
    usuario_alta      VARCHAR(255),
    ip_alta           CHAR(15),
    fecha_sis_alta    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_modi      VARCHAR(255),
    ip_modi           CHAR(15),
    fecha_modi        TIMESTAMP
);

# 3. TABLA MÓDULOS 
CREATE TABLE modulos (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nombre          VARCHAR(100) NOT NULL,
    siglas          VARCHAR(10) NOT NULL,
    color           VARCHAR(7) NOT NULL UNIQUE,
    curso_asignado  INT NOT NULL,
    FOREIGN KEY (curso_asignado) REFERENCES cursos(id),

    # DATOS AUDITORÍA
    usuario_alta      VARCHAR(255),
    ip_alta           CHAR(15),
    fecha_sis_alta    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_modi      VARCHAR(255),
    ip_modi           CHAR(15),
    fecha_modi        TIMESTAMP
);

# 5. TABLA AULAS (Corregido PK)
CREATE TABLE aulas(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    nombre  VARCHAR(100) NOT NULL,
    letra   CHAR(1) NOT NULL,
    numero  INT NOT NULL UNIQUE,
    planta  CHAR(1), # [P]rimera, [S]egunda, [T]ercera

    # DATOS AUDITORÍA
    usuario_alta      VARCHAR(255),
    ip_alta           CHAR(15),
    fecha_sis_alta    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_modi      VARCHAR(255),
    ip_modi           CHAR(15),
    fecha_modi        TIMESTAMP
);

# 6. TABLA HORARIOS 
CREATE TABLE horarios (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    dia                 CHAR(01) NOT NULL, # L, M, X, J, V
    hora_inicio         TIME NOT NULL,
    hora_fin            TIME NOT NULL,
    
    id_modulo INT NOT NULL,
    id_profesor INT NOT NULL,
    id_aula INT NULL,
    
    FOREIGN KEY (id_modulo) REFERENCES modulos(id),
    FOREIGN KEY (id_profesor) REFERENCES personas(id),
    FOREIGN KEY (id_aula) REFERENCES aulas(id),

    # DATOS AUDITORÍA
    usuario_alta      VARCHAR(255),
    ip_alta           CHAR(15),
    fecha_sis_alta    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_modi      VARCHAR(255),
    ip_modi           CHAR(15),
    fecha_modi        TIMESTAMP
);


# ==========================================================
# 2. INSERCIÓN DE DATOS (DATA SEEDING)
# ==========================================================

# #############################
# 2.1 AULAS
# #############################
INSERT INTO aulas (id, nombre, letra, numero, planta, usuario_alta, ip_alta) VALUES
(1, 'Aula Informática 1', 'A', 101, 'P', 'ADMIN', '127.0.0.1'), # Para 1 DAW
(2, 'Aula Informática 2', 'B', 102, 'P', 'ADMIN', '127.0.0.1'), # Para 2 DAW
(3, 'Taller Hardware 1', 'C', 201, 'S', 'ADMIN', '127.0.0.1'),  # Para 1 SMR
(4, 'Taller Redes 1', 'D', 202, 'S', 'ADMIN', '127.0.0.1');     # Para 2 SMR

# #############################
# 2.2 CURSOS
# #############################
INSERT INTO cursos (id, nombre_grado, curso_numero, letra, usuario_alta, ip_alta) VALUES
(1, 'DAW', 1, 'A', 'ADMIN', '127.0.0.1'),
(2, 'DAW', 2, 'A', 'ADMIN', '127.0.0.1'),
(3, 'SMR', 1, 'A', 'ADMIN', '127.0.0.1'),
(4, 'SMR', 2, 'A', 'ADMIN', '127.0.0.1');

# #############################
# 2.3 PERSONAS (Profesores y algunos alumnos)
# #############################
INSERT INTO personas (id, nombre, apellidos, email, tipo, usuario_alta, ip_alta) VALUES
# PROFESORES (IDs 1-10)
(1, 'Alan', 'Turing', 'alan@instituto.com', 'P', 'ADMIN', '127.0.0.1'),      # Prog/Backend
(2, 'Ada', 'Lovelace', 'ada@instituto.com', 'P', 'ADMIN', '127.0.0.1'),      # BD/Sistemas
(3, 'Grace', 'Hopper', 'grace@instituto.com', 'P', 'ADMIN', '127.0.0.1'),    # Marcas/Frontend
(4, 'Linus', 'Torvalds', 'linus@instituto.com', 'P', 'ADMIN', '127.0.0.1'),  # Sistemas/Redes (SMR)
(5, 'Tim', 'Berners-Lee', 'tim@instituto.com', 'P', 'ADMIN', '127.0.0.1'),  # Servicios Red/Web
(6, 'Steve', 'Wozniak', 'steve@instituto.com', 'P', 'ADMIN', '127.0.0.1'),   # Hardware (SMR)
(7, 'Margaret', 'Hamilton', 'margaret@instituto.com', 'P', 'ADMIN', '127.0.0.1'), # FOL/EIE

# ALUMNOS (IDs 11+)
(11, 'Juan', 'Pérez', 'juan.p@alumno.com', 'A', 'ADMIN', '127.0.0.1'),
(12, 'Maria', 'García', 'maria.g@alumno.com', 'A', 'ADMIN', '127.0.0.1');

# #############################
# 2.4 MÓDULOS (Asignando IDs fijos para facilitar horarios)
# #############################
INSERT INTO modulos (id, nombre, siglas, color, curso_asignado, usuario_alta, ip_alta) VALUES
# 1 DAW (Curso ID 1)
(1, 'Programación', 'PROG', '#FF5733', 1, 'ADMIN', '127.0.0.1'),
(2, 'Bases de Datos', 'BD', '#33FF57', 1, 'ADMIN', '127.0.0.1'),
(3, 'Lenguajes de Marcas', 'LMSGI', '#3357FF', 1, 'ADMIN', '127.0.0.1'),
(4, 'Sistemas Informáticos', 'SI', '#F333FF', 1, 'ADMIN', '127.0.0.1'),
(5, 'Entornos de Desarrollo', 'ED', '#33FFF5', 1, 'ADMIN', '127.0.0.1'),
(6, 'Formación y Orientación Laboral', 'FOL', '#FF33A8', 1, 'ADMIN', '127.0.0.1'),

# 2 DAW (Curso ID 2)
(7, 'Desarrollo Web en Entorno Servidor', 'DWES', '#A833FF', 2, 'ADMIN', '127.0.0.1'),
(8, 'Desarrollo Web en Entorno Cliente', 'DWEC', '#FF8C33', 2, 'ADMIN', '127.0.0.1'),
(9, 'Diseño de Interfaces Web', 'DIW', '#33FF8C', 2, 'ADMIN', '127.0.0.1'),
(10, 'Despliegue de Aplicaciones Web', 'DAW', '#8C33FF', 2, 'ADMIN', '127.0.0.1'),
(11, 'Empresa e Iniciativa Emprendedora', 'EIE', '#FF3333', 2, 'ADMIN', '127.0.0.1'),

# 1 SMR (Curso ID 3)
(12, 'Montaje y Mantenimiento de Equipos', 'MME', '#338CFF', 3, 'ADMIN', '127.0.0.1'),
(13, 'Sistemas Operativos Monopuesto', 'SOM', '#FFC300', 3, 'ADMIN', '127.0.0.1'),
(14, 'Aplicaciones Ofimáticas', 'AO', '#DAF7A6', 3, 'ADMIN', '127.0.0.1'),
(15, 'Redes Locales', 'RL', '#581845', 3, 'ADMIN', '127.0.0.1'),
(16, 'Formación y Orientación Laboral', 'FOL-S', '#C70039', 3, 'ADMIN', '127.0.0.1'),

# 2 SMR (Curso ID 4)
(17, 'Sistemas Operativos en Red', 'SOR', '#900C3F', 4, 'ADMIN', '127.0.0.1'),
(18, 'Seguridad Informática', 'S-INF', '#2E86C1', 4, 'ADMIN', '127.0.0.1'),
(19, 'Servicios de Red', 'SER', '#138D75', 4, 'ADMIN', '127.0.0.1'),
(20, 'Aplicaciones Web', 'AW', '#D35400', 4, 'ADMIN', '127.0.0.1'),
(21, 'Empresa e Iniciativa Emprendedora', 'EIE-S', '#7D3C98', 4, 'ADMIN', '127.0.0.1');

# #############################
# 2.5 HORARIOS
# #############################
# Nota: Usaremos 'X' para Miércoles para evitar conflicto con Martes 'M'
# Tramos: 
# T1: 08:00-08:55 | T2: 08:55-09:50 | T3: 09:50-10:45 
# RECREO
# T4: 11:15-12:10 | T5: 12:10-13:05 | T6: 13:05-14:00

INSERT INTO horarios (dia, hora_inicio, hora_fin, id_modulo, id_profesor, id_aula, usuario_alta, ip_alta) VALUES

# ================== 1 DAW (Aula 1) ==================
# LUNES
('L', '08:00:00', '08:55:00', 1, 1, 1, 'ADMIN', '127.0.0.1'), # PROG (Turing)
('L', '08:55:00', '09:50:00', 1, 1, 1, 'ADMIN', '127.0.0.1'),
('L', '09:50:00', '10:45:00', 1, 1, 1, 'ADMIN', '127.0.0.1'),
('L', '11:15:00', '12:10:00', 3, 3, 1, 'ADMIN', '127.0.0.1'), # LMSGI (Hopper)
('L', '12:10:00', '13:05:00', 3, 3, 1, 'ADMIN', '127.0.0.1'),
('L', '13:05:00', '14:00:00', 6, 7, 1, 'ADMIN', '127.0.0.1'), # FOL (Hamilton)

# MARTES
('M', '08:00:00', '08:55:00', 2, 2, 1, 'ADMIN', '127.0.0.1'), # BD (Lovelace)
('M', '08:55:00', '09:50:00', 2, 2, 1, 'ADMIN', '127.0.0.1'),
('M', '09:50:00', '10:45:00', 4, 4, 1, 'ADMIN', '127.0.0.1'), # SI (Torvalds)
('M', '11:15:00', '12:10:00', 4, 4, 1, 'ADMIN', '127.0.0.1'),
('M', '12:10:00', '13:05:00', 5, 1, 1, 'ADMIN', '127.0.0.1'), # ED (Turing)
('M', '13:05:00', '14:00:00', 5, 1, 1, 'ADMIN', '127.0.0.1'),

# MIERCOLES (X)
('X', '08:00:00', '08:55:00', 1, 1, 1, 'ADMIN', '127.0.0.1'), # PROG
('X', '08:55:00', '09:50:00', 1, 1, 1, 'ADMIN', '127.0.0.1'),
('X', '09:50:00', '10:45:00', 3, 3, 1, 'ADMIN', '127.0.0.1'), # LMSGI
('X', '11:15:00', '12:10:00', 3, 3, 1, 'ADMIN', '127.0.0.1'),
('X', '12:10:00', '13:05:00', 2, 2, 1, 'ADMIN', '127.0.0.1'), # BD
('X', '13:05:00', '14:00:00', 2, 2, 1, 'ADMIN', '127.0.0.1'),

# JUEVES
('J', '08:00:00', '08:55:00', 4, 4, 1, 'ADMIN', '127.0.0.1'), # SI
('J', '08:55:00', '09:50:00', 4, 4, 1, 'ADMIN', '127.0.0.1'),
('J', '09:50:00', '10:45:00', 1, 1, 1, 'ADMIN', '127.0.0.1'), # PROG
('J', '11:15:00', '12:10:00', 1, 1, 1, 'ADMIN', '127.0.0.1'),
('J', '12:10:00', '13:05:00', 6, 7, 1, 'ADMIN', '127.0.0.1'), # FOL
('J', '13:05:00', '14:00:00', 6, 7, 1, 'ADMIN', '127.0.0.1'),

# VIERNES
('V', '08:00:00', '08:55:00', 2, 2, 1, 'ADMIN', '127.0.0.1'), # BD
('V', '08:55:00', '09:50:00', 2, 2, 1, 'ADMIN', '127.0.0.1'),
('V', '09:50:00', '10:45:00', 5, 1, 1, 'ADMIN', '127.0.0.1'), # ED
('V', '11:15:00', '12:10:00', 4, 4, 1, 'ADMIN', '127.0.0.1'), # SI
('V', '12:10:00', '13:05:00', 4, 4, 1, 'ADMIN', '127.0.0.1'),
('V', '13:05:00', '14:00:00', 1, 1, 1, 'ADMIN', '127.0.0.1'), # PROG

# ================== 2 DAW (Aula 2) ==================
# LUNES
('L', '08:00:00', '08:55:00', 7, 1, 2, 'ADMIN', '127.0.0.1'), # DWES (Turing)
('L', '08:55:00', '09:50:00', 7, 1, 2, 'ADMIN', '127.0.0.1'),
('L', '09:50:00', '10:45:00', 8, 3, 2, 'ADMIN', '127.0.0.1'), # DWEC (Hopper)
('L', '11:15:00', '12:10:00', 8, 3, 2, 'ADMIN', '127.0.0.1'),
('L', '12:10:00', '13:05:00', 9, 3, 2, 'ADMIN', '127.0.0.1'), # DIW (Hopper)
('L', '13:05:00', '14:00:00', 9, 3, 2, 'ADMIN', '127.0.0.1'),

# MARTES
('M', '08:00:00', '08:55:00', 7, 1, 2, 'ADMIN', '127.0.0.1'), # DWES
('M', '08:55:00', '09:50:00', 7, 1, 2, 'ADMIN', '127.0.0.1'),
('M', '09:50:00', '10:45:00', 10, 5, 2, 'ADMIN', '127.0.0.1'), # DAW (Berners-Lee)
('M', '11:15:00', '12:10:00', 10, 5, 2, 'ADMIN', '127.0.0.1'),
('M', '12:10:00', '13:05:00', 11, 7, 2, 'ADMIN', '127.0.0.1'), # EIE (Hamilton)
('M', '13:05:00', '14:00:00', 11, 7, 2, 'ADMIN', '127.0.0.1'),

# MIERCOLES (X)
('X', '08:00:00', '08:55:00', 8, 3, 2, 'ADMIN', '127.0.0.1'), # DWEC
('X', '08:55:00', '09:50:00', 8, 3, 2, 'ADMIN', '127.0.0.1'),
('X', '09:50:00', '10:45:00', 9, 3, 2, 'ADMIN', '127.0.0.1'), # DIW
('X', '11:15:00', '12:10:00', 9, 3, 2, 'ADMIN', '127.0.0.1'),
('X', '12:10:00', '13:05:00', 7, 1, 2, 'ADMIN', '127.0.0.1'), # DWES
('X', '13:05:00', '14:00:00', 7, 1, 2, 'ADMIN', '127.0.0.1'),

# JUEVES
('J', '08:00:00', '08:55:00', 10, 5, 2, 'ADMIN', '127.0.0.1'), # DAW
('J', '08:55:00', '09:50:00', 10, 5, 2, 'ADMIN', '127.0.0.1'),
('J', '09:50:00', '10:45:00', 11, 7, 2, 'ADMIN', '127.0.0.1'), # EIE
('J', '11:15:00', '12:10:00', 11, 7, 2, 'ADMIN', '127.0.0.1'),
('J', '12:10:00', '13:05:00', 8, 3, 2, 'ADMIN', '127.0.0.1'), # DWEC
('J', '13:05:00', '14:00:00', 8, 3, 2, 'ADMIN', '127.0.0.1'),

# VIERNES
('V', '08:00:00', '08:55:00', 7, 1, 2, 'ADMIN', '127.0.0.1'), # DWES
('V', '08:55:00', '09:50:00', 7, 1, 2, 'ADMIN', '127.0.0.1'),
('V', '09:50:00', '10:45:00', 9, 3, 2, 'ADMIN', '127.0.0.1'), # DIW
('V', '11:15:00', '12:10:00', 9, 3, 2, 'ADMIN', '127.0.0.1'),
('V', '12:10:00', '13:05:00', 8, 3, 2, 'ADMIN', '127.0.0.1'), # DWEC
('V', '13:05:00', '14:00:00', 10, 5, 2, 'ADMIN', '127.0.0.1'), # DAW

# ================== 1 SMR (Aula 3) ==================
# LUNES
('L', '08:00:00', '08:55:00', 12, 6, 3, 'ADMIN', '127.0.0.1'), # MME (Wozniak)
('L', '08:55:00', '09:50:00', 12, 6, 3, 'ADMIN', '127.0.0.1'),
('L', '09:50:00', '10:45:00', 14, 5, 3, 'ADMIN', '127.0.0.1'), # AO (Berners-Lee)
('L', '11:15:00', '12:10:00', 14, 5, 3, 'ADMIN', '127.0.0.1'),
('L', '12:10:00', '13:05:00', 13, 4, 3, 'ADMIN', '127.0.0.1'), # SOM (Torvalds)
('L', '13:05:00', '14:00:00', 13, 4, 3, 'ADMIN', '127.0.0.1'),

# MARTES
('M', '08:00:00', '08:55:00', 15, 4, 3, 'ADMIN', '127.0.0.1'), # RL (Torvalds)
('M', '08:55:00', '09:50:00', 15, 4, 3, 'ADMIN', '127.0.0.1'),
('M', '09:50:00', '10:45:00', 15, 4, 3, 'ADMIN', '127.0.0.1'),
('M', '11:15:00', '12:10:00', 12, 6, 3, 'ADMIN', '127.0.0.1'), # MME
('M', '12:10:00', '13:05:00', 12, 6, 3, 'ADMIN', '127.0.0.1'),
('M', '13:05:00', '14:00:00', 16, 7, 3, 'ADMIN', '127.0.0.1'), # FOL

# MIERCOLES (X)
('X', '08:00:00', '08:55:00', 13, 4, 3, 'ADMIN', '127.0.0.1'), # SOM
('X', '08:55:00', '09:50:00', 13, 4, 3, 'ADMIN', '127.0.0.1'),
('X', '09:50:00', '10:45:00', 14, 5, 3, 'ADMIN', '127.0.0.1'), # AO
('X', '11:15:00', '12:10:00', 14, 5, 3, 'ADMIN', '127.0.0.1'),
('X', '12:10:00', '13:05:00', 15, 4, 3, 'ADMIN', '127.0.0.1'), # RL
('X', '13:05:00', '14:00:00', 15, 4, 3, 'ADMIN', '127.0.0.1'),

# JUEVES
('J', '08:00:00', '08:55:00', 12, 6, 3, 'ADMIN', '127.0.0.1'), # MME
('J', '08:55:00', '09:50:00', 12, 6, 3, 'ADMIN', '127.0.0.1'),
('J', '09:50:00', '10:45:00', 12, 6, 3, 'ADMIN', '127.0.0.1'), 
('J', '11:15:00', '12:10:00', 13, 4, 3, 'ADMIN', '127.0.0.1'), # SOM
('J', '12:10:00', '13:05:00', 13, 4, 3, 'ADMIN', '127.0.0.1'),
('J', '13:05:00', '14:00:00', 16, 7, 3, 'ADMIN', '127.0.0.1'), # FOL

# VIERNES
('V', '08:00:00', '08:55:00', 15, 4, 3, 'ADMIN', '127.0.0.1'), # RL
('V', '08:55:00', '09:50:00', 15, 4, 3, 'ADMIN', '127.0.0.1'),
('V', '09:50:00', '10:45:00', 14, 5, 3, 'ADMIN', '127.0.0.1'), # AO
('V', '11:15:00', '12:10:00', 14, 5, 3, 'ADMIN', '127.0.0.1'),
('V', '12:10:00', '13:05:00', 14, 5, 3, 'ADMIN', '127.0.0.1'),
('V', '13:05:00', '14:00:00', 16, 7, 3, 'ADMIN', '127.0.0.1'), # FOL

# ================== 2 SMR (Aula 4) ==================
# LUNES
('L', '08:00:00', '08:55:00', 17, 4, 4, 'ADMIN', '127.0.0.1'), # SOR (Torvalds)
('L', '08:55:00', '09:50:00', 17, 4, 4, 'ADMIN', '127.0.0.1'),
('L', '09:50:00', '10:45:00', 19, 5, 4, 'ADMIN', '127.0.0.1'), # SER (Berners-Lee)
('L', '11:15:00', '12:10:00', 19, 5, 4, 'ADMIN', '127.0.0.1'),
('L', '12:10:00', '13:05:00', 20, 2, 4, 'ADMIN', '127.0.0.1'), # AW (Lovelace)
('L', '13:05:00', '14:00:00', 20, 2, 4, 'ADMIN', '127.0.0.1'),

# MARTES
('M', '08:00:00', '08:55:00', 18, 6, 4, 'ADMIN', '127.0.0.1'), # SEGURIDAD (Wozniak)
('M', '08:55:00', '09:50:00', 18, 6, 4, 'ADMIN', '127.0.0.1'),
('M', '09:50:00', '10:45:00', 17, 4, 4, 'ADMIN', '127.0.0.1'), # SOR
('M', '11:15:00', '12:10:00', 17, 4, 4, 'ADMIN', '127.0.0.1'),
('M', '12:10:00', '13:05:00', 21, 7, 4, 'ADMIN', '127.0.0.1'), # EIE
('M', '13:05:00', '14:00:00', 21, 7, 4, 'ADMIN', '127.0.0.1'),

# MIERCOLES (X)
('X', '08:00:00', '08:55:00', 19, 5, 4, 'ADMIN', '127.0.0.1'), # SER
('X', '08:55:00', '09:50:00', 19, 5, 4, 'ADMIN', '127.0.0.1'),
('X', '09:50:00', '10:45:00', 20, 2, 4, 'ADMIN', '127.0.0.1'), # AW
('X', '11:15:00', '12:10:00', 20, 2, 4, 'ADMIN', '127.0.0.1'),
('X', '12:10:00', '13:05:00', 18, 6, 4, 'ADMIN', '127.0.0.1'), # SEGURIDAD
('X', '13:05:00', '14:00:00', 18, 6, 4, 'ADMIN', '127.0.0.1'),

# JUEVES
('J', '08:00:00', '08:55:00', 17, 4, 4, 'ADMIN', '127.0.0.1'), # SOR
('J', '08:55:00', '09:50:00', 17, 4, 4, 'ADMIN', '127.0.0.1'),
('J', '09:50:00', '10:45:00', 19, 5, 4, 'ADMIN', '127.0.0.1'), # SER
('J', '11:15:00', '12:10:00', 19, 5, 4, 'ADMIN', '127.0.0.1'),
('J', '12:10:00', '13:05:00', 21, 7, 4, 'ADMIN', '127.0.0.1'), # EIE
('J', '13:05:00', '14:00:00', 21, 7, 4, 'ADMIN', '127.0.0.1'),

# VIERNES
('V', '08:00:00', '08:55:00', 18, 6, 4, 'ADMIN', '127.0.0.1'), # SEGURIDAD
('V', '08:55:00', '09:50:00', 18, 6, 4, 'ADMIN', '127.0.0.1'),
('V', '09:50:00', '10:45:00', 17, 4, 4, 'ADMIN', '127.0.0.1'), # SOR
('V', '11:15:00', '12:10:00', 17, 4, 4, 'ADMIN', '127.0.0.1'),
('V', '12:10:00', '13:05:00', 19, 5, 4, 'ADMIN', '127.0.0.1'), # SER
('V', '13:05:00', '14:00:00', 20, 2, 4, 'ADMIN', '127.0.0.1'); # AW