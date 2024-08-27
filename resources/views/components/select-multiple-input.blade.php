@props(['options' => [], 'multiple' => true, 'disabled' => false, 'value' => []])

<select
    {{ $multiple ? 'multiple' : '' }}
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}
>
    @foreach ($options as $optionsValue => $optionsLabel)
        <option
            value="{{ $optionsValue }}"
            {{ in_array($optionsValue, (array) $value) ? 'selected' : '' }}>
            {{ $optionsLabel }}
        </option>
    @endforeach
</select>