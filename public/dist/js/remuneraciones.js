const remuneraciones = () => {
  let table_remuneraciones = $("#tbl_remuneraciones").DataTable({
    ajax: {
      url: "./nivelremunerativo/list_remuneraciones",
      dataSrc: "",
      type: "POST",
    },

    columns: [
      { data: "id_remuneracion" },
      { data: "nivel" },
      { data: "fecha_registro" },
      { data: "estado_nivel" },
      { data: "acciones" },
    ],

    order: [0, "desc"],

    columnDefs: [
      {
        targets: 3,

        render: function (data, type, full, meta) {
          if (data == 1) {
            return `<div class="text-center"><span class="badge badge-success">ACTIVO</span></div>`;
          } else {
            return `<div class="text-center"><span class="badge badge-danger">INACTIVO</span></div>`;
          }
        },
      },

      {
        targets: 4,
        // orderable:false,
        render: function (data, type, full, meta) {
          const btn_accion =
            full.estado == 2
              ? { active: "fas fa-check", color: "success" }
              : { active: "fas fa-ban", color: "warning" };
          return `<center>
                                  <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                      <div class="btn-group" role="group" aria-label="First group">
                                          <button type="button" id="edit_remuneracion" item="${full.id_remuneracion}" class="btn btn-xs btn-primary  btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                          <button type="button" id="delete_remuneracion" item="${full.id_remuneracion}" class="btn btn-xs btn-danger btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                          <button type="button" status="${full.estado_nivel}" id="ban_remuneracion" item="${full.id_remuneracion}" class="btn btn-xs btn-${btn_accion.color} btn-icon"><i class="icon-nd ${btn_accion.active}"></i></button>
                                          </div>
                                  </div>
                              </center>`;
        },
      },
    ],

    pagingType: "full_numbers",

    language: {
      url: "./public/dist/js/spanish.json",
    },
  });

  // Delete remuneracion
  $(document).on("click", "#delete_remuneracion", function () {
    const item = $(this).attr("item");
    Swal.fire({
      title: "¿Desea eliminar este nivel remunerativo?",
      text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar",
      cancelButtonText: "Cancelar",
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: "./nivelremunerativo/delete_remuneracion",
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
                timer: 1500,
              });
              table_remuneraciones.ajax.reload();
            } else {
              Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
            }
          },
          error: function (err) {
            Swal.fire("Error 500", `${err.statusText}`, "error");
          },
        });
      }
    });
  });

  // Deshabilitar Nivel Remunerativo
  $(document).on("click", "#ban_remuneracion", function () {
    const item = $(this).attr("item");
    const estado = $(this).attr("status");
    msgStatus = estado == 1 ? "deshabilitar" : "habilitar";
    Swal.fire({
      title: `¿Desea  ${msgStatus} este Nivel Remunerativo?`,
      text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: `Si, ${msgStatus}`,
      cancelButtonText: "Cancelar",
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: "./nivelremunerativo/disabled_remuneracion",
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
                timer: 1500,
              });
              table_remuneraciones.ajax.reload();
            } else {
              Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
            }
          },
          error: function (err) {
            Swal.fire("Error 500", `${err.statusText}`, "error");
          },
        });
      }
    });
  });

  // Add remuneracion
  $(document).on("click", "#btnNew", function () {
    $("#modal-remuneracion").modal("show");
  });

  // Register remuneracion
  $(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        var datos = new FormData($(form_remuneracion)[0]);
        $.ajax({
          url: "./nivelremunerativo/form",
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
                timer: 1500,
              });
              resetform();
              table_remuneraciones.ajax.reload();
              $("#modal-remuneracion").modal("hide");
            } else {
              Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
            }
          },
          error: function (err) {
            Swal.fire("Error 500", `${err}`, "error");
          },
        });
      },
    });

    $("#form_remuneracion").validate({
      rules: {
        nivel: {
          required: true,
        },
        fecha_registro: {
          required: true,
        },
      },
      messages: {
        nombre: {
          required: "Campo requerido",
        },
        tipo_remuneracion: {
          required: "Campo requerido",
        },
        cantidad: {
          required: "Campo requerido",
        },
      },
      errorElement: "span",
      errorPlacement: function (error, element) {
        error.addClass("invalid-feedback");
        element.closest(".form-group").append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass("is-invalid");
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass("is-invalid");
      },
    });
  });

  // Edit remuneracion
  $(document).on('click', '#edit_remuneracion', function () {
    const item = $(this).attr('item');
    resetform();
    $.ajax({
      url: './nivelremunerativo/edit_remuneracion',
      type: "POST",
      data: { item },
      dataType: "json",
      success: function (response) {
        response = response.edit;
        if (response) {
          $("#modal-remuneracion .form").append(`<input class="temp" type="hidden" value="${response.id_remuneracion}" name="id_remuneracion">`)
          $('#modal-remuneracion [name=nivel]').val(response.nivel);
          $('#modal-remuneracion [name=fecha_registro]').val(response.fecha_registro);

          $('#modal-remuneracion').modal('show');
        }
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })
  });

  // Esconder el modal
  $('#btnCancel, .close, #btnNew').on('click', function () {
    $('#modal-remuneracion').modal('hide');
  })


};
