var parts;
var day;
var month;
var year;
var monthLength;

function borra(id, metodo, titulo) {
    //ventana de confirmacion "aceptar" = true "cancelar" = false
    if (confirm("Seguro de que desea eliminar " + titulo)) {
        $.ajax({
            type: 'get',
            url: 'metodos_autor.php',
            data: {
                id: id,
                value: metodo
            },
            success: function (datas) {
                if (datas == "eliminado") {
                    $("#" + id).remove();
                } else {
                    alert("no se pudo eliminar.");
                }
            }

        })
    }
}

function meGusta(obra) {
    $.ajax({
        type: 'post',
        url: 'metodos_autor.php',
        data: {
            metodo: "meGusta",
            idobra: obra
        },
        success: function (data) {
            $("#button" + obra).attr("onclick", "noMeGusta(" + obra + ")");
            $("#button" + obra).attr("class", "noMeGusta");
            $("#button" + obra).text(data);
        }
    });
}

function noMeGusta(obra) {
    $.ajax({
        type: 'post',
        url: 'metodos_autor.php',
        data: {
            metodo: "noMeGusta",
            idobra: obra
        },
        success: function (data) {
            $("#button" + obra).attr("onclick", "meGusta(" + obra + ")");
            $("#button" + obra).attr("class", "meGusta");
            $("#button" + obra).text(data);
        }
    });
}

// validation function
function validation() {
    var titulo = document.forms['myForm']['titulo'].value;
    var tipo = document.forms['myForm']['tipo'].value;
    var fecha = document.forms['myForm']['fecha'].value;
    var descripcion = document.forms['myForm']['descripcion'].value;

    if (titulo.length < 2 || titulo.length > 32) {
        $("[name=titulo]").css("border", "2px solid red");
        $("#error").text("error: titulo debe tener mas de 2 y menos de 32 caracteres");
        return false;
    }

    if (tipo.length < 5 || tipo.length > 16 || !(/^[a-z\s]+$/.test(tipo))) {
        $("[name=tipo]").css("border", "2px solid red");
        $("#error").text("error: tipo debe tener mas de 5 y menos de 16 caracteres");
        return false;
    }

    var date = validaFecha(fecha);
    if (!date) {
        $("[name=fecha]").css("border", "2px solid red");
        $("#error").text("error: Fecha incorrecta, debe tener formato [d]d/[m]m/aaaa y ser posible");
        return false;
    }

    if (descripcion.length < 12 || descripcion.length > 1024) {
        $("[name=descripcion]").css("border", "2px solid red");
        $("#error").text("error: el campo descripción debe tener mas de 12 y menos de 1024 caracteres");
        return false;
    }

    return true;
}

function validaFecha(date) {

    //comprobamos el patron inicial [d]d/[m]m/aaaa
    if (!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(date)) {
        return false;
    }

    // separamos la fecha en trozos para tratarla
    var partes = date.split("/");
    var day = parseInt(partes[0], 10);
    var month = parseInt(partes[1], 10);
    var year = parseInt(partes[2], 10);
    var today = new Date();

    //comprueba el rango de año y mes(año>1000 y <3000, mes>0 y <=12)
    if (year < 1000 || year > 3000 || month == 0 || month > 12) {
        return false;
    }

    // dias de los meses.
    var monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    // ajustamos la funcion para años bisiestos.
    if (year % 400 == 0 || (year % 100 != 0 && year % 4 == 0)) {
        monthLength[1] = 29;
    }

    if (new Date().getTime() - new Date(month + "/" + day + "/" + year).getTime() < 0) return false;

    //devuelve verdadero si el dia es correcto
    return day > 0 && day <= monthLength[month - 1];
}