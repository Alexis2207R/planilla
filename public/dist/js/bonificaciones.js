const bonificaciones = () => {

  let table_bonificaciones = $('#tbl_bonificaciones').DataTable({
    ajax: {
      url: './bonificaciones/list_bonificaciones',
      dataSrc: '',
      type: 'POST'
    },

    columns: [
      { data: 'id_bonificacion'          },
      { data: 'nombre_bonificacion'      },
      { data: 'nombre_tipo_bonificacion' },
      { data: 'estado_bonificacion'      },
      { data: 'acciones'                 }
    ],

    order: [0, 'desc'],

    columnDefs: [
      {
        targets: 3,

        render: function (data, type, full, meta) {
          if (data == 1) {
            return `<div class="text-center"><span class="badge badge-success">ACTIVO</span></div>`;
          } else {
            return `<div class="text-center"><span class="badge badge-danger">INACTIVO</span></div>`;
          }
        }
      },

      {
        targets: 4,
        // orderable:false,
        render: function (data, type, full, meta) {
          const btn_accion = full.estado == 2 ? { active: 'fas fa-check', color: 'success' } : { active: 'fas fa-ban', color: 'warning' };
          return `<center>
                                <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button type="button" id="edit_bonificacion" item="${full.id_bonificacion}" class="btn btn-xs btn-primary  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_bonificacion" item="${full.id_bonificacion}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        <button type="button" status="${full.estado_bonificacion}" id="ban_bonificacion" item="${full.id_bonificacion}" class="btn btn-xs btn-${btn_accion.color} btn-icon"><i class="icon-nd ${btn_accion.active}"></i></button>
                                        </div>
                                </div>
                            </center>`;
        }
      }
    ],

    pagingType: "full_numbers",

    language: {
      url:  './public/dist/js/spanish.json'
    }

  });

  // Delete bonificacion
  $(document).on('click', '#delete_bonificacion', function () {
    const item = $(this).attr('item');
    Swal.fire({
      title: "¿Desea eliminar esta bonificación?",
      text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar",
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './bonificaciones/delete_bonificacion',
          type: "POST",
          data: { item },
          dataType: "json",
          success: function (response) {
            if (response.status == 200) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: response.msg,
                showConfirmButton: false,
                timer: 1500
              });
              table_bonificaciones.ajax.reload();
            } else {
              Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
            }
          },
          error: function (err) {
            Swal.fire('Error 500', `${err.statusText}`, "error");
          }
        })
      }
    });
  });

  // Deshabilitar Bonificacion
  $(document).on('click', '#ban_bonificacion', function () {
    const item = $(this).attr('item');
    const estado = $(this).attr('status');
    msgStatus = estado == 1 ? 'deshabilitar' : 'habilitar'
    Swal.fire({
      title: `¿Desea  ${msgStatus} este bonificacion?`,
      text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: `Si, ${msgStatus}`,
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './bonificaciones/disabled_bonificacion',
          type: "POST",
          data: { item },
          dataType: "json",
          success: function (response) {
            if (response.status == 200) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: response.msg,
                showConfirmButton: false,
                timer: 1500
              });
              table_bonificaciones.ajax.reload();
            } else {
              Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
            }
          },
          error: function (err) {
            Swal.fire('Error 500', `${err.statusText}`, "error");
          }
        })
      }
    });
  });

  // Add Bonificacion
  $(document).on('click', '#btnNew', function () {
    $('#modal-bonificacion').modal('show');
  });

  // Register Bonificacion
  $(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        var datos = new FormData($(form_bonificacion)[0]);
        $.ajax({
          url: './bonificaciones/form',
          type: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            if (response.status == 200) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: response.msg,
                showConfirmButton: false,
                timer: 1500
              });
              resetform();
              table_bonificaciones.ajax.reload();
              $('#modal-bonificacion').modal('hide');
            } else {
              Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
            }
          },
          error: function (err) {
            Swal.fire('Error 500', `${err}`, "error");
          }
        })
      }
    });

    $('#form_bonificacion').validate({
      rules: {
        nombre_bonificacion: {
          required: true
        },
        id_tipo_bonificacion: {
          required: true
        },
        cantidad_bonificacion: {
          required: true
        }
      },
      messages: {
        nombre: {
          required: "Campor requerido"
        },
        tipo_bonificacion: {
          required: "Campor requerido"
        },
        cantidad: {
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

  // Edit Bonificacion
  $(document).on('click', '#edit_bonificacion', function () {
    const item = $(this).attr('item');
    resetform();
    $.ajax({
      url: './bonificaciones/edit_bonificacion',
      type: "POST",
      data: { item },
      dataType: "json",
      success: function (response) {
        response = response.edit;
        if (response) {
          $("#modal-bonificacion .form").append(`<input class="temp" type="hidden" value="${response.id_bonificacion}" name="id_bonificacion">`)
          $('#modal-bonificacion [name=nombre_bonificacion]').val(response.nombre_bonificacion);
          $('#modal-bonificacion [name=id_tipo_bonificacion]').val(response.id_tipo_bonificacion);
          $('#modal-bonificacion [name=cantidad_bonificacion]').val(response.cantidad_bonificacion);

          $('#modal-bonificacion').modal('show');
        }
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })
  });

  // Esconder el modal
  $('#btnCancel, .close, #btnNew').on('click', function () {
    $('#modal-bonificacion').modal('hide');
  })

};
