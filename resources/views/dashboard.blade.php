<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Productos</title>
    <style>
         body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .bg-gradient {
            height: 100%;
            background: linear-gradient(to right, #033c75, white, red, black);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .button-container {
            display: flex;
            gap: 20px;
        }

        .button-container a {
            padding: 12px 24px;
            background-color: rgb(48, 27, 232);
            color: black;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
            transition: 0.3s;
        }

        .button-container a:hover {
            background-color: #033c75;
            color: white;
        }
    </style>
</head>
<body>
    <x-app-layout>
        <div class="min-h-screen flex flex-col justify-center items-center bg-gradient">
            <div class="text-center">
                <div class="flex justify-center space-x-4">
                    <div class="button-container">
                        <a href="{{ route('cotizaciones.index')}}">Cotización</a>
                        <a href="{{ route('producto.index')}}">Agregar</a>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>
</html>

