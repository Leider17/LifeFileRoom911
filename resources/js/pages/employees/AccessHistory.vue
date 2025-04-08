<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Pagination from '@/components/ui/pagination/Pagination.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Search, X } from 'lucide-vue-next';

const props = defineProps({
    employee: Object,
    history: Object,
});
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Employees',
        href: '/employees/index',
    },
    {
        title: 'History',
        href: '/employees/accessHistory/'+props.employee?.id,
    }
];


interface Filters {
    from: string;
    to: string;
}
const filters = ref({
    from: new URLSearchParams(window.location.search).get('from') || '',
    to: new URLSearchParams(window.location.search).get('to') || '',
});

// apply filters
function applyFilters() {
    router.get(route('accessAttempt.history', props.employee?.id), filters.value, {
        preserveState: true,
        preserveScroll: true,
    });
}

// clear filters
const clearFilters = () => {
    filters.value = {
        from: '',
        to: '',
    };

    applyFilters();
};

// format date
function formatDate(dateString: string | null): string {
    if (!dateString) return '';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
    }).format(date);
}

// download pdf
const downloadPdf=()=> {

      let url = route('accessAttempt.downloadPdf', { employee: props.employee?.id });
      if (filters.value.from && filters.value.to) {
        url += `?from=${filters.value.from}&to=${filters.value.to}`;
      }
      window.location.href = url;
    }

</script>

<template>
    <Head title="History" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4 p-6">
            <h1 class="text-2xl font-bold">{{ employee?.first_name }} {{ employee?.last_name }} access history</h1>

            <!-- Filters -->
            <div class="flex items-end gap-4">
                <div>
                    <label class="block text-sm font-medium">From</label>
                    <Input type="date" v-model="filters.from" class="w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium">To</label>
                    <Input type="date" v-model="filters.to" class="w-full" />
                </div>

                <Button @click="applyFilters" class="bg-blue-400 hover:bg-blue-700">Filter<Search /></Button>
                <Button @click="clearFilters"class="bg-green-600 hover:bg-green-700"> Clear Filters<X /></Button>
            </div>

            <!-- Table -->
            <div class="overflow-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    <thead>
                        <tr class="bg-gray-100 text-left dark:bg-gray-800">
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Attempt status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="attempt in history?.data" :key="attempt.id" class="border-t border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2">{{ formatDate(attempt.created_at) }}</td>
                            <td class="px-4 py-2">
                                <span :class="attempt.success ? 'text-green-600' : 'text-red-600'">
                                    {{ attempt.success ? 'Sucess' : 'Failure' }}
                                </span>
                            </td>
                        </tr>
                        <tr v-if="history?.data.length === 0">
                            <td colspan="4" class="py-4 text-center text-gray-500">No records found.</td>
                        </tr>
                    </tbody>
                </table>
                <!-- Pagination -->
                <Pagination :links="history?.links" class="mt-4" />
                <Button @click="downloadPdf">Download pdf</Button>
            </div>
        </div>
    </AppLayout>
</template>
