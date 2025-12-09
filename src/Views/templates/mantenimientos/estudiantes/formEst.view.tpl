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
    <form action="index.php?page=Mantenimientos-Estudiante&mode={{mode}}&id={{id}}" method="POST">
        <div>
            <label for="id">Id</label>
            <input type="text" name="id" id="id" value="{{id}}" {{codigoReadonly}} />
            <input type="hidden" name="vlt" value="{{token}}">
        </div>
        <div>
            <label for="estudiante_nombre">Nombre de Estudiante</label>
            <input type="text" name="estudiante_nombre" id="estudiante_nombre" value="{{estudiante_nombre}}"
                {{readonly}} />
        </div>
        <div>
            <label for="fecha_incidente">Fecha del Incidente</label>
            <input type="date" name="fecha_incidente" id="fecha_incidente" value="{{fecha_incidente}}" {{readonly}} />
        </div>
        <div>
            <label for="tipo_incidente">Tipo de Incidente</label>
            <input type="text" name="tipo_incidente" id="tipo_incidente" value="{{tipo_incidente}}" {{readonly}} />
        </div>
        <div>
            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" value="{{descripcion}}" {{readonly}} />
        </div>
        <div>
            <label for="accion_tomada">Acción Tomada</label>
            <input type="text" name="accion_tomada" id="accion_tomada" value="{{accion_tomada}}" {{readonly}} />
        </div>
        <div>
            <label for="estado">Estado</label>
            {{ifnot readonly}}
            <select name="estado" id="estado">
                <option value="ACT" {{selectedACT}}>Activo</option>
                <option value="INA" {{selectedINA}}>Inactivo</option>
            </select>
            {{endifnot readonly}}

            {{if readonly}}
            <input type="text" name="estado" id="estado" value="{{estado}}" {{readonly}} />
            {{endif readonly}}
        </div>
        <div>
            <button id="btnCancelar">Cancelar</button>
            {{ifnot isDisplay}}
            <button id="btnConfirmar" type="submit">Confirmar</button>
            {{endifnot isDisplay}}
        </div>
    </form>
</section>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("btnCancelar").addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=Mantenimientos-Estudiantes");
        });
    });
</script>
