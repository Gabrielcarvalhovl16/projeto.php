<?php include "header.php"; ?>

<main class="container">

<h1>Plantio</h1>

<button class="btn" onclick="abrirModal()">+ Novo Plantio</button>

<!-- MODAL -->
<div id="modal" class="modal">
    <div class="modal-content">

        <h2>Novo Plantio</h2>

        <form method="POST">
            <label>Nome da Planta</label>
            <input type="text" name="planta" required>

            <label>Local</label>
            <input type="text" name="local">

            <label>Data</label>
            <input type="date" name="data">

            <!-- MAPA -->
            <label>Localização no Mapa</label>
            <div id="map"></div>

            <button type="submit" class="btn">Salvar</button>
            <button type="button" class="btn-outline" onclick="fecharModal()">Cancelar</button>
        </form>

    </div>
</div>

</main>

<?php include "footer.php"; ?>

<!-- LEAFLET (MAPA) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
function abrirModal() {
    document.getElementById("modal").style.display = "flex";

    setTimeout(() => {
        var map = L.map('map').setView([-8.28, -35.97], 13); // Brasil

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker;

        map.on('click', function(e) {
            if (marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
        });

    }, 200);
}

function fecharModal() {
    document.getElementById("modal").style.display = "none";
}
</script>