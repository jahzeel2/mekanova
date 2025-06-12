<?php
namespace App\Http\Controllers\Reportes2;

use App\Models\Cliente; // Asegúrate que el modelo Cliente esté importado
use Illuminate\Http\Request; // Aunque no se use en este método, es común en controladores
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; // Para consultas raw o complejas
use Illuminate\View\View; // Para el tipo de retorno de la vista

class ReportesController extends Controller
{
    /**
     * Muestra el reporte de ventas por cliente, ordenado por el total comprado.
     *
     * @return \Illuminate\View\View
     */
    public function ventasPorCliente(): View
    {
        // Consulta para obtener clientes con el total de sus compras.
        // Se asume que 'detalle_ventas' tiene 'cantidad' y 'precio_unitario'.
        $clientesConTotalCompras = Cliente::query()
            ->select([
                'clientes.idcliente',
                'clientes.nombre', // Asegúrate que este campo exista y sea el correcto en tu tabla clientes
                // Puedes añadir otros campos del cliente aquí si los necesitas en la vista
                // E.g., 'clientes.apellido', 'clientes.email'
                DB::raw('SUM(COALESCE(detalle_ventas.cantidad, 0) * COALESCE(detalle_ventas.subtotal, 0)) as total_comprado_cliente')
            ])
            ->join('ventas', 'clientes.idcliente', '=', 'ventas.cliente_id')
            ->join('detalle_ventas', 'ventas.idventa', '=', 'detalle_ventas.venta_id')
            ->groupBy('clientes.idcliente', 'clientes.nombre') // Agrupa por los campos no agregados del cliente
            ->orderByDesc('total_comprado_cliente')
            ->get();

        // Alternativa si la tabla 'ventas' ya tiene un campo 'total' fiable por cada venta:
        /*
        $clientesConTotalCompras = Cliente::query()
            ->select([
                'clientes.id',
                'clientes.nombre',
                DB::raw('SUM(COALESCE(ventas.total, 0)) as total_comprado_cliente') // Asume que 'ventas.total' existe y es fiable
            ])
            ->join('ventas', 'clientes.id', '=', 'ventas.cliente_id')
            ->groupBy('clientes.id', 'clientes.nombre')
            ->orderByDesc('total_comprado_cliente')
            ->get();
        */

        // Pasar los datos a la vista
        return view('reportes2.ventas_por_cliente', [
            'clientesReporte' => $clientesConTotalCompras
        ]);
    }
}