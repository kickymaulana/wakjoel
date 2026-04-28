<script setup lang="ts">
import RegisterForm from "@/components/RegisterForm.vue"
import { Button } from "@/components/ui/button"
import { useDark, useToggle } from '@vueuse/core'
import { IconSun, IconMoon, IconToolsKitchen2, IconChecks } from '@tabler/icons-vue'
import { Head } from '@inertiajs/vue3'

const isDark = useDark()
const toggleDark = useToggle(isDark)
</script>

<template>
  <Head title="Join Wakjoel" />

  <div class="relative min-h-svh w-full flex items-center justify-center p-4 bg-orange-50/20 dark:bg-[#020617] transition-colors duration-500">

    <div class="absolute right-6 top-6 z-50">
      <Button variant="outline" size="icon" @click="toggleDark()" class="rounded-full bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl">
        <IconSun v-if="isDark" class="size-5 text-amber-400" />
        <IconMoon v-else class="size-5 text-orange-500" />
      </Button>
    </div>

    <div class="relative z-10 w-full max-w-4xl">
      <div class="grid lg:grid-cols-12 gap-0 overflow-hidden rounded-[3rem] bg-white/60 dark:bg-slate-900/60 backdrop-blur-3xl border border-white dark:border-white/5 shadow-2xl">

        <div class="lg:col-span-5 p-10 lg:p-14 bg-gradient-to-br from-orange-500 via-orange-600 to-amber-600 text-white flex flex-col justify-between">
          <div class="space-y-10">
            <div class="size-16 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center shadow-xl rotate-12">
              <IconToolsKitchen2 class="size-10" />
            </div>

            <div class="space-y-4">
                <h2 class="text-5xl font-black leading-[0.9] uppercase italic tracking-tighter">Makan<br/>Jadi<br/>Mudah.</h2>
                <div class="h-2 w-12 bg-white rounded-full"></div>
                <p class="text-orange-50 text-sm leading-relaxed font-medium opacity-90">
                  Satu akun untuk semua pesananmu. Gak perlu lagi catat manual pakai kertas.
                </p>
            </div>

            <div class="space-y-4 pt-4">
                <div v-for="item in ['Antrean Realtime', 'Cek Total Harga', 'Notif WhatsApp']" class="flex items-center gap-3">
                    <IconChecks class="size-5 text-orange-200" />
                    <span class="text-xs font-bold uppercase tracking-widest text-orange-100">{{ item }}</span>
                </div>
            </div>
          </div>
        </div>

        <div class="lg:col-span-7 p-10 lg:p-14">
          <div class="mb-10">
            <h3 class="text-3xl font-black text-slate-900 dark:text-white uppercase italic">Gabung Sekarang</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1 font-medium">Buat profil makanmu dalam hitungan detik.</p>
          </div>

          <RegisterForm class="animate-in slide-in-from-right-4 duration-700" />
        </div>

      </div>
    </div>
  </div>
</template>
