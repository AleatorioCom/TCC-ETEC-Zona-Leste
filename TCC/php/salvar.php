<?php
/**
 * Endpoint antigo de cadastro.
 *
 * O cadastro direto agora é feito pela API (POST api/plantas.php), que exige
 * um token de administrador. Mantivemos este arquivo apenas para que links ou
 * formulários antigos não quebrem: eles são enviados para a tela correta.
 */
header('Location: ../app/#/admin/nova', true, 302);
exit;
