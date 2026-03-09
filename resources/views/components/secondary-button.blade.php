<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn-ui btn-secondary']) }}>
    {{ $slot }}
</button>
