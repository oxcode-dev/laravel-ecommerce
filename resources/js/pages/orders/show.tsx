import AppLayout from '@/layouts/app-layout';
import { OrderItem, type BreadcrumbItem, ProductItem, OrderItemsType } from '@/types';
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
    const orderItems: OrderItemsType[] = order?.order_items

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
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Total Amount</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">$ { order?.total_amount || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Delivery Cost</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">$ { order?.delivery_cost || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Created Date</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ order?.created_at || '' }</dd>
                            </div>
                            
                        </dl>
                    </div>
                </div>

                <div className="my-8">
                    <div className="dark:bg-white dark:text-gray-700 bg-gray-200 py-3 px-4">
                        <p>Products</p>
                    </div>
                    <div className="w-full hidden sm:inline-block rounded-lg overflow-hidden">
                        <table className="leading-normal w-full">
                            <thead>
                                <tr>
                                    <th className="px-5 py-3 border-b-2 border-gray-200 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider"></th>
                                    <th className="px-5 py-3 border-b-2 border-gray-200 text-center font-semibold text-gray-600 tracking-wider">
                                        <h2 className="text-base">Price</h2>
                                    </th>
                                    <th className="px-5 py-3 border-b-2 border-gray-200 text-center font-semibold text-gray-600 tracking-wider">
                                        <h2 className="text-base">Quantity</h2>
                                    </th>
                                    <th className="px-5 py-3 border-b-2 border-gray-200 text-center font-semibold text-gray-600 tracking-wider">
                                        <h2 className="text-base">Total</h2>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td className="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                        <div className="flex items-center space-x-4 sm:space-x-6">
                                            <div className="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-auto hidden">
                                                <img className="w-full object-cover h-full rounded-lg" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2.2&amp;w=160&amp;h=160&amp;q=80" alt="" />
                                            </div>
                                            <div className="ml-3 flex flex-col">
                                                <a className="text-gray-700 whitespace-no-wrap text-sm ms:text-lg" href="/store/qhijYaI8qkPdxAiTf3cj">Nivea Body Lotion</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td className="px-5 py-4 border-b border-gray-200 bg-white text-lg text-center">
                                        <p className="text-gray-900 whitespace-no-wrap">$ 45</p>
                                    </td>
                                    <td className="px-5 py-4 border-b border-gray-200 bg-white text-sm text-center">
                                        <div className="inline-flex space-x-6">
                                            <p className="text-lg">1</p>
                                        </div>
                                    </td>
                                    <td className="px-5 py-4 border-b border-gray-200 bg-white text-lg text-center">
                                        <p className="text-gray-900 whitespace-no-wrap">$ 45</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div className="sm:hidden">
                        <div className="flex items-start space-x-4 border-t py-4 px-2">
                            <div className="flex-shrink-0 w-16 sm:h-auto mt-1.5">
                                <img className="w-full object-cover h-full rounded-lg" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2.2&amp;w=160&amp;h=160&amp;q=80" alt="" />
                            </div>
                            <div className="ml-3 w-full relative">
                                <a className="text-gray-700 whitespace-no-wrap font-medium text-base" href="/store/qhijYaI8qkPdxAiTf3cj">
                                    Voluptatem ut dolore Soap
                                </a>
                                <p className="text-gray-500 whitespace-no-wrap">$ 610</p>
                                <div className="space-x-2 flex items-center w-full">
                                    <div className="flex space-x-3 items-center text-sm text-gray-500">
                                        <span>qty: </span>
                                        <span>1</span>
                                    </div>
                                </div>
                                <div className="absolute bottom-1 right-0">
                                    <p className="text-gray-900 whitespace-no-wrap font-semibold text-xl">$ 610</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div className="flex justify-end py-8">
                        <div className="">
                            <div className="py-2 flex justify-end items-center space-x-4 text-gray-500">
                                <h6 className="font-medium text-sm">Subtotal</h6>
                                <h6 className="font-medium text-xl">$ 45</h6>
                            </div>
                            <div className="py-2 flex justify-end items-center space-x-4 text-gray-500">
                                <h6 className="font-medium text-sm">Shipping cost</h6>
                                <h6 className="font-medium text-xl">$ 8</h6>
                            </div>
                            <div className="py-2 flex justify-end items-end space-x-3">
                                <h3 className="uppercase font-semibold text-lg">Total</h3>
                                <h1 className="uppercase font-bold text-4xl">$ 53</h1>
                            </div>
                        </div>
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
                            {/* <p className="text-xs capitalize">VAT: $0.00</p> */}
                            <p className="text-xs capitalize">Shipping Cost: ${ order.delivery_cost || 0 }</p>
                            {/* <p className="text-xs capitalize">Sub-total: ${ moneyFormat(order.subTotal || 0) }</p> */}
                            {/* <p className="text-xs capitalize">Discount Amount: ${ moneyFormat(order.discountAmount || 0) }</p> */}
                            {/* <p className="text-xs capitalize">Total Cost: ${ moneyFormat(order.total || 0) }</p> */}
                        </div>
                    </div>
                </div>
            </div>

        </AppLayout>
    )
}