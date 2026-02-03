<div id="pass-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full sm:rounded-lg bg-white rounded-lg shadow dark:bg-gray-800"
        style="width: 90%;">
        <div class="flex items-center justify-between p-2 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 id="insertPass" class="px-4 text-lg font-semibold text-gray-900 dark:text-white">
                Règle de passation</h3>
            </h3>
            <h3 id="editPass" class="px-4 text-lg font-semibold text-gray-900 dark:text-white">
                Modification de règle de passation</h3>
            </h3>
            <button type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-toggle="pass-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <form method="POST" action="" autocomplete="off" style="padding: 20px 0 20px 0">
            <div class=" mr-5" style="padding-left: 20px">
                @csrf
                <input type="hidden" name="phase" id="phaseId" value="">
                <input type="hidden" name="typePhase" id="typePhase" value="">
                <div id="ajoutPass" class="pt-5">
                    <ul
                        class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input id="passNombre" type="checkbox" value="" name="passNombre"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="passNombre"
                                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Nombre des candidats maximum
                                    <h2 class="px-3 float-right"><strong id="getNombPass"></strong></h2>
                                </label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600"
                            hidden>
                            <div class="flex items-center ps-3">
                                <input id="passPourcent" type="checkbox" value="" name="passPourcent"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="passPourcent"
                                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Pourcentage des candidats requis
                                    <h2 class="px-3 float-right"><strong id="getPondprive"></strong></h2>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
                <div id="nombreDiv">
                    <div id="">
                        <label for="nombre_candidat"
                            class="block mb-2 pt-3 text-sm font-medium text-gray-900 dark:text-white">Nombre des
                            candidats
                            eligible</label>
                        <input type="number" id="nombre_candidat" name="nombre_candidat"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Nombre des candidats" value="0" required />
                    </div>
                </div>
                <div id="pourcentDiv">
                    <div id="">
                        <label for="pourcent_candidat"
                            class="block mb-2 pt-3 text-sm font-medium text-gray-900 dark:text-white">Pourcenatge requis
                            des candidats
                        </label>
                        <input type="number" id="pourcent_candidat" name="pourcent_candidat"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Pourcentage des candidats" value="0" required />
                    </div>
                </div>
                <div class="flex justify-between items-center mt-4 sm:mt-6">
                    <button id="validPass" type="button" data-modal-target="passValid" onclick="validatePass(this)"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-4 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40">
                        Valider
                    </button>
                    <button id="modifier" type="button" onclick="modif()"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"">
                        Modifier
                    </button>
                    <button id="annuler" type="button" onclick="annul()"
                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                        style="display:none">
                        Annuler
                    </button>
                </div>
                <div id="passValid" tabindex="-1"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-[300px] max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button"
                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="passValid">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Veuillez
                                    selectionner au moins une case.</h3>
                                <button data-modal-hide="passValid" type="button"
                                    class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const nombre_div = document.getElementById('nombreDiv');
    nombre_div.style.display = 'none';
    const nombre_candidat = document.getElementById('nombre_candidat');

    const pourcent_div = document.getElementById('pourcentDiv');
    pourcent_div.style.display = 'none';
    const pourcent_candidat = document.getElementById('pourcent_candidat');

    const passNombreCheckbox = document.getElementById('passNombre');
    const passPourcentCheckbox = document.getElementById('passPourcent')

    const passValidModal = document.getElementById('passValid');
    const validButton = document.querySelector('button[type="submit"]');

    function validatePass(validButton) {
        const passNombreCheckbox = document.getElementById('passNombre');
        const passPourcentCheckbox = document.getElementById('passPourcent');

        if (!passNombreCheckbox.checked && !passPourcentCheckbox.checked) {

            passValidModal.classList.remove('hidden');
            passValidModal.classList.add('flex');

            validButton.type = 'button';

            return false;
        }

        passValidModal.classList.add('hidden')
        validButton.type = 'submit';

        return true;
    }

    passNombreCheckbox.addEventListener('change', () => {
        if (passNombreCheckbox.checked) {
            nombre_div.style.display = 'block';
            nombre_candidat.setAttribute('value', 1)
        } else {
            nombre_div.style.display = 'none';
            nombre_candidat.setAttribute('value', 0)
        }
    });

    passPourcentCheckbox.addEventListener('change', () => {
        if (passPourcentCheckbox.checked) {
            pourcent_div.style.display = 'block';
            pourcent_candidat.setAttribute('value', 1)
        } else {
            pourcent_div.style.display = 'none';
            pourcent_candidat.setAttribute('value', 0)
        }
    });
    const modifierButton = document.getElementById('modifier');
    const annulerButton = document.getElementById('annuler');
    const validerButton = document.getElementById('validPass');
    const editPass = document.getElementById('editPass');
    const insertPass = document.getElementById('insertPass');
    const typePhase = document.getElementById('typePhase');

    function modif() {
        if (typePhase.value == "Evaluation" || typePhase.value == "evaluation") {
            modifierButton.style.display = 'none';
            annulerButton.style.display = 'inline-block';
            validerButton.style.display = 'block';
            insertPass.style.display = 'none';
            editPass.style.display = 'flex';
            passPourcentCheckbox.checked = 'true';
            pourcent_div.style.display = 'block';
            pourcent_candidat.style.display = 'block';
        } else {
            modifierButton.style.display = 'none';
            annulerButton.style.display = 'inline-block';
            validerButton.style.display = 'block';
            nombre_div.style.display = 'block';
            nombre_candidat.style.display = 'block';
            insertPass.style.display = 'none';
            editPass.style.display = 'flex';
            passNombreCheckbox.checked = true;
        }
    }

    function annul() {
        modifierButton.style.display = 'inline-block';
        annulerButton.style.display = 'none';
        validerButton.style.display = 'none';
        nombre_div.style.display = 'none';
        nombre_candidat.style.display = 'none';
        insertPass.style.display = 'flex';
        editPass.style.display = 'none';
        passNombreCheckbox.checked = false;

        passPourcentCheckbox.checked = 'false';
        pourcent_div.style.display = 'none';
        pourcent_candidat.style.display = 'none';
    }
</script>
