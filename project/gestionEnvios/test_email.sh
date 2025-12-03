#!/bin/bash

# Script para probar el envío de emails con Brevo
# Ejecutar dentro del contenedor Docker: docker exec -it app bash
# Luego: cd /var/www/html && bash test_email.sh

echo "🧪 Iniciando prueba de envío de emails..."
echo ""

php artisan tinker << 'EOF'

// Crear o encontrar emisor
$sender = App\Models\Cliente::firstOrCreate(
    ['email' => 'villatoro503.manu@gmail.com'],
    [
        'nombre' => 'Manuel',
        'apellido' => 'Villatoro',
        'direccion' => 'San Salvador, El Salvador',
        'telefono' => '7777-7777',
        'dui' => '12345678-9'
    ]
);

// Crear o encontrar receptor
$receiver = App\Models\Cliente::firstOrCreate(
    ['email' => 'cvillatoro@gmail.com'],
    [
        'nombre' => 'Carlos',
        'apellido' => 'Villatoro',
        'direccion' => 'Santa Ana, El Salvador',
        'telefono' => '8888-8888',
        'dui' => '98765432-1'
    ]
);

echo "✅ Clientes creados/encontrados\n";
echo "   Emisor: {$sender->nombre} {$sender->apellido} ({$sender->email})\n";
echo "   Receptor: {$receiver->nombre} {$receiver->apellido} ({$receiver->email})\n\n";

// Crear paquete
$paquete = App\Models\Paquete::create([
    'codigo' => 'PKG' . str_pad(App\Models\Paquete::count() + 1, 6, '0', STR_PAD_LEFT),
    'descripcion' => 'Paquete de prueba para testing de emails con Brevo',
    'peso' => 5.5,
    'dimensiones' => '30x20x15',
    'tipo_envio_id' => 1,
    'latitud' => 13.6929,
    'longitud' => -89.2182,
]);

echo "✅ Paquete creado: {$paquete->codigo}\n\n";

// Vincular emisor
App\Models\EnvioCliente::create([
    'cliente_id' => $sender->id,
    'paquete_id' => $paquete->id,
    'tipo_cliente' => 'emisor',
]);

// Vincular receptor
App\Models\EnvioCliente::create([
    'cliente_id' => $receiver->id,
    'paquete_id' => $paquete->id,
    'tipo_cliente' => 'receptor',
]);

// Crear envío
$envio = App\Models\Envio::create([
    'paquete_id' => $paquete->id,
    'fecha_estimada' => now()->addDays(3)->format('Y-m-d'),
    'estado_envio_id' => 1,
    'costo' => 15.50,
]);

echo "✅ Envío creado\n\n";
echo "📧 Enviando correos electrónicos...\n\n";

// Enviar emails
try {
    // Email al emisor
    if ($sender->email) {
        Illuminate\Support\Facades\Mail::to($sender->email)->send(
            new App\Mail\PackageCreatedMail($paquete, $sender, 'emisor', $receiver)
        );
        echo "   ✅ Email enviado al emisor: {$sender->email}\n";
    }
    
    // Email al receptor
    if ($receiver->email) {
        Illuminate\Support\Facades\Mail::to($receiver->email)->send(
            new App\Mail\PackageCreatedMail($paquete, $receiver, 'receptor', $sender)
        );
        echo "   ✅ Email enviado al receptor: {$receiver->email}\n";
    }
    
    echo "\n🎉 ¡Prueba completada exitosamente!\n";
    echo "📦 Paquete: {$paquete->codigo}\n";
    echo "💰 Costo: \${$envio->costo}\n";
    echo "📅 Fecha estimada: {$envio->fecha_estimada}\n\n";
    echo "👉 Revisa las bandejas de entrada de:\n";
    echo "   - villatoro503.manu@gmail.com\n";
    echo "   - cvillatoro@gmail.com\n\n";
    
} catch (Exception $e) {
    echo "\n❌ Error al enviar emails:\n";
    echo "   {$e->getMessage()}\n\n";
    echo "💡 Revisa los logs para más detalles:\n";
    echo "   tail -f storage/logs/laravel.log\n\n";
}

EOF

echo ""
echo "✅ Script completado"
