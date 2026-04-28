<script setup lang="ts">
import { cn } from "@/lib/utils"
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Field, FieldGroup, FieldLabel } from "@/components/ui/field"
import { Input } from "@/components/ui/input"
import { useForm, Link } from '@inertiajs/vue3'

const props = defineProps<{
  class?: string
}>()

const form = useForm({
  name: '',
  username: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('register.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <div :class="cn('flex flex-col gap-6', props.class)">
    <Card class="bg-transparent border-none shadow-none p-0">
      <CardContent class="p-0">
        <form @submit.prevent="submit">
          <FieldGroup class="space-y-5">

            <Field>
              <FieldLabel for="name" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Nama Lengkap</FieldLabel>
              <Input
                id="name"
                v-model="form.name"
                placeholder="Masukkan nama..."
                class="h-12 bg-white/50 dark:bg-slate-900/50 border-slate-200 dark:border-slate-800 rounded-xl"
                required
              />
              <p v-if="form.errors.name" class="text-destructive text-xs mt-1">{{ form.errors.name }}</p>
            </Field>

            <Field>
              <FieldLabel for="username" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Username</FieldLabel>
              <Input
                id="username"
                v-model="form.username"
                placeholder="Contoh: kicky_maulana"
                class="h-12 bg-white/50 dark:bg-slate-900/50 border-slate-200 dark:border-slate-800 rounded-xl"
                required
              />
              <p v-if="form.errors.username" class="text-destructive text-xs mt-1">{{ form.errors.username }}</p>
            </Field>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <Field>
                <FieldLabel for="password" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Password</FieldLabel>
                <Input
                  id="password"
                  v-model="form.password"
                  type="password"
                  class="h-12 bg-white/50 dark:bg-slate-900/50 border-slate-200 dark:border-slate-800 rounded-xl"
                  required
                />
              </Field>
              <Field>
                <FieldLabel for="password_confirmation" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Konfirmasi</FieldLabel>
                <Input
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  type="password"
                  class="h-12 bg-white/50 dark:bg-slate-900/50 border-slate-200 dark:border-slate-800 rounded-xl"
                  required
                />
              </Field>
            </div>

            <Button type="submit" :disabled="form.processing" class="w-full h-12 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl shadow-lg shadow-orange-600/20">
              {{ form.processing ? 'Memproses...' : 'Daftar Sekarang' }}
            </Button>
          </FieldGroup>
        </form>

        <div class="mt-8 text-center text-sm font-medium">
          <span class="text-slate-500">Sudah punya akun?</span>
          <Link :href="route('login')" class="ml-1 text-orange-600 underline underline-offset-4 hover:text-orange-700">
            Masuk ke Wakjoel
          </Link>
        </div>
      </CardContent>
    </Card>
  </div>
</template>
