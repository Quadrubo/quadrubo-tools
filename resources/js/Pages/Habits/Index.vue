<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

// import StatusIndicator from '@/Components/StatusIndicator.vue';
// import IndigoButton from '@/Components/IndigoButton.vue';

let props = defineProps({
    habits: Object,
    date_range: Object,
});

let completeHabit = ((id, day) => {
    router.post(route('habits.complete', {habit: id, day: day}));
});

let uncompleteHabit = ((id, day) => {
    router.post(route('habits.uncomplete', {habit: id, day: day}));
});

// let wakeComputer = ((id) => {
//     router.post(route('computers.wake', id));
// });

// let pingComputers = (() => {
//     router.post(route('computers.ping'));
// });

// let useComputer = ((id) => {
//     router.post(route('computers.use', id));
// });

let getRoundedClasses = ((key, length) => {
    let classes = "";

    if (key == 0) {
        classes += "rounded-tl-lg ";
    }

    if (key == length - 1) {
        classes += "rounded-b-lg ";
    }

    return classes;
});
</script>

<template>
    <AppLayout title="Habits">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Habits
            </h2>
            <!-- <IndigoButton @click="pingComputers">Refresh</IndigoButton> -->
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 m-auto">

                    <!-- Header -->
                    <div class="grid grid-cols-2">
                        <div></div>
                        <div class="flex flex-row justify-between grow bg-white rounded-t-lg shadow-sm text-lg py-2 px-4">
                            <div v-for="day in date_range" class="flex flex-col text-center">
                                <span>{{ day.D }}</span>
                                <span>{{ day.j }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Habits -->
                    <div v-for="habit, habit_key in habits" :key="habit_key" class="grid grid-cols-2 items-center bg-white shadow-sm text-xl" :class="getRoundedClasses(habit_key, habits.length)">
                        <div class="flex flex-row items-center space-x-2 p-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>


                            <div :style="'color: ' + habit.color + ';'">
                                {{ habit.name }}
                            </div>
                        </div>

                        <!-- Last 7 days -->
                        <div class="flex flex-row justify-between grow p-4">
                            <div v-for="day in habit.days">
                                <svg v-if="day.completed" @click="uncompleteHabit(habit.id, day.day)" class="text-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>      
                                <svg v-else @click="completeHabit(habit.id, day.day)" class="text-gray-900 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
