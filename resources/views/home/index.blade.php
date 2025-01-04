@extends('layout')

@section('content')
<h2 style="color: #ff0081;">Hola,  {{ session('usuario')['nombre'] }}  <button id="logoutButton" class="bubbly-button"  style=" margin-top: 20px; "><i class="fa fa-sign-out" data-toggle="tooltip" data-placement="top" title="Salir"></i> </button> </h2>
    <div class="container mb-4">
    <button class="bubbly-button m-3"  id="crearSalaButton"><i class="fa fa-plus"></i> Crear Sala</button>
        <div class="row justify-content-center">
            @foreach ($salas as $sala)
                <div class="col-lg-3 col-sm-2 col-md-3 m-3 text-center">
                    <div class="box">
                        <strong> <i class="fa fa-users fa-lg" style="color: #ff0081;"></i> {{ $sala->nombre }}</strong>
                        <p>{{ count($sala->grupos) }} Participantes</p>
                        <p><b>{{ $sala->fecha_limite > date('Y-m-d') ? 'Vigente' : 'Expiro' }}</b></p>
                        <p>Creado por {{ $sala->id_usuario == session('usuario')['id'] ? 'Mi' : $sala->nombre_creador }} </p>
                        <i class="fa fa-copy fa-lg m-3" data-value="{{ route('ver_grupo', ['codigo' => $sala->codigo ]) }}" style="color: #ff0081; cursor: pointer;" data-toggle="tooltip" data-placement="top" title="Copiar"></i>
                        <a href="{{ route('ver_grupo', ['codigo' => $sala->codigo ]) }}"><i class="fa fa-list fa-lg m-3" style="color: #ff0081; cursor: pointer;" data-toggle="tooltip" data-placement="top" title="Ver Lista"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <input type="hidden" id="id_usuario" value="{{ session('usuario')['id'] }}">
    <script>
var paginaAnterior = document.referrer;
console.log("URL de la página anterior:", paginaAnterior);

    // Agrega un listener al botón "Crear Sala"
    document.getElementById('crearSalaButton').addEventListener('click', function() {
        // Muestra un cuadro de diálogo de entrada con SweetAlert2
        Swal.fire({
            title: 'Crear Sala',
            html:
                '<label for="nombre">Nombre de la Sala</label>' +
                '<input id="nombre" class="swal2-input" placeholder="Nombre de la Sala">' +
                '<label for="descripcion">Descripción</label>' +
                '<input id="descripcion" class="swal2-input" placeholder="Descripción">' +
                '<label for="fecha_limite">Fecha Límite</label>' +
                '<input id="fecha_limite" class="swal2-input" type="date" placeholder="Fecha Límite">',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonColor: '#ff0081',
            cancelButtonColor: '#c0c0c0',
            confirmButtonText: 'Crear',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                // Recolecta los valores de los inputs
                const nombre = Swal.getPopup().querySelector('#nombre').value;
                const descripcion = Swal.getPopup().querySelector('#descripcion').value;
                const fecha_limite = Swal.getPopup().querySelector('#fecha_limite').value;
                const codigo = generarCodigo(12);
                const id_creador =  document.getElementById('id_usuario').value;
                // Aquí puedes realizar alguna acción con los valores recolectados
                if (!nombre || !descripcion || !fecha_limite) {
                    Swal.showValidationMessage('Todos los campos son obligatorios');
                }

                return { nombre, descripcion, fecha_limite, codigo, id_creador };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Realiza la solicitud AJAX para enviar los datos al servidor
                fetch("{{ route('crea_sala') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(result.value)
                })
                .then(response => response.json())
                .then(data => {
                    Toast.fire({
                        icon: data.icon,
                        title: data.message,
                    }).then((result) => {
                        if (data.icon=='success') {
                            window.location.href = 'home';
                        }
                    });
                })
                .catch(error => {
                    console.error('Error al realizar la solicitud AJAX:', error);
                });
            }
        });
    });

    function generarCodigo(length) {
        const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let codigo = '';

        for (let i = 0; i < length; i++) {
            const indice = Math.floor(Math.random() * caracteres.length);
            codigo += caracteres.charAt(indice);
        }

        return codigo;
    }



</script>
@endsection
