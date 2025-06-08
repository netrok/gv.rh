<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        @page {
            margin: 15mm;
            size: A4;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #2D3748;
            background: white;
        }
        
        .container {
            max-width: 100%;
            margin: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #4F46E5;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        
        .header .subtitle {
            color: #718096;
            font-size: 13px;
            margin: 3px 0;
        }
        
        .header .employee-name {
            color: #2D3748;
            font-size: 16px;
            font-weight: 600;
            margin: 8px 0 5px 0;
        }
        
        .main-content {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .photo-section {
            flex: 0 0 140px;
            text-align: center;
        }
        
        .photo-container {
            width: 120px;
            height: 120px;
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            overflow: hidden;
            background: linear-gradient(135deg, #F7FAFC 0%, #EDF2F7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .photo-placeholder {
            color: #A0AEC0;
            font-size: 10px;
            text-align: center;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 25px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-active {
            background: linear-gradient(135deg, #C6F6D5 0%, #9AE6B4 100%);
            color: #22543D;
            border: 1px solid #68D391;
        }
        
        .status-inactive {
            background: linear-gradient(135deg, #FED7D7 0%, #FBB6CE 100%);
            color: #742A2A;
            border: 1px solid #F56565;
        }
        
        .details-section {
            flex: 1;
        }
        
        .section {
            margin-bottom: 20px;
            break-inside: avoid;
        }
        
        .section-title {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
            padding: 10px 16px;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-radius: 6px 6px 0 0;
            margin-bottom: 0;
        }
        
        .section-content {
            border: 1px solid #E2E8F0;
            border-top: none;
            border-radius: 0 0 6px 6px;
            padding: 16px;
            background: #FAFAFA;
        }
        
        .field-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 8px 16px;
            align-items: start;
        }
        
        .field-label {
            font-weight: 600;
            color: #4A5568;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 4px 0;
        }
        
        .field-value {
            color: #2D3748;
            font-size: 11px;
            padding: 4px 0;
            word-break: break-word;
        }
        
        .field-value strong {
            font-weight: 700;
            color: #1A202C;
        }
        
        .field-value.monospace {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            background: #F7FAFC;
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid #E2E8F0;
        }
        
        .subordinados-section {
            margin-top: 20px;
        }
        
        .subordinados-grid {
            display: grid;
            gap: 8px;
            margin-top: 12px;
        }
        
        .subordinado-item {
            display: grid;
            grid-template-columns: 2fr 1.5fr 1fr;
            gap: 12px;
            padding: 12px;
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 6px;
            align-items: center;
        }
        
        .subordinado-item:hover {
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .subordinado-name {
            font-weight: 600;
            color: #2D3748;
            font-size: 11px;
        }
        
        .subordinado-puesto {
            color: #4A5568;
            font-size: 10px;
        }
        
        .subordinado-numero {
            color: #718096;
            font-size: 10px;
            font-family: 'Courier New', monospace;
            text-align: right;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #718096;
            border-top: 1px solid #E2E8F0;
            padding-top: 15px;
            page-break-inside: avoid;
        }
        
        .footer p {
            margin: 2px 0;
        }
        
        /* Mejoras para impresión */
        @media print {
            body { 
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .main-content {
                display: block;
            }
            
            .photo-section {
                float: left;
                margin-right: 20px;
                margin-bottom: 20px;
            }
            
            .details-section {
                overflow: hidden;
            }
        }
        
        /* Responsive para pantallas pequeñas */
        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }
            
            .photo-section {
                flex: none;
                margin-bottom: 20px;
            }
            
            .field-grid {
                grid-template-columns: 1fr;
                gap: 4px;
            }
            
            .field-label {
                font-weight: bold;
                margin-bottom: 2px;
            }
            
            .subordinado-item {
                grid-template-columns: 1fr;
                gap: 4px;
                text-align: center;
            }
            
            .subordinado-numero {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>REPORTE DE EMPLEADO</h1>
            <div class="employee-name">{{ $empleado->nombres }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</div>
            <p class="subtitle">Generado el: {{ $fecha_generacion }}</p>
        </div>

        <div class="main-content">
            <div class="photo-section">
                <div class="photo-container">
                    @if($empleado->foto_base64)
                        <img src="{{ $empleado->foto_base64 }}" alt="Foto del empleado">
                    @else
                        <div class="photo-placeholder">
                            Sin foto<br>disponible
                        </div>
                    @endif
                </div>
                
                <div class="status-badge {{ $empleado->activo ? 'status-active' : 'status-inactive' }}">
                    {{ $empleado->activo ? 'Activo' : 'Inactivo' }}
                </div>
            </div>

            <div class="details-section">
                <!-- Información Personal -->
                <div class="section">
                    <h3 class="section-title">Información Personal</h3>
                    <div class="section-content">
                        <div class="field-grid">
                            <div class="field-label">Número de Empleado:</div>
                            <div class="field-value"><strong>{{ $empleado->num_empleado }}</strong></div>
                            
                            <div class="field-label">Nombres:</div>
                            <div class="field-value">{{ $empleado->nombres }}</div>
                            
                            <div class="field-label">Apellido Paterno:</div>
                            <div class="field-value">{{ $empleado->apellido_paterno }}</div>
                            
                            <div class="field-label">Apellido Materno:</div>
                            <div class="field-value">{{ $empleado->apellido_materno ?? 'No especificado' }}</div>
                            
                            <div class="field-label">Fecha de Nacimiento:</div>
                            <div class="field-value">{{ \Carbon\Carbon::parse($empleado->fecha_nacimiento)->format('d/m/Y') }}</div>
                            
                            <div class="field-label">Edad:</div>
                            <div class="field-value">{{ \Carbon\Carbon::parse($empleado->fecha_nacimiento)->age }} años</div>
                            
                            <div class="field-label">Género:</div>
                            <div class="field-value">{{ $empleado->genero }}</div>
                            
                            <div class="field-label">Estado Civil:</div>
                            <div class="field-value">{{ str_replace('_', ' ', $empleado->estado_civil) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Información Legal -->
                <div class="section">
                    <h3 class="section-title">Información Legal</h3>
                    <div class="section-content">
                        <div class="field-grid">
                            <div class="field-label">CURP:</div>
                            <div class="field-value monospace">{{ $empleado->curp }}</div>
                            
                            <div class="field-label">RFC:</div>
                            <div class="field-value monospace">{{ $empleado->rfc }}</div>
                            
                            <div class="field-label">NSS:</div>
                            <div class="field-value monospace">{{ $empleado->nss ?? 'No especificado' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="section">
                    <h3 class="section-title">Información de Contacto</h3>
                    <div class="section-content">
                        <div class="field-grid">
                            <div class="field-label">Teléfono:</div>
                            <div class="field-value">{{ $empleado->telefono ?? 'No especificado' }}</div>
                            
                            <div class="field-label">Correo Electrónico:</div>
                            <div class="field-value">{{ $empleado->email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Información Laboral -->
                <div class="section">
                    <h3 class="section-title">Información Laboral</h3>
                    <div class="section-content">
                        <div class="field-grid">
                            <div class="field-label">Puesto:</div>
                            <div class="field-value">{{ $empleado->puesto->nombre ?? 'No asignado' }}</div>
                            
                            <div class="field-label">Departamento:</div>
                            <div class="field-value">{{ $empleado->departamento->nombre ?? 'No asignado' }}</div>
                            
                            <div class="field-label">Jefe Directo:</div>
                            <div class="field-value">
                                @if($empleado->jefe)
                                    {{ $empleado->jefe->nombres }} {{ $empleado->jefe->apellido_paterno }}
                                @else
                                    No asignado
                                @endif
                            </div>
                            
                            <div class="field-label">Fecha de Ingreso:</div>
                            <div class="field-value">{{ \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') }}</div>
                            
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
                    <div class="section subordinados-section">
                        <h3 class="section-title">Empleados a Cargo ({{ $empleado->subordinados->count() }})</h3>
                        <div class="section-content">
                            <div class="subordinados-grid">
                                @foreach($empleado->subordinados as $subordinado)
                                    <div class="subordinado-item">
                                        <div class="subordinado-name">
                                            {{ $subordinado->nombres }} {{ $subordinado->apellido_paterno }}
                                        </div>
                                        <div class="subordinado-puesto">
                                            {{ $subordinado->puesto->nombre ?? 'Sin puesto' }}
                                        </div>
                                        <div class="subordinado-numero">
                                            {{ $subordinado->num_empleado }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="footer">
            <p>Este documento fue generado automáticamente el {{ $fecha_generacion }}</p>
            <p>Sistema de Gestión de Empleados</p>
        </div>
    </div>
</body>
</html>