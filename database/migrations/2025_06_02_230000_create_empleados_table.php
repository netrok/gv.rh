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

            $table->string('nombres');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();

            $table->date('fecha_nacimiento')->nullable();
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable();
            $table->string('estado_civil')->nullable();

            $table->string('curp', 18)->nullable();
            $table->string('rfc', 13)->nullable();
            $table->string('nss', 15)->nullable();

            $table->string('telefono', 20)->nullable();
            $table->string('email')->unique()->nullable();

            // Definimos claves foráneas con constrained() apuntando a tablas existentes
            $table->foreignId('puesto_id')
                ->constrained('puestos')  // explícito, por claridad
                ->onDelete('cascade');

            $table->foreignId('departamento_id')
                ->constrained('departamentos')  // explícito, para evitar errores
                ->onDelete('cascade');

            // Para jefe_id, si quieres clave foránea, agregar así:
            $table->unsignedBigInteger('jefe_id')->nullable();
            $table->foreign('jefe_id')
                ->references('id')
                ->on('empleados')
                ->onDelete('set null');

            $table->date('fecha_ingreso')->nullable();
            $table->boolean('activo')->default(true);

            $table->string('foto')->nullable();

            $table->timestamps();
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
