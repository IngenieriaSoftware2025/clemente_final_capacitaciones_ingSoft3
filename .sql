
create database perez_cle


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

CREATE TABLE avpc_aplicacion(
app_id SERIAL PRIMARY KEY,
app_nombre_largo VARCHAR (250) NOT NULL,
app_nombre_medium VARCHAR (150) NOT NULL,
app_nombre_corto VARCHAR (50) NOT NULL,
app_fecha_creacion DATE DEFAULT TODAY,
app_situacion SMALLINT DEFAULT 1
);

CREATE TABLE avpc_permiso (
    permiso_id SERIAL PRIMARY KEY,
    usuario_id INTEGER NOT NULL,
    app_id INTEGER NOT NULL,
    permiso_nombre VARCHAR(150) NOT NULL,
    permiso_clave VARCHAR(250) NOT NULL,
    permiso_desc VARCHAR(250) NOT NULL,
    permiso_tipo VARCHAR(50) DEFAULT 'FUNCIONAL',  
    permiso_fecha DATE DEFAULT TODAY,
    permiso_usuario_asigno INTEGER NOT NULL,   
    permiso_motivo VARCHAR(250),                   
    permiso_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (usuario_id) REFERENCES avpc_usuario(usuario_id),
    FOREIGN KEY (app_id) REFERENCES avpc_aplicacion(app_id),
    FOREIGN KEY (permiso_usuario_asigno) REFERENCES avpc_usuario(usuario_id)
);

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


CREATE TABLE avpc_comision(
comision_id SERIAL PRIMARY KEY,
comision_titulo VARCHAR (250) NOT NULL,
comision_descripcion LVARCHAR (1056) NOT NULL,
comision_tipo VARCHAR (50) NOT NULL,
comision_fecha_inicio DATE NOT NULL,
comision_duracion INT NOT NULL,
comision_duracion_tipo VARCHAR (10) NOT NULL,
comision_fecha_fin DATE NOT NULL,
comision_ubicacion VARCHAR (250) NOT NULL,
comision_observaciones LVARCHAR (1056),
comision_estado VARCHAR (50) DEFAULT 'PROGRAMADA',
comision_fecha_creacion DATE DEFAULT TODAY,
comision_usuario_creo INT NOT NULL,
comision_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (comision_usuario_creo) REFERENCES avpc_usuario(usuario_id)
);

CREATE TABLE avpc_comision_personal(
comision_personal_id SERIAL PRIMARY KEY,
comision_id INT NOT NULL,
usuario_id INT NOT NULL,
comision_personal_fecha_asignacion DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
comision_personal_usuario_asigno INT NOT NULL,
comision_personal_observaciones VARCHAR (250),
comision_personal_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (comision_id) REFERENCES avpc_comision(comision_id),
FOREIGN KEY (usuario_id) REFERENCES avpc_usuario(usuario_id),
FOREIGN KEY (comision_personal_usuario_asigno) REFERENCES avpc_usuario(usuario_id)
);
