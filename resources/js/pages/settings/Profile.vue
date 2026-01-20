<script setup lang="ts">
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import { edit } from '@/routes/profile';
import { send } from '@/routes/verification';
import { Form, Head, Link, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem } from '@/types';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: edit().url,
    },
];

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Configurações do perfil" />

        <SettingsLayout>
            <div class="space-y-10 max-w-4xl">

                <!-- PROFILE CARD -->
                <section class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
                    <HeadingSmall
                        title="Informações do perfil"
                        description="Atualize seu nome e endereço de e-mail"
                        class="text-neutral-700"
                    />

                    <div class="mt-6 border-t pt-6">
                        <Form
                            v-bind="ProfileController.update.form()"
                            class="space-y-6"
                            v-slot="{ errors, processing, recentlySuccessful }"
                        >
                            <!-- FORM GRID -->
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="space-y-2">
                                    <Label for="name">Nome</Label>
                                    <Input
                                        id="name"
                                        name="name"
                                        :default-value="user.name"
                                        required
                                        autocomplete="name"
                                        placeholder="Nome completo"
                                    />
                                    <InputError :message="errors.name" />
                                </div>

                                <div class="space-y-2">
                                    <Label for="email">Endereço de e-mail</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        name="email"
                                        :default-value="user.email"
                                        required
                                        autocomplete="username"
                                        placeholder="E-mail"
                                    />
                                    <InputError :message="errors.email" />
                                </div>
                            </div>

                            <!-- EMAIL VERIFICATION -->
                            <div
                                v-if="mustVerifyEmail && !user.email_verified_at"
                                class="rounded-md bg-orange-50 p-4 text-sm text-orange-700"
                            >
                                Seu endereço de e-mail ainda não foi verificado.
                                <Link
                                    :href="send()"
                                    as="button"
                                    class="ml-1 font-medium underline underline-offset-4"
                                >
                                    Reenviar e-mail de verificação
                                </Link>

                                <p
                                    v-if="status === 'verification-link-sent'"
                                    class="mt-2 font-medium text-green-600"
                                >
                                    Um novo link de verificação foi enviado para
                                    o seu e-mail.
                                </p>
                            </div>

                            <!-- ACTIONS -->
                            <div class="flex items-center gap-4">
                                <Button
                                    :disabled="processing"
                                    data-test="update-profile-button"
                                    class="bg-orange-500 text-white hover:bg-orange-600"
                                >
                                    Salvar alterações
                                </Button>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <span
                                        v-show="recentlySuccessful"
                                        class="text-sm text-neutral-600"
                                    >
                                        Alterações salvas com sucesso.🧡 
                                    </span>
                                </Transition>
                            </div>
                        </Form>
                    </div>
                </section>

                <!-- DANGER ZONE -->
                <section class="rounded-xl border border-red-200 bg-red-50 p-6">
                    <DeleteUser />
                </section>

            </div>
        </SettingsLayout>
    </AppLayout>
</template>