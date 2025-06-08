<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Departamentos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3B82F6;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #1F2937;
            font-size: 24px;
            margin: 0;
        }
        
        .header p {
            color: #6B7280;
            margin: 5px 0 0 0;
        }
        
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 25px;
            background-color: #F9FAFB;
            padding: 15px;
            border-radius: 8px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #1F2937;
        }
        
        .stat-label {
            font-size: 10px;
            color: #6B7280;
            margin-top: 5px;
        }
        
        .filters {
            background-color: #EFF6FF;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #3B82F6;
        }
        
        .filters h3 {
            margin: 0 0 8px 0;
            color: #1F2937;
            font-size: 14px;
        }
        
        .filter-item {
            margin: 3px 0;
            color: #374151;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th {
            background-color: #F3F4F6;
            color: #374151;
            font-weight: bold;
            padding: 12px 8px;
            text-align: left;
            border-bottom: 2px solid #D1D5DB;
            font-size: 11px;
        }
        
        .table td {
            padding: 10px 8px;
            border-bottom: 1px solid #E5E7EB;
            vertical-align: top;
        }
        
        .table tbody tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        
        .table tbody tr:hover {
            background-color: #F3F4F6;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            min-width: 60px;
        }
        
        .badge-active {
            background-color: #DCFCE7;
            color: #166534;
        }
        
        .badge-inactive {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .badge-count {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        
        .codigo {
            font-weight: bold;
            color: #1F2937;
        }
        
        .nombre {
            font-weight: 600;
            color: #374151;
        }
        
        .descripcion {
            color: #6B7280;
            font-style: italic;
        }
        
        .jefe {
            color: #059669;
        }
        
        .sin-jefe {
            color: #9CA3AF;
            font-style: italic;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #6B7280;
            font-size: 10px;
            border-top: 1px solid #E5E7EB;
            padding-top: 15px;
        }
        
        .no-data {
            text-align: center;
            color: #6B7280;
            font-style: italic;
            padding: 40px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Departamentos</h1>
        <p>Generado el {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Estadísticas -->
    <div class="stats">
        <div class="stat-item">
            <div class="stat-number">{{ $stats['total'] }}</div>
            <div class="stat-label">Total</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['activos'] }}</div>
            <div class="stat-label">Activos</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['inactivos'] }}</div>
            <div class="stat-label">Inactivos</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['con_jefe'] }}</div>
            <div class="stat-label">Con Jefe</div>
        </div>
    </div>

    <!-- Filtros aplicados -->
    @if(!empty($filtros))
        <div class="filters">
            <h3>Filtros Aplicados:</h3>
            @if(isset($filtros['busqueda']))
                <div class="filter-item">• Búsqueda: "{{ $filtros['busqueda'] }}"</div>
            @endif
            @if(isset($filtros['jefe']))
                <div class="filter-item">• Jefe: {{ $filtros['jefe'] }}</div>
            @endif
            @if(isset($filtros['estado']))
                <div class="filter-item">• Estado: {{ $filtros['estado'] }}</div>
            @endif
        </div>
    @endif

    <!-- Tabla de departamentos -->
    @if($departamentos->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 12%;">Código</th>
                    <th style="width: 20%;">Nombre</th>
                    <th style="width: 30%;">Descripción</th>
                    <th style="width: 20%;">Jefe</th>
                    <th style="width: 8%;">Empleados</th>
                    <th style="width: 10%;">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departamentos as $departamento)
                    <tr>
                        <td class="codigo">{{ $departamento->codigo }}</td>
                        <td class="nombre">{{ $departamento->nombre }}</td>
                        <td class="descripcion">
                            {{ $departamento->descripcion ?: 'Sin descripción' }}
                        </td>
                        <td>
                            @if($departamento->jefe)
                                <span class="jefe">
                                    {{ $departamento->jefe->nombres }} {{ $departamento->jefe->apellido_paterno }}
                                </span>
                            @else
                                <span class="sin-jefe">Sin asignar</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <span class="badge badge-count">{{ $departamento->empleados_count ?? 0 }}</span>
                        </td>
                        <td style="text-align: center;">
                            @if($departamento->activo)
                                <span class="badge badge-active">Activo</span>
                            @else
                                <span class="badge badge-inactive">Inactivo</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>No se encontraron departamentos que coincidan con los filtros aplicados.</p>
        </div>
    @endif

    <div class="footer">
        <p>Reporte generado automáticamente por el Sistema de Gestión de Departamentos</p>
        <p>Página 1 de 1 | Total de registros: {{ $departamentos->count() }}</p>
    </div>
</body>
</html>