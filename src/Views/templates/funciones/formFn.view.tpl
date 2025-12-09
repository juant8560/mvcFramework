<section class="container">
    <section class="depth-2">
        <h2>{{modeDsc}}</h2>
    </section>

    {{if hasErrors}}
    <ul class="error">
        {{foreach errores}}
        <li>{{this}}</li>
        {{endfor errores}}
    </ul>
    {{endif hasErrors}}

    <form action="index.php?page=Funciones-Funcion&mode={{mode}}&id={{fncod}}" method="POST">
        <div>
            <label for="fncod">Código</label>
            <input type="text" name="fncod" id="fncod" value="{{fncod}}" {{codigoReadonly}} />
            <input type="hidden" name="vlt" value="{{token}}">
        </div>

        <div>
            <label for="fndsc">Descripción</label>
            <input type="text" name="fndsc" id="fndsc" value="{{fndsc}}" {{readonly}} />
        </div>

        <div>
            <label for="fntyp">Tipo</label>
            <input type="text" name="fntyp" id="fntyp" value="{{fntyp}}" {{readonly}} />
        </div>

        <div>
            <label for="fnest">Estado</label>

            {{ifnot readonly}}
            <select name="fnest" id="fnest">
                <option value="ACT" {{selectedACT}}>Activo</option>
                <option value="INA" {{selectedINA}}>Inactivo</option>
            </select>
            {{endifnot readonly}}

            {{if readonly}}
            <input type="text" id="fnest" value="{{fnest}}" {{readonly}}>
            {{endif readonly}}
        </div>

        <div>
            <button id="btnCancelar">Cancelar</button>
            {{ifnot isDisplay}}
            <button type="submit">Confirmar</button>
            {{endifnot isDisplay}}
        </div>
    </form>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btnCancelar").addEventListener("click", (e) => {
        e.preventDefault();
        window.location.assign("index.php?page=Funciones-Funciones");
    });
});
</script>
