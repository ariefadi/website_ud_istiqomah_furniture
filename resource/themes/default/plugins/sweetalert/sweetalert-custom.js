function createAlert(messages) {
      disableBlockUI(); // remove modal-backdrop

      var self = this;
      var errors = messages.errors == '' ? '' : messages.errors;
      if (messages.status == "success") {
        swal("Berhasil!", messages.message, "success");
      } else if (messages.status == "updated") {
        swal({
          title: "Berhasil!",
          text: messages.message,
          type: "success"
        },function() {
          window.location.href = messages.redirect;
        });
      } else if (messages.status == "deleted") {

        swal("Berhasil!", messages.message, "success");
        
      } else if (messages.status == "info") {
        swal({
          title: "Info",
          text: messages.message + ' ' + errors,
          type: "info",
          html: true,
          showCancelButton: false,
          confirmButtonClass: 'btn-primary',
          confirmButtonText: 'Ok'
        });
      } else if (messages.status == "warning") {
        swal({
          title: "Peringatan!",
          text: messages.message + ' ' + errors,
          type: "warning",
          html: true,
          showCancelButton: false,
          confirmButtonClass: 'btn-warning',
          confirmButtonText: 'Ok'
        });
      } else if (messages.status == "error") {
        swal({
          title: "Terjadi Kesalahan :(",
          text: messages.message + ' ' + errors,
          type: "error",
          html: true,
          showCancelButton: false,
          confirmButtonClass: 'btn-danger',
          confirmButtonText: 'Ok'
        });
      }
    }
