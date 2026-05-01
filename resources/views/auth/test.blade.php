<x-modal name="addNewCard">
    <x-slot name="title">
        <h1 class="flex items-center text-2xl font-bold text-gray-800">
            <img src="./img/payment-card.png" class="mt-2" alt="payment">
            <span class="block ml-3"> {{ __('payment.payment_method') }}</span>
        </h1>
    </x-slot>
    <x-slot name="body">
        <div class="-mx-4 -mt-6">
            <div>
                <h2 class="mb-6 text-xl font-bold text-black"> {{ __('payment.add_card') }}</h2>
                <p class="text-sm text-black">
                     {{ __('payment.add_card_1') }}
                    {{ ' ' . __('payment.add_card_2') }}
                </p>
                <div class="mt-8">
                    <img src="img/cards.png" alt="card">
                </div>
                <div class="mt-6">
                    <form method="POST" x-data="paymentMethod()" id="paymentMethod" @submit="submit" autocomplete="off" action="{{ route('savepaymentMethod') }}">
                        @csrf
						<div class="relative mb-6 floating-input">
                            <input type="text" class="w-full h-12 p-3 text-sm font-medium border-2 rounded border-finlendia-base placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-finlendia-base focus:border-transparent"  name="first_name" id="first_name" x-bind:class="{'invalid':first_name.errorMessage && first_name.blurred}" @blur="blur" @input="input" data-rules='["required"]' autocomplete="none" onfocus="this.setAttribute('autocomplete', 'none');">
                            <label for="name" class="absolute top-0 left-0 h-full px-3 py-3 font-medium transition-all duration-100 ease-in-out origin-left transform pointer-events-none text-finlendia-base">
                                 {{ __('payment.first_name') }}
                            </label>
							<p x-cloak x-show="first_name.errorMessage && first_name.blurred" x-text="first_name.errorMessage" class="flex items-center mt-1 ml-1 text-xs font-medium tracking-wide text-red-500"></p>
                        </div>
                        <div class="relative mb-6 floating-input">
                            <input type="text" class="w-full h-12 p-3 text-sm font-medium border-2 rounded border-finlendia-base placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-finlendia-base focus:border-transparent" name="last_name" id="last_name" x-bind:class="{'invalid':last_name.errorMessage && last_name.blurred}" @blur="blur" @input="input" data-rules='["required"]' autocomplete="none" onfocus="this.setAttribute('autocomplete', 'none');">
                            <label for="last-name" class="absolute top-0 left-0 h-full px-3 py-3 font-medium transition-all duration-100 ease-in-out origin-left transform pointer-events-none text-finlendia-base">
                                {{ __('payment.last_name') }}
                            </label>
							<p x-cloak x-show="last_name.errorMessage && last_name.blurred" x-text="last_name.errorMessage" class="flex items-center mt-1 ml-1 text-xs font-medium tracking-wide text-red-500"></p>
                        </div>

						<input type="hidden" name="payment" id="payment_id" class="form-control">
						<div class="p-0 col-sm-12">
                            <div id="card-element" class="w-full h-12 p-3 text-sm font-medium border-2 border-finlendia-base rounded placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-finlendia-base focus:border-transparent"></div>

							<div id="payment-result" class="font-medium text-red-500 text-xs"></div>
						</div>

                        <div class="m-4">
                            <h2 class="text-lg font-bold text-black">
                                 {{ __('payment.bill_address') }}
                            </h2>
                        </div>
                        <div class="relative flex-auto mb-4 floating-input">
                            <input type="text" class="w-full h-12 p-3 text-sm font-medium border-2 rounded border-finlendia-base placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-finlendia-base focus:border-transparent" name="address1" id="address1" x-bind:class="{'invalid':address1.errorMessage && address1.blurred}" @blur="blur" @input="input" data-rules='["required"]' autocomplete="none" onfocus="this.setAttribute('autocomplete', 'none');">
                            <label for="last-name" class="absolute top-0 left-0 h-full px-3 py-3 font-medium transition-all duration-100 ease-in-out origin-left transform pointer-events-none text-finlendia-base">
                                 {{ __('payment.address') }} 1
                            </label>
							<p x-cloak x-show="address1.errorMessage && address1.blurred" x-text="address1.errorMessage" class="flex items-center mt-1 ml-1 text-xs font-medium tracking-wide text-red-500"></p>
                        </div>
                        <div class="relative flex-auto mb-4 floating-input">
                            <input type="text" class="w-full h-12 p-3 text-sm font-medium border-2 rounded border-finlendia-base placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-finlendia-base focus:border-transparent" name="address2" id="address2">
                            <label for="last-name" class="absolute top-0 left-0 h-full px-3 py-3 font-medium transition-all duration-100 ease-in-out origin-left transform pointer-events-none text-finlendia-base">
                                 {{ __('payment.address') }} 2
                            </label>

                        </div>
                        <div class="flex">
                            <div class="relative flex-auto mb-4 mr-2 floating-input">
                                <input type="text" class="w-full h-12 p-3 text-sm font-medium border-2 rounded border-finlendia-base placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-finlendia-base focus:border-transparent" name="city" id="city" x-bind:class="{'invalid':city.errorMessage && city.blurred}" @blur="blur" @input="input" data-rules='["required"]' autocomplete="none" onfocus="this.setAttribute('autocomplete', 'none');">
                                <label for="last-name" class="absolute top-0 left-0 h-full px-3 py-3 font-medium transition-all duration-100 ease-in-out origin-left transform pointer-events-none text-finlendia-base">
                                    {{ __('payment.city') }}
                                </label>
								<p x-cloak x-show="city.errorMessage && city.blurred" x-text="city.errorMessage" class="flex items-center mt-1 ml-1 text-xs font-medium tracking-wide text-red-500"></p>
                            </div>
                            <div class="relative flex-auto mb-4 floating-input">
                                <input type="text" class="w-full h-12 p-3 text-sm font-medium border-2 rounded border-finlendia-base placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-finlendia-base focus:border-transparent" name="zip" id="zip" x-bind:class="{'invalid':zip.errorMessage && zip.blurred}" @blur="blur" @input="input" data-rules='["required"]' autocomplete="none" onfocus="this.setAttribute('autocomplete', 'none');">
                                <label for="last-name" class="absolute top-0 left-0 h-full px-3 py-3 font-medium transition-all duration-100 ease-in-out origin-left transform pointer-events-none text-finlendia-base">
                                {{ __('payment.zip_code') }}
                                </label>
								<p x-cloak x-show="zip.errorMessage && zip.blurred" x-text="zip.errorMessage" class="flex items-center mt-1 ml-1 text-xs font-medium tracking-wide text-red-500"></p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="relative flex-auto mb-4 mr-2 floating-input">
                                <select  class="w-full h-12 px-3 py-2 text-sm font-medium border-2 rounded-md border-finlendia-base placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-finlendia-base focus:border-transparent" name="country" id="country" x-bind:class="{'invalid':country.errorMessage && country.blurred}" @blur="blur" @input="input" data-rules='["required"]' autocomplete="none">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->sortname }}" :selected="selectedCard?.billing_address?.country == `{{ $country->name }}`">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <label for="last-name" class="absolute top-0 left-0 h-full px-3 py-3 font-medium transition-all duration-100 ease-in-out origin-left transform pointer-events-none text-finlendia-base">
                                     {{ __('payment.country') }}
                                </label>
								<p x-cloak x-show="country.errorMessage && country.blurred" x-text="country.errorMessage" class="flex items-center mt-1 ml-1 text-xs font-medium tracking-wide text-red-500"></p>
                            </div>
                            <div class="relative flex-auto mb-4 floating-input">
                                <input type="text" class="w-full h-12 p-3 text-sm font-medium border-2 rounded border-finlendia-base placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-finlendia-base focus:border-transparent" name="state" id="state" x-bind:class="{'invalid':state.errorMessage && state.blurred}" @blur="blur" @input="input" data-rules='["required"]' autocomplete="none" onfocus="this.setAttribute('autocomplete', 'none');">
                                <label for="last-name" class="absolute top-0 left-0 h-full px-3 py-3 font-medium transition-all duration-100 ease-in-out origin-left transform pointer-events-none text-finlendia-base">
                                    {{ __('payment.state') }}
                                </label>
								<p x-cloak x-show="state.errorMessage && state.blurred" x-text="state.errorMessage" class="flex items-center mt-1 ml-1 text-xs font-medium tracking-wide text-red-500"></p>
                            </div>
						</div>
						<button type="submit" class="w-full p-3 font-medium text-white rounded-md bg-finlendia-base hover:bg-finlendia-dark"> {{ __('payment.add_card') }} </button>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-modal>
@push('scripts')
    <script>
        function paymentMethod(){
        Iodine.setErrorMessages({ required: `[FIELD] is required`});
            return {
                first_name: {errorMessage:'', blurred:false},
                last_name: {errorMessage:'', blurred:false},
                // card: {errorMessage:'', blurred:false},
                // month: {errorMessage:'', blurred:false},
                // cvv: {errorMessage:'', blurred:false},
                address1: {errorMessage:'', blurred:false},
                city: {errorMessage:'', blurred:false},
                zip: {errorMessage:'', blurred:false},
                country: {errorMessage:'', blurred:false},
                state: {errorMessage:'', blurred:false},
                blur: function(event) {
                    let ele = event.target;
                    this[ele.name].blurred = true;
                    let rules = JSON.parse(ele.dataset.rules)
                    this[ele.name].errorMessage = this.getErrorMess(ele.value, rules, ele.getAttribute('name'));
                },
                input: function(event) {
                    let ele = event.target;
                    let rules = JSON.parse(ele.dataset.rules)
                    this[ele.name].errorMessage = this.getErrorMess(ele.value, rules, ele.getAttribute('name'));
                },
                submit: function (event) {
                event.preventDefault();
                // return false;
                let inputs = [...this.$el.querySelectorAll("input[data-rules]")];
                let hasErrors = false;
                inputs.map((input) => {
                    if (Iodine.is(input.value, JSON.parse(input.dataset.rules)) !== true) {
                        let rules = JSON.parse(input.dataset.rules)
                        this[input.name].errorMessage = this.getErrorMess(input.value, rules, input.getAttribute('name'));
                        this[input.name].blurred = true;
                        hasErrors = true;
                    }
                });
                if(!hasErrors){
                    stripe.createPaymentMethod({
                        type: 'card',
                        card: cardElement,
                        billing_details:{
                            address:{
                                line1: document.getElementById('address1').value,
                                line2: document.getElementById('address2').value,
                                city: document.getElementById('city').value,
                                state: document.getElementById('state').value,
                                postal_code: document.getElementById('zip').value,
                                country: document.getElementById('country').value,
                            },
                            name: document.getElementById('first_name').value+' '+document.getElementById('last_name').value
                        }
                    }).then(handlePaymentMethodResult);
                }
            },
            getErrorMess: function (value, rules, name) {
                let isValid = Iodine.is(value, rules);
                if (isValid !== true) {
                    const capitalizedName = name => name.charAt(0).toUpperCase() + name.slice(1)
                    return Iodine.getErrorMessage(isValid, {
                        field: capitalizedName(name).replace('_', ' ')
                    });
                }
                return '';
            }
        }
        }
    </script>
@endpush
