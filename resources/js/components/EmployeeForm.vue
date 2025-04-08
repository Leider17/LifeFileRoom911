<script setup>
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import Input from '@/components/ui/input/Input.vue';
import Label from './ui/label/Label.vue';

const props = defineProps({
    form: Object,
    departments: Array,
    onSubmit: Function,
});
</script>

<template>
    <form @submit.prevent="onSubmit" class="space-y-6">
        <div>
            <Label for="first_name">First name</Label>
            <Input id="first_name" v-model="form.first_name" placeholder="first name" class="mt-1 block w-full"  type="text" />
            <InputError :message="form.errors.first_name" />
        </div>

        <div>
            <Label for="last_name">Last name</Label>
            <Input id="last_name" v-model="form.last_name" placeholder="last name" class="mt-1 block w-full" type="text"  />
            <InputError :message="form.errors.last_name" />
        </div>

        <div>
            <Label for="employee_id">internal id</Label>
            <Input id="employee_id" v-model="form.internal_id" placeholder="internal id" class="mt-1 block w-full" type="text"  />
            <InputError :message="form.errors.internal_id" />
        </div>

        <div>
            <Label for="department_id">Departments</Label>
            <select id="department_id" v-model="form.department_id" class="rounded border bg-black px-3 py-2 text-white w-full mt-1 " >
                <option value="" disabled>Seleccione...</option>
                <option v-for="dept in departments" :key="dept.id" :value="dept.id">
                    {{ dept.name }}
                </option>
            </select>
            <InputError :message="form.errors.department_id" />
        </div>

        <div class="flex items-center gap-2">
            <input
                type="checkbox"
                id="has_access"
                v-model="form.has_access"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
            />
            <Label for="has_access"> Has access </Label>
        </div>

        <div class="flex justify-end gap-4">
            <Button variant="ghost" type="button" @click="$inertia.visit(route('employee.index'))"> Cancel </Button>
            <Button :disabled="form.processing" type="submit"> Save </Button>
        </div>
    </form>
</template>
