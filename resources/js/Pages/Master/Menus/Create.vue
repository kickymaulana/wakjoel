<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { Head, Link, useForm } from "@inertiajs/vue3"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { IconArrowLeft, IconDeviceFloppy } from "@tabler/icons-vue"

defineOptions({ layout: AuthenticatedLayout })

const form = useForm({
    nama_item: '',
    harga: '',
    is_available: true,
})

const submit = () => {
    form.post(route('menus.store'))
}
</script>

<template>
    <Head title="Tambah Lauk" />
    <div class="flex flex-col gap-6 p-4 md:p-8 pt-4">
        <div class="flex items-center gap-4">
            <Button variant="outline" size="icon" as-child>
                <Link :href="route('menus.index')"><IconArrowLeft class="size-4" /></Link>
            </Button>
            <h2 class="text-2xl font-bold">Tambah Lauk Baru</h2>
        </div>
        <div class="max-w-xl">
            <Card>
                <CardContent class="pt-6">
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <Label for="nama">Nama Item (Contoh: Bakwan Jagung)</Label>
                            <Input id="nama" v-model="form.nama_item" placeholder="Rendang Daging..." />
                            <p v-if="form.errors.nama_item" class="text-xs text-destructive">{{ form.errors.nama_item }}</p>
                        </div>
                        <div>
                            <Label for="harga">Harga (Satuan)</Label>
                            <Input id="harga" type="number" v-model="form.harga" placeholder="15000" />
                            <p v-if="form.errors.harga" class="text-xs text-destructive">{{ form.errors.harga }}</p>
                        </div>
                        <div class="flex items-center gap-2 pt-2">
                            <input type="checkbox" id="avail" v-model="form.is_available" />
                            <Label for="avail">Lauk Masih Tersedia?</Label>
                        </div>
                        <Button type="submit" class="w-full" :disabled="form.processing">
                            <IconDeviceFloppy class="mr-2 size-4" /> Simpan Menu
                        </Button>
                    </form>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
