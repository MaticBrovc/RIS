function validateForm() {
    var mesec = document.forms["vnos"]["mesec"].value;
    var leto = document.forms["vnos"]["leto"].value;
    var d = new Date();
    var n = d.getMonth() + 1;
    var y = d.getFullYear();
    if ((n < mesec && y < leto) || (mesec > n && leto == y) || (mesec <= n && leto > y) || (leto > y)) {
        alert("Prosim vnesite veljaven datum in ne datum v prihodnosti. Časovne naprave namreč nimamo!");
        return false;
    }
  }