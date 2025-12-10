<section class="container px-4 py-4" style="background-color:#001f3f; color:white;">
  <h1>Catálogo de Productos</h1>
</section>

<section class="container px-4 py-5" style="background-color:#001f3f; color:white;">
  {{if products}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3" style="gap:30px;">
      {{foreach products}}
        <div class="col">
          <div class="card h-100 text-center" style="background-color:#003366; color:white; border-radius:8px; padding:15px; margin-bottom:20px;">
            <img src="public/{{productImgUrl}}" alt="{{productName}}" class="card-img-top" style="max-height: 150px; object-fit: contain; margin-bottom:10px;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{productName}}</h5>
              <p class="card-text">{{productDescription}}</p>
              <p class="mt-auto"><strong>Precio: L{{productPrice}}</strong></p>
              <form action="index.php?page=Carretilla-Carretilla" method="POST">
                <input type="hidden" name="productId" value="{{productId}}">
                <input type="hidden" name="price" value="{{productPrice}}">
                <label style="margin-right:5px;">Cantidad:</label>
                <input type="number" name="quantity" value="1" min="1" style="width:50px;">
                <button type="submit" style="background-color:#5dade2; color:white; padding:5px 10px; border:none; border-radius:5px; margin-top:5px;">Agregar al Carrito</button>
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
