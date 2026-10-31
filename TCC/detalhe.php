<?php
/**
 * Compatibilidade com links antigos: detalhe.php?id=5
 * A tela de detalhe agora faz parte da SPA (app/).
 */
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$destino = $id > 0 ? 'app/#/planta/' . $id : 'app/#/';

header('Location: ' . $destino, true, 302);
exit;
