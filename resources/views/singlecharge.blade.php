<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Subscribe Page
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- <h3>{{dd($intent->client_secret)}}</h3> --}}
                    <!-- Display a payment form -->
                    <form id="payment-form" action="{{route('subscribe.post')}}" method="POST">
                        @csrf
                        <input id="card-holder-name" type="text">

                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element" class="py-6"></div>

                        <button type="button" class="bg-blue-500 px-4 py-2 text-white" id="card-button"
                            data-secret="{{ $intent->client_secret }}">
                            Single Charge Payment Method
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- @push('stripe') --}}

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe('pk_test_51KMQVJBNmFUisL09Al9sz3g4hSLghaKrPLj1uSn6gF3h7aLyphMfDuLOfyJYmYGIHDH0BAv2czra644kBgqHnoRm00ig5cNF8s');

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
           
            //* in single charge, id has to pass (follow docs)
            const { paymentMethod, error } = await stripe.createPaymentMethod(
                        'card', cardElement, {
                        billing_details: { name: cardHolderName.value }
                        }
                        );
            
            if (error) {
            // Display "error.message" to the user...
            } else {
            console.log(paymentMethod)
            console.log("success")
            
            axios.post('/singlecharge',{paymentMethodId:paymentMethod.id});
            }
        });
    </script>

    {{-- @endpush --}}
</x-app-layout>