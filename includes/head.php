<?php
/**
 * Cabecera HTML compartida.
 *
 * Variables opcionales:
 *   $titulo      Título de la pestaña.
 *   $descripcion Descripción para motores de búsqueda.
 *   $bodyClass   Clases extra para <body>.
 *   $cssExtra    Array de hojas de estilo adicionales (rutas relativas al proyecto).
 */

$titulo = $titulo ?? 'Inicio';
$descripcion = $descripcion ?? 'Tutor interactivo de desarrollo web, PHP y Python.';
$bodyClass = $bodyClass ?? '';
$cssExtra = $cssExtra ?? [];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($descripcion) ?>">
    <title><?= e($titulo) ?> · <?= e(APP_NOMBRE) ?></title>

    <link rel="shortcut icon" href="<?= url('assets/img/favicon.ico') ?>" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="<?= url('assets/css/estilos.css') ?>">

    <?php foreach ($cssExtra as $hoja): ?>
        <link rel="stylesheet" href="<?= url($hoja) ?>">
    <?php endforeach; ?>
</head>

<body class="<?= e($bodyClass) ?>">
