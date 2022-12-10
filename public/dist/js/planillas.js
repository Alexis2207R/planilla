const planillas = () => {

  let table_planillas = $('#tbl_planillas').DataTable({
    ajax: {
      url: './planillas/list_planillas',
      dataSrc: '',
      type: 'POST'
    },

    columns: [
      { data: 'numero_planilla' },
      { data: 'nombre_tipo_planilla' },
      { data: 'nombre_year' },
      { data: 'estado_planilla' },
      { data: 'acciones' }
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
                                        <button type="button" id="edit_planilla" item="${full.id_planilla}" class="btn btn-xs btn-primary  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_planilla" item="${full.id_planilla}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        <button type="button" status="${full.estado_planilla}" id="ban_planilla" item="${full.id_planilla}" class="btn btn-xs btn-${btn_accion.color} btn-icon"><i class="icon-nd ${btn_accion.active}"></i></button>
                                        </div>
                                </div>
                            </center>`;
        }
      }
    ],

    pagingType: "full_numbers",

    language: {
      url: './public/dist/js/spanish.json'
    }

  });

  // Delete planilla
  $(document).on('click', '#delete_planilla', function () {
    const item = $(this).attr('item');
    Swal.fire({
      title: "¿Desea eliminar este planilla?",
      text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar",
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './planillas/delete_planilla',
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
              table_planillas.ajax.reload();
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

  // Deshabilitar Planilla
  $(document).on('click', '#ban_planilla', function () {
    const item = $(this).attr('item');
    const estado = $(this).attr('status');
    msgStatus = estado == 1 ? 'deshabilitar' : 'habilitar'
    Swal.fire({
      title: `¿Desea  ${msgStatus} este planilla?`,
      //text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: `Si, ${msgStatus}`,
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './planillas/disabled_planilla',
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
              table_planillas.ajax.reload();
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

  // Add Planilla
  $(document).on('click', '#btnNew', function () {
    $('#modal-planilla').modal('show');
  });

  // Register Planilla
  $(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        var datos = new FormData($(form_planilla)[0]);
        console.log({datos});
        let descuentos = datos.getAll('descuentos');
        let bonificaciones = datos.getAll('bonificaciones');
        datos.append('id_descuentos', descuentos);
        datos.append('id_bonificaciones', bonificaciones);
        $.ajax({
          url: './planillas/form',
          type: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {

            console.log(response);
            // if (response.status == 200) {
            //   Swal.fire({
            //     position: "center",
            //     icon: "success",
            //     title: response.msg,
            //     showConfirmButton: false,
            //     timer: 1500
            //   });
            //   resetform();
            //   table_planillas.ajax.reload();
            //   $('#modal-planilla').modal('hide');
            // } else {
            //   Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
            // }
          },

          error: function (err) {
            Swal.fire('Error 500', `${err}`, "error");
          }

        })
      }
    });

    $('#form_planilla').validate({
      rules: {
        numero_planilla: {
          required: true
        },
        id_tipo_planilla: {
          required: true
        },
        id_year_planilla: {
          required: true
        }
      },
      messages: {
        numero_planilla: {
          required: "Campo requerido"
        },
        id_tipo_planilla: {
          required: "Campo requerido"
        },
        id_year_planilla: {
          required: "Campo requerido"
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

  // Edit Planilla
  $(document).on('click', '#edit_planilla', function () {
    const item = $(this).attr('item');
    resetform();
    $.ajax({
      url: './planillas/edit_planilla',
      type: "POST",
      data: { item },
      dataType: "json",
      success: function (response) {
        response = response.edit;
        if (response) {
          $("#modal-planilla .form").append(`<input class="temp" type="hidden" value="${response.id_planilla}" name="id_planilla">`)
          $('#modal-planilla [name=nombre_planilla]').val(response.nombre_planilla);
          $('#modal-planilla [name=id_tipo_planilla]').val(response.id_tipo_planilla);
          $('#modal-planilla [name=cantidad_planilla]').val(response.cantidad_planilla);

          $('#modal-planilla').modal('show');
        }
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })
  });

  // Esconder el modal
  $('#btnCancel, .close, #btnNew').on('click', function () {
    $('#modal-planilla').modal('hide');
  })

};
