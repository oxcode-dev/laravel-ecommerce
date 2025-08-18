import Pager from '@/components/Pager';
import { formatDate } from '@/helper';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, OrderItemsType, OrderItemsPropType } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { Link } from '@inertiajs/react'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: '/orders',
    },
];

export default function Dashboard() {
    // @ts-ignore
    const orderItems: OrderItemsPropType = usePage().props.orderItems
    const orderItemsData: OrderItemsType[] = orderItems?.data || {}

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Orders" />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div className="flex justify-end px-4">
                <Link href="/products/create" className="bg-blue-600 text-white rounded-lg px-4 py-2">
                    Create
                </Link>
            </div>
            <div className="relative min-h-[100vh] rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                
                <div>
                    <table className="min-w-full bg-transparent">
                        <thead>
                            <tr className="bg-gray-500 text-white border-b">
                                <th className="py-3 px-4 text-left">Product</th>
                                <th className="py-3 px-4 text-left">Quantity</th>
                                <th className="py-3 px-4 text-left">Unit Price($)</th>
                                <th className="py-3 px-4 text-left">Date</th>
                                <th className="py-3 px-4 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody className="">
                            {
                                orderItemsData.map((item, key) => (
                                    <tr key={key} className="border-b border-blue-gray-200 capitalize">
                                        <td className="py-3 px-4">{ item?.product?.title || '' }</td>
                                        <td className="py-3 px-4 capitalize">{ item?.quantity || 0 }</td>
                                        <td className="py-3 px-4">{ item?.unit_price }</td>
                                        <td className="py-3 px-4">{ formatDate(item?.created_at || null) }</td>
                                        <td className="py-3 px-4">
                                            <Link href={`/order-items/${item.id}`} className="font-medium text-blue-600 hover:text-blue-800">
                                                View
                                            </Link>
                                        </td>
                                    </tr>
                                ))
                            }
                            
                        </tbody>
                    </table>
                </div>

                <div className="py-6">
                    <Pager 
                        prev_page_url={orderItems?.prev_page_url}
                        next_page_url={orderItems?.next_page_url}
                        last_page={orderItems?.last_page}
                        current_page={orderItems?.current_page}
                    />
                </div>
            </div>
        </div>
        </AppLayout>
    )
};