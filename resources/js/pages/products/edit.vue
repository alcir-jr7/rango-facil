<script setup lang="ts">
import ProductController, {
    index,
    edit,
} from '@/actions/App/Http/Controllers/ProductController'

import InputError from "@/components/InputError.vue"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import AppLayout from "@/layouts/AppLayout.vue"
import { type BreadcrumbItem } from "@/types"
import { Head, useForm } from "@inertiajs/vue3"

// Props
const props = defineProps<{
    product: {
        id: number
        name: string
        description?: string
        price: number
        min_price?: number
        image?: string
        store_id: number
        category_id: number
    }
    store_id: number
    categories: {
        id: number
        name: string
    }[]
}>()

// Formulário (estado controlado pelo Inertia)
const form = useForm({
    name: props.product.name,
    description: props.product.description ?? '',
    price: props.product.price,
    min_price: props.product.min_price ?? '',
    image: null as File | null,
    store_id: props.store_id,
    category_id: props.product.category_id,
    _method: 'put',
})

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Products",
        href: index().url,
    },
    {
        title: "Editar Produto",
        href: edit(props.product.id).url,
    },
]

// Submit
const submit = () => {
    form.post(ProductController.update(props.product.id).url, {
        forceFormData: true,
    })
}
</script>

<template>
    <Head :title="`Editar Produto: ${props.product.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 max-w-xl">
            <h1 class="mb-6 text-2xl font-bold">
                Editar Produto
            </h1>

            <form @submit.prevent="submit" class="space-y-4">
                <!-- Nome -->
                <div>
                    <Label for="name">Nome do Produto</Label>
                    <Input
                        id="name"
                        name="name"
                        v-model="form.name"
                        required
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <!-- Descrição -->
                <div>
                    <Label for="description">Descrição</Label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        v-model="form.description"
                        class="w-full rounded border border-gray-300 p-2 focus:ring-gray-300"
                    />
                    <InputError :message="form.errors.description" />
                </div>

                <!-- Categoria -->
                <div>
                    <Label for="category_id">Categoria</Label>
                    <select
                        id="category_id"
                        v-model="form.category_id"
                        class="w-full rounded border border-gray-300 p-2"
                        required
                    >
                        <option disabled value="">
                            Selecione uma categoria
                        </option>

                        <option
                            v-for="category in props.categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.category_id" />
                </div>

                <!-- Imagem -->
                <div>
                    <Label for="image">Imagem do Produto</Label>

                    <Input
                        id="image"
                        name="image"
                        type="file"
                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                        @change="form.image = $event.target.files[0]"
                    />

                    <InputError :message="form.errors.image" />

                    <p class="mt-1 text-sm text-gray-500">
                        Envie uma nova imagem apenas se desejar substituir a atual.
                    </p>

                    <div v-if="props.product.image" class="mt-2">
                        <p class="text-sm text-gray-700 mb-1">
                            Imagem atual:
                        </p>
                        <img
                            :src="props.product.image"
                            alt="Imagem atual"
                            class="h-24 rounded shadow"
                        />
                    </div>
                </div>

                <!-- Preço -->
                <div>
                    <Label for="price">Preço</Label>
                    <Input
                        id="price"
                        name="price"
                        type="number"
                        step="0.01"
                        min="0"
                        v-model="form.price"
                        required
                    />
                    <InputError :message="form.errors.price" />
                </div>

                <!-- Preço mínimo -->
                <div>
                    <Label for="min_price">Preço Mínimo</Label>
                    <Input
                        id="min_price"
                        name="min_price"
                        type="number"
                        step="0.01"
                        min="0"
                        v-model="form.min_price"
                    />
                    <InputError :message="form.errors.min_price" />
                </div>

                <!-- Botão -->
                <div class="pt-4">
                    <Button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full"
                    >
                        Atualizar Produto
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
