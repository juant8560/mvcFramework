<section class="container">
    <section class="depth-2">
        <h2>Usuarios y Roles</h2>
    </section>

    <form action="index.php?page=Roles-RolesUsuariosController&action=usuariosRoles" method="post">
        <div>
            <label for="usercod">Usuario:</label>
            <select name="usercod" id="usercod">
                <option value="">---Seleccionar---</option>
                {{foreach usuarios}}
                <option value="{{usercod}}" {{if selectedUser==usercod}}selected{{endif}}>
                    {{username}}
                </option>
                {{endfor usuarios}}
            </select>
        </div>
    </form>



    {{if selectedUser}}
    <section>
        <h3>Roles asignados</h3>
        <ul>
            {{foreach rolesAsignados}}
            <li>{{rolesdsc}} ({{estado}})</li>
            {{endfor rolesAsignados}}
        </ul>

        <h3>Roles disponibles</h3>
        <form action="index.php?page=Roles-RolesUsuariosController&action=asignarRol" method="POST">
            <input type="hidden" name="usercod" value="{{selectedUser}}">
            <ul>
                {{foreach rolesNoAsignados}}
                <li>
                    <input type="checkbox" name="roles[]" value="{{rolescod}}"> {{rolesdsc}}
                </li>
                {{endfor rolesNoAsignados}}
            </ul>
            <button type="submit">Asignar Roles</button>
        </form>
    </section>
    {{endif selectedUser}}
</section>