<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Arial';
            background: #f0f0f0;
        }
        h2 {
            margin-top: 30px;
            text-align: center;
        }
        input[type="number"]::-webkit-inner-spin-button, input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
        .bubbly-button {
            font-family: 'Helvetica', 'Arial', sans-serif;
            display: inline-block;
            font-size: 1em;
            padding: 15px 10px;
            margin-top: 150px;
            -webkit-appearance: none;
            appearance: none;
            background-color: #ff0081;
            color: #fff;
            border-radius: 4px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border: none;
            cursor: pointer;
            position: relative;
            transition: transform ease-in 0.1s, box-shadow ease-in 0.25s;
            box-shadow: 0 2px 25px rgba(255, 0, 130, 0.5);
        }
        .bubbly-button:focus {
            outline: 0;
        }
        .bubbly-button:before, .bubbly-button:after {
            position: absolute;
            content: '';
            display: block;
            width: 140%;
            height: 100%;
            left: -20%;
            z-index: -1000;
            transition: all ease-in-out 0.5s;
            background-repeat: no-repeat;
        }
        .bubbly-button:before {
            display: none;
            top: -75%;
            background-image: radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, transparent 20%, #ff0081 20%, transparent 30%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, transparent 10%, #ff0081 15%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%);
            background-size: 10% 10%, 20% 20%, 15% 15%, 20% 20%, 18% 18%, 10% 10%, 15% 15%, 10% 10%, 18% 18%;
        }
        .bubbly-button:after {
            display: none;
            bottom: -75%;
            background-image: radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, transparent 10%, #ff0081 15%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%);
            background-size: 15% 15%, 20% 20%, 18% 18%, 20% 20%, 15% 15%, 10% 10%, 20% 20%;
        }
        .bubbly-button:active {
            transform: scale(0.9);
            background-color: #e60074;
            box-shadow: 0 2px 25px rgba(255, 0, 130, 0.2);
        }
        .bubbly-button.animate:before {
            display: block;
            animation: topBubbles ease-in-out 0.75s forwards;
        }
        .bubbly-button.animate:after {
            display: block;
            animation: bottomBubbles ease-in-out 0.75s forwards;
        }
        @keyframes topBubbles {
            0% {
                background-position: 5% 90%, 10% 90%, 10% 90%, 15% 90%, 25% 90%, 25% 90%, 40% 90%, 55% 90%, 70% 90%;
            }
            50% {
                background-position: 0% 80%, 0% 20%, 10% 40%, 20% 0%, 30% 30%, 22% 50%, 50% 50%, 65% 20%, 90% 30%;
            }
            100% {
                background-position: 0% 70%, 0% 10%, 10% 30%, 20% -10%, 30% 20%, 22% 40%, 50% 40%, 65% 10%, 90% 20%;
                background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
            }
        }
        @keyframes bottomBubbles {
            0% {
                background-position: 10% -10%, 30% 10%, 55% -10%, 70% -10%, 85% -10%, 70% -10%, 70% 0%;
            }
            50% {
                background-position: 0% 80%, 20% 80%, 45% 60%, 60% 100%, 75% 70%, 95% 60%, 105% 0%;
            }
            100% {
                background-position: 0% 90%, 20% 90%, 45% 70%, 60% 110%, 75% 80%, 95% 70%, 110% 10%;
                background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
            }
        }
        main {
            position: absolute;
            top: 0px;
            left: 0px;
            bottom: 0px;
            right: 0px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .box {
            background: white;
            border-radius: 10px;
            border: 1px solid #ccc;
            padding: 20px 10px;
            text-align: center;
        }
        .box strong {
            display: block;
            margin-bottom: 10px;
        }
        .box .code {
            border: 0px;
            text-align: center;
            border-bottom: 3px solid #999;
            width: 30px;
            margin: 0px 10px;
            font-weight: bold;
            font-size: 20px;
            padding-bottom: 5px;
        }
        .box .indicativo {
            border: 0px;
            text-align: center;
            border-bottom: 3px solid #999;
            width: 40px;
            margin: 0px 10px;
            font-weight: bold;
            font-size: 20px;
            padding-bottom: 5px;
        }
        .box .numero {
            border: 0px;
            text-align: center;
            border-bottom: 3px solid #999;
            width: 140px;
            margin: 0px 10px;
            font-weight: bold;
            font-size: 20px;
            padding-bottom: 5px;
        }
        .box .name {
            border: 0px;
            text-align: center;
            border-bottom: 3px solid #999;
            width: 200px;
            margin: 0px 10px;
            font-weight: bold;
            font-size: 20px;
            padding-bottom: 5px;
        }


        .colored-toast.swal2-icon-success {
        background-color: #a5dc86 !important;
        }

        .colored-toast.swal2-icon-error {
        background-color: #f27474 !important;
        }

        .colored-toast.swal2-icon-warning {
        background-color: #f8bb86 !important;
        }

        .colored-toast.swal2-icon-info {
        background-color: #3fc3ee !important;
        }

        .colored-toast.swal2-icon-question {
        background-color: #87adbd !important;
        }

        .colored-toast .swal2-title {
        color: white;
        }

        .colored-toast .swal2-close {
        color: white;
        }

        .colored-toast .swal2-html-container {
        color: white;
        }
        /* Cambiar el color del spinner con menor prioridad */
        .swal2-popup .swal2-loader {
            border-color: #ff0081 transparent #ff0081 transparent;
        }


    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>
<body>
    @yield('content')
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast',
        },
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        icon: 'error',
        title: 'Campos Obligatorios',
    });

    function formatIndicativo(input) {
        let inputValue = input.value;

        // Verifica si ya hay un prefijo '+' presente
        if (!inputValue.startsWith("+")) {
        // Añade el prefijo solo si no está presente
        input.value = "+" + inputValue;
        }
    }

    function formatNumero(input) {
        let inputValue = input.value;

        // Elimina cualquier caracter que no sea un número
        let numericValue = inputValue.replace(/\D/g, '');

        // Formatea el número como (XXX) XXX-XXXX
        let formattedValue = "(" + numericValue.slice(0, 3) + ") " + numericValue.slice(3, 6) + "-" + numericValue.slice(6, 10);

        // Actualiza el valor del campo de entrada con el formato deseado
        input.value = formattedValue;
    }


    var animateButton = function(e) {

    e.preventDefault;
    //reset animation
    e.target.classList.remove('animate');

    e.target.classList.add('animate');
    setTimeout(function(){
        e.target.classList.remove('animate');
    },700);
    };

    var bubblyButtons = document.getElementsByClassName("bubbly-button");

    for (var i = 0; i < bubblyButtons.length; i++) {
    bubblyButtons[i].addEventListener('click', animateButton, false);
    }

    document.addEventListener('DOMContentLoaded', function() {

        // Obtén todos los elementos con la clase 'fa-copy'
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
    });


    document.getElementById('logoutButton').addEventListener('click', function() {
        // Muestra la alerta SweetAlert
        Swal.fire({
            title: '¿Estás seguro de que quieres cerrar sesión?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff0081',
            cancelButtonColor: '#c0c0c0',
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/salir'
            }
        });
    });
</script>
</body>
</html>
