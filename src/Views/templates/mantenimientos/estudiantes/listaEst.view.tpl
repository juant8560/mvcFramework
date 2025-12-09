<section class="py-4 px-4 depth-2">
    <h2>Listado de Estudiantes</h2>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Acción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            {{foreach estudiantes}}
            <tr>
                <td>{{id}}</td>
                <td>{{estudiante_nombre}}</td>
                <td>{{fecha_incidente}}</td>
                <td>{{tipo_incidente}}</td>
                <td>{{descripcion}}</td>
                <td>{{accion_tomada}}</td>
                <td>{{estado}}</td>
            </tr>
            <tr>
                <td><a href="index.php?page=Mantenimientos-Estudiante&mode=INS">Nuevo</a></td>
                <td><a href="index.php?page=Mantenimientos-Estudiante&mode=UPD&id={{id}}">Editar</a></td>
                <td><a href="index.php?page=Mantenimientos-Estudiante&mode=DEL&id={{id}}">Eliminar</a></td>
                <td><a href="index.php?page=Mantenimientos-Estudiante&mode=DSP&id={{id}}">Ver</a></td>
            </tr>
            {{endfor estudiantes}}

        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" class="right">
                    Registros: {{total}}
                </td>
                <br>
            </tr>
        </tfoot>
    </table>
</section>