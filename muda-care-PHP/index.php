<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Controle de Mudas</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Inter', system-ui, sans-serif; background: #f5f7f2; color: #1a3a2a; }
    header { background: #2d8a56; color: #fff; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
    header a { color: #fff; text-decoration: none; font-weight: bold; font-size: 18px; display: flex; align-items: center; gap: 8px; }
    nav { display: flex; gap: 4px; }
    nav a { color: #fff; text-decoration: none; padding: 6px 12px; border-radius: 8px; font-size: 14px; }
    nav a:hover { background: rgba(255,255,255,0.1); }
    nav a.active { background: rgba(255,255,255,0.2); }
    main { max-width: 1152px; margin: 0 auto; padding: 24px; width: 100%; }
    h1 { font-size: 24px; font-weight: bold; margin-bottom: 24px; }
    h2 { font-size: 18px; font-weight: 600; margin-bottom: 12px; }
    .btn { background: #2d8a56; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 14px; }
    .btn:hover { background: #257a4a; }
    .btn-outline { background: transparent; border: 1px solid #ccc; color: #333; }
    .card { background: #fff; border-radius: 12px; border: 1px solid #d4ddd0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    thead tr { background: rgba(0,0,0,0.03); border-bottom: 1px solid #d4ddd0; }
    th { text-align: left; padding: 8px 16px; font-weight: 500; }
    td { padding: 8px 16px; border-bottom: 1px solid #eee; }
    tr:last-child td { border-bottom: none; }
    input, select, textarea { width: 100%; padding: 8px 12px; border: 1px solid #d4ddd0; border-radius: 8px; font-size: 14px; }
    label { font-size: 14px; font-weight: 500; display: block; margin-bottom: 4px; }
    .form-group { margin-bottom: 16px; }
    .grid-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
    .grid-stats { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; margin-bottom: 32px; }
    .stat-card { text-align: center; }
    .stat-value { font-size: 24px; font-weight: bold; }
    .stat-label { font-size: 12px; color: #6b7c6e; }
    .badge { padding: 2px 8px; border-radius: 999px; font-size: 12px; font-weight: 500; }
    .badge-green { background: rgba(45,138,86,0.1); color: #2d8a56; }
    .badge-red { background: rgba(220,50,50,0.1); color: #dc3232; }
    .badge-yellow { background: rgba(210,160,60,0.1); color: #a07a20; }
    .text-muted { color: #6b7c6e; font-size: 14px; }
    .text-right { text-align: right; }
    .flex-between { display: flex; justify-content: space-between; align-items: center; }
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; display: flex; align-items: center; justify-content: center; }
    .modal { background: #fff; border-radius: 12px; padding: 24px; width: 90%; max-width: 500px; }
    .modal h3 { font-size: 18px; font-weight: 600; margin-bottom: 16px; }
    .flex-end { display: flex; gap: 8px; justify-content: flex-end; }
    @media (max-width: 768px) { .grid-stats { grid-template-columns: repeat(2, 1fr); } .hide-mobile { display: none; } }
  </style>
</head>
<body>
  <header>
    <a href="index.php">🌿 Controle de Mudas</a>
    <nav>
      <a href="index.php">Dashboard</a>
      <a href="catalogo.php">Catálogo</a>
      <a href="estoque.php">Estoque</a>
      <a href="doacoes.php">Doações</a>
      <a href="plantio.php">Plantio</a>
    </nav>
  </header>
  <main>
   <h1>Dashboard</h1>
<div class="grid-stats">
  <div class="card stat-card">
    <div class="stat-value"><!-- totalMudas --></div>
    <div class="stat-label">Mudas Cadastradas</div>
  </div>
  <div class="card stat-card">
    <div class="stat-value"><!-- totalEstoque --></div>
    <div class="stat-label">Em Estoque</div>
  </div>
  <div class="card stat-card">
    <div class="stat-value"><!-- totalPlantado --></div>
    <div class="stat-label">Plantadas</div>
  </div>
  <div class="card stat-card">
    <div class="stat-value"><!-- totalDoado --></div>
    <div class="stat-label">Doadas</div>
  </div>
  <div class="card stat-card">
    <div class="stat-value"><!-- totalRecebido --></div>
    <div class="stat-label">Recebidas</div>
  </div>
</div>

<h2>Movimentações Recentes</h2>
<div class="card">
  <table>
    <thead>
      <tr>
        <th>Data</th>
        <th>Muda</th>
        <th>Tipo</th>
        <th class="text-right">Qtd</th>
      </tr>
    </thead>
    <tbody>
      <!-- foreach movimentação -->
      <tr>
        <td><!-- data formatada dd/mm/aaaa --></td>
        <td><!-- nome da muda --></td>
        <td><!-- Entrada|Saída|Doação|Recebimento|Plantio --></td>
        <td class="text-right"><!-- quantidade --></td>
      </tr>
      <!-- endforeach -->
    </tbody>
  </table>
</div>

  </main>
</body>
</html>
