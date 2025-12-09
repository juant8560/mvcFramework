<section class="container row px-4 py-4">
  <h1>Catálogo de Productos</h1>
</section>

<section class="container row px-4 py-4">
  {{if products}}
    <div class="row">
      {{foreach products}}
        <div class="col-12 col-m-6 col-l-4 mb-4">
          <div class="card">
            <img src="{{productImgUrl}}" alt="{{productName}}" class="card-img">
            <div class="card-body">
              <h3>{{productName}}</h3>
              <p>{{productDescription}}</p>
              <p><strong>Precio: ${{productPrice}}</strong></p>
              <form action="index.php?page=Carretilla-Carretilla" method="POST">
                <input type="hidden" name="productId" value="{{productId}}">
                <input type="hidden" name="price" value="{{productPrice}}">
                <label>Cantidad:</label>
                <input type="number" name="quantity" value="1" min="1">
                <button type="submit" class="primary btn mt-2">Agregar al Carrito</button>
              </form>
            </div>
          </div>
        </div>
      {{endfor products}}
    </div>
  {{else}}
    <p>No hay productos disponibles.</p>
  {{endif products}}
</section>
