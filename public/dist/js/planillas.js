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
                                        <button type="button" id="edit_planilla"   item="${full.id_planilla}" class="btn btn-xs btn-primary   btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_planilla" item="${full.id_planilla}" class="btn btn-xs btn-danger    btn-icon"><i class="icon-nd fas fa-trash"></i></button>
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
        let descuentos = datos.getAll('descuentos');
        let bonificaciones = datos.getAll('bonificaciones');
        datos.append('id_descuentos', descuentos);
        datos.append('id_bonificaciones', bonificaciones);
        console.log({datos});
        $.ajax({
          url: './planillas/form',
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
              table_planillas.ajax.reload();
              $('#modal-planilla').modal('hide');
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

    $('#form_planilla').validate({
      rules: {
        numero_planilla: {
          required: true
        },
        id_tipo_planilla: {
          required: true
        },
        id_year: {
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
        id_year: {
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
        if (!response)
          return;
        response = response.edit;
        console.log(response);
        let planilla = response.planilla;
        let bonificaciones = response.bonificaciones;
        let descuentos = response.descuentos;

        $("#modal-planilla .form").append(`<input class="temp" type="hidden" value="${planilla.id_planilla}" name="id_planilla">`)
        $('#modal-planilla [name=numero_planilla]').val(planilla.numero_planilla);
        $('#modal-planilla [name=id_tipo_planilla]').val(planilla.id_tipo_planilla);
        $('#modal-planilla [name=id_year]').val(planilla.id_year);

        // resetDualLists();

        // bonificaciones.forEach((item) => {
        //   $('#bonificaciones option[value="' + item.id_bonificacion + '"]').prop('selected', true);
        // });

        // descuentos.forEach((item) => {
        //   $('#descuentos option[value="' + item.id_descuento + '"]').prop('selected', true);
        // });

        // $('#bonificaciones').bootstrapDualListbox('refresh', true);
        // $('#descuentos').bootstrapDualListbox('refresh', true);

        $('#modal-planilla').modal('show');
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })
  });

  // View planilla
  $(document).on('click', '#view_planilla', function () {
    const item = $(this).attr('item');
    $.ajax({
      url: './planillas/view_planilla',
      type: "POST",
      data: { item },
      dataType: "json",
      success: function (response) {
        if (response.status == 200) {
          let planilla = response.view.planilla;
          $('#view-numero-planilla').val(planilla.numero_planilla);
          $('#view-tipo-planilla').val(planilla.nombre_tipo_planilla);
          $('#view-id-year').val(planilla.nombre_year);
          $('#view-fecha-creacion').val(planilla.fecha_creacion_planilla);

          $('#view-total-ingreso').val(planilla.total_ingreso);
          $('#view-total-egreso').val(planilla.total_egreso);
          $('#view-total-neto').val(planilla.total_neto);

          let bonificaciones = response.view.bonificaciones;
          bonificaciones.forEach((item) => {
            let li = `<li class="nav-item mt-2">
                                            ${item.nombre_bonificacion} <span class="float-right badge bg-primary">S/ ${item.cantidad_bonificacion}</span>
                                        </li>`;
            $('#list-bonificaciones').append(li);
          });

          let descuentos = response.view.descuentos;
          descuentos.forEach((item) => {
            let li = `<li class="nav-item mt-2">
                                            ${item.nombre_descuento} <span class="float-right badge bg-primary">S/ ${item.cantidad_descuento}</span>
                                        </li>`;
            $('#list-descuentos').append(li);
          });

          $('#modal-view-planilla').modal('show');
        } else {
          Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
        }
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    });
  });

  function resetDualLists() {
    // Funciones internas de la libreria
    $('.removeall').trigger('click');
  }



  // Esconder el modal
  $('#btnCancel, .close').on('click', function () {
    $('#modal-planilla').modal('hide');
  })

  $('#btnNew').on('click', function () {
    resetDualLists();
  });

  // Esconder el modal de view
  $('.close-view').on('click', function () {
    $('#modal-view-planilla').modal('hide');
    $('#list-bonificaciones').empty();
    $('#list-descuentos').empty();
  })

};
