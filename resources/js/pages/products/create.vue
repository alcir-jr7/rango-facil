<script setup lang="ts">
import ProductController, {
    create,
    index,
} from '@/actions/App/Http/Controllers/ProductController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Form, Head } from '@inertiajs/vue3';


// Receber o store_id como prop
defineProps<{
    store_id: number;
}>();


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: index().url,
    },
    {
        title: 'Criar Produto',
        href: create().url,
    },
];
</script>


<template>
    <Head title="Criar Produto" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 max-w-xl">
            <h1 class="mb-4 text-2xl font-bold">Criar Produto</h1>
           
            <!-- Formulário de criação de produto -->
            <Form
                v-bind="ProductController.store.form()"
                v-slot="{ errors, processing }"
            >
                <div class="mb-4">
                    <Label class="mb-2 block font-medium" for="name">
                        Nome do Produto
                    </Label>
                    <Input
                        class="w-full rounded border border-gray-300 p-2"
                        type="text"
                        id="name"
                        name="name"
                        required
                        placeholder="Digite o nome do produto"
                    />
                    <InputError :message="errors.name" />
                </div>


                <div class="mb-4">
                    <Label class="mb-2 block font-medium" for="description">
                        Descrição
                    </Label>
                    <Textarea
                        class="w-full rounded border border-gray-300 p-2"
                        id="description"
                        name="description"
                        placeholder="Digite a descrição do produto (opcional)"
                        rows="4"
                    />
                    <InputError :message="errors.description" />
                </div>


                <div class="mb-4">
                    <Label class="mb-2 block font-medium" for="image">
                        Imagem do Produto
                    </Label>
                    <Input
                        class="w-full rounded border border-gray-300 p-2"
                        type="file"
                        id="image"
                        name="image"
                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                    />
                    <InputError :message="errors.image" />
                    <p class="mt-1 text-sm text-gray-500">
                        Formatos aceitos: JPG, PNG, GIF, WEBP (máx. 2MB)
                    </p>
                </div>


                <div class="mb-4">
                    <Label class="mb-2 block font-medium" for="price">
                        Preço
                    </Label>
                    <Input
                        class="w-full rounded border border-gray-300 p-2"
                        type="number"
                        id="price"
                        name="price"
                        required
                        placeholder="Digite o preço"
                        step="0.01"
                        min="0"
                    />
                    <InputError :message="errors.price" />
                </div>


                <div class="mb-4">
                    <Label class="mb-2 block font-medium" for="min_price">
                        Preço Mínimo
                    </Label>
                    <Input
                        class="w-full rounded border border-gray-300 p-2"
                        type="number"
                        id="min_price"
                        name="min_price"
                        placeholder="Digite o preço mínimo (opcional)"
                        step="0.01"
                        min="0"
                    />
                    <InputError :message="errors.min_price" />
                </div>


                <!-- Campo hidden para store_id -->
                <input type="hidden" name="store_id" :value="store_id" />


                <Button class="cursor-pointer" type="submit" :disabled="processing">
                    Criar Produto
                </Button>
            </Form>
        </div>
    </AppLayout>
</template>
