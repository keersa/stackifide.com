<x-admin-layout>
    <x-admin-website-header :website="$website" title="Subscribe to {{ ucfirst($plan) }} Plan" />

    <div class="py-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white">{{ ucfirst($plan) }} Plan</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">${{ number_format($planPrice) }}/month</p>
                        </div>
                        <a href="{{ route('admin.websites.show', $website) }}" 
                           class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="p-8">
                    @if (session('error'))
                        <div class="mb-6 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form id="payment-form">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $plan }}">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        
                        <!-- Card Element container -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Card Information</label>
                            <div id="card-element" class="p-4 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                                <!-- Stripe Elements will create form elements here -->
                            </div>
                            <div id="card-errors" role="alert" class="mt-2 text-sm text-red-600 dark:text-red-400"></div>
                        </div>

                        <!-- Display error message -->
                        <div id="payment-errors" role="alert" class="hidden mb-4 text-sm text-red-600 dark:text-red-400"></div>

                        <!-- Submit button -->
                        <button type="submit" id="submit-button" 
                                class="w-full bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-3 px-4 rounded-lg transition">
                            <span id="button-text">Subscribe for ${{ number_format($planPrice) }}/month</span>
                            <span id="spinner" class="hidden">
                                <svg class="animate-spin h-5 w-5 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
                <p>Secure payment powered by Stripe</p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            const stripe = Stripe('{{ $stripeKey }}');
            const priceId = '{{ $priceId }}';
            const websiteId = {{ $website->id }};
            const plan = '{{ $plan }}';

            let elements;
            let cardElement;

            // Initialize Stripe Elements
            async function initialize() {
                try {
                    // Create card element
                    elements = stripe.elements({
                        appearance: {
                            theme: document.documentElement.classList.contains('dark') ? 'night' : 'stripe',
                        },
                    });

                    cardElement = elements.create('card', {
                        style: {
                            base: {
                                fontSize: '16px',
                                color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#1f2937',
                                '::placeholder': {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280',
                                },
                            },
                        },
                    });
                    cardElement.mount('#card-element');

                    // Handle real-time validation errors
                    cardElement.on('change', function(event) {
                        const displayError = document.getElementById('card-errors');
                        if (event.error) {
                            displayError.textContent = event.error.message;
                            displayError.classList.remove('hidden');
                        } else {
                            displayError.textContent = '';
                            displayError.classList.add('hidden');
                        }
                    });
                } catch (error) {
                    console.error('Error initializing Stripe Elements:', error);
                    showError('Failed to initialize payment form. Please refresh the page.');
                }
            }

            // Handle form submission
            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                
                setLoading(true);

                try {
                    // Create payment method from card details
                    const { error: pmError, paymentMethod } = await stripe.createPaymentMethod({
                        type: 'card',
                        card: cardElement,
                    });

                    if (pmError) {
                        showError(pmError.message);
                        setLoading(false);
                        return;
                    }

                    // Submit payment method to server
                    const response = await fetch('{{ route("admin.websites.subscriptions.store", $website) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                          document.querySelector('input[name="_token"]')?.value,
                        },
                        body: JSON.stringify({
                            plan: plan,
                            payment_method_id: paymentMethod.id,
                        }),
                    });

                    // Check content type before parsing
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await response.text();
                        console.error('Server returned non-JSON:', text.substring(0, 200));
                        showError('Server returned an invalid response. Please check the console for details.');
                        setLoading(false);
                        return;
                    }

                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({ error: `HTTP error! status: ${response.status}` }));
                        throw new Error(errorData.error || `HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.error) {
                        showError(data.error);
                        setLoading(false);
                    } else if (data.client_secret) {
                        // Always confirm the payment intent, even if it doesn't require action
                        // This is necessary for incomplete subscriptions to become active
                        const { error: confirmError, paymentIntent } = await stripe.confirmCardPayment(data.client_secret);
                        
                        if (confirmError) {
                            showError(confirmError.message);
                            setLoading(false);
                        } else if (paymentIntent) {
                            // Payment intent confirmed - now confirm with backend
                            const confirmResponse = await fetch('{{ route("admin.websites.subscriptions.confirm", $website) }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                                  document.querySelector('input[name="_token"]')?.value,
                                },
                                body: JSON.stringify({
                                    payment_intent_id: paymentIntent.id,
                                    subscription_id: data.subscription_id,
                                }),
                            });

                            if (!confirmResponse.ok) {
                                const errorData = await confirmResponse.json().catch(() => ({ error: 'Confirmation failed' }));
                                showError(errorData.error || 'Failed to confirm subscription');
                                setLoading(false);
                                return;
                            }

                            const confirmData = await confirmResponse.json();
                            
                            if (confirmData.error) {
                                showError(confirmData.error);
                                setLoading(false);
                            } else {
                                // Success - redirect
                                window.location.href = '{{ route("admin.websites.show", $website) }}';
                            }
                        } else {
                            showError('Payment confirmation failed. Please try again.');
                            setLoading(false);
                        }
                    } else {
                        showError('Invalid response from server');
                        setLoading(false);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showError(error.message || 'An unexpected error occurred. Please try again.');
                    setLoading(false);
                }
            });

            function showError(message) {
                const errorElement = document.getElementById('payment-errors');
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
            }

            function setLoading(isLoading) {
                const submitButton = document.getElementById('submit-button');
                const buttonText = document.getElementById('button-text');
                const spinner = document.getElementById('spinner');
                
                if (isLoading) {
                    submitButton.disabled = true;
                    buttonText.classList.add('hidden');
                    spinner.classList.remove('hidden');
                } else {
                    submitButton.disabled = false;
                    buttonText.classList.remove('hidden');
                    spinner.classList.add('hidden');
                }
            }

            // Initialize on page load
            initialize();
        </script>
    @endpush
</x-admin-layout>
