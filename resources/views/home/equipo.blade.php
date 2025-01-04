@extends('layout')

@section('content')
    <h2 style="color: #ff0081;">Hola,  {{ session('usuario')['nombre'] }}  <button class="bubbly-button" id="logoutButton" style=" margin-top: 20px; "><i class="fa fa-sign-out" data-toggle="tooltip" data-placement="top" title="Salir"></i> </button> </h2>
    <div class="container mb-4">
    @if($sala->id_usuario == session('usuario')['id'] && $grupos[0]->id_usuario_corresponde == null)
        <button id="realizarSorteo" class="bubbly-button m-3"><i class="fa fa-pie-chart"></i> Realizar Sorteo </button>
    @endif
    @if($grupos[0]->id_usuario_corresponde != null)
        <button class="bubbly-button m-3" onclick="verOculto()"><i class="fa fa-question-circle"></i> Ver Mi Oculto</button>
    @endif
    <button onclick="location.href = '/home'" class="bubbly-button m-3"><i class="fa fa-home"></i> Panel </button>

        <div class="row">
            <div class="col-lg-3 col-sm-1 col-md-2 m-3">
                <div class="box">
                <div class="box" style=" padding: 7px; margin-bottom: 10px;">
                    Compartir:
                    <a target="_blank" href="https://api.whatsapp.com/send/?text=Hola, se a creado esta sala para realizar el sorteo de participantes. Por favor, ingresa y únete {{ route('ver_grupo', ['codigo' => $sala->codigo ]) }}"> <i class="fa fa-whatsapp fa-lg mr-2" style="color: #ff0081; cursor: pointer;" data-toggle="tooltip" data-placement="top" title="Informar"></i></a>
                    <i class="fa fa-copy fa-lg " data-value="{{ route('ver_grupo', ['codigo' => $sala->codigo ]) }}" style="color: #ff0081; cursor: pointer;" data-toggle="tooltip" data-placement="top" title="Copiar"></i>

                </div>
                    <b>Nombre de Sala: </b><br>{{$sala->nombre}}
                    <br><br>
                    <b>Descripcion: </b><br>{{$sala->descripcion}}
                    <br><br>
                    <b>Fecha limite: </b><br>{{$sala->fecha_limite}}
                    <br><br>
                    <b>Creado por: </b><br>{{ $sala->id_usuario == session('usuario')['id'] ? 'Yo' : $sala->nombre_creador }}
                </div>
            </div>

            <div class="col-lg-8 col-sm-1 col-md-2">
                <div class="row justify-content-center">
                @foreach ($grupos as $grupo)
                <input type="hidden" class="id_user" value="{{$grupo->id_usuario}}">
                    <div class="col-lg-3 col-sm-2 col-md-3 m-3 text-center">
                        <div class="box">
                            <strong> @if($grupo->id_usuario_corresponde == null) <i class="fa fa-user fa-lg mr-2" style="color: #ff0081;"></i> @else <i class="fa fa-check fa-lg mr-2" style="color: #ff0081;"></i> @endif {{$grupo->nombre}}</strong>
                            @if($grupo->id_usuario_corresponde != null)
                                @if($sala->id_usuario == session('usuario')['id'])
                                    <a href="https://api.whatsapp.com/send/?phone={{$grupo->indicativo}}{{$grupo->whatsapp}}&text=Hola {{$grupo->nombre}}, ya puedes ingresar a ver tu amigo oculto {{route('ver_oculto', ['codigo' => $sala->codigo]) }}" ><i class="fa fa-whatsapp fa-lg mr-2" style="color: #ff0081; cursor: pointer;" data-toggle="tooltip" data-placement="top" title="Informar"></i>
                                @endif
                                @if($grupo->id_usuario == session('usuario')['id'])
                                    <i  onclick="verOculto()" class="fa fa-question-circle fa-lg" style="color: #ff0081; cursor: pointer;" data-toggle="tooltip" data-placement="top" title="Ver mi Oculto"></i>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="id_usuario" value="{{ session('usuario')['id'] }}">
    <script>
        const id_usuario =  document.getElementById('id_usuario').value;

        const id_user_array = Array.from(document.querySelectorAll('.id_user')).map(input => input.value.trim().replace(/\D/g, ''));

        const idUsuarioPresente = id_user_array.includes(id_usuario);

        let jugado = {{$grupos[0]->id_usuario_corresponde}};
        if(!idUsuarioPresente && jugado != null){
            Swal.fire({
                icon: 'error',
                title: 'Ya se realizo el sorteo en esta sala.',
                showCancelButton: false,
                confirmButtonColor: '#ff0081',
                confirmButtonText: 'De acuerdo',
            }).then((result) => {
                window.location.href = "{{route('home')}}";
            });
        }
        else if(!idUsuarioPresente){
            Swal.fire({
                title: '¿Te quieres unir a la sala {{$sala->nombre}} creada por {{$sala->nombre_creador}}?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ff0081',
                cancelButtonColor: '#c0c0c0',
                confirmButtonText: 'Sí, unirme',
                cancelButtonText: 'No, salir'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('unirme', ['id' => $sala->id ]) }}", {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Toast.fire({
                            icon: data.icon,
                            title: data.message,
                        }).then((result) => {
                            if (data.icon=='success') {
                                location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error al realizar la solicitud AJAX:', error);
                    });
                }else{
                    window.location.href = '{{route("home")}}'
                }
            });
        }

        const copyIcons = document.querySelectorAll('.fa-copy');
        // Agrega un evento de clic a cada ícono de copia
        copyIcons.forEach(icon => {
            icon.addEventListener('click', function() {
                // Obtiene el valor del atributo 'data-value'
                const codigoSala = this.getAttribute('data-value');

                // Crea un elemento de textarea temporal
                const textarea = document.createElement('textarea');
                textarea.value = codigoSala;

                // Añade el textarea al DOM
                document.body.appendChild(textarea);

                // Selecciona y copia el contenido del textarea
                textarea.select();
                document.execCommand('copy');

                // Elimina el textarea del DOM
                document.body.removeChild(textarea);

                // Muestra un mensaje de éxito o realiza otras acciones si es necesario
                Toast.fire({
                    icon: 'info',
                    title: 'Link copiado',
                });
            });
        });


        document.getElementById('realizarSorteo').addEventListener('click', function() {

            Swal.fire({
                    title: '¿Estás seguro de que quieres realizar el sorteo?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff0081',
                    cancelButtonColor: '#c0c0c0',
                    confirmButtonText: 'Sí, seguro',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Cargando...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            showLoaderOnConfirm: true,
                            onBeforeOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        let idsUsers =  Array.from(document.querySelectorAll('.id_user')).map(input => input.value.trim().replace(/\D/g, ''));
                        let idsUsersDescartar =  Array.from(document.querySelectorAll('.id_user')).map(input => input.value.trim().replace(/\D/g, ''));
                        let idsUserAsignados = [];
                        for (let i = 0; i < idsUsers.length; i++) {
                            let x = Math.floor(Math.random() * idsUsersDescartar.length);
                            if (idsUsers[i] != idsUsersDescartar[x]) {
                                idsUserAsignados.push([idsUsers[i], idsUsersDescartar[x]]);
                                idsUsersDescartar.splice(x, 1);
                            }else{
                                i--;
                            }
                        }

                        fetch("{{ route('sorteo', ['id' => $sala->id ]) }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({'sorteo': idsUserAsignados})
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.close();
                            Toast.fire({
                                icon: data.icon,
                                title: data.message,
                            }).then((result) => {
                                if (data.icon=='success') {
                                    location.reload();
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error al realizar la solicitud AJAX:', error);
                        });
                    }
                });





        });

        function verOculto(codigo) {
            window.location.href = "{{route('ver_oculto', ['codigo' => $sala->codigo]) }}";
        }
    </script>
    @endsection
