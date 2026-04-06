@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-gray-900 dark:text-gray-300 dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
