
CREATE DATABASE perez_clemente
-------FINALIZADO
select * from avpc_usuario
CREATE TABLE avpc_usuario(
    usuario_id SERIAL PRIMARY KEY,
    usuario_nom1 VARCHAR (50) NOT NULL,
    usuario_nom2 VARCHAR (50) NOT NULL,
    usuario_ape1 VARCHAR (50) NOT NULL,
    usuario_ape2 VARCHAR (50) NOT NULL,
    usuario_tel INT NOT NULL, 
    usuario_direc VARCHAR (150) NOT NULL,
    usuario_dpi VARCHAR (13) NOT NULL,
    usuario_correo VARCHAR (100) NOT NULL,
    usuario_contra LVARCHAR (1056) NOT NULL,
    usuario_token LVARCHAR (1056) NOT NULL,
    usuario_fecha_creacion DATE DEFAULT TODAY,
    usuario_fecha_contra DATE DEFAULT TODAY,
    usuario_fotografia LVARCHAR (2056),
    usuario_situacion SMALLINT DEFAULT 1
);
select * from avpc_asig_permisos
----FINALIZADO
CREATE TABLE avpc_compania(
    app_id SERIAL PRIMARY KEY,
    app_nombre_largo VARCHAR (250) NOT NULL,
    app_nombre_corto VARCHAR (150) NOT NULL,
    app_fecha_creacion DATE DEFAULT TODAY,
    app_situacion SMALLINT DEFAULT 1
);


--FINALIZDO
CREATE TABLE avpc_capacitacion(
    capacitacion_id SERIAL PRIMARY KEY,
    capacitacion_nombre VARCHAR(250) NOT NULL,
    capacitacion_descripcion LVARCHAR(2056) NOT NULL,
    capacitacion_duracion_horas INT NOT NULL,
    capacitacion_objetivos LVARCHAR(1056),
    capacitacion_fecha_creacion DATE DEFAULT TODAY,
    capacitacion_usuario_creo INT NOT NULL,
    capacitacion_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (capacitacion_usuario_creo) REFERENCES avpc_usuario(usuario_id)
);

--FINALIZADO
CREATE TABLE avpc_instructor(
    instructor_id SERIAL PRIMARY KEY,
    instructor_usuario_id INT NOT NULL,
    instructor_grado VARCHAR(200) NOT NULL,
    instructor_arma VARCHAR(200) NOT NULL,
    instructor_anos_servicio INT DEFAULT 0,
    instructor_fecha_registro DATE DEFAULT TODAY,
    instructor_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (instructor_usuario_id) REFERENCES avpc_usuario(usuario_id)
);

--FINALIZADO
CREATE TABLE avpc_area_entrenamiento(
    area_id SERIAL PRIMARY KEY,
    area_nombre VARCHAR(200) NOT NULL,
    area_descripcion VARCHAR(250),
    area_direccion VARCHAR(250) NOT NULL,
    area_situacion SMALLINT DEFAULT 1
);




--FINALIZADO
-- programar entrenamientos/horarios
CREATE TABLE avpc_entrenamiento(
    entrenamiento_id SERIAL PRIMARY KEY,
    entrenamiento_capacitacion_id INT NOT NULL,
    entrenamiento_compania_id INT NOT NULL,
    entrenamiento_instructor_id INT NOT NULL,
    entrenamiento_area_id INT NOT NULL,
    entrenamiento_fecha_inicio DATETIME YEAR TO MINUTE NOT NULL,
    entrenamiento_fecha_fin DATETIME YEAR TO MINUTE NOT NULL,
    entrenamiento_estado VARCHAR(50) DEFAULT 'PROGRAMADO', -- PROGRAMADO, EN_CURSO, COMPLETADO, CANCELADO
    entrenamiento_observaciones LVARCHAR(1056),
    entrenamiento_usuario_creo INT NOT NULL,
    entrenamiento_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (entrenamiento_capacitacion_id) REFERENCES avpc_capacitacion(capacitacion_id),
    FOREIGN KEY (entrenamiento_compania_id) REFERENCES avpc_compania(app_id),
    FOREIGN KEY (entrenamiento_instructor_id) REFERENCES avpc_instructor(instructor_id),
    FOREIGN KEY (entrenamiento_area_id) REFERENCES avpc_area_entrenamiento(area_id),
    FOREIGN KEY (entrenamiento_usuario_creo) REFERENCES avpc_usuario(usuario_id)
);

--FINALIZADO
select * from avpc_aplicacion
CREATE TABLE avpc_aplicacion(
    app_id SERIAL PRIMARY KEY,
    app_nombre_largo VARCHAR (250) NOT NULL,
    app_nombre_corto VARCHAR (150) NOT NULL,
    app_fecha_creacion DATE DEFAULT TODAY,
    app_situacion SMALLINT DEFAULT 1
);


--FINALIZADO
CREATE TABLE avpc_permiso (
    permiso_id SERIAL PRIMARY KEY,
    usuario_id INTEGER NOT NULL,
    app_id INTEGER NOT NULL,
    permiso_nombre VARCHAR(150) NOT NULL,
    permiso_clave VARCHAR(250) NOT NULL,
    permiso_desc VARCHAR(250) NOT NULL,  
    permiso_fecha DATE DEFAULT TODAY,
    permiso_motivo VARCHAR(250),                   
    permiso_situacion SMALLINT DEFAULT 1,
    permiso_tipo VARCHAR(20),
    FOREIGN KEY (app_id) REFERENCES avpc_aplicacion(app_id)
);

select * from avpc_asig_permisos
CREATE TABLE avpc_asig_permisos(
    asignacion_id SERIAL PRIMARY KEY,
    asignacion_usuario_id INT NOT NULL,
    asignacion_app_id INT NOT NULL,
    asignacion_permiso_id INT NOT NULL,
    asignacion_fecha DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    asignacion_quitar_fechaPermiso DATETIME YEAR TO SECOND DEFAULT NULL,
    asignacion_usuario_asigno INT NOT NULL,
    asignacion_motivo VARCHAR (250) NOT NULL,
    asignacion_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (asignacion_usuario_id) REFERENCES avpc_usuario(usuario_id),
    FOREIGN KEY (asignacion_app_id) REFERENCES avpc_aplicacion(app_id),
    FOREIGN KEY (asignacion_permiso_id) REFERENCES avpc_permiso(permiso_id)
);



CREATE TABLE avpc_rutas(
    ruta_id SERIAL PRIMARY KEY,
    ruta_app_id INT NOT NULL,
    ruta_nombre LVARCHAR (1056) NOT NULL,
    ruta_descripcion VARCHAR (250) NOT NULL,
    ruta_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (ruta_app_id) REFERENCES avpc_aplicacion(app_id)
);


CREATE TABLE avpc_historial_act(
    historial_id SERIAL PRIMARY KEY,
    historial_usuario_id INT NOT NULL,
    historial_fecha DATETIME YEAR TO MINUTE,
    historial_ruta INT NOT NULL,
    historial_ejecucion LVARCHAR (1056) NOT NULL,
    historial_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (historial_usuario_id) REFERENCES avpc_usuario(usuario_id),
    FOREIGN KEY (historial_ruta) REFERENCES avpc_rutas(ruta_id)
);

