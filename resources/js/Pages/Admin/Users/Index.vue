<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <user-new></user-new>
                <user-list :users="users"></user-list>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import UserNew from './UserNew'
    import UserList from './UserList'
    export default {
        props: [
            'users',
        ],
        components: {
            AppLayout,
            JetSectionBorder,
            UserNew,
            UserList,
        },
    }
</script>