<h2>Roles y Funciones</h2>

<form method="get">
    <input type="hidden" name="page" value="Roles-RolesUsuariosController">
    <input type="hidden" name="action" value="rolesFunciones">

    <label>Rol:</label>
    <select name="rolescod" onchange="this.form.submit()">
        <option value="">--Seleccione--</option>
        {foreach $roles as $rol}
            <option value="{$rol.rolescod}" {if $selectedRol == $rol.rolescod}selected{/if}>
                {$rol.rolesdsc}
            </option>
        {/foreach}
    </select>
</form>

{if $selectedRol}
    <h3>Funciones asignadas</h3>
    <ul>
        {foreach $funcionesAsignadas as $func}
            <li>{$func.funciondsc} ({$func.estado})</li>
        {/foreach}
    </ul>

    <h3>Funciones disponibles</h3>
    <ul>
        {foreach $funcionesNoAsignadas as $func}
            <li>{$func.funciondsc}</li>
        {/foreach}
    </ul>
{/if}
