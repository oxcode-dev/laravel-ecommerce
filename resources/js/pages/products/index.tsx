import Pager from '@/components/Pager';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, ProductType, ProductItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { Link } from '@inertiajs/react'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
];

export default function Dashboard() {
    // @ts-ignore
    const products: ProductType = usePage().props.products
    const productsData: ProductItem[] = products?.data || {}

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Products" />

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
                                <th className="py-3 px-4 text-left">Title</th>
                                <th className="py-3 px-4 text-left">Category</th>
                                <th className="py-3 px-4 text-left">Price($)</th>
                                <th className="py-3 px-4 text-left">Owner</th>
                                <th className="py-3 px-4 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody className="">
                            {
                                productsData.map((product, key) => (
                                    <tr v-for="(product, key) in productsData" key={key} className="border-b border-blue-gray-200 capitalize">
                                        <td className="py-3 px-4">{ product?.title || '' }</td>
                                        <td className="py-3 px-4">{ product?.category?.name }</td>
                                        <td className="py-3 px-4 capitalize">{ product?.price || '' }</td>
                                        <td className="py-3 px-4">{ product?.user?.name }</td>
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

                <div className="py-6">
                    <Pager 
                        prev_page_url={products?.prev_page_url}
                        next_page_url={products?.next_page_url}
                        last_page={products?.last_page}
                        current_page={products?.current_page}
                    />
                </div>
            </div>
        </div>
        </AppLayout>
    )
};