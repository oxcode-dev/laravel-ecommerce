import AppLayout from '@/layouts/app-layout';
import { OrderItem, type BreadcrumbItem } from '@/types';
import { Head, router, useForm, usePage } from '@inertiajs/react';
import { Link } from '@inertiajs/react'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: '/orders',
    },
];

export default function Dashboard() {
    // @ts-ignore
    const order: OrderItem = usePage().props.order

    const form = useForm({});

    const handleDeleteOrder = () => {
        if(confirm('Are you sure, you want to delete this order?')) {
            form.delete(route('orders.delete', { order: order.id }), {
                onSuccess: () => {
                    alert('Order deleted Successfully!!!')
                    router.visit('/orders')
                } 
            });
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Orders" />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-end px-4 space-x-3">
                    <Link href={`/orders/${order?.id}/edit`} className="bg-blue-600 text-white rounded-lg px-4 py-2">
                        Edit
                    </Link>

                    <a onClick={ () => handleDeleteOrder() } href="#" className="bg-red-600 text-white rounded-lg px-4 py-2">
                        Delete
                    </a>    
                </div>
                <div className="bg-transparent shadow-sm overflow-hidden sm:rounded-lg my-4">
                    <div className="px-4 py-5 sm:p-0">
                        <dl className="sm:divide-y sm:divide-gray-200 capitalize text-gray-900 dark:text-gray-100">
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Buyer Details</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2 inline-flex flex-col">
                                    <span>{order?.user?.name}</span>
                                    <span>{order?.user?.email}</span>
                                </dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Status</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ order?.status || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Payment Method</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ order?.payment_method || 'Cash' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Payment Status</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ order?.payment_status || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Total Amount</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">$ { order?.total_amount || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Delivery Cost</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">$ { order?.delivery_cost || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Status</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ order?.status || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Created Date</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ order?.created_at || '' }</dd>
                            </div>
                            
                        </dl>
                    </div>
                </div>

                <div className="flex mx-6 flex-wrap ">
                    <div className="w-full md:w-1/2 md:pr-3">
                        <div className="bg-transparent p-3 border mr-2 rounded-md h-48 space-y-2 my-2">
                            <h2 className="text-sm dark:text-white text-gray-600 font-semibold mb-2">Shipping Details</h2>
                            <p className="text-xs capitalize">{ order?.address?.street || 'N/A' }</p>
                            <p className="text-xs capitalize">{ order?.address?.phone || 'N/A' }</p>
                            <p className="text-xs capitalize">{ order?.address?.postal_code || 'N/A' }</p>
                            <p className="text-xs capitalize">{ order?.address?.city || 'N/A' }</p>
                            <p className="text-xs capitalize">{ order?.address?.state || 'N/A' }</p>
                            <p className="text-xs capitalize">{ order?.address?.country || 'N/A' }</p>
                        </div>
                    </div>
                    <div className="w-full md:w-1/2 md:pl-3">
                        <div className="bg-transparent p-3 border mr-2 rounded-md h-48 my-2 space-y-2">
                            <h2 className="text-sm dark:text-white text-gray-600 font-semibold mb-2">Payment Information</h2>
                            <p className="text-xs capitalize">Payment Status: { order?.payment_status }</p>
                            <p className="text-xs capitalize">Payment Method: { order?.payment_method || 'Cash' }</p>
                            {/* <p className="text-xs capitalize">VAT: £0.00</p> */}
                            <p className="text-xs capitalize">Shipping Cost: ${ order.delivery_cost || 0 }</p>
                            {/* <p className="text-xs capitalize">Sub-total: £{ moneyFormat(order.subTotal || 0) }</p> */}
                            {/* <p className="text-xs capitalize">Discount Amount: £{ moneyFormat(order.discountAmount || 0) }</p> */}
                            {/* <p className="text-xs capitalize">Total Cost: £{ moneyFormat(order.total || 0) }</p> */}
                        </div>
                    </div>
                </div>
            </div>

        </AppLayout>
    )
}