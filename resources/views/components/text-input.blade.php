@props(['disabled' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' => 'w-full px-4 py-3 rounded-xl border text-sm transition-colors outline-none focus:ring-2 focus:ring-offset-1 placeholder-gray-400 ' .
                   ($errors->has($attributes->get('name'))
                       ? 'border-red-400 bg-red-50 focus:ring-red-300'
                       : 'border-gray-200 bg-white focus:border-emerald-700 focus:ring-emerald-200')
    ]) !!}
    style="{{ $errors->has($attributes->get('name')) ? 'border-color: #DC2626;' : 'border-color: #E5E7EB;' }}"
>
