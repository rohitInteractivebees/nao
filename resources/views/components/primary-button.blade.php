<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'common-btn red']) }}>
    {{ $slot }}
</button>
