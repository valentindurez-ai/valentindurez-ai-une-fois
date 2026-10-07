# Une Fois 🇧🇪 — Symfony + FrankenPHP on Clever Cloud

> A Belgian-culture Symfony app running on FrankenPHP in worker mode: frietkot sauce generator, Belgian beers, comics and a little Belgian-French dictionary. The frietkot counter lives in a static PHP property, so it survives between requests in worker mode — a playful way to show persistent worker processes.

---

## Routes

| Route            | Description                                              |
|------------------|----------------------------------------------------------|
| `/`              | « Une Fois » homepage (frietkot, bières, BD, dico)       |
| `/api/frites`    | JSON: random sauce + worker stats (PID, counter, uptime) |
| `/api/belgique`  | JSON: the full Belgian culture catalogue                 |
| `/stellar`       | Legacy Stellar.ai demo homepage                          |

---

## Deploy on Clever Cloud

```bash
clever login
clever create une-fois --type frankenphp --org orga_8ad87d63-9b0a-49c0-8eb6-83a643cec4f7 --region par
clever deploy
```

No add-on needed (SQLite). The `.env` file is committed — Symfony requires it at boot.
Set `APP_SECRET` in the Clever Cloud console to override the placeholder.

---

## Run locally

```bash
composer install
php -S 127.0.0.1:8000 -t public   # or: frankenphp run (uses the Caddyfile, worker mode)
```

---

## Stack

| Layer      | Technology                              |
|------------|-----------------------------------------|
| Language   | PHP 8.3                                 |
| Framework  | Symfony 7 (Twig templates)              |
| Server     | FrankenPHP (worker mode)                |
| Database   | SQLite (local)                          |
| Front      | Twig + vanilla CSS/JS (Fraunces, Space Grotesk) |

---

## Project Structure

```
├── src/
│   ├── Belgique/Culture.php            # Sauces, bières, BD, dico, slogans
│   └── Controller/BelgiqueController.php # Homepage + JSON API, worker counter
├── templates/belgique/index.html.twig  # « Une Fois » page
├── public/                             # Web root
├── Caddyfile                           # FrankenPHP worker config
└── .env                                # Committed — required by Symfony
```
