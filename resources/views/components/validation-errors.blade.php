@props([
    'errors',
    'type' => 'red'
])

@if ($errors->any())
    <div class="bg-{{ $type }}-100 border-l-4 border-{{ $type }}-500 text-{{ $type }}-700 p-4 mx-8 my-2" role="alert">
        <p>
            <b>{{ count($errors) }}件のエラーがあります。</b>
        </p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
