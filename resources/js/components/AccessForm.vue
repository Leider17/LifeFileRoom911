<script setup>
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import Input from '@/components/ui/input/Input.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    internal_id: '',
});

function submit() {
    form.post(route('accessAttempt.attempt'), {
        preserveScroll: true,
    });
}
</script>

<template>
    <form @submit.prevent="submit" class="w-full space-y-6 rounded-lg bg-white p-8 shadow dark:bg-zinc-900">
        <h2 class="text-center text-xl font-bold">Employee access</h2>

        <div>
            <label for="internal_id" class="block text-sm font-medium">Internal ID</label>
            <Input v-model="form.internal_id" id="internal_id" type="text" class="mt-1 block w-full" />
            <InputError :message="form.errors.internal_id" />
            <p v-if="$page.props.flash.status" class="text-green-600">
                {{ $page.props.flash.status }}
            </p>
        </div>

        <Button type="submit" class="w-full" :disabled="form.processing">Access</Button>
    </form>
</template>
