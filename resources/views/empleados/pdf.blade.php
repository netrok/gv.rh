<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #4F46E5;
            margin: 0;
            font-size: 24px;
        }
        
        .header .subtitle {
            color: #6B7280;
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        
        .employee-info {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .photo-section {
            display: table-cell;
            width: 150px;
            vertical-align: top;
            text-align: center;
            padding-right: 20px;
        }
        
        .photo-placeholder {
            width: 120px;
            height: 120px;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #F9FAFB;
            margin: 0 auto;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            margin-top: 10px;
        }
        
        .status-active {
            background-color: #D1FAE5;
            color: #065F46;
        }
        
        .status-inactive {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .details-section {
            display: table-cell;
            vertical-align: top;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            background-color: #4F46E5;
            color: white;
            padding: 8px 12px;
            margin: 0 0 15px 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        .field-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        
        .field-row {
            display: table-row;
        }
        
        .field-label {
            display: table-cell;
            width: 30%;
            padding: 6px 12px 6px 0;
            font-weight: bold;
            color: #6B7280;
            vertical-align: top;
        }
        
        .field-value {
            display: table-cell;
            padding: 6px 0;
            color: #111827;
            vertical-align: top;
        }
        
        .subordinados-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .subordinado-row {
            display: table-row;
            border-bottom: 1px solid #E5E7EB;
        }
        
        .subordinado-cell {
            display: table-cell;
            padding: 8px 12px 8px 0;
            vertical-align: middle;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #6B7280;
            border-top: 1px solid #E5E7EB;
            padding-top: 15px;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE EMPLEADO</h1>
        <p class="subtitle">{{ $empleado->nombres }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</p>
        <p class="subtitle">Generado el: {{ $fecha_generacion }}</p>
    </div>

    <div class="employee-info">
        <div class="photo-section">
            @if($empleado->foto && file_exists(public_path('storage/' . $empleado->foto)))
                <img src="{{ public_path('storage/' . $empleado->foto) }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 2px solid #E5E7EB;">
            @else
                <div class="photo-placeholder">
                    <span style="color: #9CA3AF; font-size: 10px;">Sin foto</span>
                </div>
            @endif
            
            <div class="status-badge {{ $empleado->activo ? 'status-active' : 'status-inactive' }}">
                {{ $empleado->activo ? 'ACTIVO' : 'INACTIVO' }}
            </div>
        </div>

        <div class="details-section">
            <!-- Información Personal -->
            <div class="section">
                <h3 class="section-title">INFORMACIÓN PERSONAL</h3>
                <div class="field-grid">
                    <div class="field-row">
                        <div class="field-label">Número de Empleado:</div>
                        <div class="field-value"><strong>{{ $empleado->num_empleado }}</strong></div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">Nombres:</div>
                        <div class="field-value">{{ $empleado->nombres }}</div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">Apellido Paterno:</div>
                        <div class="field-value">{{ $empleado->apellido_paterno }}</div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">Apellido Materno:</div>
                        <div class="field-value">{{ $empleado->apellido_materno ?? 'No especificado' }}</div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">Fecha de Nacimiento:</div>
                        <div class="field-value">{{ \Carbon\Carbon::parse($empleado->fecha_nacimiento)->format('d/m/Y') }}</div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">Edad:</div>
                        <div class="field-value">{{ \Carbon\Carbon::parse($empleado->fecha_nacimiento)->age }} años</div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">Género:</div>
                        <div class="field-value">{{ $empleado->genero }}</div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">Estado Civil:</div>
                        <div class="field-value">{{ str_replace('_', ' ', $empleado->estado_civil) }}</div>
                    </div>
                </div>
            </div>

            <!-- Información Legal -->
            <div class="section">
                <h3 class="section-title">INFORMACIÓN LEGAL</h3>
                <div class="field-grid">
                    <div class="field-row">
                        <div class="field-label">CURP:</div>
                        <div class="field-value" style="font-family: monospace;">{{ $empleado->curp }}</div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">RFC:</div>
                        <div class="field-value" style="font-family: monospace;">{{ $empleado->rfc }}</div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">NSS:</div>
                        <div class="field-value" style="font-family: monospace;">{{ $empleado->nss ?? 'No especificado' }}</div>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="section">
                <h3 class="section-title">INFORMACIÓN DE CONTACTO</h3>
                <div class="field-grid">
                    <div class="field-row">
                        <div class="field-label">Teléfono:</div>
                        <div class="field-value">{{ $empleado->telefono ?? 'No especificado' }}</div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">Correo Electrónico:</div>
                        <div class="field-value">{{ $empleado->email }}</div>
                    </div>
                </div>
            </div>

            <!-- Información Laboral -->
            <div class="section">
                <h3 class="section-title">INFORMACIÓN LABORAL</h3>
                <div class="field-grid">
                    <div class="field-row">
                        <div class="field-label">Puesto:</div>
                        <div class="field-value">{{ $empleado->puesto->nombre ?? 'No asignado' }}</div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">Departamento:</div>
                        <div class="field-value">{{ $empleado->departamento->nombre ?? 'No asignado' }}</div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">Jefe Directo:</div>
                        <div class="field-value">
                            @if($empleado->jefe)
                                {{ $empleado->jefe->nombres }} {{ $empleado->jefe->apellido_paterno }}
                            @else
                                No asignado
                            @endif
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">Fecha de Ingreso:</div>
                        <div class="field-value">{{ \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') }}</div>
                    </div>
                    <div class="field-row">
                        <div class="field-label">Tiempo en la empresa:</div>
                        <div class="field-value">
                            @php
                                $fechaIngreso = \Carbon\Carbon::parse($empleado->fecha_ingreso);
                                $años = $fechaIngreso->diffInYears(now());
                                $meses = $fechaIngreso->copy()->addYears($años)->diffInMonths(now());
                            @endphp
                            {{ $años }} años, {{ $meses }} meses
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empleados a Cargo -->
            @if($empleado->subordinados && $empleado->subordinados->count() > 0)
                <div class="section">
                    <h3 class="section-title">EMPLEADOS A CARGO ({{ $empleado->subordinados->count() }})</h3>
                    <div class="subordinados-grid">
                        @foreach($empleado->subordinados as $subordinado)
                            <div class="subordinado-row">
                                <div class="subordinado-cell" style="width: 40%;">
                                    <strong>{{ $subordinado->nombres }} {{ $subordinado->apellido_paterno }}</strong>
                                </div>
                                <div class="subordinado-cell" style="width: 30%;">
                                    {{ $subordinado->puesto->nombre ?? 'Sin puesto' }}
                                </div>
                                <div class="subordinado-cell" style="width: 30%;">
                                    {{ $subordinado->num_empleado }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="footer">
        <p>Este documento fue generado automáticamente el {{ $fecha_generacion }}</p>
        <p>Sistema de Gestión de Empleados</p>
    </div>
</body>
</html>