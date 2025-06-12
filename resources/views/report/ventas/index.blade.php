@extends('layouts.admin')
@section('contenido')
    
    
    <div class="container mt-4">
        <h1>Reporte de Ventas por Cliente</h1>
        <p class="text-muted text-center mb-4">Clientes ordenados del que más compró al que menos compró.</p>

        @if($clientesReporte->isEmpty())
            <div class="alert alert-info text-center" role="alert">
                No hay datos de ventas para mostrar en este reporte.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID Cliente</th>
                            <th scope="col">Nombre del Cliente</th>
                            <th scope="col" class="text-end">Total Comprado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientesReporte as $index => $reporte)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $reporte->id }}</td>
                                <td>{{ $reporte->nombre ?? 'N/A' }}</td>
                                <td class="text-end">${{ number_format($reporte->total_comprado_cliente, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

