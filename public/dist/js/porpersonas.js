const porpersonas = () => {

  let table_porpersonas = $('#tbl_porpersonas').DataTable({});

  $(document).on('click', '#btnSearch', () => {
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
        // table_porpersonas.data(response);
        // table_porpersonas.draw();
        //table_porpersonas.rows.add(response.reporte).draw();
        createTable(response);
        // if (response.status == 200) {
        //   Swal.fire({
        //     position: "center",
        //     icon: "success",
        //     title: response.msg,
        //     showConfirmButton: false,
        //     timer: 1500
        //   });
        //   table_porpersonas.ajax.reload();
        // } else {
        //   Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
        // }
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
      columns: ecolumns
    });
  }

};
