<?php

namespace Controllers\Mantenimientos;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Estudiantes\Estudiantes as EstudianteDAO;

class Estudiantes extends PublicController
{

    public function run(): void
    {
        $viewData = [];
        $tmpEstudiantes = EstudianteDAO::obtenerEstudiantes();
        $viewData["estudiantes"] = $tmpEstudiantes;
        $viewData["total"] = count($viewData["estudiantes"]);
        Renderer::render("mantenimientos/estudiantes/listaEst", $viewData);
    }
}
