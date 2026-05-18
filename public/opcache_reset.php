<?php
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo 'opcache limpiado';
} else {
    echo 'opcache no activo';
}
