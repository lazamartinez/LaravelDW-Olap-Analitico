-- docker/postgresql/init.sql

CREATE SCHEMA IF NOT EXISTS dw;

-- Dimensión Tiempo
CREATE TABLE IF NOT EXISTS dw.dim_tiempo (
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
CREATE TABLE IF NOT EXISTS dw.dim_producto (
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
CREATE TABLE IF NOT EXISTS dw.dim_cliente (
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

-- Dimensión Sucursal
CREATE TABLE IF NOT EXISTS dw.dim_sucursal (
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

-- Tabla de Hechos Ventas particionada por rango en tiempo_id
DROP TABLE IF EXISTS dw.fact_ventas CASCADE;

CREATE TABLE dw.fact_ventas (
    venta_id BIGSERIAL,
    tiempo_id INTEGER NOT NULL,
    producto_id INTEGER NOT NULL,
    cliente_id INTEGER NOT NULL,
    sucursal_id INTEGER NOT NULL,
    cantidad_vendida INTEGER NOT NULL,
    monto_total DECIMAL(12,2) NOT NULL,
    descuento_total DECIMAL(12,2) DEFAULT 0,
    costo_total DECIMAL(12,2) NOT NULL,
    margen_ganancia DECIMAL(12,2) NOT NULL,
    metodo_pago VARCHAR(50) NOT NULL,
    PRIMARY KEY (venta_id, tiempo_id)
) PARTITION BY RANGE (tiempo_id);

-- Partición genérica (puedes crear particiones específicas por rango)
CREATE TABLE IF NOT EXISTS dw.fact_ventas_2023 PARTITION OF dw.fact_ventas
    FOR VALUES FROM (MINVALUE) TO (MAXVALUE);

-- Índices para optimización
CREATE INDEX IF NOT EXISTS idx_dim_producto_categoria ON dw.dim_producto(categoria);
CREATE INDEX IF NOT EXISTS idx_dim_tiempo_anio_mes ON dw.dim_tiempo(anio, mes);
CREATE INDEX IF NOT EXISTS idx_fact_ventas_metodo_pago ON dw.fact_ventas(metodo_pago);

CREATE INDEX IF NOT EXISTS idx_fact_ventas_producto ON dw.fact_ventas(producto_id);
CREATE INDEX IF NOT EXISTS idx_fact_ventas_sucursal ON dw.fact_ventas(sucursal_id);
CREATE INDEX IF NOT EXISTS idx_fact_ventas_cliente ON dw.fact_ventas(cliente_id);
CREATE INDEX IF NOT EXISTS idx_fact_ventas_tiempo ON dw.fact_ventas(tiempo_id);

-- Vista materializada para consultas frecuentes
CREATE MATERIALIZED VIEW IF NOT EXISTS dw.mv_sales_by_category_month AS
SELECT 
    p.categoria,
    t.anio,
    t.mes,
    SUM(f.monto_total) AS ventas_totales,
    SUM(f.cantidad_vendida) AS unidades_vendidas
FROM dw.fact_ventas f
JOIN dw.dim_producto p ON f.producto_id = p.producto_id
JOIN dw.dim_tiempo t ON f.tiempo_id = t.tiempo_id
GROUP BY p.categoria, t.anio, t.mes;