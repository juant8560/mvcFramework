<section class="py-4 px-4 depth-2">
    <h2>Listado de Funciones</h2>
</section>

<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            {{foreach funciones}}
            <tr>
                <td>{{fncod}}</td>
                <td>{{fndsc}}</td>
                <td>{{fntyp}}</td>
                <td>{{fnest}}</td>
                <td>
                    <a href="index.php?page=Funciones-Funcion&mode=INS">Nuevo</a> |
                    <a href="index.php?page=Funciones-Funcion&mode=UPD&id={{fncod}}">Editar</a> |
                    <a href="index.php?page=Funciones-Funcion&mode=DEL&id={{fncod}}">Eliminar</a> |
                    <a href="index.php?page=Funciones-Funcion&mode=DSP&id={{fncod}}">Ver</a>
                </td>
            </tr>
            {{endfor funciones}}
        </tbody>

        <tfoot>
            <tr>
                <td colspan="5" class="right">Registros: {{total}}</td>
            </tr>
        </tfoot>
    </table>
</section>
