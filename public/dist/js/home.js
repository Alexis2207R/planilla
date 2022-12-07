// GLOBAL VAR
let token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Imxva2l2aWxsYUBnbWFpbC5jb20ifQ.E4DuXm-eYDbf9pcWk61HoPu8jCDJfvPw0LrJfuK4tzI';
const url_datatable = './public/dist/js/spanish.json';
const resetform = () => {
    $(".form select").each(function() { this.selectedIndex = 0 });
    // $('#kt_select2_1').html('');
    $(".form input[type=text], .form input[type=number], .form input[type=date] , .form textarea, .form input[type=file], .form input[type=email], .form input[type=password],.form .select2").each(function() { this.value = '' });
    $('.form input[type=checkbox]').each(function() {this.checked = false})
    // $("#form_alu").append('<input class="temp" type="text" name="COD_ALU">')
    $(".temp").each(function() { this.remove() });
    $('#form').trigger('reset');
}
$( '#btnCancel, .close, #btnNew').on( 'click', function(){
    resetform();
} )

// Perfiles
const perfiles = () => {
    // Tabla Perfiles
    var table_perfil;
    
    table_perfil = $('#tbl_perfiles').DataTable({
        ajax:{
            url: './perfil/list_perfiles',
            dataSrc: '',
            type: 'POST',
        },
        columns: [
            { data: 'id_perfil' },
            { data: 'nombreperfil' },
            { data: 'modulos'},
            { data: 'estadoperfil' },
            { data: 'acciones'}
        ],
        order: [0,'desc'],
        columnDefs:[
            {
                targets:4,
                // orderable:false,
                render: function( data, type, full, meta ) {
                    const btn_accion = full.estadoperfil == 2?{active:'fas fa-check', color:'success'}:{active:'fas fa-ban', color:'warning'};
                    return  `<center>
                                <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button type="button" id="edit_per" item="${full.id_perfil}" class="btn btn-xs btn-primary  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_per" item="${full.id_perfil}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        <button type="button" status="${full.estadoperfil}" id="ban_per" item="${full.id_perfil}" class="btn btn-xs btn-${btn_accion.color} btn-icon"><i class="icon-nd ${btn_accion.active}"></i></button>
                                    </div>
                                </div>
                            </center>`
                }
            },
            {
                targets:3,
                // orderable:false,
                render: function( data, type, full, meta ) {
                    if (data == 1) {
                        return `<div class="text-center"><span class="badge badge-success">ACTIVO</span></div>`;
                    }else{
                        return `<div class="text-center"><span class="badge badge-danger">INACTIVO</span></div>`;
                    }
                },
            },
            {
                targets:2,
                // orderable:false,
                render: function( data, type, full, meta ) {
                    return `<div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    <button type="button" id="modulos_per" item="${full.id_perfil}" class="btn btn-xs btn-secondary btn-icon"><i class="icon-nd fas fa-sign-in-alt"></i> Ver Accesos</button>
                                </div>
                            </div>`;
                },
            },
            {
                targets:0,
                // orderable:false,
                render: function( data, type, full, meta ) {
                    return `<div class="text-center"><span>${data}</span></div>`
                },
            }
    
        ],
        responsive: !0,
        pagingType: "full_numbers",
        language: {
            url: url_datatable
        }
    
    });
    
    // View Access
    $(document).on('click', '#modulos_per', function() {
        const item = $(this).attr('item');
        $.ajax({
            url: './perfil/list_accesos',
            type: "POST",
            data: {item},
            dataType: "json",
            success: function(response) {
                // console.log(response);
                if ( !response ) {
                    return Swal.fire('Perfil', `No tiene permisos asignados`, "info");
                }
                $('#modal-acceso tbody').html('');
                $('#modal-acceso').modal('show');
                response.Accesos.forEach(element => {         
                    $('#modal-acceso tbody').append(`
                        <tr>
                            <td>${element.id_permiso}</td>
                            <td>${response.Accesos[0].nombreperfil}</td>
                            <td>${element.nombremodulo}</td>
                        </tr>`
                    );
                });
            },
            error: function(err) {
                Swal.fire('Error 500', `${err.statusText}`, "error");
            }
        })
    })
    
    // Register Perfil
    $(function () {
        $.validator.setDefaults({
          submitHandler: function () {
            var datos = new FormData($(form_perfil)[0]);
            $.ajax({
                url: './perfil/form',
                type: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    // console.log( response );
                    // return;
                    if ( response.status == 200 ) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        resetform();
                        table_perfil.ajax.reload();
                        $('#modal-perfil').modal('hide');
                    }else{
                        Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
                    }
                    
    
                },
                error: function(err) {
                    Swal.fire('Error 500', `${err}`, "error");
                }
            })
          }
        });
        $('#form_perfil').validate({
          rules: {
            nombreperfil: {
              required: true
            }
          },
          messages: {
            nombreperfil: {
              required: "Campo requerido.",
            }
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });
    });
    
    // Edit Perfil
    $(document).on( 'click', '#edit_per', function() {
        const item = $(this).attr('item');
        resetform();
        $.ajax({
            url: './perfil/single_perfil',
            type: "POST",
            data: {item},
            dataType: "json",
            success: function(response) {
                if ( response.Perfil ) {
                    // console.log( response );
                    $("#modal-perfil .form").append('<input class="temp" type="hidden" name="id_perfil">')
                    $('#modal-perfil [name=nombreperfil]').val( response.Perfil.nombreperfil );
                    $('#modal-perfil [name=id_perfil]').val( response.Perfil.id_perfil );
    
                    response.Access.forEach( function(element, index) {
                        $('#modal-perfil .check-'+element['idmodulo']).prop('checked', true);
                    });
    
                    $('#modal-perfil').modal('show');
                }
            },
            error: function(err) {
                Swal.fire('Error 500', `${err.statusText}`, "error");
            }
        })
    })
    
    // Delete Perfil
    $(document).on( 'click', '#delete_per', function() {
        const item = $(this).attr('item');
        Swal.fire({
            title: "¿Desea eliminar este perfil?",
            text: "Esta acción es irrevesible",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "Cancelar"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: './perfil/delete_perfil',
                    type: "POST",
                    data: {item},
                    dataType: "json",
                    success: function(response) {
                        if ( response.status == 200 ) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: response.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            table_perfil.ajax.reload();
                        }else{
                            Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
                        }
                    },
                    error: function(err) {
                        Swal.fire('Error 500', `${err.statusText}`, "error");
                    }
                })
            }
        });
    })
    
    // Deshabilitar Perfil
    $(document).on( 'click', '#ban_per', function() {
        const item = $(this).attr('item');
        const estado = $(this).attr('status');
        msgStatus = estado == 1?'deshabilitar':'habilitar'
        Swal.fire({
            title: `¿Desea  ${msgStatus} este perfil?`,
            text: "Esta acción es irrevesible",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: `Si, ${msgStatus}`,
            cancelButtonText: "Cancelar"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: './perfil/disabled_perfil',
                    type: "POST",
                    data: {item},
                    dataType: "json",
                    success: function(response) {
                        if ( response.status == 200 ) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: response.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            table_perfil.ajax.reload();
                        }else{
                            Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
                        }
                    },
                    error: function(err) {
                        Swal.fire('Error 500', `${err.statusText}`, "error");
                    }
                })
            }
        });
    })
}

const usuarios = () => {
    // Tabla Perfiles
    var table_usuario;
    
    table_usuario = $('#tbl_usuarios').DataTable({
        ajax:{
            url: './usuario/list_usuarios',
            dataSrc: '',
            type: 'POST',
        },
        columns: [
            { data: 'id_usuario' },
            { data: 'dni' },
            { data: 'nombre' },
            { data: 'apellido'},
            { data: 'nombreperfil' },
            { data: 'estado' },
            { data: 'acciones'}
        ],
        order: [0,'desc'],
        columnDefs:[
            {
                targets:6,
                // orderable:false,
                render: function( data, type, full, meta ) {
                    const btn_accion = full.estado == 2?{active:'fas fa-check', color:'success'}:{active:'fas fa-ban', color:'warning'};
                    return  `<center>
                                <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button type="button" id="edit_user" item="${full.id_usuario}" class="btn btn-xs btn-primary  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_user" item="${full.id_usuario}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        <button type="button" id="rest_user" item="${full.id_usuario}" class="btn btn-xs btn-success btn-icon"><i class="icon-nd fas fa-redo-alt"></i></button>                                    
                                        <button type="button" status="${full.estado}" id="ban_user" item="${full.id_usuario}" class="btn btn-xs btn-${btn_accion.color} btn-icon"><i class="icon-nd ${btn_accion.active}"></i></button>
                                        </div>
                                </div>
                            </center>`
                }
            },
            {
                targets:5,
                // orderable:false,
                render: function( data, type, full, meta ) {
                    if (data == 1) {
                        return `<div class="text-center"><span class="badge badge-success">ACTIVO</span></div>`;
                    }else{
                        return `<div class="text-center"><span class="badge badge-danger">INACTIVO</span></div>`;
                    }
                },
            },
            {
                targets:0,
                visible:false,
                render: function( data, type, full, meta ) {
                    return `<div class="text-center"><span>${data}</span></div>`
                },
            }
    
        ],
        responsive: !0,
        pagingType: "full_numbers",
        language: {
            url: url_datatable
        }
    
    });

    // Delete Usuario
    $(document).on( 'click', '#delete_user', function() {
        const item = $(this).attr('item');
        Swal.fire({
            title: "¿Desea eliminar este usuario?",
            text: "Esta acción es irrevesible",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "Cancelar"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: './usuario/delete_usuario',
                    type: "POST",
                    data: {item},
                    dataType: "json",
                    success: function(response) {
                        if ( response.status == 200 ) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: response.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            table_usuario.ajax.reload();
                        }else{
                            Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
                        }
                    },
                    error: function(err) {
                        Swal.fire('Error 500', `${err.statusText}`, "error");
                    }
                })
            }
        });
    })
    
    // Deshabilitar Usuario
    $(document).on( 'click', '#ban_user', function() {
        const item = $(this).attr('item');
        const estado = $(this).attr('status');
        msgStatus = estado == 1?'deshabilitar':'habilitar'
        Swal.fire({
            title: `¿Desea  ${msgStatus} este usuario?`,
            text: "Esta acción es irrevesible",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: `Si, ${msgStatus}`,
            cancelButtonText: "Cancelar"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: './usuario/disabled_usuario',
                    type: "POST",
                    data: {item},
                    dataType: "json",
                    success: function(response) {
                        if ( response.status == 200 ) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: response.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            table_usuario.ajax.reload();
                        }else{
                            Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
                        }
                    },
                    error: function(err) {
                        Swal.fire('Error 500', `${err.statusText}`, "error");
                    }
                })
            }
        });
    })

    // Reset Usuario
    $(document).on( 'click', '#rest_user', function() {
        const item = $(this).attr('item');
        Swal.fire({
            title: `¿Desea restaurar este usuario?`,
            text: "Esta acción es irrevesible",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: `Si, restaurar`,
            cancelButtonText: "Cancelar"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: './usuario/reset_usuario',
                    type: "POST",
                    data: {item},
                    dataType: "json",
                    success: function(response) {
                        if ( response.status == 200 ) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: response.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }else{
                            Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
                        }
                    },
                    error: function(err) {
                        Swal.fire('Error 500', `${err.statusText}`, "error");
                    }
                })
            }
        });
    })

    // Buscar DNI API
    $(document).on('click', '#api_user', function() {
        let dni = $('[name="dni"]').val();
        if ( dni.length != 8 ) {
            Swal.fire('Error 400', 'Ingrese un DNI válido', "error");
            return false;
        }
        $.ajax({
            url: `https://dniruc.apisperu.com/api/v1/dni/${dni}?token=${token}`,
            type:'GET',
            success: function (str) {// Función de devolución de llamada exitosa
                if (str.success == false) {
                    Swal.fire(`${str.message}`, '',"info");
                    $('[name="nombre"]').val('');
                    $('[name="apellido"]').val('');
                    return false;
                }
                $('[name="nombre"]').val(str.nombres);
                $('[name="apellido"]').val(`${str.apellidoPaterno} ${str.apellidoMaterno}`);
            },
            error: function (err) {// Función de devolución de llamada fallida
                Swal.fire(`${err.status}`, `${err.statusText}`, "error");
                $('[name="nombre"]').val('');
                $('[name="apellido"]').val('');
            }   
        })
    })

    // Register User
    $(function () {
        $.validator.setDefaults({
          submitHandler: function () {
            var datos = new FormData($(form_usuario)[0]);
            $.ajax({
                url: './usuario/form',
                type: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    // console.log( response );
                    // return;
                    if ( response.status == 200 ) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        resetform();
                        table_usuario.ajax.reload();
                        $('#modal-usuario').modal('hide');
                    }else{
                        Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
                    }
                    
    
                },
                error: function(err) {
                    Swal.fire('Error 500', `${err}`, "error");
                }
            })
          }
        });
        $('#form_usuario').validate({
          rules: {
            dni: {
              required: true
            }
          },
          messages: {
            dni: {
              required: "Campo requerido.",
            }
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });
    });

    // Edit Perfil
    $(document).on( 'click', '#edit_user', function() {
        const item = $(this).attr('item');
        resetform();
        $.ajax({
            url: './usuario/single_usuario',
            type: "POST",
            data: {item},
            dataType: "json",
            success: function(response) {
                // console.log(response);
                if ( response ) {
                    // console.log( response );
                    $("#modal-usuario .form").append(`<input class="temp" type="hidden" value="${response.id_usuario}" name="id_usuario">`)
                    $('#modal-usuario [name=nombre]').val( response.nombre );
                    $('#modal-usuario [name=apellido]').val( response.apellido );
                    $('#modal-usuario [name=dni]').val( response.dni );
                    $('#modal-usuario [name=idperfil_usuario]').val(response.id_perfil);
    
                    $('#modal-usuario').modal('show');
                }
            },
            error: function(err) {
                Swal.fire('Error 500', `${err.statusText}`, "error");
            }
        })
    })
}

const renumeracion = () => {

    // Tabla Remuneracion
    var table_nivel;
    
    table_nivel = $('#tbl_nivel').DataTable({
        ajax:{
            url: './remuneracion/list_niveles',
            dataSrc: '',
            type: 'POST',
        },
        columns: [
            { data: 'id_remuneracion' },
            { data: 'nivel' },
            { data: 'fecha_registro' },
            { data: 'acciones'}
        ],
        order: [0,'desc'],
        columnDefs:[
            {
                targets:3,
                // orderable:false,
                render: function( data, type, full, meta ) {
                    return  `<center>
                                <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button type="button" id="edit_nivel" item="${full.id_remuneracion}" class="btn btn-xs btn-success  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_nivel" item="${full.id_remuneracion}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        </div>
                                </div>
                            </center>`
                }
            },
            {
                targets:0,
                visible:false,
                render: function( data, type, full, meta ) {
                    return `<div class="text-center"><span>${data}</span></div>`
                },
            }
    
        ],
        responsive: !0,
        pagingType: "full_numbers",
        language: {
            url: url_datatable
        }
    
    });

    // Register Remuneracion
    $(function () {
        $.validator.setDefaults({
          submitHandler: function () {
            var datos = new FormData($(form_nivel)[0]);
            $.ajax({
                url: './remuneracion/form',
                type: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    // console.log( response );
                    if ( response.status == 200 ) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        resetform();
                        table_nivel.ajax.reload();
                    }else{
                        Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
                    }    
                },
                error: function(err) {
                    Swal.fire('Error 500', `${err}`, "error");
                }
            })
          }
        });
        $('#form_nivel').validate({
          rules: {
            nivel: {
              required: true
            }
          },
          messages: {
            nivel: {
              required: "Campo requerido.",
            }
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });
    });

    // Delete Remuneracion
    $(document).on( 'click', '#delete_nivel', function() {
        const item = $(this).attr('item');
        Swal.fire({
            title: "¿Desea eliminar este nivel?",
            text: "Esta acción es irrevesible",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "Cancelar"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: './remuneracion/delete_nivel',
                    type: "POST",
                    data: {item},
                    dataType: "json",
                    success: function(response) {
                        if ( response.status == 200 ) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: response.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            table_nivel.ajax.reload();
                        }else{
                            Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
                        }
                    },
                    error: function(err) {
                        Swal.fire('Error 500', `${err.statusText}`, "error");
                    }
                })
            }
        });
    })

    // Edit Remuneracion
    $(document).on( 'click', '#edit_nivel', function() {
        const item = $(this).attr('item');
        // resetform();
        $.ajax({
            url: './remuneracion/single_nivel',
            type: "POST",
            data: {item},
            dataType: "json",
            success: function(response) {
                console.log(response);
                if ( response.Remunerado ) {
                    $(".form").append(`<input class="temp" type="hidden" value="${response.Remunerado.id_remuneracion}" name="id_remuneracion">`)
                    $('[name=nivel]').val( response.Remunerado.nivel );
                }
            },
            error: function(err) {
                Swal.fire('Error 500', `${err.statusText}`, "error");
            }
        })
    })
}

const condicion = () => {
    // Tabla Condicion
    var table_condicion;
    
    table_condicion = $('#tbl_condicion').DataTable({
        ajax:{
            url: './condicion/list_condicion',
            dataSrc: '',
            type: 'POST',
        },
        columns: [
            { data: 'id_condicion' },
            { data: 'condicion' },
            { data: 'fecha_act_condicion' },
            { data: 'acciones'}
        ],
        order: [0,'desc'],
        columnDefs:[
            {
                targets:3,
                // orderable:false,
                render: function( data, type, full, meta ) {
                    return  `<center>
                                <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button type="button" id="edit_condicion" item="${full.id_condicion}" class="btn btn-xs btn-success  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_condicion" item="${full.id_condicion}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        </div>
                                </div>
                            </center>`
                }
            },
            {
                targets:0,
                visible:false,
                render: function( data, type, full, meta ) {
                    return `<div class="text-center"><span>${data}</span></div>`
                },
            }
    
        ],
        responsive: !0,
        pagingType: "full_numbers",
        language: {
            url: url_datatable
        }
    
    });

    // Register Condicion
    $(function () {
        $.validator.setDefaults({
          submitHandler: function () {
            var datos = new FormData($(form_condicion)[0]);
            $.ajax({
                url: './condicion/form',
                type: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    // console.log( response );
                    if ( response.status == 200 ) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        resetform();
                        table_condicion.ajax.reload();
                    }else{
                        Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
                    }    
                },
                error: function(err) {
                    Swal.fire('Error 500', `${err}`, "error");
                }
            })
          }
        });
        $('#form_condicion').validate({
          rules: {
            condicion: {
              required: true
            }
          },
          messages: {
            condicion: {
              required: "Campo requerido.",
            }
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });
    });

    // Delete Remuneracion
    $(document).on( 'click', '#delete_condicion', function() {
        const item = $(this).attr('item');
        Swal.fire({
            title: "¿Desea eliminar esta condición?",
            text: "Esta acción es irrevesible",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "Cancelar"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: './condicion/delete_condicion',
                    type: "POST",
                    data: {item},
                    dataType: "json",
                    success: function(response) {
                        if ( response.status == 200 ) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: response.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            table_condicion.ajax.reload();
                        }else{
                            Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
                        }
                    },
                    error: function(err) {
                        Swal.fire('Error 500', `${err.statusText}`, "error");
                    }
                })
            }
        });
    })

    // Edit Condicion
    $(document).on( 'click', '#edit_condicion', function() {
        const item = $(this).attr('item');
        // resetform();
        $.ajax({
            url: './condicion/single_condicion',
            type: "POST",
            data: {item},
            dataType: "json",
            success: function(response) {
                // console.log(response);
                if ( response.CondicionSingle ) {
                    $(".form").append(`<input class="temp" type="hidden" value="${response.CondicionSingle.id_condicion}" name="id_condicion">`)
                    $('[name=condicion]').val( response.CondicionSingle.condicion );
                }
            },
            error: function(err) {
                Swal.fire('Error 500', `${err.statusText}`, "error");
            }
        })
    })
}

const personal = () => {

    var table_personal;
    
    table_personal = $('#tbl_personal').DataTable({
        ajax:{
            url: './personal/list_personal',
            dataSrc: '',
            type: 'POST',
        },
        columns: [
            { data: 'id_personal' },
            { data: 'dni_personal' },
            { data: 'nombre_personal' },
            { data: 'paterno_personal' },
            { data: 'materno_personal' },
            { data: 'sexo_personal' },
            { data: 'nivel' },
            { data: 'condicion' },
            { data: 'ubicacion_dpt' },
            { data: 'sueldo_personal' },
            { data: 'incentivo_personal' },
            { data: 'costo_dia' },
            { data: 'costo_hora' },
            { data: 'costo_minuto' },
            { data: 'acciones'}
        ],
        order: [0,'desc'],
        columnDefs:[
            {
                targets:14,
                // orderable:false,
                render: function( data, type, full, meta ) {
                    return  `<center>
                                <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button type="button" id="edit_personal" item="${full.id_personal}" class="btn btn-xs btn-success  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_personal" item="${full.id_personal}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        </div>
                                </div>
                            </center>`
                }
            },
            {
                targets:0,
                visible:false,
                render: function( data, type, full, meta ) {
                    return `<div class="text-center"><span>${data}</span></div>`
                },
            }
    
        ],
        responsive: !0,
        pagingType: "full_numbers",
        language: {
            url: url_datatable
        }
    
    });
    
    // Buscar DNI API
    $(document).on('click', '#api_personal', function() {
        let dni = $('[name="dni_personal"]').val();
        if ( dni.length != 8 ) {
            Swal.fire('Error 400', 'Ingrese un DNI válido', "error");
            return false;
        }
        $.ajax({
            url: `https://dniruc.apisperu.com/api/v1/dni/${dni}?token=${token}`,
            type:'GET',
            success: function (str) {// Función de devolución de llamada exitosa
                if (str.success == false) {
                    Swal.fire(`${str.message}`, '',"info");
                    $('[name="nombre_personal"]').val('');
                    $('[name="paterno_personal"]').val('');
                    $('[name="materno_personal"]').val('');
                    return false;
                }

                $('[name="nombre_personal"]').val(str.nombres);
                $('[name="paterno_personal"]').val(str.apellidoPaterno);
                $('[name="materno_personal"]').val(str.apellidoMaterno);
            },
            error: function (err) {// Función de devolución de llamada fallida
                Swal.fire(`${err.status}`, `${err.statusText}`, "error");
                $('[name="nombre_personal"]').val('');
                $('[name="paterno_personal"]').val('');
                $('[name="materno_personal"]').val('');
            }   
        })
    })

    // Register Personal
    $(function () {
        $.validator.setDefaults({
          submitHandler: function () {
            var datos = new FormData($(form_personal)[0]);
            $.ajax({
                url: './personal/form',
                type: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    // console.log( response );
                    // return;
                    if ( response.status == 200 ) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        resetform();
                        table_personal.ajax.reload();
                        $('#modal-personal').modal('hide');
                    }else{
                        Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
                    }
                    
    
                },
                error: function(err) {
                    Swal.fire('Error 500', `${err}`, "error");
                }
            })
          }
        });
        $('#form_personal').validate({

          rules: {
            dni_personal: {
              required: true
            },
            nombre_personal: {
              required: true
            },
            paterno_personal: {
              required: true
            },
            materno_personal: {
              required: true
            },
            sexo_personal: {
              required: true
            },
            nivel_remuneracion: {
              required: true
            },
            condicion_laboral: {
              required: true
            },
            sueldo_personal: {
              required: true
            },
            incentivo_personal: {
              required: true
            },
            costo_dia: {
              required: true
            },
            costo_hora: {
              required: true
            },
            costo_minuto: {
              required: true
            }
          },
          messages: {
            dni_personal: {
                required: "Campor requerido"
              },
              nombre_personal: {
                required: "Campor requerido"
              },
              paterno_personal: {
                required: "Campor requerido"
              },
              materno_personal: {
                required: "Campor requerido"
              },
              sexo_personal: {
                required: "Campor requerido"
              },
              nivel_remuneracion: {
                required: "Campor requerido"
              },
              condicion_laboral: {
                required: "Campor requerido"
              },
              sueldo_personal: {
                required: "Campor requerido"
              },
              incentivo_personal: {
                required: "Campor requerido"
              },
              costo_dia: {
                required: "Campor requerido"
              },
              costo_hora: {
                required: "Campor requerido"
              },
              costo_minuto: {
                required: "Campor requerido"
              }
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });
    });

    // Edit Personal
    $(document).on( 'click', '#edit_personal', function() {
        const item = $(this).attr('item');
        resetform();
        $.ajax({
            url: './personal/single_personal',
            type: "POST",
            data: {item},
            dataType: "json",
            success: function(response) {
                // console.log(response);
                if ( response ) {
                    const Personal = response.Personal;
                    // console.log( response );
                    $("#modal-personal .form").append(`<input class="temp" type="hidden" value="${Personal.id_personal}" name="id_personal">`)
                    $('#modal-personal [name=dni_personal]').val( Personal.dni_personal );
                    $('#modal-personal [name=nombre_personal]').val( Personal.nombre_personal );
                    $('#modal-personal [name=paterno_personal]').val( Personal.paterno_personal );
                    $('#modal-personal [name=materno_personal]').val( Personal.materno_personal );
                    $('#modal-personal [name=sexo_personal]').val( Personal.sexo_personal );
                    $('#modal-personal [name=nivel_remuneracion]').val( Personal.nivel_remuneracion );
                    $('#modal-personal [name=condicion_laboral]').val( Personal.condicion_laboral );
                    $('#modal-personal [name=sueldo_personal]').val( Personal.sueldo_personal );
                    $('#modal-personal [name=incentivo_personal]').val( Personal.incentivo_personal );
                    $('#modal-personal [name=costo_dia]').val( Personal.costo_dia );
                    $('#modal-personal [name=costo_hora]').val( Personal.costo_hora );
                    $('#modal-personal [name=costo_minuto]').val( Personal.costo_minuto );
                    $('#modal-personal [name=direccion_personal]').val( Personal.direccion_personal );
                    $('#modal-personal [name=ubicacion_dpt]').val( Personal.ubicacion_dpt );
                    $('#modal-personal [name=ubicacion_prov]').val( Personal.ubicacion_prov );
                    $('#modal-personal [name=ubicacion_dist]').val( Personal.ubicacion_dist );


                    $('#modal-personal').modal('show');
                }
            },
            error: function(err) {
                Swal.fire('Error 500', `${err.statusText}`, "error");
            }
        })
    })
}