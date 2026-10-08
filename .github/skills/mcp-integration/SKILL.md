---
name: mcp-integration
description: "Use when designing, implementing, reviewing, or debugging a Model Context Protocol (MCP) server or client for this Laravel project. Covers transport, SDK selection, Laravel integration, security, and tests."
---

# MCP Integration

Use this workflow only for tasks involving MCP. Do not create an MCP server or client just because this skill was loaded; implement only the behavior the user requested.

## Current Project State

- This project is a Laravel 12 application requiring PHP `^8.2`.
- No MCP SDK, MCP endpoint, or MCP-specific tests are currently present.
- Web routes are registered in `routes/web.php`; application bootstrap and middleware configuration are in `bootstrap/app.php`.
- Composer defines `composer test` as `php artisan test`; Pint is available as a development dependency.
- The project has only basic example tests. Add focused coverage for new MCP behavior rather than assuming broad existing coverage.

Re-check `composer.json`, route registration, and relevant tests before changing this baseline. Do not treat incidental matches in lockfiles as an MCP dependency.

## Procedure

1. Establish whether the requested component is an MCP server, an MCP client, or both, and identify the intended consumers and capabilities. If these materially affect the design and are unspecified, ask a concise clarification before committing to an architecture.
2. Confirm the required transport and deployment model. Verify current MCP protocol requirements and maintained PHP SDK options from authoritative documentation before selecting a package; check compatibility with PHP `^8.2` and Laravel 12. Do not invent package names, protocol details, or support claims.
3. Keep protocol handling behind a focused application boundary. Reuse Laravel's routing, dependency injection, configuration, validation, and authorization patterns where appropriate; avoid putting server logic in Blade views or frontend JavaScript.
4. Treat every tool invocation and remote response as untrusted. Define narrow capabilities, validate input at the boundary, authorize access to protected data, and return only the minimum necessary output. Never expose secrets, unrestricted database access, or arbitrary command execution.
5. Choose middleware and authentication to match the transport and deployment. Do not assume browser session authentication or web CSRF middleware is appropriate for every MCP transport; document and test the actual access-control boundary. Keep credentials in environment-backed Laravel configuration, never in source or client-visible assets.
6. For stdio transports, ensure protocol messages remain isolated on stdout; send diagnostics to stderr and avoid framework boot output corrupting the protocol stream.
7. Add focused tests for protocol behavior, input validation, authorization, and failure responses at the layer that owns them. Run the relevant tests, then `composer test` when practical; use Pint for changed PHP files.
8. Summarize the chosen transport, SDK, exposed capabilities, authentication boundary, and verification performed. Call out any deployment or protocol assumptions that remain unresolved.

## Project References

- [Composer dependencies and scripts](../../../composer.json)
- [Web routes](../../../routes/web.php)
- [Laravel bootstrap](../../../bootstrap/app.php)
- [Tests](../../../tests)