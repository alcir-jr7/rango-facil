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
        <div class="p-4 sm:p-6 max-w-3xl mx-auto">
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                    Criar Novo Produto
                </h1>
                <p class="mt-2 text-sm text-gray-600">
                    Preencha as informações abaixo para adicionar um novo produto à sua loja
                </p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <Label for="name" class="text-sm font-semibold text-gray-900">
                            Nome do Produto
                            <span class="text-red-500">*</span>
                        </Label>
                        <Input
                            id="name"
                            v-model="form.name"
                            required
                            placeholder="Ex: Pizza Margherita"
                            class="mt-2 h-11 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                        />
                        <InputError :message="form.errors.name" class="mt-1.5" />
                    </div>
                    <div>
                        <Label for="description" class="text-sm font-semibold text-gray-900">
                            Descrição
                        </Label>
                        <textarea
                            id="description"
                            v-model="form.description"
                            placeholder="Descreva os detalhes do produto, ingredientes, sabores..."
                            class="mt-2 w-full rounded-lg border border-gray-300 p-3 text-sm focus:border-gray-300 focus:ring-2 focus:ring-orange-500 focus:ring-opacity-20 transition-colors bg-white"
                            rows="4"
                        />
                        <InputError :message="form.errors.description" class="mt-1.5" />
                        <p class="mt-1.5 text-xs text-gray-500">
                            Uma boa descrição ajuda os clientes a conhecerem melhor o produto
                        </p>
                    </div>

                    <div>
                        <Label for="category_id" class="text-sm font-semibold text-gray-900">
                            Categoria
                            <span class="text-red-500">*</span>
                        </Label>
                        <select
                            id="category_id"
                            v-model="form.category_id"
                            required
                            class="mt-2 w-full h-11 rounded-lg border border-gray-300 px-3 text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500 focus:ring-opacity-20 transition-colors bg-white"
                        >
                            <option value="" disabled>Selecione uma categoria</option>
                            <option
                                v-for="c in categories"
                                :key="c.id"
                                :value="c.id"
                            >
                                {{ c.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.category_id" class="mt-1.5" />
                    </div>

                    <div>
                        <Label for="image" class="text-sm font-semibold text-gray-900">
                            Imagem do Produto
                        </Label>
                        <div class="mt-2">
                            <div class="flex items-center justify-center w-full">
                                <label
                                    for="image"
                                    class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors"
                                >
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg
                                            class="w-10 h-10 mb-3 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                            />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold">Clique para enviar</span> ou arraste
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG, WEBP (MAX. 2MB)</p>
                                    </div>
                                    <Input
                                        type="file"
                                        id="image"
                                        class="hidden"
                                        accept="image/*"
                                        @input="form.image = ($event.target as HTMLInputElement).files?.[0] || null"
                                    />
                                </label>
                            </div>
                        </div>
                        <InputError :message="form.errors.image" class="mt-1.5" />
                        <p v-if="form.image" class="mt-2 text-sm text-green-600 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            {{ form.image.name }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <Label for="price" class="text-sm font-semibold text-gray-900">
                                Preço
                                <span class="text-red-500">*</span>
                            </Label>
                            <div class="relative mt-2">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">
                                    R$
                                </span>
                                <Input
                                    type="number"
                                    id="price"
                                    v-model="form.price"
                                    step="0.01"
                                    min="0"
                                    required
                                    placeholder="0,00"
                                    class="pl-10 h-11 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                                />
                            </div>
                            <InputError :message="form.errors.price" class="mt-1.5" />
                        </div>

                        <div>
                            <Label for="min_price" class="text-sm font-semibold text-gray-900">
                                Preço Mínimo
                            </Label>
                            <div class="relative mt-2">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">
                                    R$
                                </span>
                                <Input
                                    type="number"
                                    id="min_price"
                                    v-model="form.min_price"
                                    step="0.01"
                                    min="0"
                                    placeholder="0,00"
                                    class="pl-10 h-11 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                                />
                            </div>
                            <InputError :message="form.errors.min_price" class="mt-1.5" />
                            <p class="mt-1.5 text-xs text-gray-500">
                                Opcional: preço mínimo para promoções
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                        <Button
                            type="button"
                            variant="outline"
                            @click="$inertia.visit('/products')"
                            class="px-6"
                        >
                            Cancelar
                        </Button>
                        <Button
                            type="submit"
                            :disabled="form.processing"
                            class="px-8 bg-orange-600 hover:bg-orange-700 focus:ring-orange-500"
                        >
                            <svg
                                v-if="form.processing"
                                class="animate-spin -ml-1 mr-2 h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                />
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                />
                            </svg>
                            {{ form.processing ? 'Criando...' : 'Criar Produto' }}
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>