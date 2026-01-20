<script setup lang="ts">
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';

// Components
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const passwordInput = ref<InstanceType<typeof Input> | null>(null);
</script>

<template>
    <div class="space-y-6">
        <HeadingSmall
            title="Deletar conta"
            description="Deletar sua conta permanentemente"
        />
        <div
            class="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10"
        >
            <div class="relative space-y-0.5 text-neutral-900">
                <p class="font-medium">Aviso</p>
                <p class="text-sm">
                    Por favor, tenha em mente que a exclusão da sua conta é uma ação permanente. Todos os seus dados serão
                    removidos e não poderão ser recuperados. Certifique-se de fazer backup de quaisquer informações
                    importantes antes de prosseguir com a exclusão da conta.
                </p>
            </div>
            <Dialog>
                <DialogTrigger as-child>
                    <Button variant="destructive" data-test="delete-user-button"
                        >Deletar conta</Button
                    >
                </DialogTrigger>
                    <DialogContent class=" bg-white dark:bg-card">
                    <Form
                        v-bind="ProfileController.destroy.form()"
                        reset-on-success
                        @error="() => passwordInput?.$el?.focus()"
                        :options="{
                            preserveScroll: true,
                        }"
                        class="space-y-6"
                        v-slot="{ errors, processing, reset, clearErrors }"
                    >
                        <DialogHeader class="space-y-3">
                            <DialogTitle
                                >Tem certeza que deseja excluir sua conta?</DialogTitle
                            >
                            <DialogDescription class="text-neutral-700 dark:text-neutral-800">
                                
                                Ao excluir sua conta, todos os seus dados e recursos serão
                                removidos permanentemente. Esta ação não pode ser desfeita.
                                Por favor, informe sua senha para confirmar.

                            </DialogDescription>
                        </DialogHeader>

                        <div class="grid gap-2">
                            <Label for="password" class="sr-only"
                                >Senha</Label
                            >
                            <Input
                            id="password"
                            type="password"
                            name="password"
                            ref="passwordInput"
                            placeholder="Senha"
                            class="text-neutral-800 placeholder:text-neutral-500"
                            />
                            <InputError :message="errors.password" />
                        </div>

                        <DialogFooter class="gap-2">
                            <DialogClose as-child>
                                <Button
                                class="bg-orange-500 text-white hover:bg-orange-600"
                                >
                                Cancelar
                                </Button>

                            </DialogClose>

                            <Button
                                type="submit"
                                variant="destructive"
                                :disabled="processing"
                                data-test="confirm-delete-user-button"
                            >
                                Deletar conta
                            </Button>
                        </DialogFooter>
                    </Form>
                </DialogContent>
            </Dialog>
        </div>
    </div>
</template>
