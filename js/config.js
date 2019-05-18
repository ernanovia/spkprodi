$(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
  // Kita sembunyikan dulu untuk loadingnya
  $("#loading").hide();
  
  $("#ik").change(function(){ // Ketika user mengganti atau memilih data provinsi
    $("#nn").hide(); // Sembunyikan dulu combobox kota nya
    $("#loading").show(); // Tampilkan loadingnya
  
    $.ajax({
      type: "POST", // Method pengiriman data bisa dengan GET atau POST
      url: "ranksssss.php", // Isi dengan url/path file php yang dituju
      data: {kriteria : $("#ik").val()}, // data yang akan dikirim ke file yang dituju
      dataType: "json",
      beforeSend: function(e) {
        if(e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response){ // Ketika proses pengiriman berhasil
        $("#loading").hide(); // Sembunyikan loadingnya

        // set isi dari combobox kota
        // lalu munculkan kembali combobox kotanya
        $("#nn").html(response.data_nilai).show();
      },
      error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
        alert(thrownError); // Munculkan alert error
      }
    });
    });
});