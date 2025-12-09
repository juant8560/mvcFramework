<section class="container-m row px-4 py-4">
    <h1>Carrito de Compras</h1>
</section>
<section class="container-m row px-4 py-4">
    {{if carretilla}}
    <table class="col-12 col-m-10 offset-m-1">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{foreach carretilla}}
            <tr>
                <td>{{productName}}</td>
                <td>{{cantidad}}</td>
                <td>{{precio}}</td>
                <td>{{subtotal}}</td>
                <td>
                    <a href="index.php?page=Carretilla_Carretilla&remove={{productId}}">Eliminar</a>
                </td>
            </tr>
            {{endfor carretilla}}
            <tr>
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td>{{total}}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div class="col-12 col-m-10 offset-m-1 my-4">
        <a href="index.php?page=Checkout_Checkout" class="primary btn">Proceder al Pago</a>
    </div>
    {{else}}
    <p>El carrito está vacío.</p>
    {{endif carretilla}}
</section>
