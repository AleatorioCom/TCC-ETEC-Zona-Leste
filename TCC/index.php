<?php
/**
 * Entrada do site.
 *
 * A interface agora é uma SPA estática (pasta app/), a mesma que o Capacitor
 * empacota dentro do APK. O PHP continua responsável pela API JSON (api/).
 */
header('Location: app/', true, 302);
exit;
