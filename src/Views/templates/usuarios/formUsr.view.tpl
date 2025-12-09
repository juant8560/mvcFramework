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

    <form action="index.php?page=Usuarios-Usuario&mode={{mode}}&usercod={{usercod}}" method="post">
        <div>
            <label for="usercod">Código:</label>
            <input type="text" name="usercod" id="usercod" value="{{usercod}}" {{codigoReadonly}}>
            <input type="hidden" name="vlt" value="{{token}}">
        </div>

        <div>
            <label for="useremail">Email:</label>
            <input type="email" name="useremail" id="useremail" value="{{useremail}}" {{readonly}}>
        </div>

        <div>
            <label for="username">Nombre de Usuario:</label>
            <input type="text" name="username" id="username" value="{{username}}" {{readonly}}>
        </div>

        <div>
            <label for="userpswd">Password:</label>
            <input type="password" name="userpswd" id="userpswd" value="{{userpswd}}" {{readonly}}>
        </div>

        <div>
            <label for="userfching">Fecha de ingreso:</label>
            <input type="date" name="userfching" id="userfching" value="{{userfching}}" {{readonly}}>
        </div>

        <div>
            <label for="userpswdest">Estado de password:</label>
            {{ifnot readonly}}
            <select name="userpswdest" id="userpswdest">
                <option value="ACT" {{selected_pswdest_ACT}}>ACT</option>
                <option value="INA" {{selected_pswdest_INA}}>INA</option>
            </select>
            {{endifnot readonly}}
            {{if readonly}}
            <input type="text" name="userpswdest" value="{{userpswdest}}" readonly>
            {{endif readonly}}
        </div>

        <div>
            <label for="userpswdexp">Fecha de expiración de password:</label>
            <input type="date" name="userpswdexp" id="userpswdexp" value="{{userpswdexp}}" {{readonly}}>
        </div>

        <div>
            <label for="userest">Estado de usuario:</label>
            {{ifnot readonly}}
            <select name="userest" id="userest">
                <option value="ACT" {{selected_est_ACT}}>ACT</option>
                <option value="INA" {{selected_est_INA}}>INA</option>
            </select>
            {{endifnot readonly}}
            {{if readonly}}
            <input type="text" name="userest" value="{{userest}}" readonly>
            {{endif readonly}}
        </div>

        <div>
            <label for="usertipo">Tipo de usuario:</label>
            {{ifnot readonly}}
            <select name="usertipo" id="usertipo">
                <option value="ACT" {{selected_est_ACT}}>ACT</option>
                <option value="INA" {{selected_est_INA}}>INA</option>
            </select>
            {{endifnot readonly}}
            {{if readonly}}
            <input type="text" name="usertipo" value="{{usertipo}}" readonly>
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
        window.location.assign("index.php?page=Usuarios-Usuarios");
    });
});
</script>
