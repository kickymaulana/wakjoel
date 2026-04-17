<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { Head, Link, useForm } from "@inertiajs/vue3"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card"
import { IconArrowLeft, IconDeviceFloppy, IconLoader2 } from "@tabler/icons-vue"

defineOptions({ layout: AuthenticatedLayout })

const props = defineProps<{
    menu: {
        id: number
        nama_item: string
        harga: number
        is_available: boolean
    }
}>()

const form = useForm({
    nama_item: props.menu.nama_item,
    harga: props.menu.harga,
    is_available: props.menu.is_available,
})

const submit = () => {
    // Gunakan put sesuai dengan route
    form.put(route('menus.update', props.menu.id))
}
</script>

<template>
    <Head :title="'Edit Lauk - ' + menu.nama_item" />

    <div class="flex flex-col gap-6 p-4 md:p-8 pt-4">
        <div class="flex items-center gap-4">
            <Button variant="outline" size="icon" as-child>
                <Link :href="route('menus.index')">
                    <IconArrowLeft class="size-4" />
                </Link>
            </Button>
            <div>
                <h2 class="text-2xl font-bold tracking-tight">Edit Lauk</h2>
                <p class="text-muted-foreground text-sm">Sesuaikan nama atau harga lauk Wakjoel.</p>
            </div>
        </div>

        <div class="max-w-xl">
            <Card>
                <CardHeader>
                    <CardTitle>Informasi Lauk</CardTitle>
                    <CardDescription>Perubahan harga akan langsung berpengaruh pada pesanan baru.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid gap-2">
                            <Label for="nama">Nama Lauk</Label>
                            <Input id="nama" v-model="form.nama_item" />
                            <p v-if="form.errors.nama_item" class="text-sm text-destructive">{{ form.errors.nama_item }}</p>
                        </div>

                        <div class="grid gap-2">
                            <Label for="harga">Harga Satuan (Rp)</Label>
                            <Input id="harga" type="number" v-model="form.harga" />
                            <p v-if="form.errors.harga" class="text-sm text-destructive">{{ form.errors.harga }}</p>
                        </div>

                        <div class="flex items-center space-x-2">
                            <input
                                type="checkbox"
                                id="is_available"
                                v-model="form.is_available"
                                class="rounded border-gray-300 text-primary focus:ring-primary"
                            />
                            <Label for="is_available">Lauk Tersedia</Label>
                        </div>

                        <div class="flex justify-end pt-4">
                            <Button type="submit" :disabled="form.processing">
                                <IconLoader2 v-if="form.processing" class="mr-2 size-4 animate-spin" />
                                <IconDeviceFloppy v-else class="mr-2 size-4" />
                                Simpan Perubahan
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
