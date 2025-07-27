-- Script de inicialización para el Data Warehouse OLAP
CREATE SCHEMA dw;

-- Dimensión Tiempo
CREATE TABLE dw.dim_tiempo (
    tiempo_id SERIAL PRIMARY KEY,
    fecha DATE NOT NULL,
    dia INTEGER NOT NULL,
    mes INTEGER NOT NULL,
    año INTEGER NOT NULL,
    trimestre INTEGER NOT NULL,
    dia_semana INTEGER NOT NULL,
    nombre_dia VARCHAR(10) NOT NULL,
    nombre_mes VARCHAR(10) NOT NULL,
    es_fin_de_semana BOOLEAN NOT NULL,
    UNIQUE(fecha)
);

-- Dimensión Producto
CREATE TABLE dw.dim_producto (
    producto_id SERIAL PRIMARY KEY,
    codigo_producto VARCHAR(50) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    subcategoria VARCHAR(50),
    precio NUMERIC(10,2) NOT NULL,
    UNIQUE(codigo_producto)
);

-- Dimensión Cliente
CREATE TABLE dw.dim_cliente (
    cliente_id SERIAL PRIMARY KEY,
    codigo_cliente VARCHAR(50) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    provincia VARCHAR(50) NOT NULL,
    ciudad VARCHAR(50) NOT NULL,
    segmento VARCHAR(50),
    UNIQUE(codigo_cliente)
);

-- Dimensión Sucursal
CREATE TABLE dw.dim_sucursal (
    sucursal_id SERIAL PRIMARY KEY,
    codigo_sucursal VARCHAR(50) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    provincia VARCHAR(50) NOT NULL,
    ciudad VARCHAR(50) NOT NULL,
    direccion VARCHAR(200),
    UNIQUE(codigo_sucursal)
);

-- Tabla de Hechos Ventas
CREATE TABLE dw.fact_ventas (
    venta_id SERIAL PRIMARY KEY,
    tiempo_id INTEGER REFERENCES dw.dim_tiempo(tiempo_id),
    producto_id INTEGER REFERENCES dw.dim_producto(producto_id),
    cliente_id INTEGER REFERENCES dw.dim_cliente(cliente_id),
    sucursal_id INTEGER REFERENCES dw.dim_sucursal(sucursal_id),
    cantidad_vendida INTEGER NOT NULL,
    monto_total NUMERIC(12,2) NOT NULL,
    costo_total NUMERIC(12,2) NOT NULL,
    margen NUMERIC(12,2) NOT NULL
);

-- Crear índices para mejorar el rendimiento OLAP
CREATE INDEX idx_fact_ventas_tiempo ON dw.fact_ventas(tiempo_id);
CREATE INDEX idx_fact_ventas_producto ON dw.fact_ventas(producto_id);
CREATE INDEX idx_fact_ventas_cliente ON dw.fact_ventas(cliente_id);
CREATE INDEX idx_fact_ventas_sucursal ON dw.fact_ventas(sucursal_id);
CREATE INDEX idx_dim_tiempo_fecha ON dw.dim_tiempo(fecha);
