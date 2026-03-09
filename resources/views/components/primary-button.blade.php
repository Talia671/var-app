<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-ui btn-primary']) }}>
    {{ $slot }}
</button>
