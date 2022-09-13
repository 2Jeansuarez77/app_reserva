
  var app = new Vue({
    el: '#app',
    data: {
        socios : [],
        socio : {},
        error_socio : {},
    },
    methods: {
        init() {
            this.getSocios();
        },
        getSocios(){

            mv = this;
            $.get( URL_SOCIOS, function(resp) {

                mv.socios = resp.socios;
            })
            .fail(function() {
                alert( "error" );
            });
        },
        nuevoSocio(){
            
            this.resetConfig();
            $('#form_socios').modal('show');

        },
        editarSocio(socio){

            this.resetConfig();
            this.socio = socio;
            $('#form_socios').modal('show');

        },
        createSocio(){
            try {
                
                if(!this.socio.dni){
                    alert("El DNI es obligatorio");

                }else if(!this.socio.nombres){
                    alert("El nombre es obligatorio");

                }else if(!this.socio.apellidos){
                    alert("Los apellidos son obligatorio");

                }else{

                    this.socio._token = _TOKEN;
                    mv = this;

                    $('#btn-save').prop('disabled', true);
                    $.post( URL_SOCIOS_CREATE, this.socio, function(resp) {

                        alert("Registro exitoso");
                        mv.getSocios();
                        mv.resetConfig();

                    })
                    .fail(function(resp) {
                        let result = resp.responseJSON;
                        var content = ''

                        Object.values(result.errors).forEach(function(element) {
                            content += '* '+element[0] + " <br>";
                        });

                        $("#error_panel").show();
                        $("#error_panel").html(content);
                        
                        $('#btn-save').prop('disabled', false);
                        alert( "Verificar datos del formulario" );
                    });
                }

            } catch (error) {
                alert(error);
            }
        },
        eliminarSocio(socio){

            if(confirm("Esta seguro de eliminar el socio: "+socio.nombres)){
                mv = this;
                $.ajax({
                    url: URL_SOCIOS_ELIMINAR + '/' + socio.id,
                    type: 'DELETE',
                    data: {
                        "_token": _TOKEN,
                    },
                    success: function (result) {
                        alert('Socio eliminado con exito');
                        mv.getSocios();
                        mv.resetConfig();
                    },
                    error : function(xhr, status) {
                        alert('Disculpe, existió un problema');
                    },
                });
            }
        },
        actualizarSocio(){

            mv = this;

            this.socio._token = _TOKEN;
            $('#btn-save').prop('disabled', true);

            $.ajax({
                url: URL_SOCIOS_ACTUALIZAR + '/' + mv.socio.id,
                type: 'PUT',
                data: mv.socio,
                success: function (result) {
                    alert('Socio actualizado con exito');
                    mv.getSocios();
                    mv.resetConfig();
                },
                error : function(xhr, status) {
                    $('#btn-save').prop('disabled', false);
                    alert('Disculpe, existió un problema');
                },
            });

        },
        resetConfig(){
            this.socio = {};
            $("#error_panel").hide();
            $('#form_socios').modal('hide');
            $('#btn-save').prop('disabled', false);

        }
    
    },
    mounted() {
        this.init();
    }
});