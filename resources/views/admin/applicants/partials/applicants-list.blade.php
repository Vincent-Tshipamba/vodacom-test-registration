<div class="p-4 overflow-x-auto">
    <table id="applicants-table" class="w-full whitespace-nowrap display" width="100%">
        <!-- Table header -->
        <thead>
            <tr class="bg-gray-50 dark:bg-gray-700 dark:border-gray-600 border-b">
                <th
                    class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">
                    Nom
                </th>
                <th
                    class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">
                    Prénom
                </th>
                <th
                    class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">
                    Téléphone
                </th>
                <th
                    class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">
                    Statut
                </th>
                <th
                    class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <!-- Table body will be loaded via AJAX -->
        <tbody id="applicantsTableBody" class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($listApplicants as $applicant)
                <tr>
                    <td class="px-6 py-4 text-gray-900 dark:text-white text-sm whitespace-nowrap">
                        {{ $applicant->last_name }}
                    </td>
                    <td class="px-6 py-4 text-gray-900 dark:text-white text-sm whitespace-nowrap">
                        {{ $applicant->first_name }}
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-300 text-sm whitespace-nowrap">
                        {{ $applicant->phone_number }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $applicant->application_status === 'ADMITTED' ? 'bg-green-200 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ __("status.$applicant->application_status") }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-sm whitespace-nowrap">
                        <a href="{{ route('admin.applicants.show', ['applicant' => $applicant->id, 'locale' => app()->getLocale()]) }}"
                            class="mr-3 text-blue-600 hover:text-blue-900">Voir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
