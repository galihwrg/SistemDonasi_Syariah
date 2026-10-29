@props(['messages'])

@if ($messages)
    <ul class="space-y-1">
        @foreach ((array) $messages as $message)
            <li class="text-sm" style="color: #DC2626;">{{ $message }}</li>
        @endforeach
    </ul>
@endif
