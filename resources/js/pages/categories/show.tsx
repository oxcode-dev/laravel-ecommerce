import { formatDate } from '@/helper';
import AppLayout from '@/layouts/app-layout';
import { CategoryItem, type BreadcrumbItem } from '@/types';
import { Head, router, useForm, usePage } from '@inertiajs/react';
import { Link } from '@inertiajs/react'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/categories',
    },
];

export default function Dashboard() {
    // @ts-ignore
    const category: CategoryItem = usePage().props.category

    const form = useForm({});

    const handleDeleteCategory = () => {
        if(confirm('Are you sure, you want to delete this category?')) {
            form.delete(route('categories.delete', { category: category.id }), {
                onFinish: () => {
                    alert('Category deleted Successfully!!!')
                    router.visit('/categories')
                } 
            });
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-end px-4 space-x-3">
                    <Link href={`/categories/${category?.id}/edit`} className="bg-blue-600 text-white rounded-lg px-4 py-2">
                        Edit
                    </Link>

                    <a onClick={ () => handleDeleteCategory() } href="#" className="bg-red-600 text-white rounded-lg px-4 py-2">
                        Delete
                    </a>
                </div>
                <div className="bg-transparent shadow-sm overflow-hidden sm:rounded-lg my-4">
                    <div className="px-4 py-5 sm:p-0">
                        <dl className="sm:divide-y sm:divide-gray-200 capitalize text-gray-900 dark:text-gray-100">
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Name</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ category?.name || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Slug</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ category?.slug || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">description</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ category?.description || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Created Date</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ formatDate(category?.created_at || '') }</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

        </AppLayout>
    )
}