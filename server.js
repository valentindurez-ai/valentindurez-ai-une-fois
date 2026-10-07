import http from 'node:http';
import { readFile } from 'node:fs/promises';
import pg from 'pg';

const SAUCES = ['Andalouse', 'Samouraï', 'Américaine', 'Brazil', 'Pickles', 'Tartare', 'Hannibal', 'Mayonnaise', 'Cocktail', 'Biggy Burger'];

// Clever Cloud's PostgreSQL add-on injects POSTGRESQL_ADDON_URI.
const connectionString = process.env.POSTGRESQL_ADDON_URI || process.env.DATABASE_URL;
if (!connectionString) {
  console.error('Missing POSTGRESQL_ADDON_URI (link a PostgreSQL add-on) or DATABASE_URL.');
  process.exit(1);
}
const db = new pg.Pool({ connectionString, max: 4 });

await db.query(`
  CREATE TABLE IF NOT EXISTS commandes (
    id         SERIAL PRIMARY KEY,
    prenom     TEXT NOT NULL,
    sauce      TEXT NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT now()
  )
`);

const indexHtml = await readFile(new URL('./public/index.html', import.meta.url));

async function etat() {
  const [classement, dernieres, total] = await Promise.all([
    db.query('SELECT sauce, COUNT(*)::int AS votes FROM commandes GROUP BY sauce ORDER BY votes DESC, sauce'),
    db.query('SELECT prenom, sauce, created_at FROM commandes ORDER BY id DESC LIMIT 8'),
    db.query('SELECT COUNT(*)::int AS n FROM commandes'),
  ]);
  return { sauces: SAUCES, classement: classement.rows, dernieres: dernieres.rows, total: total.rows[0].n };
}

function json(res, status, body) {
  res.writeHead(status, { 'Content-Type': 'application/json; charset=utf-8' });
  res.end(JSON.stringify(body));
}

async function lireCorps(req) {
  let data = '';
  for await (const chunk of req) {
    data += chunk;
    if (data.length > 1e4) throw new Error('trop gros');
  }
  return JSON.parse(data || '{}');
}

const server = http.createServer(async (req, res) => {
  const path = new URL(req.url, 'http://localhost').pathname.replace(/\/+$/, '') || '/';
  const method = req.method === 'HEAD' ? 'GET' : req.method;
  try {
    if (method === 'GET' && (path === '/' || path === '/index.html')) {
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(indexHtml);
    }
    if (method === 'GET' && path === '/api/commandes') {
      return json(res, 200, await etat());
    }
    if (method === 'POST' && path === '/api/commandes') {
      const { prenom, sauce } = await lireCorps(req);
      const nom = String(prenom ?? '').trim().slice(0, 30);
      if (!nom || !SAUCES.includes(sauce)) {
        return json(res, 400, { erreur: 'Un prénom et une vraie sauce, une fois !' });
      }
      await db.query('INSERT INTO commandes (prenom, sauce) VALUES ($1, $2)', [nom, sauce]);
      return json(res, 201, await etat());
    }
    if (method === 'GET' && path === '/health') {
      await db.query('SELECT 1');
      return json(res, 200, { ok: true });
    }
    json(res, 404, { erreur: 'Pas de frites ici.' });
  } catch (err) {
    console.error(err);
    json(res, 500, { erreur: 'Le frietkot a brûlé l\'huile.' });
  }
});

const port = Number(process.env.PORT) || 8080;
server.listen(port, '0.0.0.0', () => console.log(`🍟 Frietkot ouvert sur le port ${port}`));
