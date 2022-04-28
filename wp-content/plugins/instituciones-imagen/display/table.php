<?php
function menu_instituciones_imagen() {
    add_menu_page('Instituciones Imagen',
    'Instituciones Imagen',
    'manage_options',
    'instituciones_imagen',
    'generar_pantalla_instituciones_imagen','',3
    );
}


function generar_pantalla_instituciones_imagen() {
	$rows_institucion_pais = sql_institucion_pais();
	$trHtml = '';
    foreach ($rows_institucion_pais as $institucion_pais ){
        $trHtml .= "<tr>
                        <td colspan='4' style='text-align: center; font-weight: bold'>
                            {$institucion_pais['institucion']}
                        </td>
                    </tr>";
		
		
    foreach ($institucion_pais['pais'] as $pais){
            $code = strtolower($institucion_pais["institucion"].'_'.$pais);
            $code =  str_replace(" ", "_", $code);

            $trHtml .= '<tr code="'.$code .'}">
                        <td>
                            '.$code .'
                        </td>
                        <td>'.$institucion_pais['institucion'].'</td>
                        <td>'.$pais.'</td>
                        <td>
                            <form action="post" enctype="multipart/form-data">
                            <input code="'.$code .'"  type="file" name="image_intitucion">
                            <input type="hidden" name="ountry" value="'.$pais.'">
                            <input type="hidden" name="institution" value="'.$institucion_pais['institucion'].'">
                            <br>
                            <button class="btn btn-success">Enviar</button>
                            </form>                        
                        </td>
                    </tr>';
        }
    }

    $html = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">';
    $html .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';
    $html .= "<h1 style='width: 100%; text-align: center; margin-top: 20px'>Manejar Instituciones</h1><br>";
    $html .= '<div class="container" style="margin: 0px;">
        <table class="table table-bordered table-hover table-striped" id="tb">
            <thead>
            <tr>
                <th>Código</th>
                <th>Institución</th>
                <th>País</th>
                <th style="width: 10%">Imagen</th>
            </tr>
            </thead>
            <tbody>
            '.$trHtml.'
            </tbody>
        </table>
    </div>';
    $html .= '<nav aria-label="...">
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link">Aterior</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">Siguiente</a>
            </li>
        </ul>
    </nav>';
    echo $html;
}




add_action('admin_menu', 'menu_instituciones_imagen');