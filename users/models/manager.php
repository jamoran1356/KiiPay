<?php
require_once 'connect.php';

class Manage {
    private $conexion;
    private $strcodigo;

    public function __construct(){
        $this->conexion = new ConexionBDD();
        $this->conexion = $this->conexion->connect();
    }

    public function generarCodigo(int $ancho){
        $this->strcodigo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $ancho);
        return $this->strcodigo;
    }


    //se crea la funcion que genera el codigo de verificacion y lo almacena en la base de datos
    public function crear_verificacion($idpersona){
        for($i=0; $i<=4; $i++){
            $c[$i] = strtoupper(self::generarCodigo(5));
        }
        $codigo = $c[0]. '-'.$c[1].'-'.$c[2].'-'.$c[3];
        $codigo_hash = password_hash($codigo,PASSWORD_DEFAULT);
        $sql = "INSERT INTO persona_verificacion (idpersona, codigo) VALUES (?, ?)";
        $insert = $this->conexion ->prepare($sql);
        $Data = array($idpersona, $codigo_hash);
        $excInsert = $insert->execute($Data);
        return $codigo;
    }

    public function verificacion($tipo, $token, $correo){
        $id = self::obtener_id($correo);
        if($id>0){
            $sql = "SELECT codigo, idpersona FROM persona_verificacion WHERE idpersona = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$id]);
            $data = $smts->fetch(PDO::FETCH_ASSOC);
            if($data){
                $dbcodigo = $data['codigo'];
                if(password_verify($token, $dbcodigo)){
                    $sql = "UPDATE persona_profile SET verificado = 1 WHERE idpersona = ?";
                    $smts = $this->conexion->prepare($sql);
                    $smts->execute([$id]);
                    $data = $smts->rowCount();
                    
                    $sql2 = "DELETE FROM persona_verificacion WHERE idpersona = ?";
                    $smts2 = $this->conexion->prepare($sql2);
                    $smts2->execute([$id]);
                    $data2 = $smts2->rowCount();
                    $_SESSION['id'] = $id;
                    return $id;
                } else {
                    //error en el codigo de verificacion
                    return 0;
                }
            } else {
                //no existe el codigo en la tabla
                return 2;
            }
        } else {
            //no existe la persona
            return 3;
        }
    }

    public function mostrar_listado_persona() {
        $sql = "SELECT p.nombre, p.apellido, p.date_created, p.verificado, a.estado, a.zipcode
        FROM persona_profile p 
        INNER JOIN persona_address a ON p.idPersona = a.idPersona
        ORDER BY p.idpersona DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function crear_session_admin($correo, $idpersona, $nombre){
        $_SESSION['id999822'] = $idpersona;
        $_SESSION['nm167852'] = $nombre;
        $_SESSION['em158325'] = $correo;
    }

    public function login($correo, $clave){
        $sql = "SELECT idpersona, nombre, apellido, email, clave FROM persona_profile WHERE email = ? ORDER BY idpersona DESC LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$correo]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data !== false) {
            $dbclave = $data['clave'];
            if(!empty($dbclave)){
                if(password_verify($clave, $dbclave)){
                    $nombre = isset($data['nombre']) ? $data['nombre'] : "";
                    $apellido = isset($data['apellido']) ? $data['apellido'] : "";
                    $username = $nombre .' ' . $apellido;
                    self::crear_session_admin($correo, $data['idpersona'], $username);
                    return 1;
                } else {
                    return 0; // contraseña incorrecta
                }
            } else {
                return 3; //usuario no existe
            }
        } else {
            return 3; //usuario no existe
        }
    }

    function getMonthName($mes) {
        $monthNames = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];
        
        return $monthNames[$mes];
    }

    public function format_fecha($fecha){
        $date = explode("-", $fecha);
        $mes = $date[1];
        $mes = self::getMonthName($mes);
        $year = $date[0];
        $fecha_format = $mes.' '.$year;
        return $fecha_format;
    }


    public function cuenta_admin(){
        $sql = "SELECT COUNT(*) AS total FROM persona_profile WHERE rol = 'Administrador";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchColumn();
        return $data;
    }
    
    public function getEndPoints($titulo){
        $sql = "SELECT * FROM endpoints WHERE titulo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$titulo]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function updateEndPoint($id, $url){
        $sql = "UPDATE endpoints SET url = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$url, $id]);
        $data = $stmt->rowCount();
        return $data;
    }

    function getEndPoint($titulo){
        $sql = "SELECT url FROM endpoints WHERE titulo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$titulo]);
        $data = $stmt->fetchColumn();
        return $data;
    }

    public function enviar_correo_personal($correo, $codigo, $idpersona, $rol){
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
        require 'PHPMailer/src/Exception.php';
    
        $mail = new PHPMailer\PHPMailer\PHPMailer();
    
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'mail.pydti.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hello@pydti.com';
        $mail->Password = 'XR!3c.+lFQgT';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        
        if($rol == 'Vendedor'){
            $url = self::getEndPoint('url_vendedores');
            $url = str_replace('$codigo', $codigo, $url);
            $url = str_replace('$correo', $correo, $url);

        } 
        if($rol == 'Administrador'){
            $url = self::getEndPoint('url_admin');
            $url = str_replace('$codigo', $codigo, $url);
            $url = str_replace('$correo', $correo, $url);
        }
        
    
         // Configuración del correo electrónico
         $mail->setFrom('no-reply@pydti.com', 'Control y Seguimiento de clientes');
         $mail->addAddress($correo);
         $mail->CharSet = 'UTF-8';
         $mail->Subject = 'Bienvenido a Sistema de Gestión GRUPO CIF
         - Verificación de cuenta';
         $mail->isHTML(true);
         $mail->Body = '
         <!DOCTYPE html>
         <html lang="en">
         <head>
             <meta charset="UTF-8">
             <meta http-equiv="X-UA-Compatible" content="IE=edge">
             <meta name="viewport" content="width=device-width, initial-scale=1.0">
             <title>Bienvenido al sistema administrativo Grupo CIF</title>
         </head>
         <body>
             <table width="600px" style="margin: auto; padding: auto; font-family: Geneva, Tahoma, sans-serif; font-size: 0.9rem; overflow: hidden;" cellspacing="0" cellpadding="0">
                 <tr>
                     <td style="height: 100px;"></td>
                 </tr>
                 <tr>
                     <td style="height: 100px; text-align:center"><img src="https://pydti.com/portafolio/grupocif/admin/assest/images/logo_email.jpg" alt="logo Grupo CIF"></td>
                 </tr>
                 <tr>
                     <td style="height: 100px; font-size: 0.9rem; color: #454546; text-align:center"><h1>Bienvenido a nuestro sistema administrativo!</h1></td>
                 </tr>
                 <tr>
                     <td style="padding-left: 15px; padding-right: 15px; font-size: 0.9rem; color: #454546; text-align:justify  ">
                         
                         <p>Bienvenido a nuestro sistema, la presente es para notificarle que se ha generado una cuenta para usted en nuestro sistema de <strong>Gestión administrativa</strong> con el rol de: <strong>'.$rol.'</strong>. Este sistema es una plataforma tecnológica que facilitará el control de los avances de las ventas, pagos, contacto y seguimiento de clientes.</p>
                         <p>Para comprobar que la data que tenemos es precisa, es necesario que verifiques tu correo, el cual será usado para poder ingresar a nuestro sistema, y para comunicarnos contigo.</p>
                         <p>Para verificar tu correo haz click en el siguiente enlace, una vez verificado, podrás crear tu contraseña de acceso a nuestro sistema:</p>
                         <a target="_blank" href="'.$url.'">Verificar correo</a>
                         <p>Queremos que este sistema sea de fácil uso, es por ello que si tienes alguna duda o comentario, no dudes en  <a href="mailto:sugerencias@grupocif.com" style="text-decoration: underline; color:#5d3d79">contactarnos</a>.</p>
                         </td>
                 </tr>
                 <tr>
                     <td style="height:80px;"></td>
                 </tr>
                 <tr>
                     <td style="height:80px;">        
                     <p style="font-size: 0.8rem; color: #454546; text-align: center; margin-top: 50px;">Esta dirección de correo es un buzón no monitoreado, por lo que recomendamos no responder a el remitente de este mensaje. Recibes este correo por que te han suscrito a nuestro sitio web, si crees que esto ha sido un error puedes darte de baja en este <a href="#" class="linkfooter">enlace</a></p>
                     </td>
                 </tr>
                 <tr>
                     <td style="height:80px;"></td>
                 </tr>    
             </table>
             </div>
         </body>
         </html>';
    
        if($mail->send()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function grabar__($pnombre, $snombre, $papellido, $sapellido, $identificacion, $email, $celular, $clave, $rol){
        $existe = self::check_personal($identificacion);
        if ($existe>0){
            return 0;
        } else {
            $idpersona = self::grabar_personal($pnombre, $snombre, $papellido, $sapellido, $identificacion, $email, $celular, $clave, $rol);
            $codigo = self::crear_verificacion($idpersona);
            //$rs = self::enviar_correo_personal($email, $codigo, $idpersona, $rol);
            return $idpersona;
        }
    }

   

    
    public function savedepto($idpersona, $nombre, $descripcion){
        $fecha = date('Y-m-d');
        $sql = "INSERT INTO departamento (creado_por, titulo, descripcion, fecha_creado) VALUES (?, ?, ?, ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona, $nombre, $descripcion, $fecha]);
        $data = $this->conexion->LastInsertId();
        return $data;
    }

    public function upddepto($idpersona, $nombre, $descripcion, $id){
        $sql = "UPDATE departamento SET titulo = ?, descripcion = ? WHERE creado_por = ? AND iddepartamento = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$nombre, $descripcion, $idpersona, $id]);
        $data = $smts->rowCount();
        return $data;
    }

   

    public function getdptos_paginado($inicio, $registros, $orden){
        $sql = "SELECT iddepartamento, titulo
        FROM departamento
        ORDER BY titulo $orden 
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $key => $value) {
            $data[$key]['total_empleados'] = self::contar_empleados_dpto($value['iddepartamento']);
        }
        return $data;
    }

    public function getManagerDpto($iddepartamento){
        $sql = "SELECT dm.idpersona, p.nombre, p.apellido, im.imagen FROM departamento_manager dm
        INNER JOIN persona_profile p ON dm.idpersona = p.idpersona
        LEFT JOIN persona_profile_pic im ON dm.idpersona = im.idPersona
        WHERE dm.departamento_id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$iddepartamento]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function check_Manager_Dpto($idempleado){
        $sql = "SELECT COUNT(*) AS total FROM departamento_manager WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data = $smts->fetchColumn();
        return $data;
    }

    public function contar_dptos(){
        $sql = "SELECT COUNT(*) AS total FROM departamento";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $data = $smts->fetchColumn();
        return $data;
    }

    public function get_dptos(){
        $sql = "SELECT iddepartamento, titulo FROM departamento ORDER BY titulo ASC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $data = $smts->fetchAll();
        return $data;
    }

    public function get_dptos_by_id($id){
        $sql = "SELECT iddepartamento, titulo, descripcion FROM departamento WHERE iddepartamento = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll();
        return $data;
    }

    public function del_depto($idpersona, $id){
        $sql = "DELETE FROM departamento WHERE iddepartamento = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->rowCount();
        if($data>0){
            self::grabar_log($idpersona, 'Ha eliminado el departamento # '.$id, 'eliminación');
            return 1;
        } else {
            return 0;
        }
        
    }

    public function get_dptos_select($idpersona){
        $sql = "SELECT iddepartamento as id, titulo as nombre FROM departamento WHERE creado_por = ? ORDER BY titulo ASC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona]);
        $data = $smts->fetchAll();
        return $data;
    }

    function grabar_log($idpersona, $accion, $tipo){
        $fecha = date('Y-m-d H:i:s');
        $sql = "INSERT INTO persona_log (idpersona, accion, tipo, fecha_incidencia) VALUES (?, ?, ?, ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona, $accion, $tipo, $fecha]);
        $data = $this->conexion->LastInsertId();
        return $data;
    }

    function grabar_perfil_empleado($nombre, $apellido, $nacimiento, $sexo, $identificacion, $correo, $movil, $tipo_acceso, $acceso){
        $fecha = date('Y:m:d');
        $sql = "INSERT INTO persona_profile (nombre, apellido, identificacion, fecha_nacimiento, sexo, email, celular, has_access, tipo, date_created) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$nombre, $apellido, $identificacion, $nacimiento, $sexo, $correo, $movil, $tipo_acceso, $acceso, $fecha]);
        $data = $this->conexion->LastInsertId();
        return $data;        
       

    }

    function grabar_direccion_empleado($idempleado, $direccion, $ciudad){
        $sql = "INSERT INTO persona_address (idpersona, address_line1, city) VALUES (?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado, $direccion, $ciudad]);
        $data = $this->conexion->LastInsertId();
        return $data;
    }

    function grabar_img_perfil_empleado($idempleado, $imagen){
        $sql = "INSERT INTO persona_profile_pic (idpersona, imagen) VALUES (?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado, $imagen]);
        $data = $this->conexion->LastInsertId();
        return $data;
    }

    function grabar_historial($idempleado, $fecha_ingreso, $cargo, $ismanager, $departamento){
        $sql = "INSERT INTO persona_laboral (idpersona, fecha_ingreso, cargo, is_manager, departamento) VALUES (?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado, $fecha_ingreso, $cargo, $ismanager, $departamento]);
        $data = $this->conexion->LastInsertId();
        return $data;
    }

    function grabar_manager_dpto($idempleado, $deptoid){
        $sql = "INSERT INTO departamento_manager (idpersona, departamento_id) VALUES (?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado, $deptoid]);
        $data = $this->conexion->LastInsertId();
        return $data;
    }

    function check_empleado($correo){
        $sql = "SELECT COUNT(*) AS total FROM persona_profile WHERE email = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$correo]);
        $data = $smts->fetchColumn();
        return $data;
    }

    public function grabar_empleado($nombre, $apellido, $nacimiento, $sexo, $identificacion, $correo, $celular, $acceso, $direccion, $ciudad, $imagen, $fecha_ingreso, $cargo, $departamento, $ismanager, $idpersona){
        $is_manager = isset($ismanager) ? 1 : 0;
        $check_empleado = self::check_empleado($correo);
        if($check_empleado>0){
            //existe empleado
            return 3;
        }
        if($acceso=='no-acceso'){
            $tipo_acceso = 0;
            $idempleado = self::grabar_perfil_empleado($nombre, $apellido, $nacimiento, $sexo, $identificacion, $correo, $celular, $tipo_acceso, $acceso);    
        } else {
            $tipo_acceso = 1;
            $idempleado = self::grabar_perfil_empleado($nombre, $apellido, $nacimiento, $sexo, $identificacion, $correo, $celular, $tipo_acceso, $acceso);    
        }
        $idaddress = self::grabar_direccion_empleado($idempleado, $direccion, $ciudad);
        $idpic = self::grabar_img_perfil_empleado($idempleado, $imagen);
        $idhistorial = self::grabar_historial($idempleado, $fecha_ingreso, $cargo, $is_manager, $departamento);

        if($ismanager){
            $idmanager = self::grabar_manager_dpto($idempleado, $departamento);
        }
        
        if($acceso=='no-acceso'){
            if($idempleado > 0 ){
                self::grabar_log($idpersona, 'Ha creado el perfil de usuario # '.$idempleado, 'registro');
                return 1;
            } else {
                return 0;
            } 
        } else {
            self::grabar_log($idpersona, 'Ha creado el perfil de usuario # '.$idempleado, 'registro');
            $codigo = self::crear_verificacion($idempleado);
            $rs = self::enviar_correo_personal($correo, $codigo, $idempleado, $acceso);
            if($rs>0){
                self::grabar_log($idpersona, 'se ha enviado el correo al empleado id '.$idempleado, 'correo');
                return 1;
            } else {
                //error enviando el correo
                return 2;
            }
        }
        
        
    }

    function obtener_id($correo){
        $sql = "SELECT idpersona FROM persona_profile WHERE email = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$correo]);
        $data = $smts->fetchColumn();
        return $data;
    }


    public function verifica_cuenta($token, $correo){
        $id = self::obtener_id($correo);
        if($id>0){
            $sql = "SELECT codigo, idpersona FROM persona_verificacion WHERE idpersona = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$id]);
            $data = $smts->fetch(PDO::FETCH_ASSOC);
            if($data){
                $dbcodigo = $data['codigo'];
                if(password_verify($token, $dbcodigo)){
                    $sql = "UPDATE persona_profile SET verificado = 1 WHERE idpersona = ?";
                    $smts = $this->conexion->prepare($sql);
                    $smts->execute([$id]);
                    $data = $smts->rowCount();
                    return $data;
                } else {
                    //error en el codigo de verificacion
                    return 0;
                }
            } else {
                //no existe el codigo en la tabla
                return 2;
            }
        } else {
            //no existe la persona
            return 3;
        }
        
    }

    public function contar_empleados(){
        $sql = "SELECT COUNT(*) AS total FROM persona_laboral";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $data = $smts->fetchColumn();
        return $data;
    }

    public function getempleados_paginado($inicio, $registros, $orden){
        $sql = "SELECT pl.idpersona, pl.fecha_ingreso, pl.cargo, pl.departamento, p.nombre, p.apellido, p.email, p.celular, p.tipo, im.imagen, dp.titulo
        FROM persona_laboral pl
        INNER JOIN persona_profile p ON pl.idpersona = p.idpersona
        INNER JOIN persona_profile_pic im ON pl.idpersona = im.idpersona
        INNER JOIN departamento dp ON pl.departamento = dp.iddepartamento
        ORDER BY pl.idpersona $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchAll();
        return $data;
    }


    public function del_empleado($idempleado, $idpersona){
        $sql = "DELETE FROM persona_profile WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data = $smts->rowCount();
        
        $sql = "DELETE FROM persona_address WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data2 = $smts->rowCount();

        $sql = "SELECT imagen FROM persona_profile_pic WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data3 = $smts->fetchColumn();
        if ($data3!=='no-image.webp'){
            unlink('../assest/images/personal/'.$data3);
        }
        $sql = "DELETE FROM persona_profile_pic WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data4 = $smts->rowCount();
        
        $sql = "DELETE FROM persona_laboral WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data5 = $smts->rowCount();
        self::grabar_log($idpersona, 'se ha eliminado el '.$idempleado,  'eliminación');
        
        return $data;


    }
        
    public function getEmpId($idempleado){
        $sql = "SELECT pl.idpersona, pl.fecha_ingreso, pl.cargo, pl.is_manager, pl.departamento, p.nombre, p.apellido, p.identificacion, p.sexo, p.fecha_nacimiento, p.email, p.celular, p.tipo, pa.address_line1, pa.city, im.imagen, dp.titulo
        FROM persona_laboral pl
        INNER JOIN persona_profile p ON pl.idpersona = p.idpersona
        INNER JOIN persona_profile_pic im ON pl.idpersona = im.idpersona
        INNER JOIN persona_address pa ON pl.idpersona = pa.idpersona
        INNER JOIN departamento dp ON pl.departamento = dp.iddepartamento
        WHERE pl.idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data = $smts->fetchAll();
        return $data;
    }


    public function contar_empleados_dpto($iddepartamento){
        $sql = "SELECT COUNT(*) AS total FROM persona_laboral WHERE departamento = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$iddepartamento]);
        $data = $smts->fetchColumn();
        return $data;
    }

    function update_Personal_data($idpersona, $idempleado, $nombre, $apellido, $identificacion, $nacimiento, $sexo, $correo, $celular, $hasaccess, $acceso){
        $sql = "UPDATE persona_profile SET nombre = ?, apellido = ?, identificacion = ?, fecha_nacimiento = ?, sexo = ?, email = ?, celular = ?, has_access = ?, tipo = ? WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$nombre, $apellido, $identificacion, $nacimiento, $sexo, $correo, $celular,  $hasaccess, $acceso, $idempleado]);
        $data = $smts->rowCount();
        if($data>0){
            self::grabar_log($idpersona, 'se ha actualizado la data personal del empleado # '.$idempleado, 'actualización');
        }
        return $data;
    }

    function update_Personal_direccion($idempleado, $direccion, $ciudad, $idpersona){
        $sql = "UPDATE persona_address SET address_line1 = ?, city = ?WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$direccion, $ciudad, $idempleado]);
        $data = $smts->rowCount();
        if($data>0){
            self::grabar_log($idpersona, 'se ha actualizado la dirección del empleado # '.$idempleado, 'actualización');
        }
        return $data;
    }

    function update_Personal_Pic($idempleado, $idpersona, $imagen){
        $sql = "SELECT imagen FROM persona_profile_pic WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data = $smts->fetchColumn();
        
        if($imagen == $data){
            return 0;
        } else {
            if ($data && $data !== 'no-image.webp' && file_exists('../assest/images/personal/'.$data)){
                unlink('../assest/images/personal/'.$data);
            }
            $sql = "UPDATE persona_profile_pic SET imagen = ? WHERE idpersona = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$imagen, $idempleado]);
            $data = $smts->rowCount();
            if($data>0){
                self::grabar_log($idpersona, 'se ha actualizado la imagen de perfil del empleado # '.$idempleado, 'actualización');
            }
            return $data;
        }
    }

    function update_Personal_laboral($fecha_ingreso, $cargo, $departamento, $idempleado, $idpersona){
        $sql = "UPDATE persona_laboral SET fecha_ingreso = ?, cargo = ?, departamento = ? WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$fecha_ingreso, $cargo, $departamento, $idempleado]);
        $data = $smts->rowCount();
        if($data>0){
            self::grabar_log($idpersona, 'se ha actualizado la data laboral del empleado # '.$idempleado, 'actualización');
        }
        return $data;
    }

    public function updatePersonalProfile($idempleado, $nombre, $apellido, $nacimiento, $sexo, $identificacion, $correo, $celular, $acceso, $direccion, $ciudad, $imagen, $fecha_ingreso, $cargo, $departamento, $hasaccess, $ismanager, $idpersona){
        $rs = self::update_Personal_data($idpersona, $idempleado, $nombre, $apellido, $identificacion, $nacimiento, $sexo, $correo, $celular, $hasaccess, $acceso);
        $rs2 = self::update_Personal_direccion($idempleado, $direccion, $ciudad, $idpersona);
        $rs3 = self::update_Personal_Pic($idempleado, $idpersona, $imagen);
        $rs4 = self::update_Personal_laboral($fecha_ingreso, $cargo, $departamento, $idempleado, $idpersona);
        if($ismanager){
            $check_manager = self::check_Manager_Dpto($idempleado);
            if($check_manager==0){
                $idmanager = self::grabar_manager_dpto($idempleado, $departamento);
                self::grabar_log($idpersona, 'se ha asignado como manager al empleado # '.$idempleado, 'registro');
            }
        } else {
            $check_manager = self::check_Manager_Dpto($idempleado);
            if($check_manager>0){
                $sql = "DELETE FROM departamento_manager WHERE idpersona = ?";
                $smts = $this->conexion->prepare($sql);
                $smts->execute([$idempleado]);
                $data = $smts->rowCount();

                self::grabar_log($idpersona, 'se ha eliminado como manager al empleado # '.$idempleado,'eliminación');
            }
        }

        $rx = $rs + $rs2 + $rs3;
        if($rx > 0 ){
            return 1;
        } else {
            return 0;
        } 
    }

    public function crear_clave($idpersona, $clave){
        $clave_hash = password_hash($clave,PASSWORD_DEFAULT);
        $sql = "UPDATE persona_profile SET clave = ? WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$clave_hash, $idpersona]);
        $data = $smts->rowCount();
        
        if($data>0){
            self::grabar_log($idpersona, 'se ha creado la clave de acceso del empleado # '.$idpersona, 'actualización');
                $sql = "SELECT idpersona, nombre, apellido, email FROM persona_profile WHERE email = ? ORDER BY idpersona DESC LIMIT 1";
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute([$correo]);
                $data2 = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($data2 !== false) {
                            $nombre = isset($data['nombre']) ? $data['nombre'] : "";
                            $apellido = isset($data['apellido']) ? $data['apellido'] : "";
                            $username = $nombre .' ' . $apellido;
                            self::crear_session_admin($correo, $data['idpersona'], $username);
                }
            }
        return $data;
        }

        public function obtener_covertura(){
            $sql = "SELECT idcovertura, titulo FROM servicios_covertura ORDER BY titulo ASC";
            $smts = $this->conexion->prepare($sql);
            $smts->execute();
            $data = $smts->fetchAll();
            return $data;
        }

        public function obtener_servicios(){
            $sql = "SELECT id, titulo FROM servicios_servicio ORDER BY titulo ASC";
            $smts = $this->conexion->prepare($sql);
            $smts->execute();
            $data = $smts->fetchAll();
            return $data;
        }

        function guardar_plan($plan, $descripcion, $beneficiarios, $isactivo) {
            $fecha = date('Y:m:d');
            $sql = "INSERT INTO servicios_planes (plan, descripcion, num_beneficiarios, is_activo, fecha_creado) VALUES (?,?,?,?,?)";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$plan, $descripcion, $beneficiarios, $isactivo, $fecha]);
            $data = $this->conexion->LastInsertId();
            return $data;
        }

        function guardar_precio($idplan, $precio, $impuesto){
            $sql = "INSERT INTO servicios_precios (idplan, precio, impuesto) VALUES (?,?,?)";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$idplan, $precio, $impuesto]);
            $data = $this->conexion->LastInsertId();
            return $data;
        }

        function servicios_terminos($idplan, $terminos, $isterminos){
            $fecha = date('Y:m:d');
            $sql = "INSERT INTO servicios_terminos (idplan, terminos, fecha_creado, is_activo) VALUES (?,?,?,?)";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$idplan, $terminos, $fecha, $isterminos]);
            $data = $this->conexion->LastInsertId();
            return $data;
        }
        
        public function grabar_plan($plan, $descripcion, $beneficiarios, $precio, $impuesto, $isactivo, $isterminos, $terminos, $idpersona){
            $idplan = self::guardar_plan($plan, $descripcion, $beneficiarios, $isactivo);
            $idprecio = self::guardar_precio($idplan, $precio, $impuesto);
            if($isterminos == 1){
                $idterminos = self::servicios_terminos($idplan, $terminos, $isterminos);
            } else {
                $idterminos = 0;
                $idterminos = self::servicios_terminos($idplan, "", $isterminos);
            }
            if($idplan>0){
                self::grabar_log($idpersona, 'se ha creado el plan # '.$plan,  'registro');
                return 1;
            } else {
                return 0;
            }
        }

        public function contar_planes(){
            $sql = "SELECT COUNT(*) AS total FROM servicios_planes";
            $smts = $this->conexion->prepare($sql);
            $smts->execute();
            $data = $smts->fetchColumn();
            return $data;
        }

        public function getplanes_paginado($inicio, $registros, $orden){
            $sql = "SELECT sp.idplan, sp.plan, sp.num_beneficiarios, sp.is_activo, sp.fecha_creado, pp.precio, pp.impuesto FROM
            servicios_planes sp
            INNER JOIN servicios_precios pp ON sp.idplan = pp.idplan
            ORDER BY sp.plan ASC";
            $smts = $this->conexion->prepare($sql);
            $smts->execute();
            $data = $smts->fetchAll();
            return $data;

        }

        public function get_plan_by_id($id){
            $sql = "SELECT sp.idplan, sp.plan, sp.descripcion, sp.num_beneficiarios, sp.is_activo, pp.precio, pp.impuesto, st.terminos, st.is_activo as isterminos FROM
            servicios_planes sp
            INNER JOIN servicios_precios pp ON sp.idplan = pp.idplan
            LEFT JOIN servicios_terminos st ON sp.idplan = st.idplan
            WHERE sp.idplan = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$id]);
            $data = $smts->fetchAll();
            return $data;
        }

        public function delete_plan($idplan, $idpersona){
            $sql = "DELETE FROM servicios_planes WHERE idplan = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$idplan]);
            $data = $smts->rowCount();

            $sql2 = "DELETE FROM servicios_precios WHERE idplan = ?";
            $smts2 = $this->conexion->prepare($sql2);
            $smts2->execute([$idplan]);
            $data2 = $smts2->rowCount();

            $sql3 = "DELETE FROM servicios_terminos WHERE idplan = ?";
            $smts3 = $this->conexion->prepare($sql3);
            $smts3->execute([$idplan]);
            $data3 = $smts3->rowCount();

            if($data>0){
                self::grabar_log($idpersona, 'se ha eliminado el plan # '.$idplan, 'eliminación');
            }
            return $data;
        }

        public function actualizar_plan($idplpan, $plan, $descripcion, $beneficiarios, $precio, $impuesto, $isactivo, $isterminos, $terminos, $idpersona){
            $sql = "UPDATE servicios_planes SET plan = ?, descripcion = ?, num_beneficiarios = ?, is_activo = ? WHERE idplan = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$plan, $descripcion, $beneficiarios, $isactivo, $idplpan]);
            $data = $smts->rowCount();

            $sql2 = "UPDATE servicios_precios SET precio = ?, impuesto = ? WHERE idplan = ?";
            $smts2 = $this->conexion->prepare($sql2);
            $smts2->execute([$precio, $impuesto, $idplpan]);
            $data2 = $smts2->rowCount();

            if($isterminos == 1){
                $sql3 = "UPDATE servicios_terminos SET terminos = ?, is_activo = ? WHERE idplan = ?";
                $smts3 = $this->conexion->prepare($sql3);
                $smts3->execute([$terminos, $isterminos, $idplpan]);
                $data3 = $smts3->rowCount();
            } else {
                $sql3 = "UPDATE servicios_terminos SET is_activo = ? WHERE idplan = ?";
                $smts3 = $this->conexion->prepare($sql3);
                $smts3->execute([$isterminos, $idplpan]);
                $data3 = $smts3->rowCount();
            }

            if($data>0){
                self::grabar_log($idpersona, 'se ha actualizado el plan # '.$idplpan, 'actualización');
                return 1;
            } else {
                return 0;
            }
        }

        public function getplanes_select(){
            $sql = "SELECT idplan, plan FROM servicios_planes WHERE is_activo = 1 ORDER BY plan ASC";
            $smts = $this->conexion->prepare($sql);
            $smts->execute();
            $data = $smts->fetchAll();
            return $data;
        }

        public function obtener_datos_plan($idplan){
            $sql = "SELECT sp.idplan, sp.plan, sp.num_beneficiarios, sp.is_activo, sp.fecha_creado, pp.precio, pp.impuesto FROM servicios_planes sp
            INNER JOIN servicios_precios pp ON sp.idplan = pp.idplan
            WHERE sp.idplan = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$idplan]);
            $data = $smts->fetchAll();
            return $data;
        }

        public function getClientes($inicio, $registros, $orden){
            $sql = "SELECT pp.idpersona, pp.nombre, pp.apellido, pp.email FROM persona_profile pp ORDER BY nombre $orden LIMIT $inicio, $registros";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([]);
            $data = $smts->fetchAll();
            return $data;
        }

        public function grabar_icono($titulo, $descripcion, $imagen){
            $sql = "INSERT INTO iconos (titulo, descripcion, imagen) VALUES (?,?,?)";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$titulo, $descripcion, $imagen]);
            $data = $this->conexion->LastInsertId();
            return $data;
        }

        public function contar_iconos(){
            $sql = "SELECT COUNT(*) AS total FROM iconos";
            $smts = $this->conexion->prepare($sql);
            $smts->execute();
            $data = $smts->fetchColumn();
            return $data;
        }

        public function editar_iconos($idicono, $titulo, $descripcion, $imagen){
            $sql = "UPDATE iconos SET titulo = ?, descripcion = ?, imagen = ? WHERE id = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$titulo, $descripcion, $imagen, $idicono]);
            $data = $smts->rowCount();
            return $data;
        }

        public function geticonos_paginado($inicio, $registros, $orden){
            $sql = "SELECT id, titulo, descripcion, imagen FROM iconos ORDER BY titulo $orden LIMIT $inicio, $registros";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([]);
            $data = $smts->fetchAll();
            return $data;
        }

        public function get_paises(){
            $sql = "SELECT id, nombre FROM paises ORDER BY nombre ASC";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([]);
            $data = $smts->fetchAll();
            return $data;
        }

        

        

}
?>
