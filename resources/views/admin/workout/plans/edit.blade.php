@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Members') }}</title>
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
            <span>{{ __('Edit Plan') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route(auth()->user()->roleName . 'workout.plans.index') }}">{{ __('Workout Plans') }}</a> &raquo;
                <a>{{ __('Edit Plan') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 py-6" x-data="workoutWeeklyPlans()">
        <div>
            <form action="{{ route(auth()->user()->roleName . 'workout.plans.update', $plan) }}" id="createUserForm"
                method="post" class="m-auto block">
                @csrf
                @method('PUT')
                <div class="max-w-2xl">
                    {{-- Name --}}
                    <div class="sm:col-span-3">
                        <x-input-label for="name" :value="__('Plan Name')" astrik />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="$plan->name" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="name" :value="__('Plan Description')" astrik />
                        <textarea id="message" rows="4" name="description"
                            class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
                            placeholder="Write description...">{{ $plan->description }}</textarea>
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
                                        <td class="p-2" x-text="`Week ${index + 1}`"></td>
                                        <template x-for="(day,key) in week" :key="key">
                                            <td class="p-2 max-w-48 space-y-2">
                                                <input type="hidden" x-bind:name="`weekData[${index}][${day.day}][id]`"
                                                    x-model="day.id">
                                                <x-category-listing class="min-w-28 max-w-48" rest :categories="$categories"
                                                    x-bind:id="`weekData_${index}_${day.day}_category_id`"
                                                    @change="selectExercise(`weekData_${index}_${day.day}_category_id`,`weekData_${index}_${day.day}_exercises`)"
                                                    x-bind:name="`weekData[${index}][${day.day}][category_id]`"
                                                    x-model="day.category_id" />
                                                <x-exercise-listing :exercises="$exercises" x-init="initializeChoiceJs(`weekData_${index}_${day.day}_exercises`, day.exercises)"
                                                    x-bind:id="`weekData_${index}_${day.day}_exercises`"
                                                    x-bind:name="`weekData[${index}][${day.day}][exercises][]`" multiple />
                                            </td>
                                        </template>
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
            planData = @json($plan->weekData->groupBy('week_number'));
            var result = Object.values(planData);
            return {
                weeks: (result.length > 0) ? result : [{
                        day: 'monday',
                        category: null,
                        exercises: [
                            [{
                                name: null
                            }]
                        ]
                    },
                    {
                        day: 'tuesday',
                        category: null,
                        exercises: [
                            [{
                                name: null
                            }]
                        ]
                    },
                    {
                        day: 'wednesday',
                        category: null,
                        exercises: [
                            [{
                                name: null
                            }]
                        ]
                    },
                    {
                        day: 'thursday',
                        category: null,
                        exercises: [
                            [{
                                name: null
                            }]
                        ]
                    },
                    {
                        day: 'friday',
                        category: null,
                        exercises: [
                            [{
                                name: null
                            }]
                        ]
                    },
                    {
                        day: 'saturday',
                        category: null,
                        exercises: [
                            [{
                                name: null
                            }]
                        ]
                    }
                ],
                addWeek() {
                    this.weeks.push([
                        {
                            day: 'monday',
                            category: null,
                            exercises: [
                                [{
                                    name: null
                                }]
                            ]
                        },
                        {
                            day: 'tuesday',
                            category: null,
                            exercises: [
                                [{
                                    name: null
                                }]
                            ]
                        },
                        {
                            day: 'wednesday',
                            category: null,
                            exercises: [
                                [{
                                    name: null
                                }]
                            ]
                        },
                        {
                            day: 'thursday',
                            category: null,
                            exercises: [
                                [{
                                    name: null
                                }]
                            ]
                        },
                        {
                            day: 'friday',
                            category: null,
                            exercises: [
                                [{
                                    name: null
                                }]
                            ]
                        },
                        {
                            day: 'saturday',
                            category: null,
                            exercises: [
                                [{
                                    name: null
                                }]
                            ]
                        }
                    ]);
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
                initializeChoiceJs(exerciseId, exercises) {
                    var exerciseElement = document.getElementById(exerciseId);
                    var permittedValues = new Array();
                    for (i = 0; i < exercises.length; i++) {
                        permittedValues[i] = exercises[i]["id"];
                    }

                    permittedValues.forEach(value => {
                        const option = exerciseElement.querySelector(`option[value="${value}"]`);
                        if (option) {
                            option.selected = true;
                        }
                    });

                    // initialize Choice js
                    var choices = new Choices(exerciseElement, {
                        allowHTML: true,
                        removeItemButton: true,
                        itemSelectText: '',
                        position: 'down'
                    });

                    if (exerciseElement.value == '') {
                        exerciseElement.parentElement.classList.add('hidden');
                    }
                }
            }
        }
    </script>
@endpush
