<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'common-btn short']) }}>
    {{ $slot }}
</button>
