<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-ui btn-danger']) }}>
    {{ $slot }}
</button>
