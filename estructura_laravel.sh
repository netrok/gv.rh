#!/bin/bash

# Archivo de salida
OUTPUT="estructura_laravel.txt"
echo "� ESTRUCTURA DE LA APLICACIÓN LARAVEL" > $OUTPUT
echo "Generado el: $(date)" >> $OUTPUT
echo "--------------------------------------" >> $OUTPUT

# Migraciones
echo -e "\n� MIGRACIONES:" >> $OUTPUT
find database/migrations -type f -name "*.php" >> $OUTPUT

# Modelos
echo -e "\n� MODELOS:" >> $OUTPUT
find app/Models -type f -name "*.php" >> $OUTPUT

# Controladores
echo -e "\n� CONTROLADORES:" >> $OUTPUT
find app/Http/Controllers -type f -name "*.php" >> $OUTPUT

# Vistas Blade
echo -e "\n�️ VISTAS BLADE (.blade.php):" >> $OUTPUT
find resources/views -type f -name "*.blade.php" >> $OUTPUT

# Rutas
echo -e "\n�️ RUTAS:" >> $OUTPUT
if [ -f "routes/web.php" ]; then
    echo "routes/web.php" >> $OUTPUT
fi
if [ -f "routes/api.php" ]; then
    echo "routes/api.php" >> $OUTPUT
fi

# Final
echo -e "\n✅ Estructura guardada en $OUTPUT"
