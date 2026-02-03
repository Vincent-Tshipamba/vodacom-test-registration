<div id="create-modal-question" tabindex="-1" aria-hidden="true"
    class="hidden top-0 right-0 left-0 z-50 fixed md:inset-0 justify-center items-center w-full h-[calc(100%-1rem)] max-h-full overflow-x-hidden overflow-y-auto">
    <div class="relative bg-white dark:bg-gray-800 shadow rounded-lg sm:rounded-lg overflow-x-auto" style="width: 80%;">
        <div class="flex justify-between items-center p-4 md:p-5 dark:border-gray-600 border-b rounded-t">
            <h3 class="font-semibold text-gray-900 dark:text-white text-lg">
                Insertion des questions</h3>
            </h3>
            <button type="button"
                class="inline-flex justify-center items-center bg-transparent hover:bg-gray-200 dark:hover:bg-gray-600 ms-auto rounded-lg w-8 h-8 text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm"
                data-modal-toggle="create-modal-question">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <form method="POST" id="formInsertQuestion" action="" enctype="multipart/form-data"
            style="padding: 20px 0 20px 0">
            <div id="ajout" class="m-5">
                <ul
                    class="items-center bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg w-full font-medium text-gray-900 dark:text-white text-sm">
                    <li class="border-gray-200 dark:border-gray-600 sm:border-r border-b sm:border-b-0 w-full">
                        <div class="flex items-center ps-3">
                            <input id="importerCheck" type="radio" value="" name="choice"
                                class="bg-gray-100 dark:bg-gray-600 border-gray-300 dark:border-gray-500 rounded focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700 dark:ring-offset-gray-700 w-4 h-4 text-blue-600">
                            <label for="importerCheck"
                                class="ms-2 py-3 w-full font-medium text-gray-900 dark:text-gray-300 text-sm">Importer
                                des questions
                            </label>
                        </div>
                    </li>
                    <li class="border-gray-200 dark:border-gray-600 sm:border-r border-b sm:border-b-0 w-full">
                        <div class="flex items-center ps-3">
                            <input id="manuelCheck" type="radio" name="choice"
                                class="bg-gray-100 dark:bg-gray-600 border-gray-300 dark:border-gray-500 rounded focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700 dark:ring-offset-gray-700 w-4 h-4 text-blue-600">
                            <label for="manuelCheck"
                                class="ms-2 py-3 w-full font-medium text-gray-900 dark:text-gray-300 text-sm">Ajouter
                                une question et cochez la bonne réponse
                            </label>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="mr-5" style="padding-left: 20px; display: none;" id="divImporterQuestion">
                @csrf
                <input type="text" name="phase" id="phaseId" class="hidden">
                <p class="flex items-center mb-2 pl-1 font-medium text-gray-900 dark:text-white text-xl">Sélectionnez un
                    fichier CSV
                    (.csv) <button data-popover-target="popover-question" data-popover-placement="right"
                        type="button"><svg class="ms-2 w-5 h-5 text-gray-400 hover:text-gray-500" aria-hidden="true"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd"></path>
                        </svg><span class="sr-only">Show information</span></button></p>
                <div data-popover id="popover-question" role="tooltip"
                    class="invisible inline-block z-10 absolute bg-white dark:bg-gray-800 opacity-0 shadow-sm border border-gray-200 dark:border-gray-600 rounded-lg w-72 text-gray-500 dark:text-gray-400 text-sm transition-opacity duration-300">
                    <div class="space-y-2 p-3">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Details du fichier </h3>
                        <p>Pour importer des questions, veuillez télécharger ce modèle <br>Veuillez
                            cliquer <a href=""
                                class="font-medium text-blue-600 dark:text-blue-500 underline hover:no-underline"><strong class="text-xl"> ici</strong></a>
                            pour télécharger</p>
                    </div>
                    <div data-popper-arrow></div>
                </div>

                <input
                    class="block bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none w-full text-gray-900 dark:text-gray-400 text-xs cursor-pointer dark:placeholder-gray-400"
                    aria-describedby="file_input_help" id="fichierInput" type="file" name="fichier"
                    accept=".csv, .xlsx">
                <button type="submit"
                    class="inline-flex inline-flex items-center items-center bg-[#FF9119] hover:bg-[#FF9119]/80 dark:hover:bg-[#FF9119]/80 mt-4 sm:mt-6 px-4 px-5 py-2 py-2.5 rounded-lg focus:outline-none focus:ring-[#FF9119]/50 focus:ring-4 dark:focus:ring-[#FF9119]/40 font-medium font-medium text-white text-sm text-sm text-center text-center">Importer</button>
            </div>
            <div id="divManuelQuestion" style="display: none" class="m-5 mr-5" style="padding-left: 20px; margin:5px">

                <div class="mb-5">
                    <label for="questionInput"
                        class="block mb-2 font-medium text-gray-900 dark:text-white text-sm">Question</label>
                    <textarea id="questionInput" rows="5"
                        class="block bg-gray-50 dark:bg-gray-700 p-2.5 border border-gray-300 focus:border-blue-500 dark:border-gray-600 dark:focus:border-blue-500 rounded-lg focus:ring-blue-500 dark:focus:ring-blue-500 w-full text-gray-900 dark:text-white text-sm dynamic-input dark:placeholder-gray-400"
                        placeholder="Editer la question" name="question"></textarea>
                </div>
                <div id="" class="mb-5">
                    <label i for="ponderationQuestion"
                        class="block mb-2 font-medium text-gray-900 dark:text-white text-sm">Pondération</label>
                    <input type="number" id="ponderationQuestion" name="ponderation" max="99" min="0"
                        class="block bg-gray-50 dark:bg-gray-700 p-2.5 border border-gray-300 focus:border-blue-500 dark:border-gray-600 dark:focus:border-blue-500 rounded-lg focus:ring-blue-500 dark:focus:ring-blue-500 w-full text-gray-900 dark:text-white text-sm dark:placeholder-gray-400"
                        placeholder="0" />
                </div>

                <div id="dynamicForm" class="mb-5">
                    <div class="mb-5 input-container">
                        <label for="assertionInput1"
                            class="block mb-2 font-medium text-gray-900 dark:text-white text-sm">
                            Assertion 1
                            <input type="radio" name="bonneReponse" value="1"
                                class="bg-gray-100 dark:bg-gray-600 ml-5 border-gray-300 dark:border-gray-500 rounded-full focus:ring-2 focus:ring-green-500 dark:focus:ring-green-600 dark:focus:ring-offset-gray-700 dark:ring-offset-gray-700 w-4 h-4 text-green-600">
                        </label>
                        <textarea id="assertionInput1" rows="4"
                            class="block bg-gray-50 dark:bg-gray-700 p-2.5 border border-gray-300 focus:border-blue-500 dark:border-gray-600 dark:focus:border-blue-500 rounded-lg focus:ring-blue-500 dark:focus:ring-blue-500 w-full text-gray-900 dark:text-white text-sm dynamic-input dark:placeholder-gray-400"
                            placeholder="Editer l'assertion" name="assertions[1]"></textarea>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-4 sm:mt-6">
                    <button id="valider" type="submit"
                        class="inline-flex inline-flex items-center items-center bg-[#FF9119] hover:bg-[#FF9119]/80 dark:hover:bg-[#FF9119]/80 px-4 px-5 py-2.5 rounded-lg focus:outline-none focus:ring-[#FF9119]/50 focus:ring-4 dark:focus:ring-[#FF9119]/40 font-medium font-medium text-white text-sm text-sm text-center text-center">
                        Valider
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
<script>
    const formInsertQuestion = document.getElementById('formInsertQuestion');
    const divManuelQuestion = document.getElementById('divManuelQuestion');
    const divImporterQuestion = document.getElementById('divImporterQuestion');
    const importerCheckboxQuestion = document.getElementById('importerCheck');
    const manuelcCheckboxQuestion = document.getElementById('manuelCheck');
    const questionInput = document.getElementById('questionInput');
    const fichierInput = document.getElementById('fichierInput');
    const ponderationQuestion = document.getElementById('ponderationQuestion');
    const assertion1 = document.getElementById('assertionInput1');

    const actionImport = '';
    const actionManuel = '';

    const formInput = {};

    importerCheckboxQuestion.addEventListener('change', () => {
        if (importerCheckboxQuestion.checked) {

            divManuelQuestion.style.display = 'none';
            divImporterQuestion.style.display = 'block';
            formInsertQuestion.action = actionImport
            fichierInput.required = true;
            questionInput.required = false
            ponderationQuestion.required = false
            assertion1.required = false

            // console.log(formInput)
            // console.log(actionImport)
        }
    });

    manuelcCheckboxQuestion.addEventListener('change', () => {
        if (manuelcCheckboxQuestion.checked) {
            divImporterQuestion.style.display = 'none';
            divManuelQuestion.style.display = 'block';
            formInsertQuestion.action = actionManuel

            fichierInput.required = false;
            ponderationQuestion.required = true
            questionInput.required = true
            assertion1.required = true

            // console.log(formInput)
            // console.log(actionManuel)
        }
    });


    const form = document.getElementById('dynamicForm');

    form.addEventListener('input', function(event) {
        const inputs = document.querySelectorAll('.dynamic-input');
        const lastInput = inputs[inputs.length - 1];
        const num = inputs.length;


        if (lastInput.value !== '') {

            const newInputContainer = document.createElement('div');
            newInputContainer.className = "mb-5";
            newInputContainer.classList.add('input-container');

            const newInput = document.createElement('textarea');
            newInput.className =
                "block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500";
            newInput.classList.add('dynamic-input');
            newInput.placeholder = 'Saisir l"assertion ';
            newInput.name = `assertions[${num}]`
            newInput.rows = "4"

            const labelAssertion = document.createElement('label');
            labelAssertion.className = "block mb-2 text-sm font-medium text-gray-900 dark:text-white";
            labelAssertion.textContent = `Assertion ${num}`
            const radioReponse = document.createElement('input');
            radioReponse.type = 'radio';
            radioReponse.className =
                "w-4 h-4 ml-5 text-green-600 bg-gray-100 border-gray-300 rounded-full focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500";
            radioReponse.value = `${num}`;
            radioReponse.name = "bonneReponse";

            labelAssertion.appendChild(radioReponse);
            newInputContainer.appendChild(labelAssertion);
            newInputContainer.appendChild(newInput);
            form.appendChild(newInputContainer);
        }
    });
</script>
