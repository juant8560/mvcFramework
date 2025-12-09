<section class="py-4 px-4 depth-2"> 
    <h2>Listado de Usuarios</h2>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Email</th>
                <th>Nombre de Usuario</th>
                <th>Fecha Ingreso</th>
                <th>Estado Password</th>
                <th>Estado</th>
                <th>Tipo</th>
                <th><a href="index.php?page=Usuarios-Usuario&mode=INS">Nuevo</a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach usuarios}}
            <tr>
                <td>{{usercod}}</td>
                <td>{{useremail}}</td>
                <td>{{username}}</td>
                <td>{{userfching}}</td>
                <td>{{userpswdest}}</td>
                <td>{{userest}}</td>
                <td>{{usertipo}}</td>
                <td>
                    <a href="index.php?page=Usuarios-Usuario&mode=UPD&usercod={{usercod}}">Editar</a>&nbsp;
                    <a href="index.php?page=Usuarios-Usuario&mode=DEL&usercod={{usercod}}">Eliminar</a>&nbsp;
                    <a href="index.php?page=Usuarios-Usuario&mode=DSP&usercod={{usercod}}">Ver</a>
                </td>
            </tr>
            {{endfor usuarios}}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" class="right">
                    <strong>Total de Usuarios: {{total}}</strong>
                </td>
            </tr>
        </tfoot>
    </table>
</section>
