<section class="container-m row px-4 py-4">
  <h1>Resumen de Compra</h1>
</section>
<section class="container-m row px-4 py-4">
  {{if carrito}}
  <table class="col-12 col-m-10 offset-m-1">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      {{for item in carrito}}
      <tr>
        <td>{{item.productName}}</td>
        <td>{{item.cantidad}}</td>
        <td>{{item.precio}}</td>
        <td>{{item.subtotal}}</td>
      </tr>
      {{endfor}}
      <tr>
        <td colspan="3" class="text-right"><strong>Total:</strong></td>
        <td>{{total}}</td>
      </tr>
    </tbody>
  </table>
  <div class="col-12 col-m-10 offset-m-1 my-4">
    <form action="index.php?page=Checkout_Checkout" method="POST">
      <button type="submit" class="primary col-12 col-m-3">Simular Pago</button>
    </form>
  </div>
  {{else}}
  <p>No hay productos en el carrito para pagar.</p>
  {{endif}}
</section>
