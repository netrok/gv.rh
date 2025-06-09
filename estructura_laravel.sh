#!/bin/bash

# Archivo de salida
OUTPUT="estructura_laravel.txt"
echo "í³¦ ESTRUCTURA DE LA APLICACIÃ“N LARAVEL" > $OUTPUT
echo "Generado el: $(date)" >> $OUTPUT
echo "--------------------------------------" >> $OUTPUT

# Migraciones
echo -e "\ní·± MIGRACIONES:" >> $OUTPUT
find database/migrations -type f -name "*.php" >> $OUTPUT

# Modelos
echo -e "\ní³˜ MODELOS:" >> $OUTPUT
find app/Models -type f -name "*.php" >> $OUTPUT

# Controladores
echo -e "\ní¾® CONTROLADORES:" >> $OUTPUT
find app/Http/Controllers -type f -name "*.php" >> $OUTPUT

# Vistas Blade
echo -e "\ní¶¼ï¸ VISTAS BLADE (.blade.php):" >> $OUTPUT
find resources/views -type f -name "*.blade.php" >> $OUTPUT

# Rutas
echo -e "\ní»£ï¸ RUTAS:" >> $OUTPUT
if [ -f "routes/web.php" ]; then
    echo "routes/web.php" >> $OUTPUT
fi
if [ -f "routes/api.php" ]; then
    echo "routes/api.php" >> $OUTPUT
fi

# Final
echo -e "\nâœ… Estructura guardada en $OUTPUT"
