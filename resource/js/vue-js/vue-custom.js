Vue.directive('select', {
  twoWay: true,
  bind: function(el, binding, vnode) {
    $(el).select2().on("select2:select", (e) => {
      el.dispatchEvent(new Event('change', { target: e.target }));
    });
  },
});

Vue.directive('inputmask-numberid', {
  twoWay: true,
  bind: function(el, binding, vnode) {
    $(el).inputmask({
      alias:'decimal',
      groupSeparator:'.',
      radixPoint:',',
      allowMinus: false,
      autoGroup:true,
      oncomplete: dispatchEvent,
      oncleared: dispatchEvent,
      oncomplete: function(e) {
        var event = document.createEvent('HTMLEvents');
        event.initEvent('input', true, true);
        e.currentTarget.dispatchEvent(event);
        $(this).trigger('change');
      },
    },
    {
      isComplete: function (buffer, opts) {
        vnode.context.value = buffer.join('');
      }
    });
  },
});

Vue.mixin({
  methods: {
    sweetAlert: function(messages) {
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
        swal({
          title: "Terhapus!",
          text: messages.message,
          type: "success"
        },function() {
          window.location.href = messages.redirect;
        });
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
    },
    number_format_db: function(number) {
      var self = this;

      if(!number){
        return 0;
      }

      var a = number.toString();
      var b = self.findAndReplace(a, ".", "");
      var c = self.findAndReplace(b, ",", ".");

      return parseFloat(c);
    },
    number_format_id: function(number, delimiter = ',') {
      var self = this;

      if(!number){
        return 0;
      }

      var number_string = number.toString(),
      split = number_string.split(delimiter),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return rupiah;
    },
    second_to_time: function(secs){
      secs = Math.round(secs);
      var hours = Math.floor(secs / (60 * 60));

      var divisor_for_minutes = secs % (60 * 60);
      var minutes = Math.ceil(divisor_for_minutes / 60);

      var divisor_for_seconds = divisor_for_minutes % 60;
      var seconds = Math.ceil(divisor_for_seconds);

      var obj = {
        "h": hours,
        "m": minutes,
        "s": seconds
      };
      return obj;
    },
    findAndReplace: function(string, target, replacement) {
      var self = this;

      var i = 0,
      length = string.length;

      for (i; i < length; i++) {
        string = string.replace(target, replacement);
      }

      return string;
    },
    setLoading: function(isLoading) {
      var self = this;
      document.body.style.cursor = isLoading ? 'wait' : 'default';
    },
    capitalize: function(value){
      var self = this;

      if (!value) return ''
        value = value.toString()
      words = value.toLowerCase().split(' ');

      for(var i = 0; i < words.length; i++){
        var letters = words[i].split('');
        letters[0] = letters[0].toUpperCase();
        words[i] = letters.join('');
      }

      return words.join(' ');
    },
    mDateIndo: function (value, delimiter){
      var self = this;

      if (!value || value == '' || value == null || value == '0000-00-00' || value == '0000-00-00 00:00:00' || value.length == 0){
        return '-';
      }

      var month = new Array();
      month[0] = "Januari";
      month[1] = "Februari";
      month[2] = "Maret";
      month[3] = "April";
      month[4] = "Mei";
      month[5] = "Juni";
      month[6] = "Juli";
      month[7] = "Agustus";
      month[8] = "September";
      month[9] = "Oktober";
      month[10] = "November";
      month[11] = "Desember";

      var date = new Date(value);

      var split_datetime = value.split(" ");
      var date_string = split_datetime[0].toString();
      var split_date = date_string.split(delimiter);
      var tanggal = split_date[2];
      var bulan = split_date[1];
      var tahun = split_date[0];

      if(value.length == 19){
        var time_string = split_datetime[1].toString();
        return date.getDate()+' '+month[date.getMonth()]+' '+date.getFullYear() +' Jam '+time_string.toString();
      }

      return date.getDate()+' '+month[date.getMonth()]+' '+date.getFullYear();
    },
    formatDate: function(value){
      var date = new Date(value);

      var month = '' + (date.getMonth() + 1),
      day = '' + date.getDate(),
      year = date.getFullYear();

      if (month.length < 2) month = '0' + month;
      if (day.length < 2) day = '0' + day;

      return [year, month, day].join('-');
    },
    formatDateID: function(value){
      var date = new Date(value);

      var month = '' + (date.getMonth() + 1),
      day = '' + date.getDate(),
      year = date.getFullYear();

      if (month.length < 2) month = '0' + month;
      if (day.length < 2) day = '0' + day;

      return [day, month, year].join('-');
    }
  }
})
