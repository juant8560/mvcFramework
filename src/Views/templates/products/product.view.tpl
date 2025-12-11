<section class="container" style="background-color:#001f3f; color:white;">
    <section class="depth-2">
        <h2>{{FormTitle}}</h2>
    </section>

    {{if hasErrores}}
    <ul class="error">
        {{foreach errores}}
        <li>{{this}}</li>
        {{endfor errores}}
    </ul>
    {{endif hasErrores}}

    <form action="index.php?page=Products_Product&mode={{mode}}&productId={{productId}}" method="POST">
        <div>
            <label for="productId">ID</label>
            <input type="text" name="productId" id="productId" value="{{productId}}" {{codigoReadonly}} disabled />
            <input type="hidden" name="product_xss_token" value="{{product_xss_token}}">
        </div>

        <div>
            <label for="productName">Nombre</label>
            <input type="text" name="productName" id="productName" value="{{productName}}" {{readonly}} />
        </div>

        <div>
            <label for="productDescription">Descripción</label>
            <input type="text" name="productDescription" id="productDescription" value="{{productDescription}}"
                {{readonly}} />
        </div>

        <div>
            <label for="productPrice">Precio</label>
            <input type="number" step="0.01" name="productPrice" id="productPrice" value="{{productPrice}}"
                {{readonly}} />
        </div>

        <div>
            <label for="productImgUrl">URL Imagen</label>
            <input type="text" name="productImgUrl" id="productImgUrl" value="{{productImgUrl}}" {{readonly}} />
        </div>

        <div>
            <label for="productStock">Stock</label>
            <input type="text" name="productStock" id="productStock" value="{{productStock}}" {{readonly}} />
        </div>

        <div>
            <label for="productStatus">Estado</label>
            {{ifnot readonly}}
            <select name="productStatus" id="productStatus">
                <option value="ACT" {{productStatus_ACT}}>Activo</option>
                <option value="INA" {{productStatus_INA}}>Inactivo</option>
            </select>
            {{endifnot readonly}}

            {{if readonly}}
            <input type="text" name="productStatus" id="productStatus" value="{{productStatus}}" {{readonly}} />
            {{endif readonly}}
        </div>

        <div>
            <button id="btnCancelar" type="button">Cancelar</button>
            {{ifnot isDisplay}}
            <button id="btnConfirmar" type="submit">Confirmar</button>
            {{endifnot isDisplay}}
        </div>
    </form>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const btnCancelar = document.getElementById("btnCancelar");
        btnCancelar.addEventListener("click", (e) => {
            e.preventDefault();
            window.location.assign("index.php?page=Products_Products");
        });
    });
</script>