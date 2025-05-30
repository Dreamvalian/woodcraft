@props([
    'type' => 'text',
    'name',
    'label',
    'value' => '',
    'required' => false,
    'min' => null,
    'max' => null,
    'pattern' => null,
    'error' => null,
    'help' => null
])

<div x-data="{ 
    value: @entangle($attributes->wire('model')),
    error: @entangle($attributes->wire('error')),
    validate() {
        if (this.$refs.input.validity.valid) {
            this.error = null;
            return true;
        }
        
        if (this.$refs.input.validity.valueMissing) {
            this.error = '{{ $label }} is required';
        } else if (this.$refs.input.validity.tooShort) {
            this.error = '{{ $label }} must be at least {{ $min }} characters';
        } else if (this.$refs.input.validity.tooLong) {
            this.error = '{{ $label }} must be at most {{ $max }} characters';
        } else if (this.$refs.input.validity.patternMismatch) {
            this.error = '{{ $label }} format is invalid';
        } else if (this.$refs.input.validity.typeMismatch) {
            this.error = '{{ $label }} must be a valid {{ $type }}';
        }
        
        return false;
    }
}" class="form-group">
    <label 
        for="{{ $name }}" 
        class="block text-sm font-medium text-gray-700 mb-1"
    >
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <div class="relative">
        @if($type === 'textarea')
            <textarea
                id="{{ $name }}"
                name="{{ $name }}"
                x-ref="input"
                x-model="value"
                @blur="validate()"
                {{ $required ? 'required' : '' }}
                {{ $min ? "minlength=$min" : '' }}
                {{ $max ? "maxlength=$max" : '' }}
                {{ $pattern ? "pattern=$pattern" : '' }}
                class="block w-full rounded-md shadow-sm transition duration-150 ease-in-out
                    {{ $error ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-wood focus:ring-wood' }}
                    sm:text-sm"
                {{ $attributes->whereDoesntStartWith('wire:') }}
            >{{ $value }}</textarea>
        @else
            <input
                type="{{ $type }}"
                id="{{ $name }}"
                name="{{ $name }}"
                x-ref="input"
                x-model="value"
                @blur="validate()"
                value="{{ $value }}"
                {{ $required ? 'required' : '' }}
                {{ $min ? "minlength=$min" : '' }}
                {{ $max ? "maxlength=$max" : '' }}
                {{ $pattern ? "pattern=$pattern" : '' }}
                class="block w-full rounded-md shadow-sm transition duration-150 ease-in-out
                    {{ $error ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-wood focus:ring-wood' }}
                    sm:text-sm"
                {{ $attributes->whereDoesntStartWith('wire:') }}
            >
        @endif

        @if($error)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <i class="fas fa-exclamation-circle text-red-500"></i>
            </div>
        @endif
    </div>

    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif

    @if($help)
        <p class="mt-1 text-sm text-gray-500">{{ $help }}</p>
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