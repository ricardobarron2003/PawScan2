
CREATE DATABASE base_de_datos DEFAULT CHARACTER SET utf8;

USE base_de_datos;

CREATE TABLE usuarios (
    id_usuario INT NOT NULL UNIQUE AUTO_INCREMENT,
    nombre_usuario VARCHAR(50) NOT NULL,
    email_usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telefono_usuario VARCHAR(50) NOT NULL,
    direccion_usuario VARCHAR(50) NOT NULL,
    fecha_registro DATETIME NOT NULL,
    activo TINYINT NOT NULL,
    PRIMARY KEY (id_usuario)
);

CREATE TABLE mascotas (
    id_mascota INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    nombre_mascota VARCHAR(50) NOT NULL,
    foto_mascota VARCHAR(255) NOT NULL,
    edad_mascota INT NOT NULL,
    vacunas_mascota VARCHAR(255) NOT NULL,
    caracteristicas_mascota VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_mascota),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);
