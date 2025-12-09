<section class="container-m row px-4 py-4">
  <h1>Lista de Productos</h1>
  <div class="col-12">
    <a class="primary btn" href="index.php?page=Products-Product&mode=INS">Nuevo Producto</a>
  </div>
</section>

<section class="container-m row px-4 py-4">
  <table class="col-12">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Estado</th>
        <th>Imagen</th>
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
        <td><img src="{{productImgUrl}}" width="100" alt="{{productName}}"></td>
        <td>
          <a class="btn" href="index.php?page=Products-Product&mode=DSP&productId={{productId}}">DSP</a>
          <a class="btn" href="index.php?page=Products-Product&mode=UPD&productId={{productId}}">UPD</a>
          <a class="btn danger" href="index.php?page=Products-Product&mode=DEL&productId={{productId}}">DEL</a>
        </td>
      </tr>
      {{endfor products}}
    </tbody>
  </table>
</section>