<section class="container">
    <section class="depth-2">
        <h2>{{modeDsc}}</h2>
    </section>

    {{if hasErrores}}
    <ul class="error">
        {{foreach errores}}
        <li>{{this}}</li>
        {{endfor errores}}
    </ul>
    {{endif hasErrores}}

    <form action="index.php?page=Roles-Rol&mode={{mode}}&id={{rolescod}}" method="POST">
        <div>
            <label for="rolescod">Código</label>
            <input type="text" name="rolescod" id="rolescod" value="{{rolescod}}" {{codigoReadonly}} />
            <input type="hidden" name="vlt" value="{{token}}">
        </div>

        <div>
            <label for="rolesdsc">Descripción del Rol</label>
            <input type="text" name="rolesdsc" id="rolesdsc" value="{{rolesdsc}}" {{readonly}} />
        </div>

        <div>
            <label for="rolesest">Estado</label>

            {{ifnot readonly}}
            <select name="rolesest" id="rolesest">
                <option value="ACT" {{selectedACT}}>Activo</option>
                <option value="INA" {{selectedINA}}>Inactivo</option>
            </select>
            {{endifnot readonly}}

            {{if readonly}}
            <input type="text" id="rolesest" value="{{rolesest}}" {{readonly}}>
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
        e.preventDefault(); e.stopPropagation();
        window.location.assign("index.php?page=Roles-Roles");
    });
});
</script>
