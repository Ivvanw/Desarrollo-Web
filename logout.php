<?php
/**
 * Cierra la sesión y vuelve al login.
 */
require_once __DIR__ . '/config/auth.php';

cerrarSesion();

header('Location: ' . url('index.php'));
exit();
