<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\DimensionTime;
use App\Models\DimensionProduct;
use App\Models\DimensionCustomer;
use App\Models\DimensionStore;
use App\Models\FactSale;
use Carbon\Carbon;

class ETLProcess extends Command
{
    protected $signature = 'etl:run 
        {--full : Ejecutar carga completa}
        {--date= : Fecha específica para extracción (formato YYYY-MM-DD)}';

    protected $description = 'Ejecuta el proceso ETL para cargar datos al Data Warehouse';

    public function handle()
    {
        $this->info('Iniciando proceso ETL avanzado...');
        $startTime = microtime(true);

        try {
            DB::transaction(function () {
                $this->processDimensions();
                $this->processFacts();
            });

            $executionTime = round(microtime(true) - $startTime, 2);
            $this->info("Proceso ETL completado en {$executionTime} segundos.");

            // Registrar ejecución en log o tabla de control
            $this->logETLExecution(true, $executionTime);

        } catch (\Exception $e) {
            $this->error("Error en ETL: " . $e->getMessage());
            $this->logETLExecution(false, 0, $e->getMessage());
        }
    }

    protected function processDimensions()
    {
        $this->info('Procesando dimensiones...');

        // 1. Dimensión Tiempo (siempre se regenera completa)
        $this->processTimeDimension();

        // 2. Dimensión Productos (con SCD Tipo 2)
        $this->processProductsDimension();

        // 3. Dimensión Clientes (con SCD Tipo 2)
        $this->processCustomersDimension();

        // 4. Dimensión Sucursales (con SCD Tipo 2)
        $this->processStoresDimension();
    }

    protected function processTimeDimension()
    {
        $this->info('  > Procesando dimensión tiempo...');

        $startDate = Carbon::now()->subYears(5);
        $endDate = Carbon::now()->addYear();

        $currentDate = $startDate->copy();
        $inserted = 0;
        $updated = 0;

        while ($currentDate->lte($endDate)) {
            $formattedDate = $currentDate->format('Y-m-d');

            $result = DimensionTime::updateOrCreate(
                ['fecha' => $formattedDate],
                [
                    'dia' => $currentDate->day,
                    'mes' => $currentDate->month,
                    'anio' => $currentDate->year,
                    'trimestre' => ceil($currentDate->month / 3),
                    'dia_semana' => $currentDate->dayOfWeek,
                    'nombre_dia' => $currentDate->dayName,
                    'nombre_mes' => $currentDate->monthName,
                    'es_fin_semana' => $currentDate->isWeekend(),
                ]
            );

            $result->wasRecentlyCreated ? $inserted++ : $updated++;
            $currentDate->addDay();
        }

        $this->info("    ✔ Completado: {$inserted} insertados, {$updated} actualizados");
    }

    protected function processProductsDimension()
    {
        $this->info('  > Procesando dimensión productos (SCD Tipo 2)...');

        // Obtener productos nuevos o modificados desde las fuentes OLTP
        $newProducts = $this->getProductsFromOLTP();

        foreach ($newProducts as $product) {
            // Buscar si ya existe una versión activa del producto
            $existing = DimensionProduct::where('codigo', $product['codigo'])
                ->where('current', true)
                ->first();

            if ($existing) {
                // Verificar si hay cambios
                if ($this->productHasChanges($existing, $product)) {
                    // Marcar versión anterior como no actual
                    $existing->update(['current' => false, 'valid_to' => now()]);

                    // Crear nueva versión
                    DimensionProduct::create([
                        'codigo' => $product['codigo'],
                        'nombre' => $product['nombre'],
                        'categoria' => $product['categoria'],
                        'subcategoria' => $product['subcategoria'],
                        'precio_base' => $product['precio_base'],
                        'costo' => $product['costo'],
                        'current' => true,
                        'valid_from' => now(),
                        'valid_to' => null,
                        'version' => $existing->version + 1
                    ]);

                    $this->info("    ✔ Actualizado producto: {$product['codigo']} (versión " . ($existing->version + 1) . ")");
                }
            } else {
                // Nuevo producto
                DimensionProduct::create([
                    'codigo' => $product['codigo'],
                    'nombre' => $product['nombre'],
                    'categoria' => $product['categoria'],
                    'subcategoria' => $product['subcategoria'],
                    'precio_base' => $product['precio_base'],
                    'costo' => $product['costo'],
                    'current' => true,
                    'valid_from' => now(),
                    'valid_to' => null,
                    'version' => 1
                ]);

                $this->info("    ✔ Nuevo producto: {$product['codigo']}");
            }
        }
    }

    protected function productHasChanges($existing, $new)
    {
        return $existing->nombre != $new['nombre'] ||
               $existing->categoria != $new['categoria'] ||
               $existing->subcategoria != $new['subcategoria'] ||
               $existing->precio_base != $new['precio_base'] ||
               $existing->costo != $new['costo'];
    }

    protected function getProductsFromOLTP()
    {
        // Simulación: en realidad esto conectaría a las bases OLTP
        return [
            [
                'codigo' => 'PROD-001',
                'nombre' => 'Leche Entera 1L',
                'categoria' => 'Lácteos',
                'subcategoria' => 'Leche',
                'precio_base' => 1.20,
                'costo' => 0.80
            ],
            // ... más productos
        ];
    }

    protected function processCustomersDimension()
    {
        $this->info('  > Procesando dimensión clientes (SCD Tipo 2)...');

        // Simulación de clientes obtenidos desde OLTP
        $newCustomers = $this->getCustomersFromOLTP();

        foreach ($newCustomers as $customer) {
            $existing = DimensionCustomer::where('cliente_codigo', $customer['cliente_codigo'])
                ->where('current', true)
                ->first();

            if ($existing) {
                if ($this->customerHasChanges($existing, $customer)) {
                    $existing->update(['current' => false, 'valid_to' => now()]);

                    DimensionCustomer::create([
                        'cliente_codigo' => $customer['cliente_codigo'],
                        'nombre' => $customer['nombre'],
                        'apellido' => $customer['apellido'],
                        'email' => $customer['email'],
                        'telefono' => $customer['telefono'],
                        'direccion' => $customer['direccion'],
                        'current' => true,
                        'valid_from' => now(),
                        'valid_to' => null,
                        'version' => $existing->version + 1
                    ]);

                    $this->info("    ✔ Actualizado cliente: {$customer['cliente_codigo']} (versión " . ($existing->version + 1) . ")");
                }
            } else {
                DimensionCustomer::create([
                    'cliente_codigo' => $customer['cliente_codigo'],
                    'nombre' => $customer['nombre'],
                    'apellido' => $customer['apellido'],
                    'email' => $customer['email'],
                    'telefono' => $customer['telefono'],
                    'direccion' => $customer['direccion'],
                    'current' => true,
                    'valid_from' => now(),
                    'valid_to' => null,
                    'version' => 1
                ]);

                $this->info("    ✔ Nuevo cliente: {$customer['cliente_codigo']}");
            }
        }
    }

    protected function customerHasChanges($existing, $new)
    {
        return $existing->nombre != $new['nombre'] ||
               $existing->apellido != $new['apellido'] ||
               $existing->email != $new['email'] ||
               $existing->telefono != $new['telefono'] ||
               $existing->direccion != $new['direccion'];
    }

    protected function getCustomersFromOLTP()
    {
        // Simulación
        return [
            [
                'cliente_codigo' => 'CUST-001',
                'nombre' => 'Juan',
                'apellido' => 'Perez',
                'email' => 'juan.perez@example.com',
                'telefono' => '123456789',
                'direccion' => 'Calle Falsa 123'
            ],
            // ... más clientes
        ];
    }

    protected function processStoresDimension()
    {
        $this->info('  > Procesando dimensión sucursales (SCD Tipo 2)...');

        $newStores = $this->getStoresFromOLTP();

        foreach ($newStores as $store) {
            $existing = DimensionStore::where('codigo', $store['codigo'])
                ->where('current', true)
                ->first();

            if ($existing) {
                if ($this->storeHasChanges($existing, $store)) {
                    $existing->update(['current' => false, 'valid_to' => now()]);

                    DimensionStore::create([
                        'codigo' => $store['codigo'],
                        'nombre' => $store['nombre'],
                        'direccion' => $store['direccion'],
                        'ciudad' => $store['ciudad'],
                        'provincia' => $store['provincia'],
                        'current' => true,
                        'valid_from' => now(),
                        'valid_to' => null,
                        'version' => $existing->version + 1
                    ]);

                    $this->info("    ✔ Actualizada sucursal: {$store['codigo']} (versión " . ($existing->version + 1) . ")");
                }
            } else {
                DimensionStore::create([
                    'codigo' => $store['codigo'],
                    'nombre' => $store['nombre'],
                    'direccion' => $store['direccion'],
                    'ciudad' => $store['ciudad'],
                    'provincia' => $store['provincia'],
                    'current' => true,
                    'valid_from' => now(),
                    'valid_to' => null,
                    'version' => 1
                ]);

                $this->info("    ✔ Nueva sucursal: {$store['codigo']}");
            }
        }
    }

    protected function storeHasChanges($existing, $new)
    {
        return $existing->nombre != $new['nombre'] ||
               $existing->direccion != $new['direccion'] ||
               $existing->ciudad != $new['ciudad'] ||
               $existing->provincia != $new['provincia'];
    }

    protected function getStoresFromOLTP()
    {
        // Simulación
        return [
            [
                'codigo' => 'STORE-001',
                'nombre' => 'Sucursal Centro',
                'direccion' => 'Av. Principal 100',
                'ciudad' => 'Posadas',
                'provincia' => 'Misiones'
            ],
            // ... más sucursales
        ];
    }

    protected function processFacts()
    {
        $this->info('Procesando hechos...');

        // Obtener ventas nuevas desde las fuentes OLTP
        $newSales = $this->getNewSalesFromOLTP();

        $this->info("  > Procesando {$newSales->count()} registros de ventas...");

        $batchSize = 1000;
        $processed = 0;
        $batch = [];

        foreach ($newSales as $sale) {
            $batch[] = [
                'tiempo_id' => $this->getTimeId($sale['fecha']),
                'producto_id' => $this->getProductId($sale['producto_codigo']),
                'cliente_id' => $this->getCustomerId($sale['cliente_codigo']),
                'sucursal_id' => $this->getStoreId($sale['sucursal_codigo']),
                'cantidad_vendida' => $sale['cantidad'],
                'monto_total' => $sale['monto'],
                'descuento_total' => $sale['descuento'] ?? 0,
                'costo_total' => $sale['costo'] * $sale['cantidad'],
                'margen_ganancia' => $sale['monto'] - ($sale['costo'] * $sale['cantidad']),
                'metodo_pago' => $sale['metodo_pago']
            ];

            $processed++;

            if (count($batch) >= $batchSize) {
                FactSale::insert($batch);
                $batch = [];
                $this->info("    ✔ Lote procesado: {$processed}/{$newSales->count()}");
            }
        }

        // Insertar cualquier lote restante
        if (!empty($batch)) {
            FactSale::insert($batch);
        }

        $this->info("    ✔ Total ventas procesadas: {$processed}");
    }

    protected function getTimeId($date)
    {
        return DimensionTime::where('fecha', $date)->value('tiempo_id');
    }

    protected function getProductId($productCode)
    {
        return DimensionProduct::where('codigo', $productCode)
            ->where('current', true)
            ->value('producto_id');
    }

    protected function getCustomerId($customerCode)
    {
        return DimensionCustomer::where('cliente_codigo', $customerCode)
            ->where('current', true)
            ->value('cliente_id');
    }

    protected function getStoreId($storeCode)
    {
        return DimensionStore::where('codigo', $storeCode)
            ->where('current', true)
            ->value('sucursal_id');
    }

    protected function getNewSalesFromOLTP()
    {
        // Simulación de ventas nuevas
        return collect([
            [
                'fecha' => '2025-08-01',
                'producto_codigo' => 'PROD-001',
                'cliente_codigo' => 'CUST-001',
                'sucursal_codigo' => 'STORE-001',
                'cantidad' => 5,
                'monto' => 6.0,
                'descuento' => 0.0,
                'costo' => 0.8,
                'metodo_pago' => 'Tarjeta'
            ],
            // ... más ventas
        ]);
    }

    protected function logETLExecution($success, $executionTime, $error = null)
    {
        DB::table('etl_logs')->insert([
            'start_time' => now()->subSeconds($executionTime),
            'end_time' => now(),
            'duration' => $executionTime,
            'type' => $this->option('full') ? 'full' : 'incremental',
            'success' => $success,
            'records_processed' => 0, // Podría llevar conteo real
            'error_message' => $error,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}