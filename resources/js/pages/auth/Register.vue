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
        title="Create an account"
        description="Enter your details below to create your account"
    >
        <Head title="Register" />

        <Form
            v-bind="RegisteredUserController.store.form()"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">

                <!-- Name -->
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        name="name"
                        placeholder="Full name"
                    />
                    <InputError :message="errors.name" />
                </div>

                <!-- Email -->
                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        :tabindex="2"
                        autocomplete="email"
                        name="email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="errors.email" />
                </div>

                <!-- Confirm Email -->
                <div class="grid gap-2">
                    <Label for="email_confirmation">Confirm Email</Label>
                    <Input
                        id="email_confirmation"
                        type="email"
                        required
                        :tabindex="3"
                        autocomplete="email"
                        name="email_confirmation"
                        placeholder="Confirm your email"
                    />
                    <InputError :message="errors.email_confirmation" />
                </div>

                <!-- Phone -->
                <div class="grid gap-2">
                    <Label for="phone_number">Phone</Label>
                    <Input
                        id="phone_number"
                        type="text"
                        required
                        :tabindex="4"
                        autocomplete="tel"
                        name="phone_number"
                        placeholder="+5511999999999"
                    />
                    <InputError :message="errors.phone_number" />
                </div>

                <!-- Confirm Phone -->
                <div class="grid gap-2">
                    <Label for="phone_confirmation">Confirm Phone</Label>
                    <Input
                        id="phone_number_confirmation"
                        type="text"
                        required
                        :tabindex="5"
                        autocomplete="tel"
                        name="phone_number_confirmation"
                        placeholder="Confirm your phone"
                    />
                    <InputError :message="errors.phone_confirmation" />
                </div>

                <!-- Password -->
                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="6"
                        autocomplete="new-password"
                        name="password"
                        placeholder="Password"
                    />
                    <InputError :message="errors.password" />
                </div>

                <!-- Confirm Password -->
                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="7"
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="Confirm password"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <!-- Submit -->
                <Button
                    type="submit"
                    class="mt-2 w-full"
                    :tabindex="8"
                    :disabled="processing"
                    data-test="register-user-button"
                >
                    <LoaderCircle
                        v-if="processing"
                        class="h-4 w-4 animate-spin"
                    />
                    Create account
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground mt-4">
                Already have an account?
                <TextLink
                    :href="login()"
                    class="underline underline-offset-4"
                    :tabindex="9"
                >Log in</TextLink>
            </div>
        </Form>
    </AuthBase>
</template>
