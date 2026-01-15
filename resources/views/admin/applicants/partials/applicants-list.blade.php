<div class="overflow-x-auto">
    <table id="applicants-table" class="w-full whitespace-nowrap">
        <!-- Table header -->
        <thead>
            <tr class="bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600">
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Nom
                </th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Prénom
                </th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Téléphone
                </th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Statut
                </th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <!-- Table body will be loaded via AJAX -->
        <tbody id="applicantsTableBody" class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($listApplicants as $applicant)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                        {{ $applicant->last_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                        {{ $applicant->first_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ $applicant->phone_number }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $applicant->status === 'Présent' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $applicant->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.applicants.show', ['applicant' => $applicant->id, 'locale' => app()->getLocale()]) }}"
                            class="text-blue-600 hover:text-blue-900 mr-3">Voir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
