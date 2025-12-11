<section class="container px-4 py-4" style="background-color:#001f3f; color:white;">
  <h1>Historial de Transacciones</h1>
</section>

<section class="container px-4 py-5" style="background-color:#003366; color:white;">
  {{if transacciones}}
    {{foreach transacciones}}
      <div class="card mb-4" style="background-color:#004080; padding:15px; border-radius:8px;">
        <h5>Transacción #{{transactionId}} - Fecha: {{trxdate}} - Total: L{{total}}</h5>
        {{if usercod && usercod != ""}}
          <p>Cliente: {{usercod}}</p>
        {{endif}}
        <ul style="margin-left:20px;">
          {{foreach items}}
            <li>{{productName}} x {{quantity}} - L{{price}} c/u</li>
          {{endfor items}}
        </ul>
      </div>
    {{endfor transacciones}}
  {{else}}
    <p>No hay transacciones registradas.</p>
    <a href="index.php?page=Products_Products" style="background-color:#5dade2; color:white; padding: 3xp 12px ; border-radius:5px; text-decoration:none;">Ir a Products</p>
  {{endif transacciones}}
</section>
