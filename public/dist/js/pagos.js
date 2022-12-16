const pagos = () => {

  let table_pagos = $('#tbl_pagos').DataTable({
    ajax: {
      url: './pagos/list_pagos',
      dataSrc: '',
      type: 'POST'
    },

    columns: [
      { data: 'id_pago' },
      { data: 'nombre_personal' },
      { data: 'apellido_personal' },
      { data: 'numero_planilla' },
      { data: 'nombre_year' },
      { data: 'nombre_mes' },
      { data: 'estado_pago' },
      { data: 'acciones' }
    ],

    order: [0, 'desc'],

    columnDefs: [
      {
        targets: 6,

        render: function (data, type, full, meta) {
          if (data == 1) {
            return `<div class="text-center"><span class="badge badge-success">ACTIVO</span></div>`;
          } else {
            return `<div class="text-center"><span class="badge badge-danger">INACTIVO</span></div>`;
          }
        }
      },

      {
        targets: 7,

        render: function (data, type, full, meta) {
          const btn_accion = full.estado == 2 ? { active: 'fas fa-check', color: 'success' } : { active: 'fas fa-ban', color: 'warning' };
          return `<center>
                                <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button type="button" id="edit_pago" item="${full.id_pago}" class="btn btn-xs btn-primary  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_pago" item="${full.id_pago}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        <button type="button" id="view_pago"   item="${full.id_pago}" class="btn btn-xs btn-secondary btn-icon"><i class="icon-nd fas fa-eye"></i></button>
                                        <button type="button" status="${full.estado_pago}" id="ban_pago" item="${full.id_pago}" class="btn btn-xs btn-${btn_accion.color} btn-icon"><i class="icon-nd ${btn_accion.active}"></i></button>
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

  // Delete pago
  $(document).on('click', '#delete_pago', function () {
    const item = $(this).attr('item');
    Swal.fire({
      title: "¿Desea eliminar este pago?",
      text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar",
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './pagos/delete_pago',
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
              table_pagos.ajax.reload();
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

  // Deshabilitar Pago
  $(document).on('click', '#ban_pago', function () {
    const item = $(this).attr('item');
    const estado = $(this).attr('status');
    msgStatus = estado == 1 ? 'deshabilitar' : 'habilitar'
    Swal.fire({
      title: `¿Desea  ${msgStatus} este pago?`,
      //text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: `Si, ${msgStatus}`,
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './pagos/disabled_pago',
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
              table_pagos.ajax.reload();
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

  // Add Pago
  $(document).on('click', '#btnNew', function () {
    $('#modal-pago').modal('show');
  });

  // Register Pago
  $(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        var datos = new FormData($(form_pago)[0]);
        console.log(datos);
        datos.append('bonificaciones', datos.getAll('bonificacion_id').join());
        datos.append('cbonificaciones', datos.getAll('bonificacion_cantidad').join());
        datos.append('descuentos', datos.getAll('descuento_id').join());
        datos.append('cdescuentos', datos.getAll('descuento_cantidad').join());
        console.log(datos);
        $.ajax({
          url: './pagos/form',
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
              table_pagos.ajax.reload();
              $('#modal-pago').modal('hide');
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

    $('#form_pago').validate({
      rules: {
        nombre_pago: {
          required: true
        },
        id_tipo_pago: {
          required: true
        },
        cantidad_pago: {
          required: true
        }
      },
      messages: {
        nombre: {
          required: "Campor requerido"
        },
        tipo_pago: {
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

  // Edit Pago
  $(document).on('click', '#edit_pago', function () {
    const item = $(this).attr('item');
    resetform();
    $.ajax({
      url: './pagos/edit_pago',
      type: "POST",
      data: { item },
      dataType: "json",
      success: function (response) {
        response = response.edit;
        if (response) {
          $("#modal-pago .form").append(`<input class="temp" type="hidden" value="${response.id_pago}" name="id_pago">`)
          $('#modal-pago [name=nombre_pago]').val(response.nombre_pago);
          $('#modal-pago [name=id_tipo_pago]').val(response.id_tipo_pago);
          $('#modal-pago [name=cantidad_pago]').val(response.cantidad_pago);

          $('#modal-pago').modal('show');
        }
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })
  });

  $(document).on('click', '#btnAddBonificacion', () => {
    let id = $('#id_bonificacion').val();
    let id_text = $('#id_bonificacion option:selected').text();
    let cantidad = $('#cantidad_bonificacion').val();

    let container = $('#container_bonificaciones');
    let newBon = `<div class="row mt-1" id="row">
                            <div class="col-4">
                                <input type="text" name="bonificacion_${id}" value="${id_text}" placeholder="${id_text}" readonly />
                                <input type="hidden" name="bonificacion_id" value="${id}" placeholder="${id_text}" readonly />
                            </div>
                            <div class="col-4">
                                <input type="number" step="0.01" name="bonificacion_cantidad" value="${cantidad}" placeholder="${cantidad}" readonly />
                            </div>
                            <div class="col-4">
                                <button class="btn btn-sm btn-danger" type="button" id="deleteBon"> ELIMINAR </button>
                            </div>
                    </div>`;
    container.append(newBon);

    $('#id_bonificacion').val('').trigger('change');
    $('#cantidad_bonificacion').val('');
  });


  $(document).on('click', '#btnAddDescuento', () => {
    let id = $('#id_descuento').val();
    let id_text = $('#id_descuento option:selected').text();
    let cantidad = $('#cantidad_descuento').val();

    let container = $('#container_descuentos');
    let newBon = `<div class="row mt-1" id="row">
                            <div class="col-4">
                                <input type="text" name="descuento_${id}" value="${id_text}" placeholder="${id_text}" readonly />
                                <input type="hidden" name="descuento_id" value="${id}" placeholder="${id_text}" readonly />
                            </div>
                            <div class="col-4">
                                <input type="number" step="0.01" name="descuento_cantidad" value="${cantidad}" placeholder="${cantidad}" readonly />
                            </div>
                            <div class="col-4">
                                <button class="btn btn-sm btn-danger" type="button" id="deleteBon"> ELIMINAR </button>
                            </div>
                    </div>`;
    container.append(newBon);

    $('#id_descuento').val('').trigger('change');
    $('#cantidad_descuento').val('');
  });

  $(document).on('click', '#deleteBon', function () {
    $(this).parents("#row").remove();
  })

  // Esconder el modal
  $('#btnCancel, .close, #btnNew').on('click', function () {
    $('#modal-pago').modal('hide');
    $('#container_bonificaciones').empty();
    $('#container_descuentos').empty();
  })

};
