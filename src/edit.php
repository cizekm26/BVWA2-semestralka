<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="output.css" rel="stylesheet">
    <script src="./js/script.js"></script>
    <title>Upravit profil</title>
</head>

<body class="bg-white">
    <?php include './templates/header.php';?>
    <div class="md:mx-20 mx-auto max-w-lg mt-5 sm:max-w-xl lg:max-w-full lg:px-5 flex items-center flex-col">
        <div class="px-4 sm:px-0">
            <h1 class="text-3xl font-semibold">Upravit profil</h1>
        </div>
        <form class="bg-gray-100 mt-5 w-full max-w-lg shadow-md p-5 rounded mb-5">
            <fieldset>
                <legend class="text-xl font-bold mb-4 border-b-2 border-blue-500">Základní údaje</legend>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                            Jméno
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="name" type="text" required autocomplete="name"/>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="last-name">
                            Příjmení
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="last-name" type="text" required />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="gender"
                            required>
                            Pohlaví
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="gender" required>
                            <option value="male">muž</option>
                            <option value="female">žena</option>
                        </select>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                            Email
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="email" type="email" required>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="photo">
                            Profilová fotka
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="photo" type="file" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="login">
                            Login
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="login" type="text" required/>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="role">
                            Role
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="role" type="text" value="uzivatel" disabled/>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend class="text-xl font-bold mb-4 border-b-2 border-blue-500 ">Změna hesla</legend>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="password">
                            Nové heslo
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="password" type="password" required minlength="8" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="password-repeat">
                            Heslo znovu
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="password-repeat" type="password" required minlength="8" />
                    </div>
                </div>
            </fieldset>
            <div class="flex items-center mb-6">
                <button class="w-1/2 mr-5 rounded-lg shadow-lg text-sm text-white bg-blue-500 px-4 py-3 uppercase font-semibold">
                    Uložit
                </button>
                <button class="w-1/2 rounded-lg shadow-lg text-sm bg-red-500 text-white px-4 py-3 uppercase font-semibold">
                    Smazat profil
                </button>
            </div>
        </form>
    </div>
</body>

</html>