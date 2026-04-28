<script setup lang="ts">
import LoginForm from "@/components/LoginForm.vue"
import { Button } from "@/components/ui/button"
import { useDark, useToggle } from '@vueuse/core'
import { IconSun, IconMoon, IconToolsKitchen2, IconFlame } from '@tabler/icons-vue'
import { Head } from '@inertiajs/vue3'

const isDark = useDark()
const toggleDark = useToggle(isDark)
</script>

<template>
  <Head title="Masuk Wakjoel" />

  <div class="relative min-h-svh w-full flex items-center justify-center overflow-hidden bg-orange-50/30 dark:bg-slate-950 transition-colors duration-500">

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute top-[-10%] right-[-5%] w-[50%] h-[50%] rounded-full bg-orange-500/20 blur-[120px]"></div>
      <div class="absolute bottom-[-10%] left-[-5%] w-[50%] h-[50%] rounded-full bg-amber-500/20 blur-[120px]"></div>
    </div>

    <div class="absolute right-6 top-6 z-50">
      <Button variant="ghost" size="icon" @click="toggleDark()" class="rounded-full bg-white/20 dark:bg-slate-900/40 backdrop-blur-xl border border-orange-200/50 dark:border-white/10">
        <IconSun v-if="isDark" class="size-5 text-amber-400" />
        <IconMoon v-else class="size-5 text-orange-600" />
      </Button>
    </div>

    <div class="relative z-10 w-full max-w-[420px] px-6">
      <div class="flex flex-col items-center mb-10 text-center">
        <div class="relative mb-4">
            <div class="absolute inset-0 bg-orange-500 blur-2xl opacity-20 animate-pulse"></div>
            <div class="relative size-20 rounded-[2.5rem] bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center shadow-2xl shadow-orange-500/40 transform -rotate-6">
                <IconToolsKitchen2 class="size-12 text-white" />
            </div>
        </div>
        <h1 class="text-5xl font-black tracking-tighter text-slate-900 dark:text-white italic">
          WAK<span class="text-orange-600">JOEL</span>
        </h1>
        <div class="flex items-center gap-2 mt-2">
            <span class="h-[1px] w-8 bg-orange-300"></span>
            <p class="text-orange-600 dark:text-orange-400 text-[10px] font-black uppercase tracking-[0.3em]">Solusi Laper Kantor</p>
            <span class="h-[1px] w-8 bg-orange-300"></span>
        </div>
      </div>

      <div class="group relative">
        <div class="absolute -inset-2 bg-gradient-to-r from-orange-500 to-amber-500 rounded-[3rem] blur-xl opacity-10 group-hover:opacity-20 transition duration-1000"></div>
        <LoginForm class="relative bg-white/70 dark:bg-slate-900/80 backdrop-blur-3xl border border-white dark:border-white/10 rounded-[2.5rem] p-4 shadow-2xl" />
      </div>

      <p class="mt-12 text-center text-[11px] text-slate-400 font-bold uppercase tracking-widest">
        Developed with <IconFlame class="inline size-3 text-orange-500" /> for the team
      </p>
    </div>
  </div>
</template>
