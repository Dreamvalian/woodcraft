@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'required' => false,
    'autocomplete' => null,
    'placeholder' => null,
    'help' => null,
    'error' => null
])

<div class="space-y-1">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-wood-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            @if($required) required @endif
            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            {{ $attributes->merge([
                'class' => 'block w-full rounded-lg border-wood-300 shadow-sm focus:border-wood-500 focus:ring-wood-500 sm:text-sm transition-colors duration-200 ' . 
                          ($error ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : '')
            ]) }}
        >

        @if($error)
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
        @endif
    </div>

    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif

    @if($help)
        <p class="mt-1 text-sm text-wood-500">{{ $help }}</p>
    @endif
</div>

@push('scripts')
<script>
    // Add custom validation patterns
    const patterns = {
        email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
        phone: /^\+?[\d\s-]{10,}$/,
        password: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$/,
        url: /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/
    };

    // Add custom validation messages
    const messages = {
        email: 'Please enter a valid email address',
        phone: 'Please enter a valid phone number',
        password: 'Password must be at least 8 characters and include both letters and numbers',
        url: 'Please enter a valid URL'
    };

    // Extend the validation function
    document.addEventListener('alpine:init', () => {
        Alpine.data('formInput', () => ({
            validate() {
                const input = this.$refs.input;
                const type = input.type;
                
                if (patterns[type] && !patterns[type].test(input.value)) {
                    this.error = messages[type];
                    return false;
                }
                
                return this.validate();
            }
        }));
    });
</script>
@endpush 