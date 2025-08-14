import { formatDate } from '@/helper';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, User, ProductItem, OrderItem, AddressItem } from '@/types';
import { Head, router, useForm, usePage } from '@inertiajs/react';
import { Link } from '@inertiajs/react'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/users',
    },
];

export default function Dashboard() {
    // @ts-ignore
    const authUser: User = usePage().props.auth?.user;
    // @ts-ignore
    const user: User = usePage().props.user;
    const products: ProductItem[] = user?.products
    const orders: OrderItem[] = user?.orders
    const addresses: AddressItem[] = user?.addresses

    const form = useForm({});

    const handleDeleteUser = () => {
        if(confirm('Are you sure, you want to delete this user?')) {
            form.delete(route('users.delete', { user: user.id }), {
                onSuccess: () => {
                    alert('User deleted Successfully!!!')
                    router.visit('/users')
                } 
            });
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Users" />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                { authUser.role === 'ADMIN' ? 
                    <div className="flex justify-end px-4 space-x-3">
                        <a onClick={ () => handleDeleteUser() } href="#" className="bg-red-600 text-white rounded-lg px-4 py-2">
                            Delete
                        </a>    
                    </div>
                    : null
                }
                <div className="bg-transparent shadow-sm overflow-hidden sm:rounded-lg my-4">
                    <div className="px-4 py-5 sm:p-0">
                        <dl className="sm:divide-y sm:divide-gray-200 capitalize text-gray-900 dark:text-gray-100">
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Name</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ user?.name || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Email</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ user?.email || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Phone</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ user?.phone || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Role</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ user?.role || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Created Date</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ formatDate(user?.created_at || '') }</dd>
                            </div>
                            
                        </dl>
                    </div>
                </div>

                { user?.role === 'VENDOR' && products.length > 0 ? <p className='text-xl font-semibold'>Products</p> : null }
                { user?.role === 'VENDOR' && products.length > 0 ? 
                    <div className='py-4'>
                        <table className="min-w-full bg-transparent">
                            <thead>
                                <tr className="bg-gray-500 text-white border-b">
                                    <th className="py-3 px-4 text-left">Title</th>
                                    <th className="py-3 px-4 text-left">Category</th>
                                    <th className="py-3 px-4 text-left">Price($)</th>
                                    <th className="py-3 px-4 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody className="">
                                {
                                    products.map((product, key) => (
                                        <tr key={key} className="border-b border-blue-gray-200 capitalize">
                                            <td className="py-3 px-4">{ product?.title || '' }</td>
                                            <td className="py-3 px-4">{ product?.category?.name }</td>
                                            <td className="py-3 px-4 capitalize">{ product?.price || '' }</td>
                                            <td className="py-3 px-4">
                                                <Link href={`/products/${product.id}`} className="font-medium text-blue-600 hover:text-blue-800">
                                                    View
                                                </Link>
                                            </td>
                                        </tr>
                                    ))
                                }
                                
                            </tbody>
                        </table>
                    </div>
                    : null
                }

                { user?.role === 'CUSTOMER' && orders.length > 0 ? <p className='text-xl font-semibold'>Orders</p> : null }
                { user?.role === 'CUSTOMER' && orders.length > 0 ? 
                    <div className='py-4'>
                        <table className="min-w-full bg-transparent">
                            <thead>
                                <tr className="bg-gray-500 text-white border-b">
                                    <th className="py-3 px-4 text-left">Date</th>
                                    <th className="py-3 px-4 text-left">Total($)</th>
                                    <th className="py-3 px-4 text-left">Status</th>
                                    <th className="py-3 px-4 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody className="">
                                {
                                    orders.map((order, key) => (
                                        <tr key={key} className="border-b border-blue-gray-200 capitalize">
                                            <td className="py-3 px-4">{ order?.created_at }</td>
                                            <td className="py-3 px-4 capitalize">{ order?.total_amount || 0 }</td>
                                            <td className="py-3 px-4">{ order?.status }</td>
                                            <td className="py-3 px-4">
                                                <Link href={`/orders/${order.id}`} className="font-medium text-blue-600 hover:text-blue-800">
                                                    View
                                                </Link>
                                            </td>
                                        </tr>
                                    ))
                                }
                                
                            </tbody>
                        </table>
                    </div>
                    : null
                }

                { user?.role === 'CUSTOMER' && addresses.length > 0 ? <p className='text-xl font-semibold'>Addresses</p> : null }
                { user?.role === 'CUSTOMER' && addresses.length > 0 ? 
                    <div className='py-4 flex flex-wrap md:flex-nowrap'>
                        {
                            addresses.map((address) => (
                                <div className="w-full md:w-1/3 bg-transparent p-3 border mr-2 rounded-md h-48 space-y-2">
                                    <div className='space-y-1'>
                                        <h2 className="text-sm dark:text-white text-gray-600 font-semibold mb-2">Shipping Details</h2>
                                        <p className="text-xs capitalize space-x-1.5">
                                            <span>Street:</span>
                                            <span className='font-medium'>{ address?.street || 'N/A' }</span>
                                        </p>
                                        <p className="text-xs capitalize space-x-1.5">
                                            <span>Phone:</span>
                                            <span className='font-medium'>{ user?.phone || 'N/A' }</span>
                                        </p>
                                        <p className="text-xs capitalize space-x-1.5">
                                            <span>Postal Code:</span>
                                            <span className='font-medium'>{ address?.postal_code || 'N/A' }</span>
                                        </p>
                                        <p className="text-xs capitalize space-x-1.5">
                                            <span>City:</span>
                                            <span className='font-medium'>{ address?.city || 'N/A' }</span>
                                        </p>
                                        <p className="text-xs capitalize space-x-1.5">
                                            <span>State:</span>
                                            <span className='font-medium'>{ address?.state || 'N/A' }</span>
                                        </p>
                                        <p className="text-xs capitalize space-x-1.5">
                                            <span>Country:</span>
                                            <span className='font-medium'>{ address?.country || 'N/A' }</span>
                                        </p>
                                    </div>
                                </div>
                            ))
                        }
                    </div>
                    : null
                }

            </div>

        </AppLayout>
    )
}