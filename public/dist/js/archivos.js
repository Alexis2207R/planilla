const archivos = () => {

  let table_archivos = $('#tbl_archivos').DataTable({
    ajax: {
      url: './archivos/list_archivos',
      dataSrc: '',
      type: 'POST'
    },

    columns: [
      { data: 'id_archivo' },
      { data: 'nombre_archivo' },
      { data: 'estado_archivo' },
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
                                        <button type="button" id="edit_archivo" item="${full.id_archivo}" class="btn btn-xs btn-primary  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_archivo" item="${full.id_archivo}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        <button type="button" status="${full.estado_archivo}" id="ban_archivo" item="${full.id_archivo}" class="btn btn-xs btn-${btn_accion.color} btn-icon"><i class="icon-nd ${btn_accion.active}"></i></button>
                                        <a href="./archivos/download_archivo/${full.id_archivo}" type="button" id="download_archivo" item="${full.id_archivo}" class="btn btn-xs btn-secondary btn-icon"><i class="icon-nd fas fa-download"></i></a>
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

  // Delete archivo
  $(document).on('click', '#delete_archivo', function () {
    const item = $(this).attr('item');
    Swal.fire({
      title: "¿Desea eliminar este archivo?",
      text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar",
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './archivos/delete_archivo',
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
              table_archivos.ajax.reload();
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

  // Deshabilitar Archivo
  $(document).on('click', '#ban_archivo', function () {
    const item = $(this).attr('item');
    const estado = $(this).attr('status');
    msgStatus = estado == 1 ? 'deshabilitar' : 'habilitar'
    Swal.fire({
      title: `¿Desea  ${msgStatus} este archivo?`,
      //text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: `Si, ${msgStatus}`,
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './archivos/disabled_archivo',
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
              table_archivos.ajax.reload();
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

  // Add Archivo
  $(document).on('click', '#btnNew', function () {
    $('#modal-archivo').modal('show');
  });

  // Register Archivo
  $(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        var datos = new FormData($(form_archivo)[0]);
        $.ajax({
          url: './archivos/form',
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
              table_archivos.ajax.reload();
              $('#modal-archivo').modal('hide');
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

    $('#form_archivo').validate({
      rules: {
        nombre_archivo: {
          required: true
        },
        archivo: {
          required: true
        }
      },
      messages: {
        nombre_archivo: {
          required: "Campo requerido"
        },
        archivo: {
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

  // Edit Archivo
  $(document).on('click', '#edit_archivo', function () {
    const item = $(this).attr('item');
    resetform();
    $.ajax({
      url: './archivos/edit_archivo',
      type: "POST",
      data: { item },
      dataType: "json",
      success: function (response) {
        response = response.edit;
        if (response) {
          $("#modal-archivo .form").append(`<input class="temp" type="hidden" value="${response.id_archivo}" name="id_archivo">`)
          $('#modal-archivo [name=nombre_archivo]').val(response.nombre_archivo);
          $('#modal-archivo [name=fecha_archivo]').val(response.fecha_archivo);

          $('#modal-archivo').modal('show');
        }
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })
  });

  // Esconder el modal
  $('#btnCancel, .close, #btnNew').on('click', function () {
    $('#modal-archivo').modal('hide');
  })

};
