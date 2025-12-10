<section class="container-m row px-4 py-4" style="background-color:#001f3f; color:white;">
  <h1>Lista de Productos</h1>
  <div class="col-12">
    <a class="primary btn" href="index.php?page=Products-Product&mode=INS" style="background-color:#5dade2; color:white; padding:8px 12px; border-radius:5px; text-decoration:none;">Nuevo Producto</a>
  </div>
</section>

<section class="container-m row px-4 py-4" style="background-color:#001f3f; color:white;">
  <table class="col-12" style="width:100%; border-collapse:collapse; margin-top:20px;">
    <thead>
      <tr style="background-color:#003366;">
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Estado</th>
        <th>Imagen</th>
        <th>Stock</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      {{foreach products}}
      <tr>
        <td>{{productId}}</td>
        <td>{{productName}}</td>
        <td>{{productDescription}}</td>
        <td>{{productPrice}}</td>
        <td>{{productStatus}}</td>
        <td><img src="public/{{productImgUrl}}" alt="{{productName}}" style="width:80px; height:auto; border-radius:5px;"></td>
        <td>{{productStock}}</td>
        <td>
          <a href="index.php?page=Products-Product&mode=DSP&productId={{productId}}" style="background-color:#5dade2; color:white; padding:5px 10px; border-radius:4px; text-decoration:none; margin-right:5px;">DSP</a>
          <a href="index.php?page=Products-Product&mode=UPD&productId={{productId}}" style="background-color:#5dade2; color:white; padding:5px 10px; border-radius:4px; text-decoration:none; margin-right:5px;">UPD</a>
          <a href="index.php?page=Products-Product&mode=DEL&productId={{productId}}" style="background-color:#e74c3c; color:white; padding:5px 10px; border-radius:4px; text-decoration:none;">DEL</a>
        </td>
      </tr>
      {{endfor products}}
    </tbody>
  </table>
  <a href="http://localhost:8080/mvcFramework/index.php?page=Transactions_Transactions" style="color:white;">Ir a Transacciones</a>
</section>
