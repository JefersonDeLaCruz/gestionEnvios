<!DOCTYPE html>
<html lang="en" data-theme="black">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $__env->yieldContent('title', 'Mi App'); ?></title>
    <script src="https://cdn.jsdelivr.net/npm/theme-change@2.0.2/index.js"></script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body>
    <header>
        <?php echo $__env->yieldContent('navbar'); ?>
    </header>
    

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer>
        <?php echo $__env->yieldContent('footer'); ?>
    </footer>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

 
</body>
</html><?php /**PATH /var/www/html/gestionEnvios/resources/views/layout/base.blade.php ENDPATH**/ ?>