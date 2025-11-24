<script setup lang="ts">
import ProductController, {
    index,
    edit,
} from '@/actions/App/Http/Controllers/ProductController'; 
import InputError from "@/components/InputError.vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import AppLayout from "@/layouts/AppLayout.vue";
import { type BreadcrumbItem } from "@/types";
import { Form, Head } from "@inertiajs/vue3";

// Props recebidas: o produto e o store_id
const props = defineProps<{
    product: {
        id: number;
        name: string;
        description?: string;
        price: number;
        min_price?: number;
        image?: string;
        store_id: number;
    };
    store_id: number;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Products",
        href: index().url,
    },
    {
        title: "Editar Produto",
        href: edit(props.product.id).url,
    },
];
</script>

<template>
    <Head :title="`Editar Produto: ${props.product.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 max-w-xl">
            <h1 class="mb-4 text-2xl font-bold">Editar Produto</h1>

            <Form
                v-bind="ProductController.update.form(props.product)"
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
                        v-model="props.product.name"
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
                        rows="4"
                        v-model="props.product.description"
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
                        Envie uma nova imagem apenas se quiser substituir.
                    </p>

                    <div v-if="props.product.image" class="mt-2">
                        <p class="text-sm text-gray-700 mb-1">Imagem atual:</p>
                        <img
                            :src="props.product.image"
                            class="h-24 rounded shadow"
                            alt="Imagem atual"
                        />
                    </div>
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
                        step="0.01"
                        min="0"
                        required
                        v-model="props.product.price"
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
                        step="0.01"
                        min="0"
                        v-model="props.product.min_price"
                    />
                    <InputError :message="errors.min_price" />
                </div>

                <!-- Campo hidden para store_id -->
                <input type="hidden" name="store_id" :value="props.store_id" />

                <Button class="cursor-pointer" type="submit" :disabled="processing">
                    Atualizar Produto
                </Button>
            </Form>
        </div>
    </AppLayout>
</template>
