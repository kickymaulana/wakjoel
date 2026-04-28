<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { Head, useForm } from "@inertiajs/vue3"
import { ref, computed } from "vue"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card"
import { IconPlus, IconTrash, IconToolsKitchen2, IconDeviceFloppy, IconLoader2 } from "@tabler/icons-vue"

defineOptions({ layout: AuthenticatedLayout })

const props = defineProps<{
    menus: Array<{ id: number; nama_item: string; harga: number }>
}>()

const form = useForm({
    catatan: '',
    items: [] as Array<{ menu_id: number; jumlah: number; nama_item: string; harga: number }>
})

// Tambah item ke keranjang
const addItem = (menu: any) => {
    const existing = form.items.find(i => i.menu_id === menu.id)
    if (existing) {
        existing.jumlah++
    } else {
        form.items.push({
            menu_id: menu.id,
            nama_item: menu.nama_item,
            harga: menu.harga,
            jumlah: 1
        })
    }
}

const removeItem = (index: number) => {
    form.items.splice(index, 1)
}

// Hitung total harga otomatis (Client-side preview)
const totalHarga = computed(() => {
    return form.items.reduce((acc, item) => acc + (item.harga * item.jumlah), 0)
})

const submit = () => {
    form.post(route('orders.store'))
}

const formatRupiah = (number: number) => {
    return new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 }).format(number)
}
</script>

<template>
    <Head title="Pesan Nasi Wakjoel" />

    <div class="flex flex-col gap-6 p-4 md:p-8 pt-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-4">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <IconToolsKitchen2 class="size-5" /> Pilih Lauk Wakjoel
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <Card v-for="menu in menus" :key="menu.id"
                        class="cursor-pointer hover:border-primary transition-all active:scale-95"
                        @click="addItem(menu)">
                        <CardContent class="p-4 flex flex-col items-center text-center gap-1">
                            <span class="font-semibold text-sm">{{ menu.nama_item }}</span>
                            <span class="text-xs text-muted-foreground">{{ formatRupiah(menu.harga) }}</span>
                        </CardContent>
                    </Card>
                </div>
            </div>

            <div class="lg:col-span-1">
                <Card class="sticky top-20 shadow-lg border-primary/20">
                    <CardHeader>
                        <CardTitle>Detail Pesanan</CardTitle>
                        <CardDescription>Pesananmu akan tercatat otomatis agar tidak tertukar.</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div v-if="form.items.length === 0" class="text-center py-6 text-muted-foreground text-sm italic">
                            Belum ada lauk yang dipilih.
                        </div>

                        <div v-for="(item, index) in form.items" :key="index" class="flex justify-between items-center text-sm border-b pb-2">
                            <div>
                                <p class="font-medium">{{ item.nama_item }} x {{ item.jumlah }}</p>
                                <p class="text-xs text-muted-foreground">{{ formatRupiah(item.harga * item.jumlah) }}</p>
                            </div>
                            <Button variant="ghost" size="icon" class="size-8 text-destructive" @click="removeItem(index)">
                                <IconTrash class="size-4" />
                            </Button>
                        </div>

                        <div class="pt-2">
                            <Label for="catatan">Catatan (Misal: Bakwan pisah)</Label>
                            <Input id="catatan" v-model="form.catatan" placeholder="Tambahkan catatan..." class="mt-1" />
                        </div>

                        <div class="pt-4 border-t flex justify-between items-center">
                            <span class="font-bold">Total:</span>
                            <span class="text-xl font-bold text-primary">{{ formatRupiah(totalHarga) }}</span>
                        </div>

                        <Button class="w-full mt-4" :disabled="form.items.length === 0 || form.processing" @click="submit">
                            <IconLoader2 v-if="form.processing" class="mr-2 size-4 animate-spin" />
                            <IconDeviceFloppy v-else class="mr-2 size-4" />
                            Kirim ke Wakjoel
                        </Button>
                    </CardContent>
                </Card>
            </div>
        </div>
    </div>
</template>
