# Une Fois 🇧🇪 — Le Grand Vote des Sauces

A tiny Belgian frietkot app: enter your first name, pick your fries sauce (Andalouse, Samouraï, Brazil…). Every order is **written to PostgreSQL** and the live leaderboard + latest orders are **read back** from it.

- `public/index.html` — static page (HTML/CSS/vanilla JS)
- `server.js` — ~90-line Node.js server (no framework) + `pg`
- Table `commandes` is created automatically at startup

## Deploy on Clever Cloud (≈3 min)

```bash
npm i -g clever-tools
clever login
clever create une-fois --type node --region par
clever addon create postgresql-addon une-fois-pg --plan dev --link une-fois
clever deploy
clever open
```

The PostgreSQL add-on injects `POSTGRESQL_ADDON_URI`; the app listens on `PORT` (8080).

## Run locally

```bash
npm install
DATABASE_URL=postgres://user:pass@localhost:5432/db npm start
```

## API

| Method | Route            | Description                         |
|--------|------------------|-------------------------------------|
| GET    | `/api/commandes` | Leaderboard, latest orders, total   |
| POST   | `/api/commandes` | `{ "prenom": "…", "sauce": "…" }`    |
| GET    | `/health`        | DB connectivity check               |
