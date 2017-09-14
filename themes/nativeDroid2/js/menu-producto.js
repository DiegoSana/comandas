var menu = {
    producto: {
        realizarPedido: function () {
            $.ajax({
                method: 'POST',
                url: '/menu/agregarProducto',
                data: $('#pedido-form').serialize()
            })
                .done(function (rta) {
                    var obj = jQuery.parseJSON(rta);
                    if (obj.status == true) {
                        $('.popResponse').html('');
                        window.location.href = '/menu';
                    }
                    else {
                        console.log($('#pedido-form').serialize());
                        $('.popResponse').html(obj.msg).addClass('clr-red');
                    }
                });
            return false;
        }
    }
}