<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});
</script>

<template>
    <Head title="Notepad: Welcome" />

    <div class="flex bg-white dark:bg-gray-900" style="height: 100vh;">
        <div class="mx-auto my-auto flex flex-col px-16" v-if="canLogin">
            <Link 
                v-if="$page.props.auth.user"
                :href="route('dashboard')" 
                class="py-2 px-16 text-center rounded-md mx-4 my-4 bg-transparent hover:shadow-md hover:bg-gray-600 text-gray-800 hover:text-white dark:text-white dark:hover:text-gray-900 dark:hover:bg-gray-100"
            >
                <div
                    class="text-2xl font-semibold focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >
                    Dashboard
                </div>
            </Link>
            <Link 
                v-if="!$page.props.auth.user"
                :href="route('login')" 
                class="py-2 px-16 text-center rounded-md mx-4 my-4 bg-transparent hover:shadow-md hover:bg-gray-600 text-gray-800 hover:text-white dark:text-white dark:hover:text-gray-900 dark:hover:bg-gray-100"
            >
                <div
                    class="text-2xl font-semibold focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >
                    Log in
                </div>
            </Link>
            <Link 
                v-if="canRegister && !$page.props.auth.user"
                :href="route('register')"
                class="py-2 px-16 text-center rounded-md mx-4 my-4 bg-transparent hover:shadow-md hover:bg-gray-600 text-gray-800 hover:text-white dark:text-white dark:hover:text-gray-900 dark:hover:bg-gray-100"
            >
                <div
                    class="text-2xl font-semibold focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >
                    Register
                </div>
            </Link>
        </div>
    </div>
    
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
