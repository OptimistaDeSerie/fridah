# Copilot Instructions for Multi-Project Workspace

This workspace contains several distinct web application projects. Each project has its own architecture, conventions, and workflows. Follow these guidelines to maximize productivity and avoid common pitfalls.

## Project Overview

- **primalaero-engine**: Python/Docker-based backend with Makefile-driven workflows. Key directories: `src/`, `dcs/`, `ibe/`. Uses Docker for development, testing, and deployment. See `README.md` for build/test commands.
- **fridah**: Laravel (PHP) application. Blade templates in `resources/views/`. Uses standard Laravel conventions for routing, controllers, and views. Key config: `config/`, `app/`, `routes/`.
- **purecrestbck**: Custom PHP framework (Zedek 4). MVC structure with custom ORM (ZORM) and templating engine (ZView). See `README.md` for URL mapping and engine structure. Key directories: `core/`, `config/`, `models/`, `templates/`.
- **purecrest**: Frontend theme assets and templates. Organized by `themes/` and `store/` subfolders. No backend logic here.
- **mofi**, **porto_ecommerce**: Static HTML/CSS/JS templates for UI prototyping.

## Critical Workflows

### primalaero-engine
- **Build/Run**: Use `make build`, `make run`, and `make shell` for Dockerized workflows.
- **Testing**: `make test` runs unit tests inside containers.
- **Linting**: `make lint` for code style checks.
- **Environment**: Copy `.env_dist` to `.env` before running.

### fridah
- **Development**: Standard Laravel (`php artisan serve`, `php artisan migrate`, etc.).
- **Views**: Blade templates use `@extends`, `@section`, and `@push` for layout and scripts. Example: `checkout.blade.php`.
- **Assets**: Use Laravel's `asset()` helper for static files.

### purecrestbck
- **Routing**: URLs map to engine directories and controller methods (see README for examples).
- **Templating**: Use ZView for logic in HTML views. Raw PHP is allowed in markup.
- **Startup**: Use `php zedek start` (or full path to PHP binary on Windows).

## Project-Specific Patterns

- **primalaero-engine**: All major operations are containerized. Avoid running Python scripts directly; use Docker/Makefile.
- **fridah**: Blade templates are the primary view layer. Use Laravel's helpers and conventions for forms, validation, and asset management.
- **purecrestbck**: Custom framework logic. ORM is ZORM, not Eloquent. Templating via ZView, not Blade.

## Integration Points

- **primalaero-engine**: Integrates with Mockoon for API mocking. See README for version requirements.
- **fridah**: Standard Laravel integrations (database, mail, etc.) via config files.
- **purecrestbck**: Minimal external dependencies; most logic is custom PHP.

## Examples

- To build and run primalaero-engine:
  ```sh
  make build
  make run
  ```
- To start purecrestbck (Zedek):
  ```sh
  php zedek start
  ```
- To serve fridah (Laravel):
  ```sh
  php artisan serve
  ```

## Key Files & Directories
- `primalaero-engine/README.md`, `Makefile`, `docker-compose.yml`
- `fridah/resources/views/`, `fridah/config/`, `fridah/app/`
- `purecrestbck/core/`, `purecrestbck/config/`, `purecrestbck/README.md`

---

If any conventions or workflows are unclear, please request clarification or provide feedback to improve these instructions.