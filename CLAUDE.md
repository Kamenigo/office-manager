# Office Manager — Rules for Claude (Platform Structure v1)

## Goal
Build the platform structure first: auth, roles, workspaces/teams, admin panel, project manager panel, worker panel, access control. No VAT/finance calculations for now.

## Hosting / Stack constraints
- Shared hosting (cPanel/JumpBG-like)
- PHP + MySQL (MariaDB) + plain HTML/CSS/JS
- NO Node.js

## Core concepts
- Workspace = company account.
- Roles:
  - Admin/Owner
  - Project Manager
  - Worker/Employee

## Authentication (hard rules)
- EVERY account MUST be email-verified before login is allowed.
- NO page must be accessible without login.
- All protected pages must check session + role server-side (not only JS).

## Registration flow (required)
1) Owner registers (creates Workspace) -> email verification required.
2) Owner chooses: works solo OR works with a team.
3) If team: Owner sends invitations (email + role) to team members.
4) Invited member registers through invite link -> email verification required -> then joins the Workspace with the assigned role.
5) Owner can manage members after that.

## Permissions (required)
### Admin/Owner
- Can add/remove people, change roles, and manage permissions/settings.
- Can create/edit orders and tasks.
- ONLY Admin can delete orders (hard rule).
- Can set salary/compensation settings per person:
  - hourly rate
  - daily rate
  - fixed salary
  - percentage
- Salary calculations/values must be hidden from lower roles (Worker/PM cannot see totals).

### Project Manager
- Can add/remove people (within allowed scope), assign roles and tasks for the day by projects.
- Can create new orders and manage existing ones.
- Can add materials and assign them to clients/orders.
- CANNOT delete orders.

### Worker/Employee
- Can start an activity with a type dropdown (e.g., Work / Shopping / Installation).
- Must select client/order/project when starting a session (if enabled by Admin).
- Time is tracked per project/order for salary calculation, but salary totals are NOT visible to Worker.
- Can complete tasks and add notes.
- Can upload documents to tasks/orders (future module).

## Orders / Clients / Payments (structure only for now)
- Project Manager can add clients, orders, offer numbers, invoice numbers, amounts, deposits/partial/final payments (store fields).
- Do not implement business rules/calculations now; just store and display per permissions.

## GPS tracking / reporting (required)
- Worker sessions can collect GPS track points (as configured).
- At end of work time, send an email report to Admin with:
  - worked sessions summary
  - GPS track summary/link (implementation detail later)
- Worker does NOT access admin-only GPS history pages.

## Safety rules for changes (important)
- Make minimal, safe changes only.
- Do not refactor unrelated files.
- When producing code: always provide file path + exact code block + exact place to paste.
- Implement one module/endpoint/page at a time.
