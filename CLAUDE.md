# Office Manager — Rules for Claude

## Stack / Hosting
- Shared hosting (cPanel/JumpBG-like)
- PHP + MySQL + plain HTML/CSS/JS
- NO Node.js

## Core product
- Multi-tenant: everything belongs to a Workspace
- Roles: Admin (Owner), Project Manager, Worker/Employee

## Permissions (hard rules)
- Worker sees only their tasks and can mark done + add notes + upload documents.
- Worker MUST NOT see financial totals, admin-only reports, or GPS track history.

## Non-negotiable logic
- VAT: do NOT calculate VAT automatically; store value + flag (with/without/unknown).
- Finance rule: offer split is 60/35/5 (+ extra partial if needed).
- Everything is stored in the database (including settings, reminders, calculator data).

## Output format
- When changing code: always give file path + exact code block + exact place to paste.
- Prefer small, safe changes. Do not refactor unrelated files.

