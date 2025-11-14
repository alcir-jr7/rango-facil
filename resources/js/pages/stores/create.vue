<script setup lang="ts">
import StoreController, {
    create,
    index,
} from '@/actions/App/Http/Controllers/StoreController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Form, Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Stores',
        href: index().url,
    },
    {
        title: 'Criar loja',
        href: create().url,
    },
];
</script>

<template>
    <Head title="Criar Loja" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 max-w-xl">
            <h1 class="mb-4 text-2xl font-bold">Criar Loja</h1>
            <!-- Formulário de criação de loja -->
            <Form
                v-bind="StoreController.store.form()"
                v-slot="{ errors, processing }"
            >
                <div class="mb-4">
                    <Label class="mb-2 block font-medium" for="name"
                        >Nome da Loja</Label
                    >
                    <Input
                        class="w-full rounded border border-gray-300 p-2"
                        type="text"
                        id="name"
                        name="name"
                        required
                        placeholder="Digite o nome da loja"
                    />
                    <InputError :message="errors.name" />
                </div>
                <div class="mb-4 flex w-full flex-row">
                    <Label for="auto_confirm" class="mt-1 mr-2 font-medium">
                        <Checkbox
                            id="auto_confirm"
                            name="auto_confirm"
                        />
                        <span>Auto Confirmar Pedidos</span>
                    </Label>
                </div>
                <Button class="cursor-pointer" type="submit">
                    Criar Loja
                </Button>
            </Form>
        </div>
    </AppLayout>
</template>
