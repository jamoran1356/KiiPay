<?php

require_once 'clientes.php';
require_once 'actividades.php';

$cn = new Clientes();
$ac = new Actividad();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
        .abierto{
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            margin: 0 auto;
            padding: 10px;
        }
        .cerrado{
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            margin: 0 auto;
            padding: 10px;
        }
        .hide{
            display: none;
        }
    </style>
</head>
<body>
    <h1>Test</h1>
    <select id="casos">
        <option value="0">Seleccione</option>
        <option value="1">Abierto</option>
        <option value="2">Cerrado</option>
    </select><br><br>
    <div id="abierto" class="abierto">
    <table class="table table-hover my-0" id="tblip">
						<thead>
							<tr>
							<th>Fecha solicitud</th>
							<th>Empresa</th>
							<th class="d-none d-xl-table-cell">Patente</th>
							<th class="d-none d-xl-table-cell">KM Actual</th>
							<th class="d-none d-xl-table-cell">Estado Unidad</th>
							<th class="d-none d-xl-table-cell">Fecha Ú.M.</th>
							<th class="d-none d-xl-table-cell">Servicio</th>
							<th class="d-none d-xl-table-cell">Inspector</th>
							<th></th>
							</tr>
						</thead>
						<tbody id="tbl-actividadesip">
						<?php
                        $ip = $ac -> listado_solicitudes_ip_paginado(0, 10, 'DESC', 1);
                        if(!empty($ip)){
                            foreach ($ip as $actividad => $xp) {
                        ?>
            				<tr>
							<td><?= $xp['fecha_solicitud']; ?></td>
							<td><?= $xp['empresa']; ?></td>
							<td class="d-none d-xl-table-cell"><?= $xp['ppu']; ?></td>
							<td class="d-none d-xl-table-cell"><?= $xp['km_actual']; ?></td>
							<td class="d-none d-xl-table-cell"><?= $xp['estatus']; ?></td>
							<td class="d-none d-xl-table-cell"><?= $xp['km_ultima']; ?></td>
							<td class="d-none d-xl-table-cell"><?= $xp['tipo_servicio']; ?></td>
							<td class="d-none d-xl-table-cell"><?= $xp['inspector_edo']['0']; ?></td>
							<td></th>
							</tr>
                        
                        <?php

                            }
                        }
                        ?>


						</tbody>
						</table>
    </div>    
    <div id="cerrado" class="cerrado hide">
    <table class="table table-hover my-0" id="tblip">
						<thead>
							<tr>
							<th>Fecha solicitud</th>
							<th>Empresa</th>
							<th class="d-none d-xl-table-cell">Patente</th>
							<th class="d-none d-xl-table-cell">KM Actual</th>
							<th class="d-none d-xl-table-cell">Estado Unidad</th>
							<th class="d-none d-xl-table-cell">Fecha Ú.M.</th>
							<th class="d-none d-xl-table-cell">Servicio</th>
							<th></th>
							</tr>
						</thead>
						<tbody id="tbl-actividadesip">
						<?php
                        $ip = $ac -> listado_solicitudes_ip_paginado(0, 10, 'DESC', 3);
                        if(!empty($ip)){
                            foreach ($ip as $actividad => $xp) {
                        ?>
            				<tr>
							<td><?= $xp['fecha_solicitud']; ?></td>
							<td><?= $xp['empresa']; ?></td>
							<td class="d-none d-xl-table-cell"><?= $xp['ppu']; ?></td>
							<td class="d-none d-xl-table-cell"><?= $xp['km_actual']; ?></td>
							<td class="d-none d-xl-table-cell"><?= $xp['estatus']; ?></td>
							<td class="d-none d-xl-table-cell"><?= $xp['km_ultima']; ?></td>
							<td class="d-none d-xl-table-cell"><?= $xp['tipo_servicio']; ?></td>
							<td></th>
							</tr>
                        
                        <?php

                            }
                        }
                        ?>


						</tbody>
						</table>
    </div>    
    
<script>
    if(document.getElementById('casos')){
        document.getElementById('casos').addEventListener('change', function(){
            var valor = this.value;
            if(valor == 1){
                document.getElementById('abierto').classList.remove('hide');
                document.getElementById('cerrado').classList.add('hide');
            }else if(valor == 2){
                document.getElementById('cerrado').classList.remove('hide');
                document.getElementById('abierto').classList.add('hide');
            }
        });
    }
</script>
</body>
</html>


