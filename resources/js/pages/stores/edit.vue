<script setup lang="ts">
import StoreController, {
    edit,
    index,
    update,
} from '@/actions/App/Http/Controllers/StoreController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Form, Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Props {
    store: {
        id: number;
        name: string;
        image?: string;
        auto_confirm: boolean;
    };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Stores',
        href: index().url,
    },
    {
        title: props.store.name,
        href: edit(props.store.id).url,
    },
    {
        title: 'Editar loja',
        href: edit(props.store.id).url,
    },
];

// Form do Inertia
const form = useForm({
    _method: 'PUT',
    name: props.store.name,
    image: null as File | null,
    auto_confirm: props.store.auto_confirm,
});

// Estado local para preview da nova imagem
const imagePreview = ref<string | null>(null);

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    
    if (file) {
        form.image = file;
        
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.post(update(props.store.id).url, {
        preserveScroll: true,
        onSuccess: () => {
            imagePreview.value = null;
        }
    });
};
</script>

<template>
    <Head title="Editar Loja" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 max-w-xl">
            <h1 class="mb-4 text-2xl font-bold">Editar Loja</h1>

            <form @submit.prevent="submit">
                <!-- Nome -->
                <div class="mb-4">
                    <Label class="mb-2 block font-medium" for="name">
                        Nome da Loja
                    </Label>
                    <Input
                        class="w-full rounded border border-gray-300 p-2"
                        type="text"
                        id="name"
                        v-model="form.name"
                        required
                        placeholder="Digite o nome da loja"
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <!-- Imagem atual ou preview da nova -->
                <div v-if="imagePreview || store.image" class="mb-4">
                    <Label class="mb-2 block font-medium">
                        {{ imagePreview ? 'Nova Foto (Preview)' : 'Foto Atual' }}
                    </Label>
                    <img 
                        :src="imagePreview || `/storage/${store.image}`"
                        :alt="store.name"
                        class="h-32 w-32 rounded object-cover border border-gray-300"
                    />
                </div>

                <!-- Imagem da loja -->
                <div class="mb-4">
                    <Label class="mb-2 block font-medium" for="image">
                        {{ store.image ? 'Alterar Foto da Loja' : 'Foto da Loja' }}
                    </Label>
                    <Input
                        class="w-full rounded border border-gray-300 p-2"
                        type="file"
                        id="image"
                        accept="image/*"
                        @change="handleImageChange"
                    />
                    <InputError :message="form.errors.image" />
                </div>

                <!-- Auto Confirmar -->
                <div class="mb-4 flex w-full flex-row items-center gap-2">
                    <Checkbox 
                        id="auto_confirm" 
                        v-model:checked="form.auto_confirm"
                    />
                    <Label for="auto_confirm" class="font-medium cursor-pointer">
                        Auto Confirmar Pedidos
                    </Label>
                </div>

                <Button class="cursor-pointer" type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Salvando...' : 'Salvar Alterações' }}
                </Button>
            </form>
        </div>
    </AppLayout>
</template>