<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="flex justify-center items-center bg-cover bg-no-repeat bg-center backdrop-blur-md min-h-screen"
        style="background-image: url('https://www.orangedigitalcenters.com:12345/api/v1/odcGlobal/ComingSoon%E2%80%9311652362999309.jpg')">
        <div class="bg-white bg-opacity-90 shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
            <div class="mb-4 font-bold text-orange-500 text-9xl">404</div>
            <h1 class="mb-6 font-bold text-gray-800 text-4xl">Oups ! Page introuvable</h1>
            <p class="mb-8 text-gray-600 text-lg">La page que vous recherchez semble être partie dans une petite
                aventure. Ne vous inquiétez pas, nous vous aiderons à retrouver votre chemin de retour.</p>
            <a href="{{ route('admin.dashboard', app()->getLocale()) }}"
                class="inline-block bg-orange-500 hover:bg-orange-500 px-6 py-3 rounded-md font-semibold text-white transition-colors duration-300">
               Retourner à la maison
            </a>
        </div>
    </div>
</body>

</html>
