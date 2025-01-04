@extends('layout')

@section('content')
    <h2 style="color: #ff0081;">Registro</h2>
    <main>
        <div class="box">
            <div class="box">
                <strong><i class="fa fa-whatsapp fa-lg" style="color: #ff0081;"></i> (+Ind) (Whatsapp)</strong>
                <input type="text" class="indicativo" tabindex="1" maxlength="4" inputmode="numeric" oninput="formatIndicativo(this)">
                <input type="text" class="numero" tabindex="1" inputmode="numeric" maxlength="14" oninput="formatNumero(this)">
            </div>
            <br>
            <div class="box">
                <strong><i class="fa fa-user fa-lg" style="color: #ff0081;"></i> Nombre</strong>
                <input type="text" class="name" tabindex="1">
            </div>
            <br>
            <div class="box">
                <strong><i class="fa fa-lock fa-lg" style="color: #ff0081;"></i> Codigo Pin</strong>
                <input type="number" class="code" tabindex="1" maxlength="1" inputmode="numeric" oninput="this.value = this.value.slice(0, this.maxLength)">
                <input type="number" class="code" tabindex="2" maxlength="1" inputmode="numeric" oninput="this.value = this.value.slice(0, this.maxLength)">
                <input type="number" class="code" tabindex="3" maxlength="1" inputmode="numeric" oninput="this.value = this.value.slice(0, this.maxLength)">
                <input type="number" class="code" tabindex="4" maxlength="1" inputmode="numeric" oninput="this.value = this.value.slice(0, this.maxLength)">
            </div>
            <br>
            <a href="{{ route('ingreso') }}" style="color: #ff0081; font-size: 12px;">Ingreso</a>
        </div>
        <button class="bubbly-button" id="enviarButton"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>

    </main>
<script>
    var items = document.querySelectorAll('.code'),
        lastTabIndex = 4,
        backSpaceCode = 8;
    items.forEach(function(item) {
        item.addEventListener('focus', function(e) {
            e.target.value = '';
        });
        item.addEventListener('keydown', function(e) {
            let keyCode = e.keyCode,
                currentTabIndex = e.target.tabIndex;
            if (keyCode !== backSpaceCode && currentTabIndex !== lastTabIndex) {
            document.querySelectorAll('.code').forEach(function(inpt) {
                if (inpt.tabIndex === currentTabIndex + 1) {
                setTimeout(function() {
                    inpt.focus();
                }, 100);
                }
            });
            }
        });
    });

    document.getElementById('enviarButton').addEventListener('click', function () {
        // Obtener valores de los campos
        var indicativo = document.querySelector('.indicativo').value.trim().replace(/\D/g, ''); // Eliminar todos los caracteres no numéricos
        var numero = document.querySelector('.numero').value.trim().replace(/\D/g, ''); // Eliminar todos los caracteres no numéricos
        var name = document.querySelector('.name').value.trim();
        var codigoPin = document.querySelectorAll('.code');


        // Validar que todos los campos estén completos
        if (indicativo === '' || numero === '' || name === '') {
            Toast.fire({
                icon: 'error',
                title: 'Campos Obligatorios',
            });
            return;
        }

        if (Array.from(codigoPin).some(input => input.value.trim() === '')) {
            Toast.fire({
                icon: 'error',
                title: 'PIN debe tener 4 dígitos',
            });
            return;
        }

        // Realizar la solicitud POST
        fetch("{{ route('crear_usuario') }}" , {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                _token: document.querySelector('meta[name="csrf-token"]').content,
                nombre: name,
                indicativo: indicativo,
                whatsapp: numero,
                codigo: Array.from(codigoPin).map(input => input.value.trim().replace(/\D/g, '')).join(''),
            }),
        })
        .then(response => response.json())
        .then(data => {
            Toast.fire({
                icon: data.icon,
                title: data.message,
            });
            document.querySelector('.indicativo').value = '';
            document.querySelector('.numero').value = '';
            document.querySelector('.name').value = '';
            codigoPin.forEach(input => input.value = '');
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

</script>
@endsection
