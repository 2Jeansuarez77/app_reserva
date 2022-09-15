
  var app = new Vue({
    el: '#app',
    data: {
        fila : '',
        columna : '',
        reservas : [],
        reserva : {butacas : []},
        socios : [],
        
    },
    methods: {
        init() {
            this.getReserva();
            this.getSocios();
        },
        getReserva(){

            mv = this;
            $.get( URL_RESERVA, function(resp) 
            {
                var resp = JSON.parse(resp);
                mv.reservas = resp.reservas;
            })
            .fail(function() 
            {
                alert( "error, al tratar de consultar las reservas" );
            });
        },
        getSocios(){

            mv = this;
            $.get( URL_SOCIOS, function(resp) {
                var resp = JSON.parse(resp);
                mv.socios = resp.socios;
            })
            .fail(function() {
                alert( "error" );
            });
        },
        nuevoReserva(){
            
            this.resetConfig();
            $('#form_reservas').modal('show');

        },
        editarReserva(reserva){

            this.resetConfig();
            this.reserva = reserva;
            $('#form_reservas').modal('show');

        },
        createReserva(){
            try {
                
                if(!this.reserva.socio_id){
                    alert("El socio es obligatorio");

                }else if(!this.reserva.fecha_reserva){
                    alert("Fecha es Obligatoria");

                }else{

                    this.reserva._token = _TOKEN;
                    mv = this;

                    $('#btn-save').prop('disabled', true);
                    $.post( URL_RESERVA_CREATE, this.reserva, function(resp) {
                        var resp = JSON.parse(resp);
                        if(!resp.error){
                            mv.getReserva();
                            mv.resetConfig();
                        }
                        $('#btn-save').prop('disabled', false);
                        alert(resp.message);


                    })
                    .fail(function(resp) {
                        
                        alert( "Verificar datos del formulario" );
                    });
                }

            } catch (error) {
                alert(error);
            }
        },
        eliminarReserva(reserva){

            if(confirm("Esta seguro de eliminar esta reserva")){
                mv = this;
                $.ajax({
                    url: URL_RESERVA_ELIMINAR + '/' + reserva.id,
                    type: 'DELETE',
                    data: {
                        "_token": _TOKEN,
                    },
                    success: function (result) {
                        var result = JSON.parse(result);
                        alert(result.message);
                        mv.getReserva();
                        mv.resetConfig();
                    },
                    error : function(xhr, status) {
                        alert('Disculpe, existió un problema');
                    },
                });
            }
        },
        actualizarReserva(){

            mv = this;

            this.reserva._token = _TOKEN;
            $('#btn-save').prop('disabled', true);

            $.ajax({
                url: URL_RESERVA_ACTUALIZAR + '/' + mv.reserva.id,
                type: 'PUT',
                data: mv.reserva,
                success: function (result) {
                    var result = JSON.parse(result);
                    alert(result.message);
                    if(!result.error){
                        mv.getReserva();
                        mv.resetConfig();
                    }
                    $('#btn-save').prop('disabled', false);

                    
                },
                error : function(xhr, status) {
                    $('#btn-save').prop('disabled', false);
                    alert('Disculpe, existió un problema');
                },
            });

        },
        resetConfig(){
            this.reserva = {butacas:[]};
            $("#error_panel").hide();
            $('#form_reservas').modal('hide');
            $('#btn-save').prop('disabled', false);
            this.fila = '';
            this.columna = '';

        },

        addButacas(){

            mv = this;

            if(!this.reserva.fecha_reserva)
            {
                alert("La fecha es Obligatoria");
            }
            if(this.fila < 1 || this.columna < 1)
            {
                alert("Debe ingresar una fila y columna");
            }
            else if(this.existButaca(this.fila, this.columna))
            {
                alert("Butaca ya esta agregada");
            
            }else
            {
                $.get( URL_RESERVA_DISPONIBLE + '/'+ this.fila + '/' + this.columna, {fecha : this.reserva.fecha_reserva} , function(resp) 
                {
                    var resp = JSON.parse(resp);

                    if(!resp.error){
                        
                        mv.reserva.butacas.push(
                            {
                                fila : mv.fila,
                                columna : mv.columna
                            }
                        );

                        mv.fila = '';
                        mv.columna = '';
                    }else{
                        alert(resp.message);
                    }
                })
                .fail(function() 
                {
                    alert( "error, al tratar de consultar las reservas" );
                    
                });
            }
        },

        eliminarButaca(id){
            mv.reserva.butacas.splice(id,1);
        },

        existButaca(fila, columna){

            let existe = false;
            this.reserva.butacas.forEach(function(butaca){

                if(butaca.fila == fila && butaca.columna == columna){

                    existe = true;
                    return;
                }
            });

            return existe;
        }
    
    },
    mounted() {
        this.init();
    }
});