<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { useForm, Head } from '@inertiajs/vue3';

// Props
const props = defineProps<{
    store_id: number;
    categories: {
        id: number;
        name: string;
    }[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Produtos',
        href: '/products',
    },
    {
        title: 'Criar Produto',
        href: '/products/create',
    },
];

// Form
const form = useForm({
    name: '',
    description: '',
    category_id: '',
    image: null as File | null,
    price: '',
    min_price: '',
    store_id: props.store_id,
});

const submit = () => {
    form.post('/products', {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Criar Produto" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 max-w-xl">
            <h1 class="mb-4 text-2xl font-bold">Criar Produto</h1>

            <form @submit.prevent="submit">
                <!-- Nome -->
                <div class="mb-4">
                    <Label for="name">Nome do Produto</Label>
                    <Input id="name" v-model="form.name" required />
                    <InputError :message="form.errors.name" />
                </div>

                <!-- Descrição -->
                <div class="mb-4">
                    <Label for="description">Descrição</Label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        class="w-full rounded border border-gray-300 p-2"
                        rows="4"
                    />
                    <InputError :message="form.errors.description" />
                </div>

                <!-- Categoria -->
                <div class="mb-4">
                    <Label for="category_id">Categoria</Label>
                    <select
                        id="category_id"
                        v-model="form.category_id"
                        class="w-full rounded border border-gray-300 p-2"
                        required
                    >
                        <option value="">Selecione uma categoria</option>
                        <option
                            v-for="c in categories"
                            :key="c.id"
                            :value="c.id"
                        >
                            {{ c.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.category_id" />
                </div>

                <!-- Imagem -->
                <div class="mb-4">
                    <Label for="image">Imagem</Label>
                    <Input 
                        type="file" 
                        id="image" 
                        @input="form.image = ($event.target as HTMLInputElement).files?.[0] || null" 
                    />
                    <InputError :message="form.errors.image" />
                </div>

                <!-- Preço -->
                <div class="mb-4">
                    <Label for="price">Preço</Label>
                    <Input type="number" id="price" v-model="form.price" step="0.01" required />
                    <InputError :message="form.errors.price" />
                </div>

                <!-- Preço mínimo -->
                <div class="mb-4">
                    <Label for="min_price">Preço Mínimo</Label>
                    <Input type="number" id="min_price" v-model="form.min_price" step="0.01" />
                    <InputError :message="form.errors.min_price" />
                </div>

                <Button type="submit" :disabled="form.processing">
                    Criar Produto
                </Button>
            </form>
        </div>
    </AppLayout>
</template>