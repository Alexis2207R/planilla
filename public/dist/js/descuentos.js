const descuentos = () => {

  let table_descuentos = $('#tbl_descuentos').DataTable({
    ajax: {
      url: './descuentos/list_descuentos',
      dataSrc: '',
      type: 'POST'
    },

    columns: [
      { data: 'id_descuento'          },
      { data: 'nombre_descuento'      },
      { data: 'nombre_tipo_descuento' },
      { data: 'estado_descuento'      },
      { data: 'acciones'              }
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
                                        <button type="button" id="edit_descuento" item="${full.id_descuento}" class="btn btn-xs btn-primary  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_descuento" item="${full.id_descuento}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        <button type="button" status="${full.estado_descuento}" id="ban_descuento" item="${full.id_descuento}" class="btn btn-xs btn-${btn_accion.color} btn-icon"><i class="icon-nd ${btn_accion.active}"></i></button>
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

  // Delete descuento
  $(document).on('click', '#delete_descuento', function () {
    const item = $(this).attr('item');
    Swal.fire({
      title: "¿Desea eliminar este descuento?",
      text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar",
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './descuentos/delete_descuento',
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
              table_descuentos.ajax.reload();
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

  // Deshabilitar Descuento
  $(document).on('click', '#ban_descuento', function () {
    const item = $(this).attr('item');
    const estado = $(this).attr('status');
    msgStatus = estado == 1 ? 'deshabilitar' : 'habilitar'
    Swal.fire({
      title: `¿Desea  ${msgStatus} este descuento?`,
      //text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: `Si, ${msgStatus}`,
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './descuentos/disabled_descuento',
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
              table_descuentos.ajax.reload();
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

  // Add Descuento
  $(document).on('click', '#btnNew', function () {
    $('#modal-descuento').modal('show');
  });

  // Register Descuento
  $(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        var datos = new FormData($(form_descuento)[0]);
        $.ajax({
          url: './descuentos/form',
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
              table_descuentos.ajax.reload();
              $('#modal-descuento').modal('hide');
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

    $('#form_descuento').validate({
      rules: {
        nombre_descuento: {
          required: true
        },
        id_tipo_descuento: {
          required: true
        },
        cantidad_descuento: {
          required: true
        }
      },
      messages: {
        nombre: {
          required: "Campor requerido"
        },
        tipo_descuento: {
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

  // Edit Descuento
  $(document).on('click', '#edit_descuento', function () {
    const item = $(this).attr('item');
    resetform();
    $.ajax({
      url: './descuentos/edit_descuento',
      type: "POST",
      data: { item },
      dataType: "json",
      success: function (response) {
        response = response.edit;
        if (response) {
          $("#modal-descuento .form").append(`<input class="temp" type="hidden" value="${response.id_descuento}" name="id_descuento">`)
          $('#modal-descuento [name=nombre_descuento]').val(response.nombre_descuento);
          $('#modal-descuento [name=id_tipo_descuento]').val(response.id_tipo_descuento);
          $('#modal-descuento [name=cantidad_descuento]').val(response.cantidad_descuento);

          $('#modal-descuento').modal('show');
        }
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })
  });

  // Esconder el modal
  $('#btnCancel, .close, #btnNew').on('click', function () {
    $('#modal-descuento').modal('hide');
  })

};
