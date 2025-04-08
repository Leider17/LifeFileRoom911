<script setup lang="ts">
import EmployeeForm from '@/components/EmployeeForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({ employee: Object, departments: Array });

const form = useForm({
    internal_id: props.employee?.internal_id,
    first_name: props.employee?.first_name,
    last_name: props.employee?.last_name,
    department_id: props.employee?.department_id,
    has_access:Boolean( props.employee?.has_access),
});
onMounted(() => {
  console.log('Props employee:', props.employee);
  console.log('Form data:', form);
});
function submit() {
    form.put(route('employee.update',props.employee?.id));
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Employees',
        href: '/employees/index',
    },
    {
        title: 'Edit employee',
        href: '/employees/edit/'+props.employee?.id,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-screen w-full flex-col items-center justify-center rounded-lg bg-white p-6 shadow dark:bg-background">
            <h1 class="mb-4 text-2xl font-bold text-gray-800 dark:text-white">Employee Edit</h1>
            <EmployeeForm :form="form" :departments="departments" :on-submit="submit" />
        </div>
    </AppLayout>
</template>
