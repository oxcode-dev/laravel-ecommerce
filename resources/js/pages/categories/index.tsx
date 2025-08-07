import AppLayout from '@/layouts/app-layout';
import { CategoryItem, type BreadcrumbItem, CategoryType } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { Link } from '@inertiajs/react'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/categories',
    },
];

export default function Dashboard() {
    // @ts-ignore
    const categories: CategoryType = usePage().props.categories
    const categoriesData: CategoryItem[] = categories?.data || {}

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div className="flex justify-end px-4">
                <Link href={`/`} className="bg-blue-600 text-white rounded-lg px-4 py-2">
                    Create
                </Link>
            </div>
            <div className="relative min-h-[100vh] rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                
                <div>
                    <table className="min-w-full bg-transparent">
                        <thead>
                            <tr className="bg-gray-500 text-white border-b">
                                <th className="py-3 px-4 text-left">Name</th>
                                <th className="py-3 px-4 text-left">Slug</th>
                                {/* <th className="py-3 px-4 text-left">Product</th> */}
                                <th className="py-3 px-4 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody className="">
                            {
                                categoriesData.map((category, key) => (
                                    <tr v-for="(category, key) in categoriesData" key={key} className="border-b border-blue-gray-200 capitalize">
                                        <td className="py-3 px-4">{ category?.name || '' }</td>
                                        <td className="py-3 px-4 capitalize">{ category?.slug || '' }</td>
                                        {/* <td className="py-3 px-4">{{ category?.products .length || 0 }}</td> */}
                                        <td className="py-3 px-4">
                                            <Link href={`/categories/${category.id}`} className="font-medium text-blue-600 hover:text-blue-800">
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
                    {/* <Pager :item="categories" /> */}
                </div>
            </div>
        </div>
        </AppLayout>
    )
};