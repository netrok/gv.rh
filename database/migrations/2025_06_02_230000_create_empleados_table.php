<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('num_empleado')->unique();

            // Información personal con longitudes específicas
            $table->string('nombres', 100);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50)->nullable();

            $table->date('fecha_nacimiento');
            $table->enum('genero', ['M', 'F']); // Consistente con las reglas del modelo
            $table->enum('estado_civil', ['Soltero', 'Casado', 'Divorciado', 'Viudo', 'Union_Libre']);

            // Documentos oficiales con longitudes exactas y únicos
            $table->string('curp', 18)->unique();
            $table->string('rfc', 13)->unique();
            $table->string('nss', 11)->nullable();

            // Contacto
            $table->string('telefono', 15)->nullable();
            $table->string('email')->unique();

            // Relaciones laborales
            $table->foreignId('puesto_id')
                ->constrained('puestos')
                ->onDelete('restrict'); // Cambié a restrict para evitar eliminaciones accidentales

            $table->foreignId('departamento_id')
                ->constrained('departamentos')
                ->onDelete('restrict'); // Cambié a restrict

            // Relación jerárquica (jefe)
            $table->unsignedBigInteger('jefe_id')->nullable();
            $table->foreign('jefe_id')
                ->references('id')
                ->on('empleados')
                ->onDelete('set null');

            // Información laboral
            $table->date('fecha_ingreso');
            $table->boolean('activo')->default(true);

            $table->string('foto')->nullable();

            $table->timestamps();
            $table->softDeletes(); // Para eliminación suave

            // Índices adicionales para optimizar consultas
            $table->index('activo');
            $table->index('departamento_id');
            $table->index('puesto_id');
            $table->index(['apellido_paterno', 'apellido_materno', 'nombres']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};