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
    <div class="flex-between">
  <h1>Registro de Plantio</h1>
  <button class="btn" onclick="abrirModal()">+ Novo Plantio</button>
</div>

<!-- Mapa de plantios -->
<h2>Mapa de Plantios</h2>
<div id="mapa" style="height:400px; border-radius:12px; border:1px solid #d4ddd0; margin-bottom:24px;"></div>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Data</th>
        <th>Muda</th>
        <th class="text-right">Qtd</th>
        <th>Local</th>
      </tr>
    </thead>
    <tbody>
      <!-- foreach plantio -->
      <tr>
        <td><!-- data --></td>
        <td><!-- nome muda --></td>
        <td class="text-right"><!-- qtd --></td>
        <td class="text-muted"><!-- local --></td>
      </tr>
      <!-- endforeach -->
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal-overlay" id="modal" style="display:none;">
  <div class="modal">
    <h3>Registrar Plantio</h3>
    <form method="POST" action="plantio.php">
      <div class="form-group">
        <label>Muda *</label>
        <select name="muda_id" required>
          <option value="">Selecione</option>
          <!-- foreach muda --><option value="ID">Nome</option><!-- endforeach -->
        </select>
      </div>
      <div class="form-group">
        <label>Quantidade *</label>
        <input type="number" name="quantidade" min="1" value="1" required>
      </div>
      <div class="form-group">
        <label>Local</label>
        <input type="text" name="local" placeholder="Ex: Praça central">
      </div>
      <div class="form-group">
        <label>Coordenadas (clique no mapa)</label>
        <div id="mapa-picker" style="height:200px; border-radius:8px; border:1px solid #d4ddd0;"></div>
        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="lng" id="lng">
        <p class="text-muted" id="coords-info"></p>
      </div>
      <div class="flex-end">
        <button type="button" class="btn btn-outline" onclick="fecharModal()">Cancelar</button>
        <button type="submit" class="btn">Registrar</button>
      </div>
    </form>
  </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  // Mapa principal com marcadores
  var mapa = L.map('mapa').setView([-15.78, -47.93], 4);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapa);
  
  // Adicionar marcadores via PHP:
  // <?php foreach ($plantios as $p): if ($p['lat'] && $p['lng']): ?>
  // L.marker([<?= $p['lat'] ?>, <?= $p['lng'] ?>]).addTo(mapa)
  //   .bindPopup('<b><?= $p['nome_muda'] ?></b><br>Qtd: <?= $p['quantidade'] ?><br><?= $p['data'] ?><br>Local: <?= $p['local'] ?>');
  // <?php endif; endforeach; ?>

  // Mapa picker no modal
  function abrirModal() {
    document.getElementById('modal').style.display = 'flex';
    setTimeout(function() {
      var picker = L.map('mapa-picker').setView([-15.78, -47.93], 4);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(picker);
      var marker;
      picker.on('click', function(e) {
        document.getElementById('lat').value = e.latlng.lat;
        document.getElementById('lng').value = e.latlng.lng;
        document.getElementById('coords-info').textContent = 'Lat: ' + e.latlng.lat.toFixed(4) + ', Lng: ' + e.latlng.lng.toFixed(4);
        if (marker) picker.removeLayer(marker);
        marker = L.marker(e.latlng).addTo(picker);
      });
    }, 100);
  }
  function fecharModal() { document.getElementById('modal').style.display = 'none'; }
</script>

  </main>
</body>
</html>
