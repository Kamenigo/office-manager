<?php
require_once __DIR__ . '/../../lib/auth_guard.php';
require_once __DIR__ . '/../../lib/db.php';

om_require_login(); // session + email verified

// id of the document record
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { http_response_code(400); exit('Bad request'); }

$pdo = om_pdo();

// MUST be scoped by workspace_id from session (never from client)
$workspaceId = (int)($_SESSION['workspace_id'] ?? 0);
if ($workspaceId <= 0) { http_response_code(403); exit('Forbidden'); }

// Read file metadata (you will create expense_docs table later OR adapt to your table)
$stmt = $pdo->prepare("
  SELECT file_path, doc_type
  FROM expense_docs
  WHERE id = ? AND workspace_id = ?
  LIMIT 1
");
$stmt->execute([$id, $workspaceId]);
$row = $stmt->fetch();

if (!$row) { http_response_code(404); exit('Not found'); }

$filePath = $row['file_path'];

// Security: file must be outside public web root
// Example: /home/USER/office_manager_storage/...
if (!is_file($filePath)) { http_response_code(404); exit('Missing file'); }

// Send file
$mime = 'application/octet-stream';
$ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
if ($ext === 'pdf') $mime = 'application/pdf';
if (in_array($ext, ['jpg','jpeg'], true)) $mime = 'image/jpeg';
if ($ext === 'png') $mime = 'image/png';
if ($ext === 'webp') $mime = 'image/webp';

header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($filePath));
header('Content-Disposition: inline; filename="document_' . $id . '.' . $ext . '"');
header('X-Content-Type-Options: nosniff');

readfile($filePath);
exit;

