
<section class="container px-4 py-4" 
         style="background-color:#001f3f; color:white;">
    <h1>Carrito de Compras</h1>
</section>

<section class="container px-4 py-5" 
         style="background-color:#001f3f; color:white;">

    {{if carretilla}}

    <table class="col-12 col-m-10 offset-m-1"
           style="width:100%; border-collapse:collapse; background-color:#003366; color:white; border-radius:10px; overflow:hidden;">

        <thead>
            <tr style="background-color:#004080;">
                <th style="padding:12px; text-align:left;">Producto</th>
                <th style="padding:12px; text-align:center;">Cantidad</th>
                <th style="padding:12px; text-align:center;">Precio Unitario</th>
                <th style="padding:12px; text-align:center;">Subtotal</th>
                <th style="padding:12px; text-align:center;">Acciones</th>
            </tr>
        </thead>

        <tbody>
            {{foreach carretilla}}

            <tr style="border-bottom:1px solid #005599;">
                <td style="padding:14px;">{{productName}}</td>
                <td style="padding:14px; text-align:center;">{{cantidad}}</td>
                <td style="padding:14px; text-align:center;">L {{precio}}</td>
                <td style="padding:14px; text-align:center;">L {{subtotal}}</td>
                <td style="padding:14px; text-align:center;">
                    <a href="index.php?page=Carretilla_Carretilla&remove={{productId}}"
                       style="color:#ff6b6b; font-weight:bold; text-decoration:none;">
                        Eliminar
                    </a>
                </td>
            </tr>

            {{endfor carretilla}}

            <tr style="background-color:#004080;">
                <td colspan="3" style="padding:14px; text-align:right;">
                    <strong>Total:</strong>
                </td>
                <td style="padding:14px; text-align:center;">
                    <strong>L {{total}}</strong>
                </td>
                <td></td>
            </tr>

        </tbody>
    </table>

    <div class="col-12 col-m-10 offset-m-1 my-4" style="text-align:center; margin-top:25px;">
        <a href="index.php?page=Checkout_Checkout" 
           class="primary btn"
           style="
             display:inline-block;
             background-color:#5dade2;
             color:white;
             padding:12px 20px;
             border-radius:8px;
             font-size:1.1rem;
             text-decoration:none;
             font-weight:bold;
           ">
           Proceder al Pago
        </a>
    </div>

    {{else}}
    {{endif carretilla}}

</section>
