@props(['value'])

<label {{ $attributes->merge(['class' => 'fieldset-legend']) }}>
    {{ $value ?? $slot }}
</label>
