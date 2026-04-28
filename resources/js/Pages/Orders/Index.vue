<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { Head, Link } from "@inertiajs/vue3"
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table"
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import {
    IconPlus,
    IconToolsKitchen2,
    IconClipboardList,
    IconCheck,
    IconClock
} from "@tabler/icons-vue"
import { router } from "@inertiajs/vue3"

const markAsDone = (id: number) => {
    if (confirm('Nasi sudah sampai?')) {
        router.patch(route('orders.updateStatus', id), {
            status: 'selesai'
        }, { preserveScroll: true })
    }
}

defineOptions({ layout: AuthenticatedLayout })

const props = defineProps<{
    orders: {
        data: Array<{
            id: number
            user: { name: string }
            total_harga: number
            status: string
            catatan_khusus: string | null
            created_at: string
            items: Array<{
                id: number
                jumlah: number
                subtotal: number
                menu: { nama_item: string }
            }>
        }>
        links: any
    }
}>()

const formatRupiah = (number: number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        maximumFractionDigits: 0,
    }).format(number)
}

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleString('id-ID', {
        day: '2-digit',
        month: 'short',
        hour: '2-digit',
        minute: '2-digit'
    })
}
</script>

<template>
    <Head title="Riwayat Pesanan Wakjoel" />

    <div class="flex flex-col gap-6 p-4 md:p-8 pt-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight">Pesanan Wakjoel</h2>
                <p class="text-muted-foreground text-sm">Pantau pesanan nasi padang tim hari ini.</p>
            </div>
            <Button as-child size="lg" class="shadow-md">
                <Link :href="route('orders.create')">
                    <IconPlus class="mr-2 size-5" />
                    Pesan Sekarang
                </Link>
            </Button>
        </div>

        <Card class="border-none shadow-sm">
            <CardHeader>
                <CardTitle class="flex items-center gap-2">
                    <IconClipboardList class="size-5 text-primary" />
                    Daftar Antrean Makan
                </CardTitle>
                <CardDescription>
                    Total pesanan masuk: {{ orders.data.length }} orang.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <div class="rounded-md border overflow-hidden">
                    <Table>
                        <TableHeader>
                            <TableRow class="bg-muted/50">
                                <TableHead class="w-[180px]">Waktu & Nama</TableHead>
                                <TableHead>Detail Lauk (Item)</TableHead>
                                <TableHead>Catatan</TableHead>
                                <TableHead>Total</TableHead>
                                <TableHead class="text-center">Status</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-if="orders.data.length === 0">
                                <TableCell colspan="5" class="h-32 text-center text-muted-foreground">
                                    Belum ada yang pesan nih, yuk makan!
                                </TableCell>
                            </TableRow>

                            <TableRow v-for="order in orders.data" :key="order.id" class="group">
                                <TableCell>
                                    <div class="flex flex-col">
                                        <span class="font-bold uppercase text-sm">{{ order.user.name }}</span>
                                        <span class="text-[10px] text-muted-foreground flex items-center gap-1">
                                            <IconClock class="size-3" /> {{ formatDate(order.created_at) }}
                                        </span>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="flex flex-wrap gap-1">
                                        <Badge v-for="item in order.items" :key="item.id" variant="secondary" class="font-normal text-[11px]">
                                            {{ item.menu.nama_item }} ({{ item.jumlah }})
                                        </Badge>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <span class="text-xs italic text-muted-foreground">
                                        {{ order.catatan_khusus ?? '-' }}
                                    </span>
                                </TableCell>
                                <TableCell>
                                    <span class="font-semibold text-primary">
                                        {{ formatRupiah(order.total_harga) }}
                                    </span>
                                </TableCell>



                                <TableCell class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <Badge :variant="order.status === 'selesai' ? 'default' : 'outline'" class="capitalize">
                                            {{ order.status }}
                                        </Badge>

                                        <Button
                                            v-if="order.status === 'diproses'"
                                            size="icon"
                                            variant="ghost"
                                            class="size-8 text-green-600 hover:text-green-700 hover:bg-green-50"
                                            @click="markAsDone(order.id)"
                                        >
                                            <IconCheck class="size-4" />
                                        </Button>
                                    </div>
                                </TableCell>


                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </CardContent>
        </Card>

    </div>
</template>
