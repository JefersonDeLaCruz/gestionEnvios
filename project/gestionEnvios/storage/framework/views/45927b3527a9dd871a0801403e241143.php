<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Envío</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 30px 20px;
        }

        .tracking-code {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .tracking-code h2 {
            margin: 0 0 10px 0;
            color: #667eea;
            font-size: 18px;
        }

        .tracking-code .code {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
        }

        .info-section {
            margin: 25px 0;
        }

        .info-section h3 {
            color: #667eea;
            font-size: 16px;
            margin-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #666;
            min-width: 140px;
        }

        .info-value {
            color: #333;
        }

        .alert {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .alert p {
            margin: 0;
            color: #856404;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .footer p {
            margin: 5px 0;
        }

        @media only screen and (max-width: 600px) {
            .info-row {
                flex-direction: column;
            }

            .info-label {
                min-width: auto;
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📦 Confirmación de Envío</h1>
            <p style="margin: 10px 0 0 0; font-size: 16px;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($clienteTipo === 'emisor'): ?>
                Tu paquete ha sido registrado exitosamente
                <?php else: ?>
                Recibirás un paquete próximamente
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </p>
        </div>

        <div class="content">
            <p>Hola <strong><?php echo e($cliente->nombre); ?> <?php echo e($cliente->apellido); ?></strong>,</p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($clienteTipo === 'emisor'): ?>
            <p>Tu paquete ha sido registrado en nuestro sistema y está listo para ser procesado. A continuación encontrarás los detalles de tu envío:</p>
            <?php else: ?>
            <p>Se ha registrado un paquete que será entregado a tu dirección. A continuación encontrarás los detalles del envío:</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="tracking-code">
                <h2>Código de Seguimiento</h2>
                <div class="code"><?php echo e($paquete->codigo); ?></div>
                <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
                    Utiliza este código para rastrear tu paquete
                </p>
            </div>

            <div class="info-section">
                <h3>📋 Detalles del Paquete</h3>
                <div class="info-row">
                    <span class="info-label">Descripción:</span>
                    <span class="info-value"><?php echo e($paquete->descripcion); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Peso:</span>
                    <span class="info-value"><?php echo e($paquete->peso); ?> kg</span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paquete->dimensiones): ?>
                <div class="info-row">
                    <span class="info-label">Dimensiones:</span>
                    <span class="info-value"><?php echo e($paquete->dimensiones); ?></span>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="info-row">
                    <span class="info-label">Tipo de Envío:</span>
                    <span class="info-value"><?php echo e(ucfirst($paquete->tipoEnvio->nombre ?? 'N/A')); ?></span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paquete->envio): ?>
                <div class="info-row">
                    <span class="info-label">Fecha Estimada:</span>
                    <span class="info-value"><?php echo e(\Carbon\Carbon::parse($paquete->envio->fecha_estimada)->format('d/m/Y')); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Costo:</span>
                    <span class="info-value">$<?php echo e(number_format($paquete->envio->costo, 2)); ?></span>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="info-section">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($clienteTipo === 'emisor'): ?>
                <h3>📍 Información del Receptor</h3>
                <?php else: ?>
                <h3>📤 Información del Emisor</h3>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="info-row">
                    <span class="info-label">Nombre:</span>
                    <span class="info-value"><?php echo e($otroCliente->nombre); ?> <?php echo e($otroCliente->apellido); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Teléfono:</span>
                    <span class="info-value"><?php echo e($otroCliente->telefono); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Dirección:</span>
                    <span class="info-value"><?php echo e($otroCliente->direccion); ?></span>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($clienteTipo === 'receptor'): ?>
            <div class="alert">
                <p><strong>Importante:</strong> Por favor, mantén tu teléfono disponible. El repartidor se comunicará contigo para coordinar la entrega.</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <p style="margin-top: 30px; color: #666;">
                Si tienes alguna pregunta sobre tu envío, no dudes en contactarnos.
            </p>
        </div>

        <div class="footer">
            <p><strong>Sistema de Gestión de Envíos</strong></p>
            <p>Este es un correo automático, por favor no responder.</p>
            <p style="margin-top: 10px; font-size: 12px; color: #999;">
                © <?php echo e(date('Y')); ?> Todos los derechos reservados
            </p>
        </div>
    </div>
</body>

</html><?php /**PATH /var/www/html/gestionEnvios/resources/views/emails/package-created.blade.php ENDPATH**/ ?>