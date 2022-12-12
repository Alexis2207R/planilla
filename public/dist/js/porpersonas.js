const porpersonas = () => {

  $(document).on('click', '#btnSearch', () => {
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

  });


};
