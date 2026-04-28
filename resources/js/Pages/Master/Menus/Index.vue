<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { Head, Link, router } from "@inertiajs/vue3"
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Badge } from "@/components/ui/badge"
import {
  IconPlus,
  IconPencil,
  IconTrash,
  IconSearch,
  IconX,
  IconToolsKitchen2
} from "@tabler/icons-vue"
import { ref, watch } from 'vue'

// 1. Definisikan Persistent Layout
defineOptions({ layout: AuthenticatedLayout })

// 2. Definisi Props
const props = defineProps<{
  menus: {
    data: Array<{
      id: number
      nama_item: string
      harga: number
      is_available: boolean
      created_at: string
    }>
    links: Array<any>
    from: number
    to: number
    total: number
  },
  filters: {
    search: string
  }
}>()

// 3. Logika Pencarian
const search = ref(props.filters.search || '')

let timeout: ReturnType<typeof setTimeout>
watch(search, (value) => {
  clearTimeout(timeout)
  timeout = setTimeout(() => {
    router.get(
      route('menus.index'),
      { search: value },
      { preserveState: true, replace: true }
    )
  }, 500)
})

const clearSearch = () => {
  search.value = ''
}

// 4. Helper Formatter
const formatRupiah = (number: number) => {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    maximumFractionDigits: 0,
  }).format(number)
}

const cleanLabel = (label: string) => {
  if (label.includes('Previous')) return 'Sebelumnya'
  if (label.includes('Next')) return 'Selanjutnya'
  return label
}
</script>

<template>
  <Head title="Manajemen Menu Wakjoel" />

  <div class="flex flex-col gap-4 p-4 md:p-8 pt-4">
    <Card class="border-none shadow-sm">
      <CardHeader class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-4 md:space-y-0 pb-6">
        <div>
          <CardTitle class="text-xl font-bold flex items-center gap-2">
            <IconToolsKitchen2 class="size-5 text-primary" />
            Daftar Lauk Wakjoel
          </CardTitle>
          <p class="text-xs text-muted-foreground">Kelola harga dan ketersediaan menu nasi padang.</p>
        </div>

        <div class="flex items-center gap-2 w-full md:w-auto">
          <div class="relative w-full md:w-72">
            <IconSearch class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-muted-foreground" />
            <Input
              v-model="search"
              placeholder="Cari lauk (rendang, ayam...)"
              class="pl-10 pr-10"
            />
            <button
              v-if="search"
              @click="clearSearch"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-foreground"
            >
              <IconX class="size-4" />
            </button>
          </div>

          <Button as-child>
            <Link :href="route('menus.create')">
              <IconPlus class="mr-2 size-4" />
              <span class="hidden sm:inline">Tambah Menu</span>
            </Link>
          </Button>
        </div>
      </CardHeader>

      <CardContent>
        <div class="rounded-md border">
          <Table>
            <TableHeader>
              <TableRow class="bg-muted/50">
                <TableHead>Nama Item</TableHead>
                <TableHead>Harga Satuan</TableHead>
                <TableHead>Status</TableHead>
                <TableHead class="text-right">Aksi</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-if="menus.data.length === 0">
                <TableCell colspan="4" class="h-24 text-center text-muted-foreground">
                  Lauk tidak ditemukan.
                </TableCell>
              </TableRow>

              <TableRow v-for="menu in menus.data" :key="menu.id">
                <TableCell class="font-medium uppercase">{{ menu.nama_item }}</TableCell>
                <TableCell>
                  <span class="font-mono text-emerald-600 font-semibold">
                    {{ formatRupiah(menu.harga) }}
                  </span>
                </TableCell>
                <TableCell>
                  <Badge :variant="menu.is_available ? 'default' : 'destructive'" class="text-[10px]">
                    {{ menu.is_available ? 'Tersedia' : 'Habis' }}
                  </Badge>
                </TableCell>

                <TableCell class="text-right">
                  <Button variant="ghost" size="icon" class="size-8" as-child>
                    <Link :href="route('menus.edit', menu.id)">
                      <IconPencil class="size-4 text-blue-600" />
                    </Link>
                  </Button>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-6">
          <p class="text-xs text-muted-foreground">
            Menampilkan {{ menus.from ?? 0 }} - {{ menus.to ?? 0 }} dari {{ menus.total }} lauk
          </p>

          <nav class="flex items-center gap-1">
            <template v-for="(link, k) in menus.links" :key="k">
              <Button
                v-if="link.url === null"
                variant="outline"
                size="sm"
                disabled
                class="opacity-50 text-xs px-3 h-8"
                v-html="cleanLabel(link.label)"
              />
              <Button
                v-else
                as-child
                variant="outline"
                size="sm"
                class="text-xs px-3 h-8"
                :class="{ 'bg-primary text-primary-foreground hover:bg-primary/90': link.active }"
              >
                <Link :href="link.url" v-html="cleanLabel(link.label)" />
              </Button>
            </template>
          </nav>
        </div>
      </CardContent>
    </Card>
  </div>
</template>
