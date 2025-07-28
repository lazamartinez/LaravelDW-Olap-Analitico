-- docker/postgresql/init.sql
CREATE SCHEMA dw;

-- Dimensión Tiempo
CREATE TABLE dw.dim_tiempo (
    tiempo_id SERIAL PRIMARY KEY,
    fecha DATE NOT NULL UNIQUE,
    dia INTEGER NOT NULL,
    mes INTEGER NOT NULL,
    anio INTEGER NOT NULL,
    trimestre INTEGER NOT NULL,
    dia_semana INTEGER NOT NULL,
    nombre_dia VARCHAR(10) NOT NULL,
    nombre_mes VARCHAR(10) NOT NULL,
    es_fin_semana BOOLEAN NOT NULL
);

-- Dimensión Producto
CREATE TABLE dw.dim_producto (
    producto_id SERIAL PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    subcategoria VARCHAR(50),
    precio_base DECIMAL(10,2) NOT NULL,
    costo DECIMAL(10,2) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT NOW(),
    fecha_actualizacion TIMESTAMP DEFAULT NOW()
);

-- Dimensión Cliente
CREATE TABLE dw.dim_cliente (
    cliente_id SERIAL PRIMARY KEY,
    identificacion VARCHAR(20) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    provincia VARCHAR(50) NOT NULL,
    canton VARCHAR(50),
    distrito VARCHAR(50),
    fecha_nacimiento DATE,
    segmento VARCHAR(50)
);

-- Dimensión Sucursal (CRUD que necesitas)
CREATE TABLE dw.dim_sucursal (
    sucursal_id SERIAL PRIMARY KEY,
    codigo VARCHAR(20) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    provincia VARCHAR(50) NOT NULL,
    canton VARCHAR(50) NOT NULL,
    distrito VARCHAR(50) NOT NULL,
    direccion_exacta TEXT,
    telefono VARCHAR(20),
    horario TEXT,
    fecha_apertura DATE NOT NULL,
    activa BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT NOW(),
    fecha_actualizacion TIMESTAMP DEFAULT NOW()
);

-- Tabla de Hechos Ventas
CREATE TABLE dw.fact_ventas (
    venta_id BIGSERIAL PRIMARY KEY,
    tiempo_id INTEGER REFERENCES dw.dim_tiempo(tiempo_id),
    producto_id INTEGER REFERENCES dw.dim_producto(producto_id),
    cliente_id INTEGER REFERENCES dw.dim_cliente(cliente_id),
    sucursal_id INTEGER REFERENCES dw.dim_sucursal(sucursal_id),
    cantidad_vendida INTEGER NOT NULL,
    monto_total DECIMAL(12,2) NOT NULL,
    descuento_total DECIMAL(12,2) DEFAULT 0,
    costo_total DECIMAL(12,2) NOT NULL,
    margen_ganancia DECIMAL(12,2) NOT NULL,
    metodo_pago VARCHAR(50) NOT NULL
);

-- Índices para optimización
CREATE INDEX idx_fact_ventas_tiempo ON dw.fact_ventas(tiempo_id);
CREATE INDEX idx_fact_ventas_producto ON dw.fact_ventas(producto_id);
CREATE INDEX idx_fact_ventas_sucursal ON dw.fact_ventas(sucursal_id);
CREATE INDEX idx_fact_ventas_cliente ON dw.fact_ventas(cliente_id);