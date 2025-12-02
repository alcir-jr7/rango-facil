<script setup lang="ts">
import RegisteredUserController from '@/actions/App/Http/Controllers/Auth/RegisteredUserController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
</script>

<template>
    <AuthBase
        title="Crie sua conta"
        description="Insira seus dados para criar sua conta"
    >
        <Head title="Registrar" />

        <Form
            v-bind="RegisteredUserController.store.form()"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
                <div class="grid gap-6 w-full max-w-lg mx-auto">

                <!-- Name -->
                <div class="grid gap-2">
                    <Label for="name">Nome</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        name="name"
                        placeholder="Seu nome completo"
                    />
                    <InputError :message="errors.name" />
                </div>

                <!-- Email -->
                <div class="grid gap-2">
                    <Label for="email">E-mail</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        :tabindex="2"
                        autocomplete="email"
                        name="email"
                        placeholder="email@exemplo.com"
                    />
                    <InputError :message="errors.email" />
                </div>

                <!-- Phone -->
                <div class="grid gap-2">
                    <Label for="phone_number">Celular</Label>
                    <Input
                        id="phone_number"
                        type="text"
                        required
                        :tabindex="3"
                        autocomplete="tel"
                        name="phone_number"
                        placeholder="+5511999999999"
                        mask="+55 ## #####-####"
                    />
                    <InputError :message="errors.phone_number" />
                 </div>

                <!-- Password -->
                <div class="grid gap-2">
                    <Label for="password">Senha</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        name="password"
                        placeholder="Senha"
                    />
                    <InputError :message="errors.password" />
                </div>

                <!-- Confirm Password -->
                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirmar senha</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="5"
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="Confirme sua senha"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <!-- Submit -->
                <Button
                    type="submit"
                    variant="orange"
                    class="mt-4 w-40 mx-auto"       
                    :tabindex="6"
                    :disabled="processing"
                    data-test="register-user-button"
                >
                    <LoaderCircle
                        v-if="processing"
                        class="h-4 w-4 animate-spin"
                    />
                    Criar conta
                </Button>
            </div>
        </Form>
    </AuthBase>
</template>
