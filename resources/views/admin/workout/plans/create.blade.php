@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __('Workout Plans') }}</title>
@endpush

@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'workout.plans.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Create Plan') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route(auth()->user()->roleName . 'workout.plans.index') }}">{{ __('Workout Plans') }}</a> &raquo;
                <a>{{ __('Create Plan') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 py-6" x-data="workoutWeeklyPlans()">
        <div>
            <form action="{{ route(auth()->user()->roleName . 'workout.plans.store') }}" id="createUserForm" method="post"
                class="m-auto block">
                @csrf
                <div class="max-w-2xl">
                    {{-- Name --}}
                    <div class="sm:col-span-3">
                        <x-input-label for="name" :value="__('Plan Name')" astrik />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="name" :value="__('Plan Description')" astrik />
                        <textarea id="message" rows="4" name="description"
                            class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
                            placeholder="Write description..."></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>
                <div class="mt-10 bg-white rounded-md text-sm px-4">
                    <div class="px-4 py-3 flex items-center justify-between border-b">
                        <h2 class="text-lg font-semibold">Add Weekly Workout Plans</h2>
                        <button x-show="weeks.length < 4" type="button" @click="addWeek()"
                            class="rounded-md bg-violet-50 px-2 border border-violet-400 py-2 text-sm font-semibold text-black shadow-sm hover:bg-violet-100 add-more-button">+
                            Add More</button>
                    </div>
                    <div class=" overflow-auto py-10">
                        <table class="w-full text-left ">
                            <thead>
                                <tr>
                                    <th class="p-2">Week No.</th>
                                    <th class="p-2">Monday</th>
                                    <th class="p-2">Tuesday</th>
                                    <th class="p-2">Wednesday</th>
                                    <th class="p-2">Thursday</th>
                                    <th class="p-2">Friday</th>
                                    <th class="p-2">Saturday</th>
                                    <th class="p-2">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(week,index) in weeks" :key="index">
                                    <tr>
                                        <td class="p-2" x-text="index+1"></td>
                                        <td class="p-2 max-w-48 space-y-2">
                                            <x-category-listing class="min-w-28 max-w-48" rest :categories="$categories" x-bind:id="`weekData_${index}_monday_id`"
                                                @change="selectExercise(`weekData_${index}_monday_id`,`weekData_${index}_monday_exercises`)"
                                                x-bind:name="`weekData[${index}][monday][id]`" />
                                            <x-exercise-listing :exercises="$exercises" class="hidden" x-init="initializeChoiceJs(`weekData_${index}_monday_exercises`)"
                                                x-bind:id="`weekData_${index}_monday_exercises`"
                                                x-bind:name="`weekData[${index}][monday][exercises][]`" multiple />
                                        </td>
                                        <td class="p-2 max-w-48 space-y-2">
                                            <x-category-listing class="min-w-28 max-w-48" rest :categories="$categories"
                                                x-bind:id="`weekData_${index}_tuesday_id`"
                                                @change="selectExercise(`weekData_${index}_tuesday_id`,`weekData_${index}_tuesday_exercises`)"
                                                x-bind:name="`weekData[${index}][tuesday][id]`" />
                                            <x-exercise-listing :exercises="$exercises" class="hidden" x-init="initializeChoiceJs(`weekData_${index}_tuesday_exercises`)"
                                                x-bind:id="`weekData_${index}_tuesday_exercises`"
                                                x-bind:name="`weekData[${index}][tuesday][exercises][]`" multiple />
                                        </td>
                                        <td class="p-2 max-w-48 space-y-2">
                                            <x-category-listing class="min-w-28 max-w-48" rest :categories="$categories"
                                                x-bind:id="`weekData_${index}_wednesday_id`"
                                                @change="selectExercise(`weekData_${index}_wednesday_id`,`weekData_${index}_wednesday_exercises`)"
                                                x-bind:name="`weekData[${index}][wednesday][id]`" />
                                            <x-exercise-listing :exercises="$exercises" class="hidden" x-init="initializeChoiceJs(`weekData_${index}_wednesday_exercises`)"
                                                x-bind:id="`weekData_${index}_wednesday_exercises`"
                                                x-bind:name="`weekData[${index}][wednesday][exercises][]`" multiple />
                                        </td>
                                        <td class="p-2 max-w-48 space-y-2">
                                            <x-category-listing class="min-w-28 max-w-48" rest :categories="$categories"
                                                x-bind:id="`weekData_${index}_thursday_id`"
                                                @change="selectExercise(`weekData_${index}_thursday_id`,`weekData_${index}_thursday_exercises`)"
                                                x-bind:name="`weekData[${index}][thursday][id]`" />
                                            <x-exercise-listing :exercises="$exercises" class="hidden" x-init="initializeChoiceJs(`weekData_${index}_thursday_exercises`)"
                                                x-bind:id="`weekData_${index}_thursday_exercises`"
                                                x-bind:name="`weekData[${index}][thursday][exercises][]`" multiple />
                                        </td>
                                        <td class="p-2 max-w-48 space-y-2">
                                            <x-category-listing class="min-w-28 max-w-48" rest :categories="$categories"
                                                x-bind:id="`weekData_${index}_friday_id`"
                                                @change="selectExercise(`weekData_${index}_friday_id`,`weekData_${index}_friday_exercises`)"
                                                x-bind:name="`weekData[${index}][friday][id]`" />
                                            <x-exercise-listing :exercises="$exercises" class="hidden" x-init="initializeChoiceJs(`weekData_${index}_friday_exercises`)"
                                                x-bind:id="`weekData_${index}_friday_exercises`"
                                                x-bind:name="`weekData[${index}][friday][exercises][]`" multiple />
                                        </td>
                                        <td class="p-2 max-w-48 space-y-2">
                                            <x-category-listing class="min-w-28 max-w-48" rest :categories="$categories"
                                                x-bind:id="`weekData_${index}_saturday_id`"
                                                @change="selectExercise(`weekData_${index}_saturday_id`,`weekData_${index}_saturday_exercises`)"
                                                x-bind:name="`weekData[${index}][saturday][id]`" />
                                            <x-exercise-listing :exercises="$exercises" class="hidden" x-init="initializeChoiceJs(`weekData_${index}_saturday_exercises`)"
                                                x-bind:id="`weekData_${index}_saturday_exercises`"
                                                x-bind:name="`weekData[${index}][saturday][exercises][]`" multiple />
                                        </td>
                                        <td class="p-2 max-w-48">
                                            <button type="button" @click="removeWeek(index)" type="button"
                                                class="rounded-md text-xs bg-violet-50 px-2 border border-violet-400 py-2 md:text-sm font-medium text-black shadow-sm hover:bg-violet-100 add-more-button ">-
                                                Remove</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <x-input-error :messages="$errors->get('weekData')" class="mt-2" />
                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route(auth()->user()->roleName . 'workout.plans.index') }}"
                        class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <x-primary-button>Submit</x-primary-button>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('script')
    <script>
        function workoutWeeklyPlans() {
            return {
                exercises: @js($exercises),
                weeks: [{
                    monday: null,
                    tuesday: null,
                    tuesday: null,
                    wednesday: null,
                    thursday: null,
                    friday: null,
                    saturday: null,
                }],
                addWeek() {
                    this.weeks.push({
                        monday: null,
                        tuesday: null,
                        tuesday: null,
                        wednesday: null,
                        thursday: null,
                        friday: null,
                        saturday: null,
                    });
                },
                removeWeek(index) {
                    this.weeks.splice(index, 1);
                },
                selectExercise(categoryId, exerciseId) {
                    var exerciseElement = document.getElementById(exerciseId);
                    var categoryElement = document.getElementById(categoryId);

                    if (categoryElement.value != '') {
                        exerciseElement.parentElement.classList.remove('hidden');
                    } else {
                        exerciseElement.parentElement.classList.add('hidden');
                    }
                },
                initializeChoiceJs(exerciseId) {
                    var exerciseElement = document.getElementById(exerciseId);
                    var choice = new Choices(exerciseElement, {
                        allowHTML: true,
                        removeItemButton: true,
                        itemSelectText: '',
                        position: 'down'
                    });

                    exerciseElement.parentElement.classList.add('hidden');
                }
            }
        }
    </script>
@endpush
