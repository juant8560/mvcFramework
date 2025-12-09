<section class="py-4 px-4 depth-2">
    <h2>Listado de Roles</h2>
</section>

<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
            {{foreach roles}}
            <tr>
                <td>{{rolescod}}</td>
                <td>{{rolesdsc}}</td>
                <td>{{rolesest}}</td>
            </tr>
            <tr>
                <td><a href="index.php?page=Roles-Rol&mode=INS">Nuevo</a></td>
                <td><a href="index.php?page=Roles-Rol&mode=UPD&id={{rolescod}}">Editar</a></td>
                <td><a href="index.php?page=Roles-Rol&mode=DEL&id={{rolescod}}">Eliminar</a></td>
                <td><a href="index.php?page=Roles-Rol&mode=DSP&id={{rolescod}}">Ver</a></td>
            </tr>
            {{endfor roles}}
        </tbody>

        <tfoot>
            <tr>
                <td colspan="4" class="right">Registros: {{total}}</td>
            </tr>
        </tfoot>
    </table>
</section>
