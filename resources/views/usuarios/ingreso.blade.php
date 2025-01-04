@extends('layout')

@section('content')
    <h2 style="color: #ff0081;">Ingreso</h2>
    <main>
        <div class="box">
            <div class="box">
                <strong> <i class="fa fa-whatsapp fa-lg" style="color: #ff0081;"></i> (+Ind) (Whatsapp)</strong>
                <input type="text" class="indicativo" tabindex="1" maxlength="4" inputmode="numeric" oninput="formatIndicativo(this)">
                <input type="text" class="numero" tabindex="1" inputmode="numeric" maxlength="14" oninput="formatNumero(this)">
            </div>
            <br>
            <div class="box">
                <strong><i class="fa fa-lock fa-lg" style="color: #ff0081;"></i>  Codigo Pin</strong>
                <input type="number" class="code" tabindex="1" maxlength="1" inputmode="numeric" oninput="this.value = this.value.slice(0, this.maxLength)">
                <input type="number" class="code" tabindex="2" maxlength="1" inputmode="numeric" oninput="this.value = this.value.slice(0, this.maxLength)">
                <input type="number" class="code" tabindex="3" maxlength="1" inputmode="numeric" oninput="this.value = this.value.slice(0, this.maxLength)">
                <input type="number" class="code" tabindex="4" maxlength="1" inputmode="numeric" oninput="this.value = this.value.slice(0, this.maxLength)">
            </div>
            <br>
            <a href="{{ route('registro') }}" style="color: #ff0081; font-size: 12px;">Registro</a>
        </div>
        <button class="bubbly-button" id="enviarButton2"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
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

    document.getElementById('enviarButton2').addEventListener('click', function () {
        // Obtener valores de los campos
        var indicativo = document.querySelector('.indicativo').value.trim().replace(/\D/g, ''); // Eliminar todos los caracteres no numéricos
        var numero = document.querySelector('.numero').value.trim().replace(/\D/g, ''); // Eliminar todos los caracteres no numéricos
        var codigoPin = document.querySelectorAll('.code');


        // Validar que todos los campos estén completos
        if (indicativo === '' || numero === '') {
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
        fetch( "{{ route('ingresar_usuario') }}" , {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                _token: document.querySelector('meta[name="csrf-token"]').content,
                indicativo: indicativo,
                whatsapp: numero,
                codigo: Array.from(codigoPin).map(input => input.value.trim().replace(/\D/g, '')).join(''),
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.icon=='success') {
                document.querySelector('.indicativo').value = '';
                document.querySelector('.numero').value = '';
                codigoPin.forEach(input => input.value = '');
            }
            Toast.fire({
                icon: data.icon,
                title: data.message,
            }).then((result) => {
                if (data.icon=='success') {
                    if (data.url.includes('ver_grupo') || data.url.includes('ver_oculto')) {
                        window.location.href = data.url;
                    } else {
                        window.location.href = "{{route('home')}}";
                    }
                }
            });

        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
@endsection
