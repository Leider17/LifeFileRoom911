<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Pagination from '@/components/ui/pagination/Pagination.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { Import, Search, X } from 'lucide-vue-next';
import { PropType, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Employees',
        href: '/employees/index',
    },
];

const props = defineProps({
    employees: Object,
    filters: Object,
    departments: Array as PropType<{ id: number; name: string }[]>,
});

const filters = ref({
    internal_id: props.filters?.id_number || '',
    first_name: props.filters?.name || '',
    last_name: props.filters?.lastname || '',
    department_id: props.filters?.department_id || '',
});
// apply filters
const applyFilters = () => {
    router.get(route('employee.index'), filters.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};
// clear filters
const clearFilters = () => {
    filters.value = {
        internal_id: '',
        first_name: '',
        last_name: '',
        department_id: '',
    };

    applyFilters();
};

// function to delete employee
const deleteEmployee = (id: number) => {
    if (confirm('Are you sure you want to delete this employee?')) {
        router.delete(route('employee.destroy', id));
    }
};
// import csv
const fileInput = ref(null);
const isUploading = ref(false);
const form = useForm<{
    file: File | null;
}>({
    file: null,
});

//function to handle csv file change
const handleFileChange = (e: Event) => {
    form.file = (e.target as HTMLInputElement).files?.[0] || null;
};

// function to submit csv file
const submitForm = () => {
    if (!form.file) {
        alert('select a csv file');
        return;
    }

    isUploading.value = true;

    form.post(route('employee.importCSV'), {
        preserveScroll: true,
        onSuccess: () => {
            if (fileInput.value) {
                fileInput.value = null;
            }
            form.reset();
            isUploading.value = false;
            alert('employees imported correctly');
        },
        onError: () => {
            isUploading.value = false;
            alert('error uploading csv');
        },
    });
};
</script>

<template>
    <Head title="Employees" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <h1 class="mb-6 text-2xl font-bold">Employees - ROOM_911 Access</h1>

            <!-- Filters -->
            <div class="mb-4 grid grid-cols-1 gap-4 text-white md:grid-cols-4">
                <Input v-model="filters.internal_id" placeholder="ID Number" />
                <Input v-model="filters.first_name" placeholder="Name" />
                <Input v-model="filters.last_name" placeholder="Last Name" />
                <select v-model="filters.department_id" class="rounded border bg-black px-3 py-2">
                    <option value="">All Departments</option>
                    <option v-for="dept in departments" :key="dept.id" :value="dept.id">
                        {{ dept.name }}
                    </option>
                </select>
                <Button @click="applyFilters" class="bg-blue-400 hover:bg-blue-700">Search<Search /></Button>
                <Button @click="clearFilters" class="bg-green-600 hover:bg-green-700">Clear filters<X /></Button>
            </div>

            <!-- employees table -->
            <div class="overflow-x-auto rounded-lg bg-white shadow">
                <table class="min-w-full text-left text-sm text-black">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Department</th>
                            <th class="px-4 py-2">Access</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="employee in employees?.data" :key="employee.id" v-if="employees && employees.data">
                            <td class="px-4 py-2">{{ employee.internal_id }}</td>
                            <td class="px-4 py-2">{{ employee.first_name }} {{ employee.last_name }}</td>
                            <td class="px-4 py-2">{{ employee.department.name }}</td>
                            <td class="px-4 py-2">
                                <span :class="employee.has_access ? 'text-green-600' : 'text-red-600'">
                                    {{ employee.has_access ? 'Granted' : 'Denied' }}
                                </span>
                            </td>
                            <td class="space-x-2 px-4 py-2">
                                <Link :href="route('employee.edit', employee.id)" class="text-blue-600 hover:underline">Edit</Link>
                                <Link :href="route('accessAttempt.history', employee.id)" class="text-gray-600 hover:underline">History</Link>
                                <Button @click="deleteEmployee(employee.id)" class="bg-transparent text-red-600 hover:underline">Delete</Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- pagination -->
            <Pagination :links="employees?.links" class="mt-4" />

            <div class="mt-2">
                <Button><Link :href="route('employee.create')">Create Employee </Link></Button>

                <form @submit.prevent="submitForm" >
                    <div class="mb-2 mt-4">
                        <Label for="csv-file" class="mb-1 block text-sm font-medium"> Select csv file</Label>
                        <Input
                            type="file"
                            id="csv-file"
                            ref="fileInput"
                            @change="handleFileChange"
                            class="block w-4/12 rounded-md border border-gray-300 p-2 text-sm"
                            accept=".csv, text/csv"
                        />
                        <InputError :message="form.errors.file" />
                    </div>

                    <div class="flex items-center">
                        <button
                            type="submit"
                            class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 flex gap-1"
                            :disabled="isUploading"
                        >
                            <span v-if="isUploading">Uploaded...</span>
                            <span v-else>Import CSV</span>
                            <Import />
                        </button>
                        <p v-if="isUploading" class="ml-3 text-sm text-gray-600">Please wait while the file is processed...</p>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
