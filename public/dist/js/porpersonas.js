
const porpersonas = () => {

  let table_porpersonas = $('#tbl_porpersonas').DataTable({})

  $(document).on('click', '#btnSearch', () => {
    if (!isValidForm()) {
      Swal.fire('Error 500', 'Seleccione a un personal', 'error');
      return;
    }
    var datos = new FormData($(form_busqueda)[0]);
    $.ajax({
      url: './porPersonas/search_porpersona',
      type: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response.status == 200) {
          createTable(response);
        } else {
          Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
        }
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })

  });

  function createTable(response) {
    let ecolumns = [
      {data: 'nombre_mes'},
      {data: 'numero_planilla'},
      {data: 'dias'}
    ];

    response.bonificaciones.forEach((e) => {
      ecolumns.push({data: e.nombre_bonificacion});
    });

    ecolumns.push({data: 'total_ingreso'})

    response.descuentos.forEach((e) => {
      ecolumns.push({data: e.nombre_descuento});
    });

    ecolumns.push({data: 'total_egreso'})
    ecolumns.push({data: 'total_neto'})

    table_porpersonas.destroy();
    table_porpersonas = $('#tbl_porpersonas').DataTable({
      data: response.reporte,
      columns: ecolumns,
    });
  }

  // Exportar a pdf
  $(document).on('click', '#btnPdf', () => {
    var datos = new FormData($(form_busqueda)[0]);
    $.ajax({
      url: './porPersonas/pdf',
      type: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })
  });

  // Exportar a Excel
  $(document).on('click', '#btnExcel', () => {
    if (!isValidForm()) {
      Swal.fire('Error 500', 'Seleccione a un personal', 'error');
      return;
    }
    var datos = new FormData($(form_busqueda)[0]);
    $.ajax({
      url: './porPersonas/excel',
      type: 'POST',
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (response) {
        var a = document.createElement('a');
        a.href = response.file;
        a.download = response.name;
        document.body.appendChild(a);
        a.click();
        a.remove();
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })
  });

  function isValidForm() {
    let jqIdPersonal = $('#id_personal');
    if (jqIdPersonal.val() == null || jqIdPersonal.val() == '')
      return false;
    return true;
  }

};
