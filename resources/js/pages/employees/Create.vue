<script setup lang="ts">
import EmployeeForm from '@/components/EmployeeForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({ departments: Array });

const form = useForm({
    internal_id: '',
    first_name: '',
    last_name: '',
    department_id: '',
    has_access: true,
});

//create employee
function submit() {
    form.post(route('employee.store'));
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Employees',
        href: '/employees/index',
    },
    {
        title: 'Create employee',
        href: '/employees/create',
    }
];
</script>

<template>
    <Head title="Create employee" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-full rounded-lg bg-white p-6 shadow dark:bg-background flex flex-col items-center justify-center h-screen">
            <h1 class="mb-4 text-2xl font-bold text-gray-800 dark:text-white">Employee Register</h1>
            <EmployeeForm :form="form" :departments="departments" :on-submit="submit" />
        </div>
    </AppLayout>
</template>
