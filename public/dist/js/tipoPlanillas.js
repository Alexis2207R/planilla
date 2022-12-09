const tipoPlanillas = () => {

  let table_tipoPlanillas = $('#tbl_tipoPlanillas').DataTable({
    ajax: {
      url: './tipoPlanillas/list_tipoPlanillas',
      dataSrc: '',
      type: 'POST'
    },

    columns: [
      { data: 'id_tipo_planilla' },
      { data: 'nombre_tipo_planilla' },
      { data: 'estado_tipo_planilla' },
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
                                        <button type="button" id="edit_tipoPlanilla" item="${full.id_tipo_planilla}" class="btn btn-xs btn-primary  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_tipoPlanilla" item="${full.id_tipo_planilla}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        <button type="button" status="${full.estado_tipo_planilla}" id="ban_tipoPlanilla" item="${full.id_tipo_planilla}" class="btn btn-xs btn-${btn_accion.color} btn-icon"><i class="icon-nd ${btn_accion.active}"></i></button>
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

  // Delete tipoPlanilla
  $(document).on('click', '#delete_tipoPlanilla', function () {
    const item = $(this).attr('item');
    Swal.fire({
      title: "¿Desea eliminar este tipo de planilla?",
      text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar",
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './tipoPlanillas/delete_tipoPlanilla',
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
              table_tipoPlanillas.ajax.reload();
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

  // Deshabilitar TipoPlanilla
  $(document).on('click', '#ban_tipoPlanilla', function () {
    const item = $(this).attr('item');
    const estado = $(this).attr('status');
    msgStatus = estado == 1 ? 'deshabilitar' : 'habilitar'
    Swal.fire({
      title: `¿Desea  ${msgStatus} este tipo de planilla?`,
      //text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: `Si, ${msgStatus}`,
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './tipoPlanillas/disabled_tipoPlanilla',
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
              table_tipoPlanillas.ajax.reload();
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

  // Add TipoPlanilla
  $(document).on('click', '#btnNew', function () {
    $('#modal-tipoPlanilla').modal('show');
  });

  // Register TipoPlanilla
  $(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        var datos = new FormData($(form_tipoPlanilla)[0]);
        $.ajax({
          url: './tipoPlanillas/form',
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
              table_tipoPlanillas.ajax.reload();
              $('#modal-tipoPlanilla').modal('hide');
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

    $('#form_tipoPlanilla').validate({
      rules: {
        nombre_tipo_planilla: {
          required: true
        }
      },
      messages: {
        nombre_tipo_planilla: {
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

  // Edit TipoPlanilla
  $(document).on('click', '#edit_tipoPlanilla', function () {
    const item = $(this).attr('item');
    resetform();
    $.ajax({
      url: './tipoPlanillas/edit_tipoPlanilla',
      type: "POST",
      data: { item },
      dataType: "json",
      success: function (response) {
        response = response.edit;
        if (response) {
          $("#modal-tipoPlanilla .form").append(`<input class="temp" type="hidden" value="${response.id_tipo_planilla}" name="id_tipo_planilla">`)
          $('#modal-tipoPlanilla [name=nombre_tipo_planilla]').val(response.nombre_tipo_planilla);

          $('#modal-tipoPlanilla').modal('show');
        }
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })
  });

  // Esconder el modal
  $('#btnCancel, .close, #btnNew').on('click', function () {
    $('#modal-tipoPlanilla').modal('hide');
  })

};
