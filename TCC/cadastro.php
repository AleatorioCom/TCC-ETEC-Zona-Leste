<?php
/**
 * Compatibilidade com links antigos: cadastro.php
 * O cadastro direto agora exige login de administrador e vive na SPA (app/).
 */
header('Location: app/#/admin/nova', true, 302);
exit;
