<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675

create database perez_comisiones


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
<<<<<<< HEAD
=======
=======
create database proyecto_celulares


CREATE TABLE permisos(
    id_permiso SERIAL PRIMARY KEY,
    nombre_permiso VARCHAR(100) NOT NULL,
    descripcion VARCHAR(250),
    fecha_creacion DATE DEFAULT TODAY,
    situacion SMALLINT DEFAULT 1
);
INSERT INTO permisos (nombre_permiso, descripcion) VALUES 
('Administrar Usuarios', 'Puede crear, editar y eliminar usuarios');
INSERT INTO permisos (nombre_permiso, descripcion) VALUES 
('Ver Inventario', 'Puede consultar el inventario de celulares');
INSERT INTO permisos (nombre_permiso, descripcion) VALUES 
('Realizar Ventas', 'Puede hacer ventas de celulares');
INSERT INTO permisos (nombre_permiso, descripcion) VALUES 
('Hacer Reparaciones', 'Puede recibir y gestionar reparaciones');
INSERT INTO permisos (nombre_permiso, descripcion) VALUES 
('Ver Reportes', 'Puede ver estadísticas y reportes del negocio');




CREATE TABLE roles(
    id_rol SERIAL PRIMARY KEY,
    nombre_rol VARCHAR(100) NOT NULL,
    nombre_corto VARCHAR(25) NOT NULL,
    descripcion VARCHAR(250),
    fecha_creacion DATE DEFAULT TODAY,
    situacion SMALLINT DEFAULT 1
);
INSERT INTO roles (nombre_rol, nombre_corto, descripcion) VALUES 
('Administrador', 'ADMIN', 'Acceso completo al sistema');
INSERT INTO roles (nombre_rol, nombre_corto, descripcion) VALUES 
('Técnico', 'TECNICO', 'Puede manejar reparaciones e inventario');
INSERT INTO roles (nombre_rol, nombre_corto, descripcion) VALUES 
('Vendedor', 'VENDEDOR', 'Puede realizar ventas');
INSERT INTO roles (nombre_rol, nombre_corto, descripcion) VALUES 
('Usuario', 'USER', 'Acceso básico');




CREATE TABLE usuarios(
    id_usuario SERIAL PRIMARY KEY,
    primer_nombre VARCHAR(100) NOT NULL,
    segundo_nombre VARCHAR(100),
    primer_apellido VARCHAR(100) NOT NULL,
    segundo_apellido VARCHAR(100),
    telefono VARCHAR(15),
    direccion VARCHAR(100),
    dpi VARCHAR(100),
    correo VARCHAR(100),
    contrasena LVARCHAR(1056),
    token LVARCHAR(1056),
    fecha_creacion DATE DEFAULT TODAY,
    fecha_contrasena DATE DEFAULT TODAY,
    fotografia LVARCHAR(2056),
    id_rol INTEGER,
    situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);
INSERT INTO usuarios (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, telefono, direccion, dpi, correo, contrasena, id_rol)
VALUES ('Juan', 'Carlos', 'Pérez', 'García', '5551-1234', 'Zona 1, Ciudad de Guatemala', '1234567890101', 'admin@celulares.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

--Email/Usuario: 1234567890101
--Contraseña: password



CREATE TABLE clientes(
    id_cliente SERIAL PRIMARY KEY,
    primer_nombre VARCHAR(100) NOT NULL,
    segundo_nombre VARCHAR(100),
    primer_apellido VARCHAR(100) NOT NULL,
    segundo_apellido VARCHAR(100),
    telefono VARCHAR(15),
    dpi VARCHAR(20),
    correo VARCHAR(100),
    direccion VARCHAR(200),
    fecha_registro DATE DEFAULT TODAY,
    situacion SMALLINT DEFAULT 1
);
INSERT INTO clientes (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, telefono, dpi, correo, direccion)
VALUES ('Mario', 'Andrés', 'Castro', 'López', '5559-7788', '2345678901234', 'mario.castro@gmail.com', 'Zona 11, Guatemala');
INSERT INTO clientes (primer_nombre, primer_apellido, telefono, dpi, correo, direccion)
VALUES ('Carmen', 'Flores', '5550-9988', '2345678901235', 'carmen.flores@hotmail.com', 'Villa Nueva, Guatemala');





CREATE TABLE marcas(
    id_marca SERIAL PRIMARY KEY,
    nombre_marca VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(250),
    fecha_creacion DATE DEFAULT TODAY,
    situacion SMALLINT DEFAULT 1
);
INSERT INTO marcas (nombre_marca, descripcion)
VALUES ('Samsung', 'Marca líder en tecnología móvil');
INSERT INTO marcas (nombre_marca, descripcion)
VALUES ('Apple', 'Innovación y diseño en dispositivos móviles');





CREATE TABLE modelos(
    id_modelo SERIAL PRIMARY KEY,
    id_marca INTEGER NOT NULL,
    nombre_modelo VARCHAR(100) NOT NULL,
    color VARCHAR(50),
    fecha_creacion DATE DEFAULT TODAY,
    situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (id_marca) REFERENCES marcas(id_marca)
);
INSERT INTO modelos (id_marca, nombre_modelo, color)
VALUES (1, 'Galaxy S23', 'Negro');
INSERT INTO modelos (id_marca, nombre_modelo, color)
VALUES (2, 'iPhone 15', 'Azul');








create TABLE inventario(
    id_inventario SERIAL PRIMARY KEY,
    id_modelo INTEGER NOT NULL,
    estado_celular VARCHAR(20) DEFAULT 'nuevo' CHECK (estado_celular IN ('nuevo', 'usado', 'dañado')),
    precio_compra DECIMAL(10,2),
    precio_venta DECIMAL(10,2),
    fecha_ingreso DATE DEFAULT TODAY,
    estado_inventario VARCHAR(20) DEFAULT 'disponible' CHECK (estado_inventario IN ('disponible', 'vendido', 'en_reparacion')),
    situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (id_modelo) REFERENCES modelos(id_modelo)
);
INSERT INTO inventario (id_modelo, estado_celular, precio_compra, precio_venta, estado_inventario)
VALUES (1, 'nuevo', 2500.00, 3200.00, 'disponible');
INSERT INTO inventario (id_modelo, estado_celular, precio_compra, precio_venta, estado_inventario)
VALUES (2, 'nuevo', 4000.00, 5200.00, 'disponible');








CREATE TABLE reparaciones(
    id_reparacion SERIAL PRIMARY KEY,
    id_cliente INTEGER NOT NULL,
    id_usuario_recibe INTEGER NOT NULL,
    id_usuario_asignado INTEGER,
    tipo_celular VARCHAR(100),
    marca_celular VARCHAR(100),
    motivo_ingreso LVARCHAR(1000),
    diagnostico LVARCHAR(1000),
    fecha_ingreso DATE DEFAULT TODAY,
    fecha_asignacion DATE,
    fecha_entrega_real DATE,
    tipo_servicio VARCHAR(50),
    estado_reparacion VARCHAR(20) DEFAULT 'recibido' CHECK 
    (estado_reparacion IN ('recibido', 'en_proceso', 'terminado', 'entregado', 'cancelado')),
    costo_total DECIMAL(10,2) DEFAULT 0,
    situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_usuario_recibe) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_usuario_asignado) REFERENCES usuarios(id_usuario)
);
INSERT INTO reparaciones (id_cliente, id_usuario_recibe, tipo_celular, marca_celular, motivo_ingreso, estado_reparacion)
VALUES (1, 1, 'Smartphone', 'Samsung', 'Pantalla rota', 'recibido');






CREATE TABLE ventas(
    id_venta SERIAL PRIMARY KEY,
    id_cliente INTEGER NOT NULL,
    id_usuario INTEGER NOT NULL,
    fecha_venta DATE DEFAULT TODAY,
    subtotal DECIMAL(10,2) DEFAULT 0,
    descuento DECIMAL(10,2) DEFAULT 0,
    total DECIMAL(10,2) DEFAULT 0,
    metodo_pago VARCHAR(50) DEFAULT 'efectivo',
    estado_venta VARCHAR(20) DEFAULT 'completada',
    observaciones LVARCHAR(500),
    situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    CHECK (metodo_pago IN ('efectivo', 'tarjeta', 'transferencia')),
    CHECK (estado_venta IN ('completada', 'cancelada', 'pendiente'))
);

INSERT INTO ventas (id_cliente, id_usuario, subtotal, descuento, total, metodo_pago, estado_venta, observaciones)
VALUES (2, 1, 5200.00, 200.00, 5000.00, 'tarjeta', 'completada', 'Descuento por cliente frecuente');






CREATE TABLE detalle_ventas(
    id_detalle SERIAL PRIMARY KEY,
    id_venta INTEGER NOT NULL,
    id_inventario INTEGER NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    cantidad INTEGER DEFAULT 1,
    subtotal_detalle DECIMAL(10,2) NOT NULL,
    situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (id_venta) REFERENCES ventas(id_venta),
    FOREIGN KEY (id_inventario) REFERENCES inventario(id_inventario)
);
INSERT INTO detalle_ventas (id_venta, id_inventario, precio_unitario, cantidad, subtotal_detalle)
VALUES (1, 1, 3200.00, 1, 3200.00);





CREATE TABLE roles_permisos(
    id_rol_permiso SERIAL PRIMARY KEY,
    id_rol INTEGER NOT NULL,
    id_permiso INTEGER NOT NULL,
    usuario_asigna INTEGER NOT NULL,
    motivo_asignacion VARCHAR(250) NOT NULL, 
    fecha_asignacion DATE DEFAULT TODAY,
    situacion SMALLINT DEFAULT 1, 
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol),
    FOREIGN KEY (id_permiso) REFERENCES permisos(id_permiso),
    FOREIGN KEY (usuario_asigna) REFERENCES usuarios(id_usuario),
    UNIQUE(id_rol, id_permiso) 
);
INSERT INTO roles_permisos (id_rol, id_permiso, usuario_asigna, motivo_asignacion)
VALUES (2, 2, 1, 'Técnico requiere consultar inventario para reparaciones');


CREATE TABLE rutas_actividades(
    ruta_id SERIAL PRIMARY KEY,
    ruta_usuario_id INTEGER NOT NULL,
    ruta_usuario_nombre VARCHAR(200) NOT NULL,
    ruta_modulo VARCHAR(50) NOT NULL,
    ruta_accion VARCHAR(50) NOT NULL,
    ruta_descripcion LVARCHAR(500) NOT NULL,
    ruta_ip VARCHAR(50),
    ruta_ruta VARCHAR(200),
    ruta_fecha_creacion DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    ruta_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (ruta_usuario_id) REFERENCES usuarios(id_usuario)
);







>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
