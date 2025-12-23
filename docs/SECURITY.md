# Office Manager — Security Rules (v1)

This document defines non-negotiable security requirements for the Cloud Workspace (SaaS) version.

## 1) Tenant isolation (Workspace)
- Every table that stores business data MUST have workspace_id.
- Backend MUST NEVER accept workspace_id from the client.
- Workspace scope comes ONLY from session: $_SESSION['workspace_id'].
- Every query must be scoped: WHERE workspace_id = ? (from session).
- Any endpoint without workspace scoping is considered a critical bug.

## 2) Authentication (Hard rules)
- Email verification is mandatory for EVERY account.
- Login is blocked unless is_email_verified = 1.
- All protected pages and API endpoints MUST enforce session checks server-side (PHP).
- No page should be accessible without login (direct URL access must be blocked).

## 3) Roles & permissions (RBAC)
Roles: admin (owner), pm (project manager), worker.
- Worker cannot access admin-only pages, financial totals, or GPS history pages.
- Project Manager cannot delete orders.
- Only Admin/Owner can delete orders (enforced server-side, not only in UI).
- Every sensitive endpoint must require role check via auth_guard.

## 4) File storage (Critical)
Goal: users must not access uploaded documents via guessed URLs.

Rules:
- Uploaded files MUST NOT be stored in any public web directory (e.g. public_html/uploads).
- Store files in a non-public folder outside web root (example):
  /home/ACCOUNT/office_manager_storage/
- Database stores only metadata + absolute/secure file_path.
- File access MUST be served through a PHP endpoint (download controller) that checks:
  session + email verified + workspace_id match + role permissions.

## 5) Download endpoint rules
- Endpoint example: backend/api/files/download.php?id=123
- Must query document by (id, workspace_id from session).
- If not found or workspace mismatch -> 404/403.
- Must set safe headers: Content-Type, Content-Disposition, X-Content-Type-Options: nosniff.
- Must never expose filesystem paths in responses.

## 6) Encryption at rest (Required for documents)
- Uploaded documents must be encrypted before saving to disk.
- Use AES-256-GCM (or equivalent authenticated encryption).
- Encryption key must be stored only in backend/config.php (never committed to Git).
- backend/config.example.php contains placeholders only.
- Without the key, stored files must be unreadable.

Note:
- If encryption is introduced, download endpoint must decrypt on-the-fly after permission checks.

## 7) Audit logging (Recommended baseline)
- Log critical actions:
  - login attempts
  - document downloads
  - order deletions (admin-only)
  - role changes / invitations
- Logs must include: workspace_id, user_id, action, timestamp, ip (if possible).

## 8) Terms/Privacy stance (Honest + safe)
- The system uses strict workspace isolation.
- Documents are stored outside public web root and accessed only through authenticated endpoints.
- Administrative access is limited to support/maintenance and should be auditable.
- Optional self-host can be offered for customers requiring full physical control.
