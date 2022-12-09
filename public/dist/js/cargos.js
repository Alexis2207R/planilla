const cargos = () => {

  let table_cargos = $('#tbl_cargos').DataTable({
    ajax: {
      url: './cargos/list_cargos',
      dataSrc: '',
      type: 'POST'
    },

    columns: [
      { data: 'id_cargo' },
      { data: 'nombre_cargo' },
      { data: 'estado_cargo' },
      { data: 'acciones' }
    ],

    order: [0, 'desc'],

    columnDefs: [
      {
        targets: 2,

        render: function (data, type, full, meta) {
          if (data == 1) {
            return `<div class="text-center"><span class="badge badge-success">ACTIVO</span></div>`;
          } else {
            return `<div class="text-center"><span class="badge badge-danger">INACTIVO</span></div>`;
          }
        }
      },

      {
        targets: 3,

        render: function (data, type, full, meta) {
          const btn_accion = full.estado == 2 ? { active: 'fas fa-check', color: 'success' } : { active: 'fas fa-ban', color: 'warning' };
          return `<center>
                                <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button type="button" id="edit_cargo" item="${full.id_cargo}" class="btn btn-xs btn-primary  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_cargo" item="${full.id_cargo}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        <button type="button" status="${full.estado_cargo}" id="ban_cargo" item="${full.id_cargo}" class="btn btn-xs btn-${btn_accion.color} btn-icon"><i class="icon-nd ${btn_accion.active}"></i></button>
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

  // Delete cargo
  $(document).on('click', '#delete_cargo', function () {
    const item = $(this).attr('item');
    Swal.fire({
      title: "¿Desea eliminar este cargo?",
      text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar",
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './cargos/delete_cargo',
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
              table_cargos.ajax.reload();
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

  // Deshabilitar Cargo
  $(document).on('click', '#ban_cargo', function () {
    const item = $(this).attr('item');
    const estado = $(this).attr('status');
    msgStatus = estado == 1 ? 'deshabilitar' : 'habilitar'
    Swal.fire({
      title: `¿Desea  ${msgStatus} este cargo?`,
      //text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: `Si, ${msgStatus}`,
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './cargos/disabled_cargo',
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
              table_cargos.ajax.reload();
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

  // Add Cargo
  $(document).on('click', '#btnNew', function () {
    $('#modal-cargo').modal('show');
  });

  // Register Cargo
  $(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        var datos = new FormData($(form_cargo)[0]);
        $.ajax({
          url: './cargos/form',
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
              table_cargos.ajax.reload();
              $('#modal-cargo').modal('hide');
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

    $('#form_cargo').validate({
      rules: {
        nombre_cargo: {
          required: true
        }
      },
      messages: {
        nombre_cargo: {
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

  // Edit Cargo
  $(document).on('click', '#edit_cargo', function () {
    const item = $(this).attr('item');
    resetform();
    $.ajax({
      url: './cargos/edit_cargo',
      type: "POST",
      data: { item },
      dataType: "json",
      success: function (response) {
        response = response.edit;
        if (response) {
          $("#modal-cargo .form").append(`<input class="temp" type="hidden" value="${response.id_cargo}" name="id_cargo">`)
          $('#modal-cargo [name=nombre_cargo]').val(response.nombre_cargo);

          $('#modal-cargo').modal('show');
        }
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })
  });

  // Esconder el modal
  $('#btnCancel, .close, #btnNew').on('click', function () {
    $('#modal-cargo').modal('hide');
  })

};
