/**
 * Sistema de facturacion
 * Version: 1.0.1
 * Author: Jesus Moran
 * Author URI: 
 */


 // Muestra el loader
 function showLoader() {
    document.getElementById("loader").style.display = "flex";
  }
  
  // Oculta el loader
  function hideLoader() {
    document.getElementById("loader").style.display = "none";
  }

function login(){
  showLoader();
  setTimeout(async ()=> {
    let username = document.getElementById('logemail').value;
    let password = document.getElementById('logpassword').value;

    let frm = new FormData();
    frm.append('logemail', username);
    frm.append('logpassword', password);

    let resp = await fetch('controllers/login.php?op=login', {
      method: 'post',
      cache: 'no-cache',
      mode: 'same-origin',
      body: frm
    });

    let json = await resp.json();
    if(json.status){
      hideLoader();
      window.location.href = 'index.php';
    } else {
      hideLoader();
      Swal.fire(
        "Error",
        json.msg,
        "warning",
      );
    }
  }, 1500);
}

if(document.getElementById('btnlogin')){
  document.getElementById('btnlogin').addEventListener('click', (e)=>{
    e.preventDefault();
    login();
  })
}

//funcion para actualizar la informacion del usuario
$('#guardarprofile').on('click', function(e){
  e.preventDefault(); 
  showLoader();
  setTimeout(function() {
      
      const data = $('#frmcuenta').serialize();
      $.ajax({
          type: 'post',
          url: 'controllers/personal.php?op=updacct',
          data: data,
          dataType: 'json',
          success:function(response){
              if(response.status){
                  switch(response.msg){
                      case 'OK':
                          hideLoader();
                          Swal.fire(
                              "Exito",
                              "La información se ha guardado de forma exitosa",
                              "success",
                          );
                          break; 
                      
                  }//fin switch
              } else {
                  switch (response.msg) {
                      case 'ERROR_01':
                          hideLoader();    
                          Swal.fire(
                              "Error",
                              "Hubo un error almacenando la informacion",
                              "warning",
                          );
                          break; 
                  }
              }
          }//fin success
      });//fin ajax    
  }, 1500);
});
  

//consulta y llenado de un selector de paises 
async function getPaises(selectId){
  let resp = await fetch('controllers/manager.php?op=getpaises', {
    method: 'get', 
    cache: 'no-cache',
  });

  let json = await resp.json();
  if(json.status){
      let data = json.data;
      const slt = document.getElementById(selectId);
      data.forEach(itm => {
          const opt = document.createElement('option');
          opt.value = itm.id;
          opt.text = itm.nombre;
          slt.appendChild(opt);
      });
    } else {
      console.log('no hay datos');
    }
      
}

if (document.getElementById('pais')){
  getPaises('pais');
}


if(document.getElementById('btntipo1')){
  const btnp1 = document.getElementById('btntipo1');
  const btnp2 = document.getElementById('btntipo2');
  const lbp1 = document.getElementById('lbtipo1');
  const lbp2 = document.getElementById('lbtipo2');
  const btxt = document.querySelectorAll('.business');

  btxt.forEach(element => {
    element.classList.add('hide');
  });

  lbp1.addEventListener('click', (e)=>{
    e.preventDefault();
    btnp1.checked = true;
    btnp2.checked = false;
    const btxt = document.querySelectorAll('.business');
    btxt.forEach(element => {
        element.style.display='none';
    });
    
});

lbp2.addEventListener('click', (e)=>{
    e.preventDefault();
    btnp1.checked = false;
    btnp2.checked = true;
    const btxt = document.querySelectorAll('.business');
    btxt.forEach(element => {
        element.style.display='block';
    });
    
});
  
    
}

async function getAdmProfile(){
  let resp = await fetch('controllers/personal.php?op=getAdmProfile', {
    method: 'get',
    cache: 'no-cache',
    mode: 'same-origin'
  });
  return resp.json();
}

if(document.getElementById('nombre')){
  getAdmProfile().then((response)=>{
    const data = response.data;
    document.getElementById('nombre').value = data.nombre;
    document.getElementById('apellido').value = data.apellido;
    document.getElementById('identificacion').value = data.identificacion;
    document.getElementById('correo').value = data.email;
    document.getElementById('movil').value = data.telefono;
    document.getElementById('direccion').value = data.address_line1;
    document.getElementById('pais').value = data.pais;
    document.getElementById('ciudad').value = data.city;
    document.getElementById('postal').value = data.zipcode;
  })
}

async function get_manager_dpto(id){
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/departamentos.php?op=gmdpto', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });
  let json = await resp.json();
  if(json.status){
    const item = json.data[0];
    const html = `${item.nombre} ${item.apellido}`
    return html;
  } else {
    return 'No asignado';
  }
}

async function getdepartamentos(pgact){
  var pgact = pgact ?? 1;
  const frm = new FormData();
  frm.append('pg', pgact);

  let resp = await fetch('controllers/departamentos.php?op=getdpto', {
    method: 'POST',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm

  });
  let json = await resp.json();

  if(json.status){
    let data = json.data;
    let paginas = json.total_paginas;
    
    const tbl = document.getElementById('tbl-departamentos');
    tbl.innerHTML = "";
    data.forEach(async (item) => {
       const manager = await get_manager_dpto(item.iddepartamento);
       const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>
        ${item.titulo}<br>
        </td>
        <td><div class="tbl-img">${manager}</div></td>
        <td>
        ${item.total_empleados}
        </td>
        <td class="submenu">
          <button onclick="predit_dpto(${item.iddepartamento})"><i class="align-middle" data-feather="edit-3"></i></button>
          <button onclick="confirmar_del(${item.iddepartamento}, 'departamentos.php?op=dltdpto')"><i class="align-middle" data-feather="trash-2"></i></button>
        </td>`;
        tbl.appendChild(tr);
        feather.replace();

        //paginacion
        const paginacion = document.getElementById('dptos-pagination');
        if (pgact == 1) {
          paginacion.innerHTML = `<li class="page-item disabled"><a class="page-link">&laquo;</a></li>`;
        } else {
            let pba = pgact - 1;
            paginacion.innerHTML = `<li class="page-item"><a href="#" class="page-link" onclick="getdepartamentos(${pba})">«</a></li>`;
        }
        
        for (let i = 1; i <= paginas; i++) {
            if (pgact == i) {
                paginacion.innerHTML += `<li class="page-item"><a class="page-link active" href="#" onclick="getdepartamentos(${i})">${i}</a></li>`;
            } 
        }
        
        if (pgact == paginas) {
            paginacion.innerHTML += `<li class="page-item disabled"><a class="page-link" href="#">»</a></li>`;
        } else {
            let pgn = pgact + 1;
            paginacion.innerHTML += `<li class="page-item"><a href="#" class="page-link" onclick="getdepartamentos(${pgn})">»</a></li>`;
        }

    });


  } else {
    console.log('no hay datos')
  }
}
if(document.getElementById('tbl-departamentos')){
  getdepartamentos();
}


if(document.getElementById('acciones-tbl')){
  const accionestbl = document.getElementById('acciones-tbl');
  accionestbl.addEventListener('click', (e)=>{
    e.preventDefault();
    const ul = accionestbl.nextElementSibling;
    ul.classList.toggle('hide');
  })
}

// $('#btndepartamento').on('click', function(e){
//   e.preventDefault(); 
//   showLoader();
//   setTimeout(function() {
      
//       const data = $('#frmdepartamento').serialize();
//       $.ajax({
//           type: 'post',
//           url: 'controllers/departamentos.php?op=svdpto',
//           data: data,
//           dataType: 'json',
//           success:function(response){
//               if(response.status){
//                   switch(response.msg){
//                       case 'OK':
//                           $('#frmdepartamento').find('input:text, textarea').val('');
//                           getdepartamentos();
//                           hideLoader();
//                           Swal.fire(
//                               "Exito",
//                               "La información se ha guardado de forma exitosa",
//                               "success",
//                           );
//                           break; 
//                   }//fin switch
//               } else {
//                   switch (response.msg) {
//                       case 'ERROR_01':
//                           hideLoader();    
//                           Swal.fire(
//                               "Error",
//                               "Hubo un error almacenando la informacion",
//                               "warning",
//                           );
//                           break; 
//                   }
//               }
//           }//fin success
//       });//fin ajax    
//   }, 1500);
// });


function obtener_num_dptos(){
  let resp = fetch('controllers/departamentos.php?op=getnumdptos', {
    method: 'get',
    cache: 'no-cache',
    mode: 'same-origin'
  });
  resp.then((response)=>{
    response.json().then((json)=>{
      document.getElementById('total_departamentos').innerHTML = json.data;
    })
  })
}

if(document.getElementById('total_departamentos')){
  obtener_num_dptos()
}

if(document.getElementById('hasaccess')){
  const accessLvl = document.getElementById('hasaccess');
  accessLvl.addEventListener('change', function() {
    if(accessLvl.checked){
      document.getElementById('dval').classList.remove('hide');
    } else {
      document.getElementById('dval').classList.add('hide');
    }
  });
}

if(document.getElementById('profilepic')){
  const input = document.getElementById('imgfile');
  const imgpv   = document.getElementById('profilepic');

  imgpv.addEventListener('click', function(e) {
      input.click();
      input.addEventListener('change', function(e){
        const file = e.target.files[0];
        const reader = new FileReader();
        reader.onloadend = function() {
            imgpv.src = reader.result;
        }
        reader.readAsDataURL(file);
      })
      
  });
  
}

if(document.getElementById('emppais')){
  getPaises('emppais');
}

async function getdptos(selectid){
  let resp = await fetch('controllers/departamentos.php?op=getdptos', {
    method: 'get',
    cache: 'no-cache',
    mode: 'same-origin'
  });
  let json = await resp.json();
  if(json.status){
    let data = json.data;
    const select = document.getElementById(selectid);
    data.forEach(item => {
      const opt = document.createElement('option');
      opt.value = item.iddepartamento;
      opt.text = item.titulo;
      select.appendChild(opt);
    });
  }
}

if(document.getElementById('empdepartamento')){
  getdptos('empdepartamento');
}

if(document.getElementById('pvempdepartamento')){
  getdptos('pvempdepartamento');
}

if(document.getElementById('showme')){
  const showme = document.getElementById('showme');
  showme.addEventListener('click', function(){
    if(document.getElementById('logpassword').type=='text'){
      document.getElementById('logpassword').type='password';
    } else {
      document.getElementById('logpassword').type='text';
    }
    
  })
}

if(document.getElementById('adddpto')){
  const adddpto = document.getElementById('adddpto');
  adddpto.addEventListener('click', function(){
    document.getElementById('tabladpto').classList.add('hide');
    document.getElementById('departamentos').classList.remove('hide');
  })
}

async function predit_dpto(id){
    const frm = new FormData();
    frm.append('id', id);
    let resp = await fetch('controllers/departamentos.php?op=getDptoById', {
      method: 'post',
      cache: 'no-cache',
      mode: 'same-origin',
      body: frm
    });
    let json = await resp.json();
    if(json.status){
      let data = json.data[0];
      document.getElementById('dptotitulo').value = data.titulo;
      document.getElementById('dptodescripcion').value = data.descripcion;
      document.getElementById('dptoid').value = data.iddepartamento;
      document.getElementById('tabladpto').classList.add('hide');
      document.getElementById('previewdpto').classList.remove('hide');
    }
}



if(document.getElementById('dptoback1')){
  const dptoback = document.getElementById('dptoback1');
  dptoback.addEventListener('click', function(e){
    e.preventDefault()
    document.getElementById('tabladpto').classList.remove('hide');
    document.getElementById('previewdpto').classList.add('hide');
    document.getElementById('departamentos').classList.add('hide');
  })
}

if(document.getElementById('dptoback2')){
  const dptoback = document.getElementById('dptoback2');
  dptoback.addEventListener('click', function(e){
    e.preventDefault()
    document.getElementById('tabladpto').classList.remove('hide');
    document.getElementById('previewdpto').classList.add('hide');
    document.getElementById('departamentos').classList.add('hide');
  })
}

if(document.getElementById('btnactualizardep')){
  document.getElementById('btnactualizardep').addEventListener('click', (e)=>{
    e.preventDefault()
    setTimeout(async ()=>{
    const frm = new FormData();
    frm.append('id', document.getElementById('dptoid').value);
    frm.append('titulo', document.getElementById('dptotitulo').value);
    frm.append('descripcion', document.getElementById('dptodescripcion').value);
    let resp = await fetch('controllers/departamentos.php?op=uptdpto', {
      method: 'post',
      cache: 'no-cache',
      mode: 'same-origin',
      body: frm
    });
    let json = await resp.json();
    if(json.status){
      switch(json.msg){
        case 'OK':
          Swal.fire(
            "Exito",
            "Departamento actualizado",
            "success",
          );
          getdepartamentos();
          document.getElementById('tabladpto').classList.remove('hide');
          document.getElementById('previewdpto').classList.add('hide');
          break;
      }
    } else {
      Swal.fire(
        "Error",
        "No se ha podido actualizar el departamento",
        "error",
      );
    }
    }, 600)
  })
}

function deldpto(id){
  Swal.fire({
    title: '¿Está seguro?',
    text: "Esta acción es irreversible",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#E70202',
    cancelButtonColor: '#03598B',
    confirmButtonText: 'Si, eliminar!'
    
  }).then((result) => {
    if (result.isConfirmed) {
      eliminar_depto(id);      
      
    }
  })

}

async function eliminar_depto(id){
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/departamentos.php?op=dltdpto', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });
  let json = await resp.json();
  if(json.status){
    switch(json.msg){
      case 'OK':
        Swal.fire(
          "Exito",
          "Departamento eliminado",
          "success",
        );
        obtener_num_dptos();
        getdepartamentos();
        break;
    }
  } else {
    Swal.fire(
      "Error",
      "No se ha podido eliminar el departamento",
      "error",
    );
  }
}

function paginacion(pgact, funcion, paginas, div){
    //paginacion
    const paginacion = document.getElementById(div);
    if (pgact == 1) {
      paginacion.innerHTML = `<li class="page-item disabled"><a class="page-link">&laquo;</a></li>`;
    } else {
        let pba = pgact - 1;
        paginacion.innerHTML = `<li class="page-item"><a href="#" class="page-link" onclick="${funcion}(${pba})">«</a></li>`;
    }
    
    for (let i = 1; i <= paginas; i++) {
        if (pgact == i) {
            paginacion.innerHTML += `<li class="page-item"><a class="page-link active" href="#" onclick="${funcion}(${i})">${i}</a></li>`;
        } 
    }
    
    if (pgact == paginas) {
        paginacion.innerHTML += `<li class="page-item disabled"><a class="page-link" href="#">»</a></li>`;
    } else {
        let pgn = pgact + 1;
        paginacion.innerHTML += `<li class="page-item"><a href="#" class="page-link" onclick="${funcion}(${pgn})">»</a></li>`;
    }
}

//funcion obtener listado de empleados
async function getEmpleados(){
  var pgact = pgact ?? 1;
  const frm = new FormData();
  frm.append('pg', pgact);

  let resp = await fetch('controllers/personal.php?op=getEmpdo', {
    method: 'POST',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm

  });
  let json = await resp.json();
  const tbl = document.getElementById('tbl-Empleados');
  tbl.innerHTML = "";
  if(json.status){
    let data = json.data;
    let paginas = json.total_paginas;
    data.forEach(item => {
        if(item.tipo!=='no-acceso'){
          tipo = 'Si';
        } else {
          tipo = 'No';
        } 
       const tr = document.createElement('tr');
       
        tr.innerHTML = `
        <td><div class="tbl-img"><a href="#" class="none-link" onclick="getEmpId(${item.idpersona})"><img src="assest/images/personal/${item.imagen}" class="profile-pic">${item.nombre} ${item.apellido}</a></div></td>
        <td class="d-none d-xl-table-cell">${item.email}</td>
        <td class="d-none d-xl-table-cell">${item.telefono}</td>
        <td class="d-none d-xl-table-cell">${item.titulo}</td>
        <td>${item.cargo}</td>
        <td class="d-none d-xl-table-cell">${tipo}</td>
        <td>
        <div class="submenu">
          <button onclick="getEmpId(${item.idpersona})"><i class="align-middle" data-feather="edit-3"></i></button>
          <button onclick="confirmar_del(${item.idpersona}, 'personal.php?op=dltempleado')"><i class="align-middle" data-feather="trash-2"></i></button>
          </div>
        </td>
        `;
        tbl.appendChild(tr);
        feather.replace();
        paginacion(pgact, 'getEmpleados', paginas, 'Empleados-pagination');   
    });
  }
}

if(document.getElementById('tbl-Empleados')){
  getEmpleados();
}



if(document.getElementById('addempleadoxbtn')){
  document.getElementById('addempleadoxbtn').addEventListener('click', (e)=>{
    e.preventDefault();
    document.getElementById('profilepic').src = 'assest/images/no-profile.webp';
    document.getElementById('empid').value = "";
    document.getElementById('empnombre').value = "";
    document.getElementById('empapellidos').value = "";
    document.getElementById('empnacimiento').value = "";
    document.getElementById('empsexo').value = "";
    document.getElementById('empidentificacion').value = "";
    document.getElementById('empcorreo').value = "";
    document.getElementById('empmovil').value ="";
    document.getElementById('empdireccion').value = "";
    document.getElementById('empciudad').value ="";
    document.getElementById('empingreso').value = "";
    document.getElementById('empdepartamento').value = "";
    document.getElementById('empcargo').value = "";
    document.getElementById('ismanager').checked = false;
    document.getElementById('hasaccess').checked = false;
    document.getElementById('departamentos').checked = false;
    document.getElementById('addpersonal').classList.remove('hide');
    document.getElementById('tblpersonal').classList.add('hide');
    document.getElementById('guardarprofile_emp').classList.remove('hide');
    document.getElementById('updatempprofile').classList.add('hide');
  })
}

if(document.getElementById('backEmp')){
  document.getElementById('backEmp').addEventListener('click', (e)=>{
    e.preventDefault();
    document.getElementById('empid').value = "";
    document.getElementById('empnombre').value = "";
    document.getElementById('empapellidos').value = "";
    document.getElementById('empnacimiento').value = "";
    document.getElementById('empsexo').value = "";
    document.getElementById('empidentificacion').value = "";
    document.getElementById('empcorreo').value = "";
    document.getElementById('empmovil').value ="";
    document.getElementById('empdireccion').value = "";
    document.getElementById('empciudad').value ="";
    document.getElementById('empingreso').value = "";
    document.getElementById('empdepartamento').value = "";
    document.getElementById('empcargo').value = "";
    document.getElementById('ismanager').checked = false;
    document.getElementById('hasaccess').checked = false;
    document.getElementById('departamentos').checked = false;
    document.getElementById('personal').checked = false;
    document.getElementById('addpersonal').classList.add('hide');
    document.getElementById('tblpersonal').classList.remove('hide');
    document.getElementById('guardarprofile_emp').classList.add('hide');
    document.getElementById('updatempprofile').classList.add('hide');
  })
}

async function grabar_empleado(){
  const frmempleado = document.getElementById('frmempleado');
  const frm = new FormData(frmempleado);

  let resp = await fetch('controllers/personal.php?op=svemp', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();
  if(json.status) {
    switch(json.msg){
      case 'OK':
        Swal.fire(
          "Exito",
          "Empleado almacenado",
          "success",
        );
        total_empleados();
        getEmpleados();
        document.getElementById('addpersonal').classList.add('hide');
        document.getElementById('tblpersonal').classList.remove('hide');
        break;
    }
  } else {
    switch (json.msg) {
      case 'ERROR_01':
        Swal.fire(
          "Error",
          "Error almacenando al empleado",
          "error",
        );
        break;

        case 'ERROR_02':
          Swal.fire(
            "Error",
            "Error enviando el correo",
            "error",
          );
          break;  

          case 'ERROR_03':
            Swal.fire(
              "Error",
              "El correo ya existe en la base de datos",
              "error",
            );
            break;          
    }
  }

}

if(document.getElementById('guardarprofile_emp')){
  document.getElementById('guardarprofile_emp').addEventListener('click', (e)=>{
    e.preventDefault();
    grabar_empleado();
  })
}

if(document.getElementById('showmep1')){
  document.getElementById('showmep1').addEventListener('click', ()=>{
    if(document.getElementById('regpassword').type=='password'){
      document.getElementById('regpassword').type='text';
    } else {
      document.getElementById('regpassword').type='password';
    }
  })
}

if(document.getElementById('showmep2')){
  document.getElementById('showmep2').addEventListener('click', ()=>{
    if(document.getElementById('regpassword1').type=='password'){
      document.getElementById('regpassword1').type='text';
    } else {
      document.getElementById('regpassword1').type='password';
    }
  })
}

if(document.getElementById('regpassword1')){
  document.getElementById('regpassword1').addEventListener('keyup', ()=>{
    const passw = document.getElementById('regpassword').value;
    const passw2 = document.getElementById('regpassword1').value;
    if(passw!==passw2){
      document.getElementById('regpassword1').classList.add('is-invalid');
      document.getElementById('regpassword').classList.add('is-invalid');
      document.getElementById('error_msg').innerHTML="Las contraseñas deben coincidir";
    } else {
      document.getElementById('regpassword1').classList.remove('is-invalid');
      document.getElementById('regpassword').classList.remove('is-invalid');
      document.getElementById('regpassword1').classList.add('is-valid');
      document.getElementById('regpassword').classList.add('is-valid');
      document.getElementById('error_msg').innerHTML="";
    }

  })
}

function confirmar_del(id, url){
  Swal.fire({
    title: '¿Está seguro?',
    text: "Esta acción es irreversible",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#E70202',
    cancelButtonColor: '#03598B',
    confirmButtonText: 'Si, eliminar!'
    
  }).then((result) => {
    if (result.isConfirmed) {
      eliminar_(id, url);      
    }
  })

}

async function eliminar_(id, url){
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/'+url, {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });
  let json = await resp.json();
  if(json.status){
      Swal.fire(
        "Exito",
        json.msg,
        "success",
      );
      cargardatos();
  } else {
    Swal.fire(
      "Error",
      json.msg,
      "error",
    );
  }
}


function cargardatos(){

  if(document.getElementById('total_empleados')){
    total_empleados();
  }
  if(document.getElementById('tbl-Empleados')){
    getEmpleados();
  }
  if(document.getElementById('tbl-clientes')){
    getClientes();
  }
  if(document.getElementById('tbl-departamentos')){
    getdepartamentos();
  }
  if(document.getElementById('total_departamentos')){
    obtener_num_dptos()
  }
  if(document.getElementById('total_empleados')){
    total_empleados();
  }
  if(document.getElementById('total_clientes')){
    obtener_total_registros('clientes.php?op=getnumcl', 'total_clientes');
  }

  if(document.getElementById('tbl-unidades')){
    getUnidades();
  }

  if(document.getElementById('total_unidades')){
    obtener_total_registros('clientes.php?op=gallunits', 'total_unidades');
  }

  if(document.getElementById('tbl-actividadesip')){
    getSolicitudes('actividadesip', 'actividades.php?op=getip', 1);
  }

  if(document.getElementById('tbl-actividadesinsp')){
    getSolicitudes('actividadesinsp', 'actividades.php?op=getinsp', 1);
  }
  if(document.getElementById('tbl-actividadesinsp')){
    obtener_listado_inspectores(1);
  }

  if(document.getElementById('total_solicitudes')){
    obtener_total_registros('actividades.php?op=getregsol', 'total_solicitudes');
  }

  if(document.getElementById('tbl-panne')){
    obtener_panne(1, '!=', 'getpanne', 'tbl-panne');
}

if(document.getElementById('tbl-ambipar')){
    obtener_panne(1, '!=', 'ambgetpanne', 'tbl-ambipar');
}
  
}

if(document.getElementById('total_solicitudes')){
  obtener_total_registros('actividades.php?op=getregsol', 'total_solicitudes');
}

//obtener panne cerrados (boton back)
if(document.getElementById('tbl-clpanne')){
  let selectElement = document.getElementById('verclosepn');
  selectElement.value = "=";
  obtener_panne(1, '=', 'getpanne', 'tbl-clpanne');
}

async function total_empleados(){
  let resp = await fetch('controllers/personal.php?op=totalemp', {
    method: 'get',
    cache: 'no-cache',
    mode: 'same-origin'
  });
  resp.json().then((response)=>{
    document.getElementById('total_empleados').innerHTML = response.data;
  })
}

if(document.getElementById('total_empleados')){
  total_empleados();
}

async function getEmpId(id){
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/personal.php?op=getEmpById', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });
  let json = await resp.json();
  if(json.status){
    let data = json.data[0];
    document.getElementById('empid').value = data.idpersona;
    document.getElementById('empnombre').value = data.nombre;
    document.getElementById('empapellidos').value = data.apellido;
    document.getElementById('empnacimiento').value = data.fecha_nacimiento;
    document.getElementById('empsexo').value = data.sexo;
    document.getElementById('empidentificacion').value = data.identificacion;
    document.getElementById('empcorreo').value = data.email;
    document.getElementById('empmovil').value = data.telefono;
    document.getElementById('empdireccion').value = data.address_line1;
    document.getElementById('empciudad').value = data.city;
    document.getElementById('empingreso').value = data.fecha_ingreso;
    document.getElementById('empdepartamento').value = data.departamento;
    document.getElementById('empcargo').value = data.cargo;
    if(data.is_manager==1){
      document.getElementById('ismanager').checked = true;
    } else {
      document.getElementById('ismanager').checked = false;
    }
    if(data.has_access==1){
      document.getElementById('hasaccess').checked = true;
      document.getElementById('dval').classList.remove('hide');
      if(data.departamentos==1){
        document.getElementById('departamentos').checked = true;
      } else {
        document.getElementById('departamentos').checked = false;
      }
      if(data.personal==1){
        document.getElementById('personal').checked = true;
      } else {
        document.getElementById('personal').checked = false;
      }
    } else {
      document.getElementById('hasaccess').checked = false;
    }
    document.getElementById('profilepic').src = `assest/images/personal/${data.imagen}`;
    document.getElementById('tblpersonal').classList.add('hide');
    document.getElementById('guardarprofile_emp').classList.add('hide');
    document.getElementById('addpersonal').classList.remove('hide');
    document.getElementById('updatempprofile').classList.remove('hide');

  }
}


if(document.getElementById('updatempprofile')){
  document.getElementById('updatempprofile').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_data('personal.php?op=updemp', 'frmempleado', 'pimg__base64', 'addpersonal', 'tblpersonal');
  })
}


function limpiarFormulario(formularioId) {
  let formulario = document.getElementById(formularioId);
  let elementos = formulario.elements;

  for (let i = 0; i < elementos.length; i++) {
    if (elementos[i].type=="file" || elementos[i].type == "text" || elementos[i].type == "number" || elementos[i].type == "date" ||elementos[i].type == "email" || elementos[i].type == "textarea" || elementos[i].type == "password") {
      elementos[i].value = "";
    } else if (elementos[i].type == "checkbox" || elementos[i].type == "radio") {
      elementos[i].checked = false;
    } else if (elementos[i].type == "select-one" || elementos[i].type == "select-multiple") {
      elementos[i].selectedIndex = -1;
    }
  }
}


if(document.getElementById('nueva_clave2')){
  document.getElementById('nueva_clave2').addEventListener('keyup', ()=>{
    const passw = document.getElementById('nueva_clave1').value;
    const passw2 = document.getElementById('nueva_clave2').value;
    if(passw!==passw2){
      document.getElementById('nueva_clave2').classList.add('is-invalid');
      document.getElementById('nueva_clave1').classList.add('is-invalid');
      document.getElementById('error_msg').innerHTML="Las contraseñas deben coincidir";
    } else {
      document.getElementById('nueva_clave2').classList.remove('is-invalid');
      document.getElementById('nueva_clave1').classList.remove('is-invalid');
      document.getElementById('nueva_clave2').classList.add('is-valid');
      document.getElementById('nueva_clave1').classList.add('is-valid');
      document.getElementById('error_msg').innerHTML="";
    }
  });
}

function cambiar_clave(){
  showLoader();
  setTimeout(async ()=>{
    if(document.getElementById('nueva_clave1').value!==document.getElementById('nueva_clave2').value){
      hideLoader();
      Swal.fire(
        "Error",
        "Las contraseñas no coinciden",
        "error",
      );
      document.getElementById('nueva_clave1').addClass('is-invalid');
      document.getElementById('nueva_clave2').addClass('is-invalid');
      return false;
    }

    const frm = new FormData(document.getElementById('frmpass'));
    let resp = await fetch('controllers/personal.php?op=changepass', {
      method: 'post',
      cache: 'no-cache',
      mode: 'same-origin',
      body: frm
    });
    let json = await resp.json();
    if(json.status){
          hideLoader();
          Swal.fire(
            "Exito",
            json.msg,
            "success",
          );
          document.getElementById('clave_actual').value = "";
          document.getElementById('nueva_clave1').value = "";
          document.getElementById('nueva_clave2').value = "";
    } else {
      hideLoader();
      Swal.fire(
        "Error",
        json.msg,
        "error",
      );
    }
  }, 500);
}

if(document.getElementById('btnupdateclave')){
  document.getElementById('btnupdateclave').addEventListener('click', (e)=>{
    e.preventDefault();
    showLoader();
    setTimeout(()=>{
      cambiar_clave();
    }, 500);
  })
}

function switch_divs(div1, div2){
    const d1 = document.getElementById(div1);
    const d2 = document.getElementById(div2);
    d1.classList.add('hide');
    d2.classList.remove('hide');
}

if(document.getElementById('addclientebtn')){
  document.getElementById('addclientebtn').addEventListener('click', (e)=>{
    e.preventDefault();
    showLoader();
    setTimeout(()=>{
      switch_divs('tblcliente', 'addcliente');
      hideLoader();
    }, 500);
  })
}

if(document.getElementById('addunidadbtn')){
  document.getElementById('addunidadbtn').addEventListener('click', (e)=>{
    e.preventDefault();
    showLoader();
    setTimeout(()=>{
      switch_divs('tblunidades', 'addunidades');
      hideLoader();
    }, 500);
  })
}

if(document.getElementById('back__empresa')){
  document.getElementById('back__empresa').addEventListener('click', (e)=>{
    e.preventDefault();
    document.getElementById('climg__pv').src = 'assest/images/no-profile.webp';
    limpiarFormulario('frmcliente');
    switch_divs('addcliente', 'tblcliente');
  })
}

if(document.getElementById('back__asignacion')){
  document.getElementById('back__asignacion').addEventListener('click', (e)=>{
    e.preventDefault();
    limpiarFormulario('frmasignacion');
      document.getElementById('inspector').classList.remove('hide');
      document.getElementById('sv__asignacion').classList.remove('hide');
      document.getElementById('fecha_agendada').removeAttribute('disabled');
      document.getElementById('hora_agendada').removeAttribute('disabled');
      document.getElementById('taller').removeAttribute('disabled');
      document.getElementById('semana').removeAttribute('disabled');
      document.getElementById('ubicacion').removeAttribute('disabled');
      document.getElementById('solicitado').removeAttribute('disabled');
      document.getElementById('aprobado_por').removeAttribute('disabled');
      
      document.getElementById('ipseleccionados').innerHTML = "";
    switch_divs('addasignacion', 'tblactividades');
  })
}

function comprobar_tamano_img(file) {
  var maxSizeKB = 1024;
  var fileSizeKB = file.size / 1024;
  return fileSizeKB <= maxSizeKB;
}

function cortar_imagen(txt, dv, btn, pvdv, prdv, inp64, finp){
  let cropper;
  let svCropClickHandler;

  if(document.getElementById(txt)){
      document.getElementById(txt).addEventListener('click', ()=>{
          document.getElementById(finp).click();
      });
  }
  
  if(document.getElementById(dv)){
      document.getElementById(dv).addEventListener('click', ()=>{
          document.getElementById(finp).click();
      });
  }
  
  document.getElementById(finp).addEventListener('change', (event)=>{
      var archivo = event.target.files[0];
      document.getElementById(btn).classList.remove('hide');

      // Comprobar el tamaño de la imagen
      if (!comprobar_tamano_img(archivo)) {
          Swal.fire('Error', 'La imagen es demasiado grande, el tamaño máximo es de 750KB', 'error');
          return false;
      }

      var imgModal = document.getElementById(prdv);

      imgModal.classList.remove('hide');
      imgModal.style.margin = "0 auto";
        imgModal.style.display = "flex";
        imgModal.style.justifyContent = "center";
        imgModal.style.alignItems = "center";
        imgModal.style.backgroundColor = "#fff";
        imgModal.style.border = "1px solid #ccc";
        imgModal.style.zIndex = "9999";
        imgModal.style.width = "500";
        imgModal.style.height = "500px";
        imgModal.style.padding = "10px";
        imgModal.style.position = "absolute";
        imgModal.style.top = "0";
        imgModal.style.left = "0"; // Asegura que el modal comienza desde el borde izquierdo de la pantalla

      
      
      var lector = new FileReader();

      lector.onload = function(event) {
          var img = document.getElementById(pvdv);
          img.src = event.target.result;
          img.classList.add('pview');

          // Destruye la instancia anterior de Cropper si existe
          if (cropper) {
              cropper.destroy();
          }

          // Inicializa Cropper después de que la imagen esté cargada
          cropper = new Cropper(img, {
              aspectRatio: 1/1,
          });

          // Elimina el controlador de eventos click anterior si existe
          if (svCropClickHandler) {
              document.getElementById(btn).removeEventListener('click', svCropClickHandler);
          }


          svCropClickHandler = ()=>{
              var imgrecortada = cropper.getCroppedCanvas().toDataURL("image/png", 0.7);
              document.getElementById(dv).src = imgrecortada;
              document.getElementById(inp64).value = imgrecortada;
              imgModal.style.display = "none";
          };

          document.getElementById(btn).addEventListener('click', svCropClickHandler);
      };

      lector.readAsDataURL(archivo);
  });
}

if(document.getElementById('clpick_img')){
  cortar_imagen('clpick_img', 'climg__pv', 'clsv__crop', 'clpvimg', 'clpvisualizar',  'climg__base64', 'climagen');
}

function obtener_total_registros(url, div){
  let resp = fetch('controllers/'+url, {
    method: 'get',
    cache: 'no-cache',
    mode: 'same-origin'
  });
  resp.then((response)=>{
    response.json().then((json)=>{
      document.getElementById(div).innerHTML = json.data;
    })
  })
}

function obtener_total_registros_post(id, url, div){
  let frm = new FormData();
  frm.append('id', id);

  let resp = fetch('controllers/'+url, {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });
  resp.then((response)=>{
    response.json().then((json)=>{
      document.getElementById(div).innerHTML = json.data;
    })
  })
}

if(document.getElementById('total_clientes')){
  obtener_total_registros('clientes.php?op=getnumcl', 'total_clientes');
}



async function getClientes(pgact){
  let frm = new FormData();
  pg  = pgact ?? 1;
  frm.append('pg', pg);

  let resp = await fetch('controllers/clientes.php?op=getclpg', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });
  let json = await resp.json();

  let tb = document.getElementById('tbl-clientes');
  tb.innerHTML = "";
  if(json.status){
    let data = json.data;
    let total_paginas = json.total_paginas;
    data.forEach(item => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td>${item.nombre}</td>
      <td class="d-none d-xl-table-cell">${item.nif}</td>
      <td class="d-none d-xl-table-cell">${item.correo}</td>
      <td class="d-none d-xl-table-cell">${item.telefono}</td>
      <td class="d-none d-xl-table-cell">${item.unidades}</td>
      <td class="submenu" style="text-align: right">
      <button onclick="previsualizar_empresa(${item.id})" data-bs-toggle="offcanvas" data-bs-target="#empdetalles" aria-controls="offcanvasRight"><i class="align-middle" data-feather="eye"></i></button>
      <button class="mnaux" title="Listado de unidades" onclick="listado(1, ${item.id}, 'tblcliente', 'tblveh_empresa')"><i class="align-middle" data-feather="list"></i></button>
      <button class="mnaux" onclick="addtruck(${item.id}, '${item.nombre}')"  title="Agregar Unidad"><i class="align-middle" data-feather="truck"></i></button>
      <button onclick="edit_clt(${item.id})" title="Editar perfil empresa"><i class="align-middle" data-feather="edit-3"></i></button>
      <button title="Eliminar perfil empresa" onclick="confirmar_del(${item.id}, 'clientes.php?op=delclt')"><i class="align-middle" data-feather="trash-2"></i></button>
      </td>`;
      tb.appendChild(tr);
      feather.replace();  

      //paginacion
      paginacion(pg, 'getClientes', total_paginas, 'cliente-pagination');
    });
  }
}

function addtruck(id, nombre){
  showLoader();
  setTimeout(()=>{
    switch_divs('tblcliente', 'addunidades');
    document.getElementById('pcnombre').value = nombre;
    document.getElementById('idpcnombre').value = id;
    hideLoader();
  }, 500);
}

let cnt;

function listado(pg, id, div1, div2){
  pgact = pg ?? 1;
  globalDiv1 = div1;
  globalDiv2 = div2;
  showLoader();
  
  setTimeout(async ()=>{
  let frm = new FormData();
  
  let idcom = document.getElementById('idcompany');
  idcom.value = id;

  frm.append('idempresa', id);
  frm.append('pg', pgact);
  let resp = await fetch('controllers/clientes.php?op=lundsemp', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });
  let json = await resp.json();
  let tb = document.getElementById('tbl-veh_empresa');
  tb.innerHTML = "";
  
   if(json.status){
    hideLoader();
    const h4 = document.getElementById('titulo_empresa');
    h4.innerHTML = "";
    h4.innerHTML = "Listado de unidades de la empresa "+json.nombre_empresa;
    switch_divs(globalDiv1, globalDiv2);
    obtener_total_registros_post(id,'clientes.php?op=galleunits', 'total_veh_empresa');
    let data = json.data;
    let total_paginas = json.total_paginas;
    data.forEach(item => {
      let estatus;
      if(item.und_last_hist!==0){
        estatus = item.und_last_hist;
      } else {
        estatus = item.estatus;
      }
      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td>${item.tipo}</td>
      <td>${item.ppu}</td>
      <td>${item.marca}</td>
      <td>${item.modelo}</td>
      <td>${item.chasis}</td>
      <td>${item.year}</td>
      <td>${item.ubicacion}</td>
      <td>${estatus}</td>
      <td class="submenu">
      <button onclick="previsualizar_unidad(${item.id})" data-bs-toggle="offcanvas" data-bs-target="#empdetalles" aria-controls="offcanvasRight"><i class="align-middle" data-feather="eye"></i></button>
      <button onclick="edit_und(${item.id}, 'tblveh_empresa', 'addunidades', 'save__unidades', 'updx__unidades')"><i class="align-middle" data-feather="edit-3"></i></button>
      <button onclick="confirmar_del(${item.id}, 'clientes.php?op=delund')"><i class="align-middle" data-feather="trash-2"></i></button>
      </td>`
      tb.appendChild(tr);
      feather.replace(); 
    });
    
    const paginacion = document.getElementById('veh_empresa-pagination');
    paginacion.innerHTML = '';
    if (pgact > 1) {
        let pba = pgact - 1;
        paginacion.innerHTML += `<li class="page-item"><a href="#" class="page-link" onclick="listado(${pba}, ${id}, 'tblveh_empresa', 'tblveh_empresa' )">«</a></li>`;
    }
    
    for (let i = 1; i <= total_paginas; i++) {
        if (pgact == i) {
            paginacion.innerHTML += `<li class="page-item active"><a class="page-link" href="#" onclick="listado(${i}, ${id}, 'tblveh_empresa', 'tblveh_empresa')">${i}</a></li>`;
        } else {
            paginacion.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="listado(${i}, ${id},  'tblveh_empresa', 'tblveh_empresa')">${i}</a></li>`;
        }
    }
    
    if (pgact < total_paginas) {
        let pgn = pgact + 1;
        paginacion.innerHTML += `<li class="page-item"><a href="#" class="page-link" onclick="listado(${pgn}, ${id},  'tblveh_empresa', 'tblveh_empresa')">»</a></li>`;
    }
  } else {
    hideLoader();
    Swal.fire(
      "Error",
      json.msg,
      "error",
    );
  }
  }, 500);
}


async function listado_unidades(){
  let id = document.getElementById('idcompany').value;
  let frm = new FormData();
  frm.append('idempresa', id);
  let resp = await fetch('controllers/clientes.php?op=lundsemp', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });
  let json = await resp.json();
  let tb = document.getElementById('tbl-veh_empresa');
  tb.innerHTML = "";
  
   if(json.status){
    let data = json.data;
    data.forEach(item => {
      let estatus;
      if(item.und_last_hist!==0){
        estatus = item.und_last_hist;
      } else {
        estatus = item.estatus;
      }
      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td>${item.tipo}</td>
      <td>${item.ppu}</td>
      <td>${item.marca}</td>
      <td>${item.modelo}</td>
      <td>${item.chasis}</td>
      <td>${item.year}</td>
      <td>${item.ubicacion}</td>
      <td>${estatus}</td>
      <td class="submenu">
      <button onclick="previsualizar_unidad(${item.id})" data-bs-toggle="offcanvas" data-bs-target="#empdetalles" aria-controls="offcanvasRight"><i class="align-middle" data-feather="eye"></i></button>
      <button onclick="edit_und(${item.id}, 'tblveh_empresa', 'addunidades', 'save__unidades', 'updx__unidades')"><i class="align-middle" data-feather="edit-3"></i></button>
      <button onclick="confirmar_del(${item.id}, 'clientes.php?op=delund')"><i class="align-middle" data-feather="trash-2"></i></button>
      </td>`
      tb.appendChild(tr);
      feather.replace(); 
    });
    }
}


if(document.getElementById('back__und')){
  document.getElementById('back__und').addEventListener('click', (e)=>{
    e.preventDefault();
    showLoader(); 
    setTimeout(()=>{
      switch_divs('addunidades', 'tblcliente');
      hideLoader();
    }, 500);
  })

}

if(document.getElementById('back__undx1')){
  document.getElementById('back__undx1').addEventListener('click', (e)=>{
    e.preventDefault();
    showLoader(); 
    setTimeout(()=>{
      switch_divs('tblveh_empresa', 'tblcliente');
      hideLoader();
    }, 500);
  })

}

function guardar_data(url, form, inp64, div1, div2){
  showLoader();
  setTimeout(async ()=>{
    const frm = new FormData(document.getElementById(form));

    if(document.getElementById(inp64).value!==""){
      var imgrecortada = document.getElementById(inp64).value;
      var base64String = imgrecortada.split(',')[1];
      var binaryString = window.atob(base64String);
      var binaryLen = binaryString.length;
      var bytes = new Uint8Array(binaryLen);
        for (var i = 0; i < binaryLen; i++) {
            var ascii = binaryString.charCodeAt(i);
            bytes[i] = ascii;
        }
      var blob = new Blob([bytes], {type: "image/png"});
      frm.append('image', blob);
    }   

    let resp = await fetch('controllers/'+url, {
      method: 'post',
      cache: 'no-cache',
      mode: 'same-origin',
      body: frm
    });
    let json = await resp.json();
    if(json.status){
      hideLoader();
      Swal.fire(
        "Exito",
        json.msg,
        "success",
      );
      limpiarFormulario(form);
      switch_divs(div1, div2);
      cargardatos();
      document.getElementById('climg__pv').src='assest/images/no-profile.webp';
    } else {
      hideLoader();
      Swal.fire(
        "Error",
        json.msg,
        "error",
      );
    }
  }, 500);
}

if(document.getElementById('cliente-pagination')){
  getClientes();
}

if(document.getElementById('save__empresa')){
  document.getElementById('save__empresa').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_data('clientes.php?op=svcl', 'frmcliente', 'climg__base64', 'addcliente', 'tblcliente');
  })
}

function edit_clt(id){
  showLoader();
  setTimeout(async ()=>{
    switch_divs('tblcliente', 'addcliente');
  const frm = new FormData();
  frm.append('id', id);
  fetch('controllers/clientes.php?op=getcltbyid', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  }).then((response)=>{
    response.json().then((json)=>{
      if(json.status){
        let data = json.data;
        document.getElementById('save__empresa').classList.add('hide');
        document.getElementById('upd__empresa').classList.remove('hide');
        document.getElementById('idempresa').value = data.id;
        document.getElementById('empnombre').value = data.nombre;
        document.getElementById('empNIF').value = data.nif;
        document.getElementById('empcorreo').value = data.correo;
        document.getElementById('movil').value = data.telefono;
        document.getElementById('empdireccion').value = data.direccion;
        document.getElementById('empciudad').value = data.ciudad;
        document.getElementById('empprovincia').value = data.provincia;
        document.getElementById('empwebsite').value = data.website;
        document.getElementById('climg__pv').src = data.imagen;
        document.getElementById('climg__base64').value ="";
        hideLoader();
      }
    })
  })  
  }, 500);
}

async function previsualizar_empresa(id){
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/clientes.php?op=getcltbyid', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();
  if(json.status){
    let data = json.data;
    if(!document.getElementById('unidad-detalles').classList.contains('hide')){
      document.getElementById('unidad-detalles').classList.add('hide');
    }
    document.getElementById('empresa-detalles').classList.remove('hide');
    document.getElementById('companyname').innerHTML = data.nombre;
    document.getElementById('companynif').innerHTML = data.nif;
    document.getElementById('companyemail').innerHTML = data.correo;
    document.getElementById('companyphone').innerHTML = data.telefono;
    document.getElementById('companyaddress').innerHTML = data.direccion;
    document.getElementById('companycity').innerHTML = data.ciudad;
    document.getElementById('companystate').innerHTML = data.provincia;
    document.getElementById('companylogo').src = data.imagen;
  }

}

//editar unidades
function edit_und(id, div1, div2, btn1, btn2){
  showLoader();
  setTimeout(async ()=>{
    switch_divs(div1, div2);
  const frm = new FormData();
  frm.append('id', id);
  fetch('controllers/clientes.php?op=undbyid', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  }).then((response)=>{
    response.json().then((json)=>{
      if(json.status){
        let data = json.data[0];
        document.getElementById(btn1).classList.add('hide');
        document.getElementById(btn2).classList.remove('hide');
        document.getElementById('idpcnombre').value = data.idempresa;
        document.getElementById('idund').value = data.id;
        document.getElementById('pcnombre').value = data.nombre;
        document.getElementById('ppu_tracto').value = data.ppu;
        document.getElementById('tipo').value= data.tipo;
        document.getElementById('marca').value = data.marca;
        document.getElementById('modelo').value = data.modelo;
        document.getElementById('year').value = data.year;
        document.getElementById('chasis').value = data.chasis;
        document.getElementById('estatus').value = data.estatus;
        document.getElementById('ubicacion').value = data.ubicacion
        document.getElementById('km_actual').value = data.km_actual;
        document.getElementById('km_proximo').value = data.km_proximo;
        hideLoader();
      }
    })
  })  
  }, 500);
}
async function detalle_estados(id){
  const frm = new FormData();
  frm.append('idund', id);
  let resp = await fetch('controllers/clientes.php?op=undhistoryid', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();
  let tb = document.getElementById('tbl-undstatus');
  tb.innerHTML = "";

  if(json.status){
    let data = json.data;
    data.forEach(item => {
      let fecha = item.fecha_actualizado.split('-');
      item.fecha_actualizado = fecha[2]+'/'+fecha[1]+'/'+fecha[0];
      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td>${item.fecha_actualizado}</td>
      <td>${item.descripcion}</td>
      <td>${item.estado}</td>`;
      tb.appendChild(tr);
    });
  } else {
    console.log('no hay datos');
  }
}

async function previsualizar_unidad(id){
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/clientes.php?op=undbyid', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();
  if(json.status){
    let data = json.data[0];
    if(document.getElementById('empresa-detalles')){
      if(!document.getElementById('empresa-detalles').classList.contains('hide')){
        document.getElementById('empresa-detalles').classList.add('hide');
      }
    }
    document.getElementById('ttldetalles').innerHTML = "Detalles de la unidad";
    document.getElementById('unidad-detalles').classList.remove('hide');
    document.getElementById('undcompanylogo').src=data.imagen;
    document.getElementById('undempresaname').innerText = data.nombre;
    document.getElementById('undpatente').value = data.ppu;
    document.getElementById('undtipo').value = data.tipo;
    document.getElementById('undmarca').value = data.marca;
    document.getElementById('undmodelo').value = data.modelo;
    document.getElementById('undchasis').value = data.chasis;
    document.getElementById('undyear').value = data.year;
    document.getElementById('undkmact').value = data.km_actual;
    document.getElementById('undkmprox').value = data.km_proximo;
    document.getElementById('undubicacion').value = data.ubicacion;
    detalle_estados(id);
  }
}



async function poblar_company(input, lista){
  let frm = new FormData();
  let texto = document.getElementById(input).value;
  frm.append('txtbuscar', texto); 
  let resp = await fetch('controllers/clientes.php?op=clist', {
      method: 'POST',
      cache: 'no-cache',
      cors: 'no-cors',
      body: frm
  });

  let json = await resp.json();
  const ul = document.getElementById(lista);
  ul.innerHTML = "";
  if(json.status){
      let data = json.data;
      ul.classList.remove('hide');
      data.forEach(item => {
          let li = document.createElement('li');
          li.innerHTML = item.nombre;
          ul.appendChild(li);

          li.addEventListener('click', (e)=>{
              e.preventDefault();
              document.getElementById('id'+input).value = item.id;
              document.getElementById(input).value = item.nombre;
              ul.classList.add('hide');
          });
      });
  } else {
    ul.classList.remove('hide');
    let li = document.createElement('li');
    li.innerHTML = "Agregar nuevo cliente";
    ul.appendChild(li);

    li.addEventListener('click', (e)=>{
        e.preventDefault();
        switch_divs('addunidades', 'addcliente');
        document.getElementById('empnombre').value = texto;
    });

  }
}





if(document.getElementById('pcnombre')){
  document.getElementById('pcnombre').addEventListener('keyup', ()=>{
      if(document.getElementById('pcnombre').value.length>1){
         poblar_company('pcnombre', 'lista_empresa');
      } else {
        document.getElementById('lista_empresa').classList.add('hide');
      }
  });
}

if(document.getElementById('back__company')){
  document.getElementById('back__company').addEventListener('click', (e)=>{
    e.preventDefault();
    switch_divs('addcliente', 'tblunidades');
  })
}

if(document.getElementById('sv__empresa_fu')){
  document.getElementById('sv__empresa_fu').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_data('clientes.php?op=svcl', 'frmcliente', 'climg__base64', 'addcliente', 'addunidades');
  });
}

if(document.getElementById('upd__empresa')){
  document.getElementById('upd__empresa').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_data('clientes.php?op=updtcl', 'frmcliente', 'climg__base64', 'addcliente', 'tblcliente');
  });
}

async function getUnidades(pgact){
  let frm = new FormData();
  pg  = pgact ?? 1;
  frm.append('pg', pg);

  let resp = await fetch('controllers/clientes.php?op=lunds', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });
  let json = await resp.json();

  let tb = document.getElementById('tbl-unidades');
  tb.innerHTML = "";
  if(json.status){
    let data = json.data;
    let total_paginas = json.total_paginas;
    
    data.forEach(item => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td>${item.nombre}</td>
      <td>${item.tipo}</td>
      <td>${item.ppu}</td>
      <td>${item.marca}</td>
      <td>${item.modelo}</td>
      <td>${item.chasis}</td>
      <td>${item.year}</td>
      <td>${item.ubicacion}</td>
      <td class="submenu" style="text-align: right">
      <button onclick="previsualizar_unidad(${item.id})" data-bs-toggle="offcanvas" data-bs-target="#empdetalles" aria-controls="offcanvasRight"><i class="align-middle" data-feather="eye"></i></button>
      <button onclick="edit_und(${item.id})"><i class="align-middle" data-feather="edit-3"></i></button>
      <button onclick="confirmar_del(${item.id}, 'clientes.php?op=delund')"><i class="align-middle" data-feather="trash-2"></i></button>
      </td>`;
      tb.appendChild(tr);
      feather.replace();  

      //paginacion
      paginacion(pg, 'getUnidades', total_paginas, 'unidades-pagination')
    });
  }

}

function guardar_data_si(url, form, div1, div2){
  showLoader();
  setTimeout(async ()=>{
    const frm = new FormData(document.getElementById(form));
    let resp = await fetch('controllers/'+url, {
      method: 'post',
      cache: 'no-cache',
      mode: 'same-origin',
      body: frm
    });
    let json = await resp.json();
    if(json.status){
      hideLoader();
      Swal.fire(
        "Exito",
        json.msg,
        "success",
      );
      limpiarFormulario(form);
      switch_divs(div1, div2);
      cargardatos();
    } else {
      hideLoader();
      Swal.fire(
        "Error",
        json.msg,
        "error",
      );
    }
  }, 500);
}


function guardar_nodv(url, form, urlbk){
  showLoader();
  setTimeout(async ()=>{
    const frm = new FormData(document.getElementById(form));
    let resp = await fetch('controllers/'+url, {
      method: 'post',
      cache: 'no-cache',
      mode: 'same-origin',
      body: frm
    });
    let json = await resp.json();
    if(json.status){
      hideLoader();
      limpiarFormulario(form);
      Swal.fire(
        "Exito",
        json.msg,
        "success",
      ).then((result) => {
        if(result.isConfirmed){
          cargardatos();
          window.location.href = urlbk;
        }
      });
    } else {
      hideLoader();
      Swal.fire(
        "Error",
        json.msg,
        "error",
      );
    }
  }, 500);
}


function guardar_data_url(url, form, redireccion){
  showLoader();
  setTimeout(async ()=>{
    const frm = new FormData(document.getElementById(form));
    let resp = await fetch('controllers/'+url, {
      method: 'post',
      cache: 'no-cache',
      mode: 'same-origin',
      body: frm
    });
    let json = await resp.json();
    if(json.status){
      hideLoader();
      limpiarFormulario(form);
      cargardatos();
      Swal.fire(
        "Exito",
        json.msg,
        "success",
      ).then((result) =>{
        if(result.isConfirmed)
          window.location.href = redireccion;
      })
    } else {
      hideLoader();
      Swal.fire(
        "Error",
        json.msg,
        "error",
      );
    }
  }, 500);
}

if(document.getElementById('total_unidades')){
  obtener_total_registros('clientes.php?op=gallunits', 'total_unidades');
}

if(document.getElementById('idx_unidades')){
  obtener_total_registros('clientes.php?op=gallunits', 'idx_unidades');
}

if(document.getElementById('idx_clientes')){
  obtener_total_registros('clientes.php?op=getnumcl', 'idx_clientes');
}

if(document.getElementById('tbl-unidades')){
    getUnidades();
}

if(document.getElementById('sv__unidades')){
  document.getElementById('sv__unidades').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_data_si('clientes.php?op=svunds', 'frmunidades', 'addunidades', 'tblunidades');
  })
}

if(document.getElementById('updx__unidades')){
  document.getElementById('updx__unidades').addEventListener('click', (e)=>{
    e.preventDefault();
    let id = document.getElementById('idpcnombre').value;
    guardar_data_si('clientes.php?op=upunds', 'frmunidades', 'addunidades', 'tblveh_empresa');
    listado(1, id, 'tblveh_empresa', 'tblveh_empresa');
  })
}

if(document.getElementById('save__unidades')){
  document.getElementById('save__unidades').addEventListener('click', (e)=>{
    e.preventDefault();
    let id = document.getElementById('idpcnombre').value;
    guardar_data_si('clientes.php?op=svunds', 'frmunidades', 'addunidades', 'tblveh_empresa');
    listado(1, id, 'tblveh_empresa', 'tblveh_empresa');
  })
}

if(document.getElementById('addtareabtn')){
  document.getElementById('addtareabtn').addEventListener('click', (e)=>{
    e.preventDefault();
    showLoader();
    setTimeout(()=>{
      switch_divs('tblactividades', 'addsolicitud');
      hideLoader();
    }, 500);
  })
}

if(document.getElementById('back__sol')){
  document.getElementById('back__sol').addEventListener('click', (e)=>{
    e.preventDefault();
    showLoader();
    setTimeout(()=>{
      switch_divs('addsolicitud', 'tblactividades');
      hideLoader();
    }, 500);
  })
}


if(document.getElementById('archivos')){
  document.getElementById('archivos').addEventListener('change', function() {
    var archivos = this.files;
    var archivosList = document.getElementById('archivosList');
    archivosList.innerHTML = '';
    for (var i = 0; i < archivos.length; i++) {
        archivosList.innerHTML += '<li>' + archivos[i].name + '</li>';
    }
  });
}

if(document.getElementById('detallesunit')){
  document.getElementById('detallesunit').addEventListener('change', (e)=>{
    e.preventDefault();
      if(document.getElementById('detallesunit').checked){
        document.getElementById('detalles_unidad').classList.remove('hide');
      } else {
        document.getElementById('detalles_unidad').classList.add('hide');
      }
  })
}

function poblar_unidades_empresa(id){
  showLoader();
  setTimeout(async ()=>{
    let frm = new FormData();
    frm.append('id', id);
    let resp = await fetch('controllers/clientes.php?op=undbyidem', {
      method: 'POST',
      cache: 'no-cache',
      cors: 'no-cors',
      body: frm
    });
    let json = await resp.json();
    const selector = document.getElementById('ppu_semi');
    if(json.status){
        hideLoader();
        let data = json.data;
        selector.innerHTML = "";
        data.forEach(item => {
            let opt = document.createElement('option');
            opt.text = item.ppu + ' ' +item.tipo;
            opt.value = item.id;
            selector.add(opt);
        });
    } else {
      hideLoader();
      Swal.fire(
        "Error",
        json.msg,
        "error",);
        const selector = document.getElementById('ppu_semi');
        selector.innerHTML = "";
  
  
    } 
  }, 500);
}


async function poblar_company_tarea(input, lista){
  let frm = new FormData();
  let texto = document.getElementById(input).value;
  frm.append('txtbuscar', texto); 
  let resp = await fetch('controllers/clientes.php?op=clist', {
      method: 'POST',
      cache: 'no-cache',
      cors: 'no-cors',
      body: frm
  });

  let json = await resp.json();
  const ul = document.getElementById(lista);
  ul.innerHTML = "";
  if(json.status){
      let data = json.data;
      ul.classList.remove('hide');
      data.forEach(item => {
          let li = document.createElement('li');
          li.innerHTML = item.nombre;
          ul.appendChild(li);

          li.addEventListener('click', (e)=>{
              e.preventDefault();
              document.getElementById('id'+input).value = item.id;
              document.getElementById(input).value = item.nombre;
              poblar_unidades_empresa(item.id);
              ul.classList.add('hide');
              
          });
      });
  } else {
    document.getElementById('ppu_semi').value = "";
    ul.classList.add('hide');
   
  }
}

if(document.getElementById('pcnombre')){
  document.getElementById('pcnombre').addEventListener('keyup', ()=>{
      if(document.getElementById('pcnombre').value.length>1){
         poblar_company_tarea('pcnombre', 'lista_empresa');
      } else {
        document.getElementById('lista_empresa').classList.add('hide');
      }
  });
}

async function poblar_inspectores(input, lista){
  let frm = new FormData();
  let texto = document.getElementById(input).value;
  frm.append('txtbuscar', texto); 
  let resp = await fetch('controllers/personal.php?op=gtempbydpt', {
      method: 'POST',
      cache: 'no-cache',
      cors: 'no-cors',
      body: frm
  });

  let json = await resp.json();
  const ul = document.getElementById(lista);

  if(json.status){
      ul.innerHTML = "";
      let data = json.data;
      ul.classList.remove('hide');
      data.forEach(item => {
          let li = document.createElement('li');
          li.innerHTML = item.nombre + ' ' + item.apellido;
          ul.appendChild(li);
          li.addEventListener('click', (e)=>{
              e.preventDefault();
              document.getElementById('id'+input).value += item.idpersona +',';
              document.getElementById(input).value = "";
              let nisp = document.createElement('span');
              nisp.innerHTML = item.nombre + ' ' + item.apellido;
              nisp.id = item.idpersona;
              document.getElementById('ipseleccionados').classList.remove('hide');
              document.getElementById('ipseleccionados').appendChild(nisp);
              console.log(document.getElementById('id'+input).value);
              ul.classList.add('hide');

              nisp.addEventListener('click', (e)=>{
                e.preventDefault();
                document.getElementById('id'+input).value = document.getElementById('id'+input).value.replace(item.idpersona+',', '');
                console.log(document.getElementById('id'+input).value);
                document.getElementById('ipseleccionados').removeChild(nisp);
                if(document.getElementById('id'+input).value==""){
                  document.getElementById('ipseleccionados').classList.add('hide');
                }
              });
          });
      });
  } else {
    ul.classList.add('hide');
    console.log('no hay datos');
  }


}

if(document.getElementById('inspector')){
  document.getElementById('inspector').addEventListener('keyup', ()=>{
      if(document.getElementById('inspector').value.length>1){
         poblar_inspectores('inspector', 'lista_inspectores');
      } else {
        document.getElementById('lista_inspectores').classList.add('hide');
      }
  });
}

if(document.getElementById('trinspector')){
  document.getElementById('trinspector').addEventListener('keyup', ()=>{
      if(document.getElementById('trinspector').value.length>1){
         poblar_inspectores('trinspector', 'trlista_inspectores');
      } else {
        document.getElementById('trlista_inspectores').classList.add('hide');
      }
  });
}



if(document.getElementById('multiples_inspectores')){
  document.getElementById('multiples_inspectores').addEventListener('change', ()=>{
    if(document.getElementById('multiples_inspectores').checked){
      document.getElementById('inspector').value = "";
      document.getElementById('mulinspectores').classList.remove('hide');
    } else {
      document.getElementById('mulinspectores').classList.add('hide');
      document.getElementById('inspector').value = "";
    }
  })
}

if(document.getElementById('back__tareas')){
  document.getElementById('back__tareas').addEventListener('click', (e)=>{
    e.preventDefault();
    showLoader();
    setTimeout(()=>{
      switch_divs('addtareas', 'tblactividades');
      hideLoader();
    }, 500);
  })
}


if(document.getElementById('sv__tareas')){
  document.getElementById('sv__tareas').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_data_si('actividades.php?op=crtact', 'frmsolicitud', 'addsolicitud', 'tblactividades');
  });
}


if(document.getElementById('status')){
  document.getElementById('status').addEventListener('change', ()=>{
    if(document.getElementById('status').value==4){
      document.getElementById('mot_incumplimiento').classList.remove('hide');
    } else {
      document.getElementById('mot_incumplimiento').classList.add('hide');
    }
  });
}


async function getSolicitudes(tipo, url, pgact, comp){
  let frm = new FormData();
  pg  = pgact ?? 1;
  comp = comp ?? '!=';
  frm.append('pg', pg);
  frm.append('comp', comp);


  let resp = await fetch('controllers/'+url, {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });
  let json = await resp.json();

  let tb = document.getElementById('tbl-'+tipo);
  tb.innerHTML = "";
  if(json.status){
    let data = json.data;
    let total_paginas = json.total_paginas;
    let inspector = '';
    data.forEach(item => {
      if (item.idactividad!=null && item.idactividad!='' && item.idactividad!=0) {
        inspector = '<span class="asignado">Asignado</span>';
      } else {
        inspector = '<span class="noasignado">No asignado</span>';
      }
      const tr = document.createElement('tr');
      let botonera;
      if(item.estado_solicitud==3){
        inspector = 'Cerrado';
        botonera = `
        <button class="btn-mn" onclick="location.href='index.php?p=detalles&cat=ip&id=${item.id}'" title="Actualizar solicitud">
          <i class="align-middle" data-feather="eye"></i>
        </button>
        `
      } else {
        botonera = `
        <button class="btn-mn" onclick="add_ip(${item.id})" title="Procesar solicitud"><i class="align-middle" data-feather="calendar"></i></button>
        <button class="btn-mn" onclick="add_updt(${item.id})" title="Actualizar solicitud"><i class="align-middle" data-feather="clipboard"></i></button>
        <button class="btn-mn" onclick="cerrar_ip(${item.id})" title="Cerrar IP/PM"><i class="align-middle" data-feather="check-circle"></i></button>
        <button class="btn-mn" title="Eliminar actividad" onclick="confirmar_del(${item.id}, 'actividades.php?op=delip')"><i class="align-middle" data-feather="trash-2"></i></button>
        `
      }
      tr.innerHTML = `
      <td>${item.fecha_solicitud}</td>
      <td>${item.empresa}</td>
      <td>${item.ppu}</td>
      <td>${item.km_actual}</td>
      <td>${item.last_status}</td>
      <td>${item.fecha_ultima}</td>
      <td>${item.tipo_servicio}</td>
      <td>${inspector}</td>
      <td>
      ${botonera}
      </td>`;
      tb.appendChild(tr);
      feather.replace();  

      
    });
  } else {
    document.getElementById('tbl-actividadesip').innerHTML = "";
    document.getElementById('tblip').classList.remove('table-hover');
    document.getElementById('tbl-actividadesip').innerHTML = `
    <tr>
       <td colspan="8">
           <div class="no_registros">
               <img class="nreg" src="assest/images/svg/tecnicos.svg">
               <h2>Sin datos para mostrar</h2>
               <p>No hay solicitudes IP/PM en este momento</p>
           </div>
       </td>
   </tr>`
     }
}

if(document.getElementById('tbl-actividadesip')){
  getSolicitudes('actividadesip', 'actividades.php?op=getip', 1);
}


async function add_updt(id){
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/actividades.php?op=getsobyid', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();

  if(json.status){
    let data = json.data[0];
    if(data.idactividad==null || data.idactividad=='' || data.idactividad==0){
      Swal.fire(
        "Error",
        "Debe rellenar la solicitud antes de procesarla",
        "error",
      );
    } else {
      
      document.getElementById('dactividad').innerText = "";
      if(data.edosolicitud!=3){
        document.getElementById('frmreporte').classList.remove('hide');
      } else {
        document.getElementById('frmreporte').classList.add('hide');
      }
      document.getElementById('dtllssolc').classList.remove('hide');
      document.getElementById('dactividad').classList.remove('hide');
      let q1 = document.querySelectorAll('.actdlls');
      let q2 = document.querySelectorAll('.dtllssol');
      q1.forEach(item=>{
        document.getElementById('dtllssolc').innerText = "";
        document.getElementById('dtllssolc').innerText = "Ocultar detalles";
        item.classList.remove('hide');
      });
      q2.forEach(item=>{
        document.getElementById('dactividad').innerText = "";
        document.getElementById('dactividad').innerText = "Ocultar detalles";
        item.classList.remove('hide');
      });

     

    switch_divs('tblactividades', 'addreporte');
    document.getElementById('rpinspector').value = data.inspectores;
    document.getElementById('rpinspector').setAttribute('disabled', 'disabled');
    document.getElementById('rpidsol').value = data.id;
    document.getElementById('rppcnombre').value = data.empresa;
    document.getElementById('rpppu_semi').value = data.ppu;
    document.getElementById('rptipo').value = data.tipo_servicio;
    document.getElementById('rpkm_actual').value = data.km_actual;
    document.getElementById('rpkm_ultima').value = data.km_ultima;
    document.getElementById('rpfecha_ultima').value = data.fecha_ultima;
    document.getElementById('rptaller').value = data.taller;
    document.getElementById('rpubicacion').value = data.ubicacion;
    document.getElementById('rpobservaciones').value = data.observaciones;
    document.getElementById('rpservicio').value = data.contrato;
    document.getElementById('rpfecha_solicitud').value = data.fecha_solicitud;
    document.getElementById('rpsemana').value = data.semana;
    document.getElementById('rpsemana').setAttribute('disabled', 'disabled');
    document.getElementById('rpfecha_agendada').value = data.fecha_revision;
    document.getElementById('rpfecha_agendada').setAttribute('disabled', 'disabled');
    document.getElementById('rphora_agendada').value = data.hora;
    document.getElementById('rphora_agendada').setAttribute('disabled', 'disabled');
    document.getElementById('rpsemana').value = data.semana;
    document.getElementById('rpsemana').setAttribute('disabled', 'disabled');
    document.getElementById('rpsolicitado').value = data.solicitado_por;
    document.getElementById('rpsolicitado').setAttribute('disabled', 'disabled');
    document.getElementById('rpaprobado_por').value = data.autorizado_por;
    document.getElementById('rpaprobado_por').setAttribute('disabled', 'disabled');
    document.getElementById('sv__asignacion').classList.add('hide');
    mostrar_avances(data.id, 'resumen_actividades', 'actividades.php?op=gtodactip', 'tr-actividad');
    document.getElementById('sv__actividad').classList.remove('hide');
    document.getElementById('sv__asignacion').classList.add('hide');
    } 
  } else {
    console.log('error');
  }
}


async function cerrar_ip(id){
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/actividades.php?op=getsobyid', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();

  if(json.status){
    let data = json.data[0];
      
      document.getElementById('dactividad').innerText = "";

      document.getElementById('dtllssolc').classList.remove('hide');
      document.getElementById('dactividad').classList.remove('hide');
      let q1 = document.querySelectorAll('.actdlls');
      let q2 = document.querySelectorAll('.dtllssol');
      q1.forEach(item=>{
        document.getElementById('dtllssolc').innerText = "";
        document.getElementById('dtllssolc').innerText = "Ocultar detalles";
        item.classList.remove('hide');
      });
      q2.forEach(item=>{
        document.getElementById('dactividad').innerText = "";
        document.getElementById('dactividad').innerText = "Ocultar detalles";
        item.classList.remove('hide');
      });

    switch_divs('tblactividades', 'addreporte');
    document.getElementById('frmreporte').classList.add('hide');
    document.getElementById('frmcloseip').classList.remove('hide');
    
    document.getElementById('rpinspector').value = data.inspectores;
    document.getElementById('rpinspector').setAttribute('disabled', 'disabled');
    document.getElementById('cl_idsol').value = data.id;
    console.log(document.getElementById('cl_idsol').value)
    document.getElementById('rppcnombre').value = data.empresa;
    document.getElementById('rpppu_semi').value = data.ppu;
    document.getElementById('rptipo').value = data.tipo_servicio;
    document.getElementById('rpkm_actual').value = data.km_actual;
    document.getElementById('rpkm_ultima').value = data.km_ultima;
    document.getElementById('rpfecha_ultima').value = data.fecha_ultima;
    document.getElementById('rptaller').value = data.taller;
    document.getElementById('rpubicacion').value = data.ubicacion;
    document.getElementById('rpobservaciones').value = data.observaciones;
    document.getElementById('rpservicio').value = data.contrato;
    document.getElementById('rpfecha_solicitud').value = data.fecha_solicitud;
    document.getElementById('rpsemana').value = data.semana;
    document.getElementById('rpsemana').setAttribute('disabled', 'disabled');
    document.getElementById('rpfecha_agendada').value = data.fecha_revision;
    document.getElementById('rpfecha_agendada').setAttribute('disabled', 'disabled');
    document.getElementById('rphora_agendada').value = data.hora;
    document.getElementById('rphora_agendada').setAttribute('disabled', 'disabled');
    document.getElementById('rpsemana').value = data.semana;
    document.getElementById('rpsemana').setAttribute('disabled', 'disabled');
    document.getElementById('rpsolicitado').value = data.solicitado_por;
    document.getElementById('rpsolicitado').setAttribute('disabled', 'disabled');
    document.getElementById('rpaprobado_por').value = data.autorizado_por;
    document.getElementById('rpaprobado_por').setAttribute('disabled', 'disabled');
    document.getElementById('sv__asignacion').classList.add('hide');
    mostrar_avances(data.id, 'resumen_actividades', 'actividades.php?op=gtodactip', 'tr-actividad');
  } else {
    console.log('error');
  }
}

async function add_ip(id){
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/actividades.php?op=getsolbyid', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();

  if(json.status){
    let data = json.data[0];
    if(data.estado_solicitud==0){
      switch_divs('tblactividades', 'addasignacion');
      document.getElementById('dtllssolc').classList.add('hide');
      document.getElementById('dactividad').classList.add('hide');
      document.getElementById('idsol').value = id;
      document.getElementById('solpcnombre').value = data.empresa;
      document.getElementById('solppu_semi').value = data.ppu;
      document.getElementById('soltipo').value = data.tipo_servicio;
      document.getElementById('solkm_actual').value = data.km_actual;
      document.getElementById('solkm_ultima').value = data.km_ultima;
      document.getElementById('soltaller').value = data.taller;
      document.getElementById('solubicacion').value = data.ubicacion;
      document.getElementById('solobservaciones').value = data.observaciones;
      document.getElementById('solfecha_ultima').value = data.fecha_ultima;
      document.getElementById('solservicio').value = data.contrato;
      document.getElementById('fecha_solicitud').value = data.fecha_solicitud;
    } else {
      Swal.fire(
        "Error",
        "La solicitud ya ha sido procesada",
        "error",
      );
    }
  } 
}

function edit_ip(id){
  showLoader();
  setTimeout(async ()=>{
    
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/actividades.php?op=getipbyid', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  }); 
  let json = await resp.json();
  if(json.status){
    let data = json.data[0];
    if(data.idinspector=='' || data.idinspector==null){
        switch_divs('tblactividades', 'asignartareas');
        document.getElementById('trsv__tareas').classList.add('hide');
        document.getElementById('trupd__tareas').classList.remove('hide');
        document.getElementById('idtr').value = data.id;
        document.getElementById('trpcnombre').value = data.empresa;
        document.getElementById('trppu_semi').value = data.ppu;
        document.getElementById('trfecha_solicitud').value = data.fecha_solicitud;
        document.getElementById('trfecha_agendada').value = data.fecha_revision;
        document.getElementById('trhora_agendada').value = data.hora;
        document.getElementById('trtaller').value = data.taller;
        document.getElementById('tractividad').value = data.actividad;
        document.getElementById('trmarca').value = data.marca;
        document.getElementById('trmodelo').value = data.modelo;
        document.getElementById('trtipo').value = data.tipo;
        document.getElementById('trubicacion').value = data.ubicacion;
        document.getElementById('trsemana').value = data.semana;
        document.getElementById('trsolicitado').value = data.solicitado_por;
        document.getElementById('traprobado').value = data.autorizado_por;
      hideLoader();
      } else {
        switch_divs('tblactividades', 'tractualizaciones');
        document.getElementById('ctrupd__tareas').classList.remove('hide');
        document.getElementById('tractualizaciones').classList.remove('hide');
        document.getElementById('idtr').value = data.id;
        document.getElementById('actrpcnombre').value = data.empresa;
        document.getElementById('actrppu_semi').value = data.ppu;
        document.getElementById('actrmarca').value = data.marca;
        document.getElementById('actrmodelo').value = data.modelo;
        document.getElementById('actrtipo').value = data.tipo;
        document.getElementById('actrfecha_solicitud').value = data.fecha_solicitud;
        document.getElementById('actrfecha_agendada').value = data.fecha_revision;
        document.getElementById('actrhora_agendada').value = data.hora;
        document.getElementById('actrtaller').value = data.taller;
        document.getElementById('actrubicacion').value = data.ubicacion;
        document.getElementById('actrsemana').value = data.semana;
        hideLoader();
      }
  }

  }, 500);
}

if(document.getElementById('fecha_propuesta')){
  
  document.getElementById('fecha_propuesta').addEventListener('click', ()=>{
    if(document.getElementById('fecha_propuesta').checked){
      let fecha = document.getElementById('trfecha_agendada').value;
      let hora = document.getElementById('trhora_agendada').value; 
      let propuesta = document.getElementById('trfecha_programada');
      let hora_propuesta = document.getElementById('trhora_programada');
      propuesta.value = fecha;
      hora_propuesta.value = hora;
      //document.getElementById('trhora_programada').value == document.getElementById('trhora_agendada').value;
    } else {
      document.getElementById('trfecha_programada').value = "";
      document.getElementById('trhora_programada').value = "";
    }
  }); 
  
}

if(document.getElementById('trupd__tareas')){
  document.getElementById('trupd__tareas').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_data_si('actividades.php?op=svactrv', 'frmasignacion', 'asignartareas', 'tblactividades');
  })
}

if(document.getElementById('upd__unidades')){
  document.getElementById('upd__unidades').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_data_si('clientes.php?op=upunds', 'frmunidades', 'addunidades', 'tblveh_empresa');
  })
}

if(document.getElementById('sv__asignacion')){
  document.getElementById('sv__asignacion').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_data_si('actividades.php?op=crtasg', 'frmasignacion', 'addasignacion', 'tblactividades');
  });
}

if(document.getElementById('dtllssolc')){
  document.getElementById('dtllssolc').addEventListener('click', (e)=>{
    if(document.getElementById('dtllssolc').innerText=="Ocultar detalles"){
    document.getElementById('dtllssolc').innerText = "Mostrar detalles";
    e.preventDefault();
    let sw = document.querySelectorAll('.dtllssol');
    sw.forEach(item=>{
      item.classList.toggle('hide');
    });
  } else {
    document.getElementById('dtllssolc').innerText="Ocultar detalles"
    e.preventDefault();
    let sw = document.querySelectorAll('.dtllssol');
    sw.forEach(item=>{
      item.classList.toggle('hide');
    });
  }
  })
}

if(document.getElementById('dactividad')){
  document.getElementById('dactividad').addEventListener('click', (e)=>{
    if(document.getElementById('dactividad').innerText=="Ocultar detalles"){
    document.getElementById('dactividad').innerText = "Mostrar detalles";
    e.preventDefault();
    let sw = document.querySelectorAll('.actdlls');
    sw.forEach(item=>{
      item.classList.toggle('hide');
    });
  } else {
    document.getElementById('dactividad').innerText="Ocultar detalles"
    e.preventDefault();
    let sw = document.querySelectorAll('.actdlls');
    sw.forEach(item=>{
      item.classList.toggle('hide');
    });
  }
  })
}


if(document.getElementById('ip_superviso')){
  document.getElementById('ip_superviso').addEventListener('change', (e)=>{
    e.preventDefault();
    if(document.getElementById('ip_superviso').value=='No'){
      document.getElementById('io_motivo').classList.remove('hide');
    } else {
      document.getElementById('io_motivo').classList.add('hide');
    }
  })
}

if(document.getElementById('ip_edo_unidad')){
  document.getElementById('ip_edo_unidad').addEventListener('change', (e)=>{
    e.preventDefault();
    if(document.getElementById('ip_superviso').value=='No' && document.getElementById('ip_edo_unidad').value=='Movilizada'){
      Swal.fire(
        "Error",
        "La unidad no puede cambiar de estado si no ha sido supervisada",
        "error",
      );
      document.getElementById('ip_edo_unidad').value = "";
      document.getElementById('ip_edo_unidad').classList.add('is-invalid');
      document.getElementById('ip_edo_unidad').focus();
    } 
  })
}



async function obtener_listado_inspectores(pg){
  let frm = new FormData();
  frm.append('pg', pg);
  let resp = await fetch('controllers/actividades.php?op=getactinsp', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();
  let tb = document.getElementById('tbl-actividadesinsp');
  tb.innerHTML = "";
  if(json.status){
    let data = json.data;
    let total_paginas = json.total_paginas;
    data.forEach(item => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td>${item.fecha_revision}</td>
      <td>${item.hora}</td>
      <td>${item.empresa}</td>
      <td>${item.tipo}</td>
      <td>${item.ppu}</td>
      <td>${item.ubicacion}</td>
      <td>${item.estado_unidad}</td>
      <td class="submenu">
      <button onclick="add_updt(${item.idsolicitud})" alt="Actualizar solicitud"><i class="align-middle" data-feather="edit-3"></i></button>
      </td>`;
      tb.appendChild(tr);
      feather.replace();
      //paginacion(pg, 'obtener_listado_inspectores', total_paginas, 'inspectores-pagination')
    });
  }
}

if(document.getElementById('tbl-actividadesinsp')){
  obtener_listado_inspectores(1);
}

if(document.getElementById('total_actividadesinsp')){
  obtener_total_registros('actividades.php?op=gttlasg', 'total_actividadesinsp');
}

async function mostrar_avances(idsolicitud, iddiv, url, tabla){
  let frm = new FormData();
  frm.append('id', idsolicitud);
  let resp = await fetch('controllers/'+url, {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();
  let tb = document.getElementById(tabla);
  
  if(json.status){
    let div = document.getElementById(iddiv);
    div.classList.remove('hide');  
    tb.innerHTML = "";
    let data = json.data;
    let contador = 0;
    data.forEach(item => {
      const tr = document.createElement('tr');
      let fecha = item.fecha_actualizado.split('-');
      let fecha_actualizado = fecha[2] + '-' + fecha[1] + '-' + fecha[0];
      let motivo = '';
      if(item.realizo=='No'){
        motivo = `
        <div class="col-md-12">
          <label class="form-label">Motivo en caso de no haber realizado la inspección: </label>
          <input type="text" class="form-control" value="${item.motivo}" disabled>
        </div>
        `;
      }

      tr.innerHTML = `
      <td>
      <div class="row g-3 show-result">
        <div class="col-md-4">
          <label class="form-label">Fecha inspección: </label>
          <input type="date" class="form-control" value="${item.fecha_inspeccion}" disabled>
        </div> 
        <div class="col-md-4">
          <label class="form-label">Realizó inspección: </label>
          <input type="text" class="form-control" value="${item.realizo}" disabled>
        </div>
        <div class="col-md-4">
          <label class="form-label">Estado unidad: </label>
          <input type="text" class="form-control" value="${item.estado_unidad_sugerido}" disabled>
        </div>
        ${motivo}
        <div class="col-md-12">
          <div class="htmtexto">${item.observaciones}</div>
        </div>
        <div class="col-md-12">
        <h4>Archivos adjuntos:</h4>
        <div id="archivosList${contador}" class="show-archivos">
        </div>
        </div>
        <div class="col-md-12 d-flexj"><div id="fecha">Actualizado el día ${fecha_actualizado} por <strong>${item.nombre} ${item.apellido}</strong></div></div>
      </div></td>`;
      tb.appendChild(tr);
      let dv = document.getElementById('archivosList'+contador);
      dv.innerHTML = "";
       if(item.archivo){
        item.archivo[0].forEach(element => {
          let extension = element.archivo.split('.').pop(); 

          if(extension === 'jpg' || extension === 'gif'|| extension === 'png') {
            let img = document.createElement('img');
            img.src = 'assest/clientes/IP/'+item.idsolicitud+'/'+element.archivo;
            let a = document.createElement('a');
            a.href = '#';
            a.onclick = function(e) {
              e.preventDefault();
              // Código para abrir el modal y mostrar la imagen
              let modal = new bootstrap.Modal(document.getElementById('galleryMdl'));
              let modalImg = document.getElementById('img01');
              modalImg.src = this.children[0].src;
              modal.show();
              let link = document.getElementById('link_full');
              link.innerHTML = `<a target="_blank" href="${this.children[0].src}">Ver imagen en tamaño completo</a>`;

            };

            a.appendChild(img);
            dv.appendChild(a);
          }

          if(extension === 'doc' || extension === 'docx') {
            let a = document.createElement('a');
            a.href = 'assest/clientes/IP/'+item.idsolicitud+'/'+element.archivo;
            a.innerText = element.archivo;
            a.target = '_blank';
            dv.appendChild(a);

          }

          if(extension === 'pdf') {
            let a = document.createElement('a');
            a.href = 'assest/clientes/IP/'+item.idsolicitud+'/'+element.archivo;
            a.innerText = element.archivo;
            a.target = '_blank';
            dv.appendChild(a);
          }

        });
       } else {
        dv.innerHTML = "No hay archivos adjuntos";
       }
      contador++;
    });
      
  } else {
    let div = document.getElementById(iddiv);
    div.classList.add('hide');
  }
}

if(document.getElementById('sv__actividad')){
  document.getElementById('sv__actividad').addEventListener('click', (e)=>{
    e.preventDefault();
    let texto = document.getElementById('ip_texto');
    texto.value = document.getElementById('wyseip').innerHTML;
    document.getElementById('wyseip').value = "";
    guardar_data_si('actividades.php?op=svupdtactip', 'frmreporte', 'addreporte', 'tblactividades');
  });
}

if(document.getElementById('sv__cerrarip')){
  document.getElementById('sv__cerrarip').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_data_si('actividades.php?op=svcloseip', 'frmcloseip', 'addreporte', 'tblactividades');
  });
}

async function busqueda_txt(buscartxt){
  let frm = new FormData();
  let estado = document.getElementById('vercloseip').value;
  frm.append('txtbuscar', buscartxt);
  frm.append('comp', estado);

  let resp = await fetch('controllers/actividades.php?op=bsqip', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();
  let tb = document.getElementById('tbl-actividadesip');
    tb.innerHTML = "";  
  if(json.status){
    let data = json.data;  
    console.log(data);
    data.forEach(item => {
      if (item.idactividad!=null && item.idactividad!='' && item.idactividad!=0) {
        inspector = '<span class="asignado">Asignado</span>';
      } else {
        inspector = '<span class="noasignado">No asignado</span>';
      }
      const tr = document.createElement('tr');
      let botonera;
      if(item.estado_solicitud==3){
        botonera = `
        <button class="btn-mn" onclick="add_updt(${item.id})" title="Actualizar solicitud"><i class="align-middle" data-feather="eye"></i></button>
        `
      } else {
        botonera = `
        <button class="btn-mn" onclick="add_ip(${item.id})" title="Procesar solicitud"><i class="align-middle" data-feather="calendar"></i></button>
        <button class="btn-mn" onclick="add_updt(${item.id})" title="Actualizar solicitud"><i class="align-middle" data-feather="clipboard"></i></button>
        <button class="btn-mn" onclick="cerrar_ip(${item.id})" title="Cerrar IP/PM"><i class="align-middle" data-feather="check-circle"></i></button>
        <button class="btn-mn" title="Eliminar actividad" onclick="confirmar_del(${item.id}, 'actividades.php?op=delip')"><i class="align-middle" data-feather="trash-2"></i></button>
        `
      }
      tr.innerHTML = `
      <td>${item.fecha_solicitud}</td>
      <td>${item.empresa}</td>
      <td>${item.ppu}</td>
      <td>${item.km_actual}</td>
      <td>${item.estatus}</td>
      <td>${item.fecha_ultima}</td>
      <td>${item.tipo_servicio}</td>
      <td>${inspector}</td>
      <td>
      ${botonera}
      </td>`;
      tb.appendChild(tr);
      feather.replace();  

      
    });
  } else {
    document.getElementById('tbl-actividadesip').innerHTML = "";
    document.getElementById('tblip').classList.remove('table-hover');
    document.getElementById('tbl-actividadesip').innerHTML = `
    <tr>
       <td colspan="8">
           <div class="no_registros">
               <img class="nreg" src="assest/images/svg/tecnicos.svg">
               <h2>Sin datos para mostrar</h2>
               <p>No hay solicitudes IP/PM en este momento</p>
           </div>
       </td>
   </tr>`
     }
}

if(document.getElementById('buscartxt')){
  document.getElementById('buscartxt').addEventListener('keyup', ()=>{
    let buscartxt = document.getElementById('buscartxt').value;
    if(buscartxt.length>1){
      busqueda_txt(buscartxt);
    } else {
      let comp = document.getElementById('vercloseip').value;  
      getSolicitudes('actividadesip', 'actividades.php?op=getip', 1, comp);
    }
  });
}

if(document.getElementById('vercloseip')){
  document.getElementById('vercloseip').addEventListener('change', ()=>{
    let comp = document.getElementById('vercloseip').value;
    getSolicitudes('actividadesip', 'actividades.php?op=getip', 1, comp);
  });
}

if(document.getElementById('ord') && document.getElementById('ord').value!==''){
  let comp = "=";
  let selectElement = document.getElementById('vercloseip');
  selectElement.value = "=";
  getSolicitudes('actividadesip', 'actividades.php?op=getip', 1, comp);  
}

if(document.getElementById('addpannebtn')){
  document.getElementById('addpannebtn').addEventListener('click', ()=>{
    switch_divs('tblpanne', 'addpanne');
  });
}

if(document.getElementById('back__panne')){
  document.getElementById('back__panne').addEventListener('click', (e)=>{
    e.preventDefault();
    switch_divs('addpanne', 'tblpanne');
  });
}

if(document.getElementById('sv__panne')){
  document.getElementById('sv__panne').addEventListener('click', (e)=>{
    e.preventDefault();
    let texto = document.getElementById('falla_preliminar');
    texto.value = document.getElementById('cntpreliminar').innerHTML;
    document.getElementById('wysepreliminar').value = "";
    guardar_data_si('actividades.php?op=svpanne', 'frmpanne', 'addpanne', 'tblpanne');
  });
}

async function obtener_panne(pgact, comp, url, tabla){
  pg  = pgact ?? 1;
  comp = comp ?? document.getElementById('ordpn').value;



  let frm = new FormData();
  frm.append('pg', pg);
  frm.append('comp', comp);

  let resp = await fetch('controllers/actividades.php?op='+url, {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });
  let json = await resp.json();
  let tb = document.getElementById('tbl-panne');
  tb.innerHTML = "";
  if(json.status){
    let data = json.data;
    data.forEach(item => {
      if(item.estado_solicitud==3){
        let fecha = item.fecha_creado.split('-');
        fecha_creado = fecha[2] + '/' + fecha[1] + '/' + fecha[0];
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>${fecha_creado}</td>
        <td>${item.empresa}</td>
        <td>${item.ppu}</td>
        <td>${item.km_actual_tracto}</td>
        <td>${item.ppu_semi}</td>
        <td>${item.km_actual_semi}</td>
        <td>${item.transportista}</td>
        <td></td>
        <td>
        <div class="submenu">
        <button onclick="location.href='index.php?p=detalles&cat=panne&id=${item.idsolicitud}'" title="Detalles"><i class="align-middle" data-feather="eye"></i></button>
        </td>

        `;
        tb.appendChild(tr);
        feather.replace();
      } else {
        let fecha = item.fecha_creado.split('-');
        fecha_creado = fecha[2] + '/' + fecha[1] + '/' + fecha[0];
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>${fecha_creado}</td>
        <td>${item.empresa}</td>
        <td>${item.ppu}</td>
        <td>${item.km_actual_tracto}</td>
        <td>${item.ppu_semi}</td>
        <td>${item.km_actual_semi}</td>
        <td>${item.transportista}</td>
        <td></td>
        <td>
        <div class="submenu">
        <button onclick="pv_panne(${item.idsolicitud})" title="Actualizar solicitud"><i class="align-middle" data-feather="edit-3"></i></button>
        <button class="btn-mn" onclick="cerrar_panne(${item.idsolicitud})" title="Cerrar Panne"><i class="align-middle" data-feather="check-circle"></i></button>
        </td>

        `;
        tb.appendChild(tr);
        feather.replace();
      }
    });
  } else {
    document.getElementById(tabla).innerHTML = "";
    document.getElementById('tbpnn').classList.remove('table-hover');
    document.getElementById(tabla).innerHTML = `
    <tr>
       <td colspan="9">
           <div class="no_registros">
               <img class="nreg" src="assest/images/svg/tecnicos.svg">
               <h2>Sin datos para mostrar</h2>
               <p>No hay solicitudes de Panne en este momento</p>
           </div>
       </td>
   </tr>`
  
  }

}

if(document.getElementById('verclosepn')){
  document.getElementById('verclosepn').addEventListener('change', ()=>{
    let comp = document.getElementById('verclosepn').value;
    obtener_panne(1, comp, 'getpanne', 'tbl-panne');
  });
}



async function pv_panne(id){
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/actividades.php?op=gtpanid', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();

  if(json.status){
    let data = json.data[0];
    if(data.estado_solicitud==0){
    switch_divs('tblpanne', 'addreporte');
    document.getElementById('empresa1').value = data.empresa;
    document.getElementById('ppu1').value = data.ppu;
    document.getElementById('ppus1').value = data.ppu_semi;
    document.getElementById('kma1').value = data.km_actual_tracto;
    document.getElementById('kms1').value = data.km_actual_semi;
    document.getElementById('fecha1').value = data.fecha;
    document.getElementById('hora1').value = data.hora;
    document.getElementById('servicio1').value = data.servicio;
    document.getElementById('tipo_falla1').value = data.tipo_falla;
    document.getElementById('transp1').value = data.transportista;
    document.getElementById('sup1').value = data.supervisor;
    document.getElementById('ub1').value = data.ubicacion;
    document.getElementById('falla1').innerHTML = data.falla_preliminar;
    document.getElementById('idsolpanne').value = data.id;
    } else {
      Swal.fire(
        "Error",
        "La solicitud ya ha sido procesada",
        "error",
      );
    }
  }
}

async function cerrar_panne(id){
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/actividades.php?op=gtpanid', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();

  if(json.status){
    let data = json.data[0];
    if(data.estado_solicitud==1){
      switch_divs('tblpanne', 'addreporte');
      document.getElementById('hrseparador').classList.remove('hide');
      document.getElementById('frmreporte').classList.add('hide');
      document.getElementById('frmclosepnn').classList.remove('hide');
      document.getElementById('empresa1').value = data.empresa;
      document.getElementById('ppu1').value = data.ppu;
      document.getElementById('ppus1').value = data.ppu_semi;
      document.getElementById('kma1').value = data.km_actual_tracto;
      document.getElementById('kms1').value = data.km_actual_semi;
      document.getElementById('fecha1').value = data.fecha;
      document.getElementById('hora1').value = data.hora;
      document.getElementById('servicio1').value = data.servicio;
      document.getElementById('tipo_falla1').value = data.tipo_falla;
      document.getElementById('transp1').value = data.transportista;
      document.getElementById('sup1').value = data.supervisor;
      document.getElementById('ub1').value = data.ubicacion;
      document.getElementById('falla1').innerHTML = data.falla_preliminar;
      document.getElementById('idsolp').value = data.id;
      detalles_liberacion(data.id);
    } else if(data.estado_solicitud==2){
      Swal.fire(
        "Error",
        "La solicitud ya ha sido cerrada",
        "error",
      );
    } else if(data.estado_solicitud==0){
      Swal.fire(
        "Error",
        "La solicitud no ha sido procesada",
        "error",
      );
    }
  }
}

async function detalles_liberacion(id){
  const frm = new FormData();
  frm.append('id', id);
  let resp = await fetch('controllers/actividades.php?op=shpnne', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();

  if(json.status){
    let data = json.data[0];
      let dv = document.getElementById('pvpanne');
      dv.innerHTML = "";
      let fecha = data.fecha.split('-');
      fecha = fecha[2] + '/' + fecha[1] + '/' + fecha[0];
      let fecha_creado = data.fecha_creado.split('-');
      fecha_creado = fecha_creado[2] + '/' + fecha_creado[1] + '/' + fecha_creado[0];
        dv.innerHTML = `
        <div class="mb-25">	
					<hr class="separador">
				</div>
        <h4>Solicitud de liberación</h4>
          <div class="row g-3">
                  <div class="col-md-12">
                    <label for="falla" class="form-label">Falla: </label>
                    <input type="text" class="form-control" id="falla" value="${data.falla}" disabled>
                  </div>
                  <div class="col-md-12">
                    <label for="causa" class="form-label">Causa: </label>
                    <input type="text" class="form-control" id="causa" value="${data.causa}" disabled>
                  </div>
                  <div class="col-md-12">
                    <label for="accion" class="form-label">Acción: </label>
                    <div class="htmtexto disabled">${data.accion}</div>
                  </div>
                  <div class="col-md-12">
                    <label for="observaciones" class="form-label">Observaciones: </label>
                    <textarea class="form-control" id="observaciones" value="${data.observaciones}" disabled></textarea>
                  </div>
                  <div class="col-md-12">
                    <h4>Archivos adjuntos:</h4>
                    <div id="archivosList" class="show-archivos"></div>
                  </div>
              </div> 
              
        `;
  
        let dvx = document.getElementById('archivosList');
        dvx.innerHTML = "";
         if(data.archivo){
          data.archivo[0].forEach(element => {
            let extension = element.archivo.split('.').pop(); 
  
            if(extension === 'jpeg' ||extension === 'jpg' || extension === 'gif'|| extension === 'png') {
              let img = document.createElement('img');
              img.src = 'assest/clientes/panne/'+data.idsolicitud+'/'+element.archivo;
              img.classList.add('gimg');
              let a = document.createElement('a');
              a.href = '#';
              a.onclick = function(e) {
                e.preventDefault();
                // Código para abrir el modal y mostrar la imagen
                let modal = new bootstrap.Modal(document.getElementById('galleryMdl'));
                let modalImg = document.getElementById('img01');
                modalImg.src = this.children[0].src;
                modal.show();
                let link = document.getElementById('link_full');
                link.innerHTML = `<a target="_blank" href="${this.children[0].src}">Ver imagen en tamaño completo</a>`;
  
              };
  
              a.appendChild(img);
              dv.appendChild(a);
            }
  
            if(extension === 'doc' || extension === 'docx') {
              let a = document.createElement('a');
              a.href = 'assest/clientes/panne/'+data.idsolicitud+'/'+element.archivo;
              a.innerText = element.archivo;
              dv.appendChild(a);
  
            }
  
            if(extension === 'pdf') {
              let a = document.createElement('a');
              a.href = 'assest/clientes/'+data.idsolicitud+'/'+element.archivo;
              a.innerText = element.archivo;
              dv.appendChild(a);
            }
  
          });
         } else {
          dvx.innerHTML = "No hay archivos adjuntos";
         }
    }
}

if(document.getElementById('tbl-panne')){
    obtener_panne(1, '!=', 'getpanne', 'tbl-panne');
}

if(document.getElementById('tbl-ambipar')){
    obtener_panne(1, '!=', 'ambgetpanne', 'tbl-ambipar');
}




async function buscarclientes(url, txtbuscar){
  let form = new FormData();
  form.append('txtbuscar', txtbuscar);

  let resp = await fetch('controllers/'+url, {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: form
  });

  let json = await resp.json();

  let tb = document.getElementById('tbl-clientes');
  tb.innerHTML = "";
  if(json.status){
    let data = json.data;
    let total_paginas = json.total_paginas;
    data.forEach(item => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td>${item.nombre}</td>
      <td class="d-none d-xl-table-cell">${item.nif}</td>
      <td class="d-none d-xl-table-cell">${item.correo}</td>
      <td class="d-none d-xl-table-cell">${item.telefono}</td>
      <td class="d-none d-xl-table-cell">${item.unidades}</td>
      <td class="submenu" style="text-align: right">
      <button onclick="previsualizar_empresa(${item.id})" data-bs-toggle="offcanvas" data-bs-target="#empdetalles" aria-controls="offcanvasRight"><i class="align-middle" data-feather="eye"></i></button>
      <button class="mnaux" title="Listado de unidades" onclick="listado(1, ${item.id}, 'tblcliente', 'tblveh_empresa')"><i class="align-middle" data-feather="list"></i></button>
      <button class="mnaux" onclick="addtruck(${item.id}, '${item.nombre}')"  title="Agregar Unidad"><i class="align-middle" data-feather="truck"></i></button>
      <button onclick="edit_clt(${item.id})" title="Editar perfil empresa"><i class="align-middle" data-feather="edit-3"></i></button>
      <button title="Eliminar perfil empresa" onclick="confirmar_del(${item.id}, 'clientes.php?op=delclt')"><i class="align-middle" data-feather="trash-2"></i></button>
      </td>`;
      tb.appendChild(tr);
      feather.replace();  

    });
  }
}

if(document.getElementById('txtclientes')){
  document.getElementById('txtclientes').addEventListener('keyup', (e)=>{
    e.preventDefault();
    if(document.getElementById('txtclientes').value.length>1){
      let txt = document.getElementById('txtclientes').value;
      buscarclientes('clientes.php?op=srchcompany', txt);
    } else {
      getClientes(1)      
    }
    
  });
}

async function buscar_unidades(txt){
  let frm = new FormData();
  let idcomp = document.getElementById('idcompany').value;

  frm.append('txtbuscar', txt);
  frm.append('idcomp', idcomp);

  let resp = await fetch('controllers/clientes.php?op=srchunds', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();

  let tb = document.getElementById('tbl-veh_empresa');
  tb.innerHTML = "";
  if(json.status){
    let data = json.data;
    data.forEach(item => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td>${item.tipo}</td>
      <td>${item.ppu}</td>
      <td>${item.marca}</td>
      <td>${item.modelo}</td>
      <td>${item.chasis}</td>
      <td>${item.year}</td>
      <td>${item.ubicacion}</td>
      <td>${item.und_last_hist}</td>
      <td class="submenu">
      <button onclick="previsualizar_unidad(${item.id})" data-bs-toggle="offcanvas" data-bs-target="#empdetalles" aria-controls="offcanvasRight"><i class="align-middle" data-feather="eye"></i></button>
      <button onclick="edit_und(${item.id}, 'tblveh_empresa', 'addunidades', 'save__unidades', 'updx__unidades')"><i class="align-middle" data-feather="edit-3"></i></button>
      <button onclick="confirmar_del(${item.id}, 'clientes.php?op=delund')"><i class="align-middle" data-feather="trash-2"></i></button>
      </td>`
      tb.appendChild(tr);
      feather.replace(); 

    });
  } 
}

if(document.getElementById('txtunidades')){
  document.getElementById('txtunidades').addEventListener('keyup', (e)=>{
    e.preventDefault();
    if(document.getElementById('txtunidades').value.length>1){
      let txt = document.getElementById('txtunidades').value;
      buscar_unidades(txt);
    } else {
      listado_unidades();     
    }
  });
}

if(document.getElementById('btndepartamento')){
  document.getElementById('btndepartamento').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_data_si('departamentos.php?op=svdpto', 'frmdepartamento', 'departamentos', 'tabladpto');
  });
}

if(document.getElementById('sv__updpanne')){
  document.getElementById('sv__updpanne').addEventListener('click', (e)=>{
    e.preventDefault();
    let texto = document.getElementById('pn_accion');
    texto.value = document.getElementById('cntaccion').innerHTML;
    document.getElementById('cntaccion').innerHTML = "";
    guardar_data_si('actividades.php?op=svpanne__act', 'frmreporte', 'addreporte', 'tblpanne');
  });
}

if(document.getElementById('sv__closepanne')){
  document.getElementById('sv__closepanne').addEventListener('click', (e)=>{
    e.preventDefault();
    let texto = document.getElementById('lb_accion');
    texto.value = document.getElementById('cntliberacion').innerHTML;
    document.getElementById('cntliberacion').innerHTML = "";
    guardar_data_si('actividades.php?op=svclosepanne', 'frmclosepnn', 'addreporte', 'tblpanne');
  });
}


async function busqueda_panne(txt, url, tabla){
  let comp = document.getElementById('verclosepn').value;
  let frm = new FormData();
  frm.append('txtbuscar', txt);
  frm.append('comp', comp);

  let resp = await fetch('controllers/actividades.php?op='+url, {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();
  let tb = document.getElementById(tabla);
  tb.innerHTML = "";

  if(json.status){
    let data = json.data;
    data.forEach(item => {
      if(item.estado_solicitud==3){
        let fecha = item.fecha_creado.split('-');
        fecha_creado = fecha[2] + '/' + fecha[1] + '/' + fecha[0];
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>${fecha_creado}</td>
        <td>${item.empresa}</td>
        <td>${item.ppu}</td>
        <td>${item.km_actual_tracto}</td>
        <td>${item.km_actual_semi}</td>
        <td>${item.transportista}</td>
        <td></td>
        <td>
        <div class="submenu">
        </td>

        `;
        tb.appendChild(tr);
        feather.replace();
      } else {
        let fecha = item.fecha_creado.split('-');
        fecha_creado = fecha[2] + '/' + fecha[1] + '/' + fecha[0];
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>${fecha_creado}</td>
        <td>${item.empresa}</td>
        <td>${item.ppu}</td>
        <td>${item.km_actual_tracto}</td>
        <td>${item.km_actual_semi}</td>
        <td>${item.transportista}</td>
        <td></td>
        <td>
        <div class="submenu">
        <button onclick="pv_panne(${item.idsolicitud})" title="Actualizar solicitud"><i class="align-middle" data-feather="edit-3"></i></button>
        <button class="btn-mn" onclick="cerrar_panne(${item.idsolicitud})" title="Cerrar Panne"><i class="align-middle" data-feather="check-circle"></i></button>
        </td>

        `;
        tb.appendChild(tr);
        feather.replace();
      }
    });
  }
}

if(document.getElementById('txtbuscarpanne')){
  document.getElementById('txtbuscarpanne').addEventListener('keyup', ()=>{
    let txt = document.getElementById('txtbuscarpanne').value;
    if(txt.length>1){
      busqueda_panne(txt, 'bsqpanne', 'tbl-panne');
    } else {
      obtener_panne(1, '!=', 'getpanne', 'tbl-panne');
    }
  });
}

if(document.getElementById('ambtxtbuscarpanne')){
  document.getElementById('ambtxtbuscarpanne').addEventListener('keyup', ()=>{
    let txt = document.getElementById('ambtxtbuscarpanne').value;
    if(txt.length>1){
      busqueda_panne(txt, 'ambbsqpanne', 'tbl-ambipar');
    } else {
      obtener_panne(1, '!=', 'ambgetpanne', 'tbl-ambipar');
    }
  });
}


async function obtener_spot_todos(pg){
  pg = pg ?? 1;
  let frm = new FormData();
  frm.append('pg', pg);

  let resp = await fetch('controllers/actividades.php?op=getspotunits', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();
  let tb = document.getElementById('tbl-spot');
  tb.innerHTML = "";
  if(json.status){
    let data = json.data;
    data.forEach(item => {
      let fecha = item.fecha_creado.split('-');
      fecha_creado = fecha[2] + '/' + fecha[1] + '/' + fecha[0];
      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td>${fecha_creado}</td>
      <td>${item.empresa}</td>
      <td>${item.ppu}</td>
      <td>${item.tipo}</td>
      <td>--</td>
      <td>${item.ubicacion}</td>
      <td>--</td>
      <td>--</td>
      <td>
      <div class="submenu">
        <button class="btn-mn" onclick="window.location.href='index.php?p=action&at=addspot&id=${item.id}'" title="Crear Spot"><i class="align-middle" data-feather="calendar"></i></button>
      </div>
      </td>`;
      tb.appendChild(tr);
      feather.replace();
    });
  } else {
    document.getElementById('tbl-spot').innerHTML = "";
    document.getElementById('tbspt').classList.remove('table-hover');
    document.getElementById('tbl-spot').innerHTML = `
    <tr>
       <td colspan="9">
           <div class="no_registros">
               <img class="nreg" src="assest/images/svg/tecnicos.svg">
               <h2>Sin datos para mostrar</h2>
               <p>No hay solicitudes de Spot en este momento</p>
           </div>
       </td>
   </tr>`
     }
}


async function obtener_spot_fecha(pg, fecha){
  pg = pg ?? 1;
  let frm = new FormData();
  frm.append('pg', pg);
  frm.append('fecha', fecha);

  let resp = await fetch('controllers/actividades.php?op=getspotdate', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();
  let tb = document.getElementById('tbl-spot');
  tb.innerHTML = "";
  if(json.status){
    let data = json.data;
    data.forEach(item => {
      let fecha = item.fecha_creado.split('-');
      fecha_creado = fecha[2] + '/' + fecha[1] + '/' + fecha[0];
      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td>${fecha_creado}</td>
      <td>${item.empresa}</td>
      <td>${item.ppu}</td>
      <td>${item.tipo}</td>
      <td>${item.tipo_servicio}</td>
      <td>${item.ubicacion}</td>
      <td>${item.fecha_ultima}</td>
      <td>--</td>
      <td class="submenu">
        <button class="btn-mn" onclick="window.location.href='index.php?p=action&at=addspot&id=${item.idunidad}'" title="Crear Spot"><i class="align-middle" data-feather="calendar"></i></button>
      </td>`;
      tb.appendChild(tr);
      feather.replace();
    });
  } else {
    document.getElementById('tbl-spot').innerHTML = "";
    document.getElementById('tbspt').classList.remove('table-hover');
    document.getElementById('tbl-spot').innerHTML = `
    <tr>
       <td colspan="9">
           <div class="no_registros">
               <img class="nreg" src="assest/images/svg/tecnicos.svg">
               <h2>Sin datos para mostrar</h2>
               <p>No hay solicitudes de Spot en este momento</p>
           </div>
       </td>
   </tr>`
  }
}

async function obtener_spot(pg, edo){
  pg = pg ?? 1;
  edo = edo ?? 1;
  let frm = new FormData();
  frm.append('pg', pg);
  frm.append('estado', edo);

  let resp = await fetch('controllers/actividades.php?op=getspot', {
    method: 'post',
    cache: 'no-cache',
    mode: 'same-origin',
    body: frm
  });

  let json = await resp.json();
  let tb = document.getElementById('tbl-spot');
  tb.innerHTML = "";
  if(json.status){
    let data = json.data;
    data.forEach(item => {
      let fecha = item.fecha_creado.split('-');
      fecha_creado = fecha[2] + '/' + fecha[1] + '/' + fecha[0];
      let fecha_programado = item.fecha_programado.split('-');
      fecha_programado = fecha_programado[2] + '/' + fecha_programado[1] + '/' + fecha_programado[0];
      console.log(item.estado);
      if(item.estado==3){
        botonera = `
        <button class="btn-mn" onclick="location.href='index.php?p=action&at=detailspot&id=${item.idunidad}&idspot=${item.idspot}'" title="Actualizar solicitud">
          <i class="align-middle" data-feather="eye"></i>
        </button>
        `
      } else {
        botonera = `
        <button class="btn-mn" onclick="window.location.href='index.php?p=action&at=updtspot&id=${item.idunidad}&idspot=${item.idspot}'" title="Actualizar solicitud Spot"><i class="align-middle" data-feather="clipboard"></i></button>
        <button class="btn-mn" onclick="window.location.href='index.php?p=action&at=clspot&id=${item.idunidad}&idspot=${item.idspot}'" title="Cerrar Spot"><i class="align-middle" data-feather="check-circle"></i></button>
        `
      }

      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td>${fecha_creado}</td>
      <td>${item.empresa}</td>
      <td>${item.ppu}</td>
      <td>${item.tipo}</td>
      <td>${item.servicios}</td>
      <td>${item.ubicacion}</td>
      <td>${fecha_programado}</td>
      <td>${item.inspectores}</td>
      <td ><div class="submenu">${botonera}</div></td>`;
      tb.appendChild(tr);
      feather.replace();
    });
  } else {
    document.getElementById('tbl-spot').innerHTML = "";
    document.getElementById('tbspt').classList.remove('table-hover');
    document.getElementById('tbl-spot').innerHTML = `
    <tr>
       <td colspan="8">
           <div class="no_registros">
               <img class="nreg" src="assest/images/svg/tecnicos.svg">
               <h2>Sin datos para mostrar</h2>
               <p>No hay solicitudes de Spot en este momento</p>
           </div>
       </td>
   </tr>`
     
  }
}


function importar_excel(file) {

    const selectedFile = document.getElementById(file).files[0];
    const error = document.getElementById('error');

    if (selectedFile) {
      var fileReader = new FileReader();
      fileReader.onload = function(event) {
        
        var data = event.target.result;

        var workbook = XLSX.read(data, {
          type: "binary"
        });
        var contador = 0;  
        let porcentaje = 0;
        let c2 = 0;
        let cE = 0;
        let p2 = 0;

        var nombre_hoja = workbook.SheetNames [0]; 
        var hoja = workbook.Sheets [nombre_hoja]; 
        var rango = XLSX.utils.decode_range (hoja ['!ref']); 
        var numFilas = rango.e.r -1; 
        var datos = XLSX.utils.sheet_to_json(hoja, {header: 1});
        var nc = datos[0]; // La primera fila contiene los nombres de las columnas
        if(nc[0]!== 'Empresa' || nc[1]!== 'Patente' || nc[2]!== 'PPU_Semi' || nc[3]!== 'Tipo' || nc[4]!== 'Marca' || nc[5]!== 'Modelo' || nc[6]!== 'Año' || nc[7]!== 'Chasis' || nc[8]!== 'Estatus' || nc[9]!== 'Ubicación' || nc[10]!== 'Km_Actual' || nc[11]!== 'Km_Prox'){
          Swal.fire('Error', 'El archivo no contiene los campos requeridos para realizar la importación, por favor verificar', 'error');
          selectedFile.value = "";
          return;
        }

        workbook.SheetNames.forEach(sheet => {
          const rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
            Swal.fire({
                  title: 'Importando registros',
                  html: `<div class="progress" role="progressbar" aria-label="importación de archivo" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            <div id="progressbar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 60%"></div>
                          </div>`,
                  didOpen: () => {
                    Swal.showLoading();
                  }
            });
            for (const row of rowObject) {
              if(contador == numFilas){
                setTimeout(()=>{
                Swal.close();  
                cargardatos();
                let msg;
                let icon;
                let titulo;
                let total = contador - cE;
                
                console.log('Total: '+total);
                if(cE>2){
                  titulo = 'Error';
                  msg = 'Hubo '+ cE +' errores.<br><br>' + error.innerHTML;
                  icon = 'warning';
                } else {
                  titulo = 'Success';
                  msg = 'Se han importado ' + total + ' registros.<br><br>';
                  icon = 'success';
                }
                Swal.fire({
                  title: titulo,
                  html: msg,
                  icon: icon
                });
                }, 2000);
                } else {
                      contador++;
                      porcentaje = contador * 100 / numFilas;
                      setTimeout(async ()=>{
                        let frm = new FormData();
                        
                        frm.append('empresa', row.Empresa);
                        frm.append('patente', row.Patente);
                        frm.append('ppu_semi', row.PPU_Semi ?? '');
                        frm.append('tipo', row.Tipo);
                        frm.append('marca', row.Marca);
                        frm.append('modelo', row.Modelo);
                        frm.append('year', row.Año);
                        frm.append('chasis', row.Chasis);
                        frm.append('estatus', row.Estatus);
                        frm.append('ubicacion', row.Ubicación);
                        frm.append('km_actual', row.Km_Actual);
                        frm.append('km_proximo', row.Km_Prox);
        
                        let resp = await fetch('controllers/clientes.php?op=bulkund', {
                          method: 'post',
                          cache: 'no-cache',
                          mode: 'same-origin',
                          body: frm
                        });
                        
                        let json = await resp.json();
                        if(json.status){
                          c2++;
                          p2 = c2 * 100 / numFilas;
                          setTimeout(()=>{
                          document.getElementById('progressbar').style.width = p2 + '%';
                          }, 1000);
                        } else {
                          cE++;
                          setTimeout(()=>{
                          error.innerHTML += json.msg+'<br>';
                          }, 500);
                        }
                    }, 200);
              }
            }
        });


      };
      fileReader.readAsBinaryString(selectedFile);
    }
}


if(document.getElementById('tbl-spot')){
  obtener_spot();
}

function openModal(imageSrc) {
  let modal = new bootstrap.Modal(document.getElementById('galleryMdl'));
  let modalImg = document.getElementById('img01');
  modalImg.src = imageSrc;
  modal.show();
  let link = document.getElementById('link_full');
  link.innerHTML = `<a target="_blank" href="${imageSrc}">Ver imagen en tamaño completo</a>`;
}

if(document.getElementById('back__spot')){
  document.getElementById('back__spot').addEventListener('click', (e)=>{
    e.preventDefault();
    window.location.href = 'index.php?p=spot';
  });
}


if(document.getElementById('sv__spot')){
  document.getElementById('sv__spot').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_nodv('actividades.php?op=svspot','frmspot','index.php?p=spot');
  });
}

if(document.getElementById('sv__cerrarspot')){
  document.getElementById('sv__cerrarspot').addEventListener('click', (e)=>{
    e.preventDefault();
    guardar_nodv('actividades.php?op=svclspot','frmclspot','index.php?p=spot');
  });
}


if(document.getElementById('upd__spot')){
  document.getElementById('upd__spot').addEventListener('click', (e)=>{
    e.preventDefault();
    let texto = document.getElementById('spot_texto');
    texto.value = document.getElementById('cntspot').innerHTML;
    document.getElementById('cntspot').innerHTML = "";
    guardar_nodv('actividades.php?op=svupdtactspot','frmupdspot','index.php?p=spot');
  });
}


if(document.getElementById('importar_bulk')){
  document.getElementById('importar_bulk').addEventListener('click', ()=>{
    importar_excel('ImpUnidades');
  });
}

if(document.getElementById('tallerip')){
  crearEditor('tallerip', 'wyseip');
}

if(document.getElementById('wysepreliminar')){
  crearEditor('wysepreliminar', 'cntpreliminar');
}

if(document.getElementById('wyseaccion')){
  crearEditor('wyseaccion', 'cntaccion');
}

if(document.getElementById('wyseliberacion')){
  crearEditor('wyseliberacion', 'cntliberacion');
}

if(document.getElementById('spothtm')){
  crearEditor('spothtm', 'cntspot');
}


if(document.getElementById('lastip')){
  document.getElementById('lastip').addEventListener('change', ()=>{
    let fecha = document.getElementById('lastip').value;
    if(fecha == 1 || fecha == 2 || fecha == 3){
      obtener_spot_fecha(1, fecha); //obtiene las unidades que han tenido ip/pm 
    } 
    if (fecha == 4){
      obtener_spot_todos(1); //obtiene todas las unidades que estan almacenadas en la base de datos
    }
    if(fecha==''){
      obtener_spot(1); //obtiene los spot abiertos
    }
  });
}


if(document.getElementById('veredospot')){
  document.getElementById('veredospot').addEventListener('change', ()=>{
    let edo = document.getElementById('veredospot').value;
    obtener_spot(1, edo);
  });
}