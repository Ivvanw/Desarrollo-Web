<?php
/**
 * Cierra la sesión del manual de Python y vuelve al tutor de PHP.
 */
require_once __DIR__ . '/config/auth.php';

cerrarSesion();

header('Location: ' . url('index.php'));
exit();
