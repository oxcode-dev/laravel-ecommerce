import { formatDate, numberFormat } from '@/helper';
import AppLayout from '@/layouts/app-layout';
import { ProductItem, type BreadcrumbItem, ReviewItem } from '@/types';
import { Head, router, useForm, usePage } from '@inertiajs/react';
import { Link } from '@inertiajs/react'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
];

export default function Dashboard() {
    // @ts-ignore
    const product: ProductItem = usePage().props.product
    const reviews: ReviewItem[] = product?.reviews

    const form = useForm({});

    const handleDeleteProduct = () => {
        if(confirm('Are you sure, you want to delete this product?')) {
            form.delete(route('products.delete', { product: product.id }), {
                onFinish: () => {
                    alert('Product deleted Successfully!!!')
                    router.visit('/products')
                } 
            });
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-end px-4 space-x-3">
                    <Link href={`/products/${product?.id}/edit`} className="bg-blue-600 text-white rounded-lg px-4 py-2">
                        Edit
                    </Link>

                    <a onClick={ () => handleDeleteProduct() } href="#" className="bg-red-600 text-white rounded-lg px-4 py-2">
                        Delete
                    </a>    
                </div>
                <div className="bg-transparent shadow-sm overflow-hidden sm:rounded-lg my-4">
                    <div className="px-4 py-5 sm:p-0">
                        <dl className="sm:divide-y sm:divide-gray-200 capitalize text-gray-900 dark:text-gray-100">
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Title</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ product?.title || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Slug</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ product?.slug || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Category</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ product?.category?.name || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Owner</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ product?.user?.name || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Price</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">$ { numberFormat(product?.price || 0) }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Stock (Unit)</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ product?.stock || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Status</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ product?.status || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Summary</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ product?.summary || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">description</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ product?.description || '' }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Created Date</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ formatDate(product?.created_at || '') }</dd>
                            </div>
                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt className="text-sm font-medium text-gray-500 dark:text-white">Product Active</dt>
                                <dd className="mt-1 text-sm sm:mt-0 sm:col-span-2">{ product?.is_active ? 'Yes' : 'No' }</dd>
                            </div>
                        </dl>
    {/* images: string | null; */}
                    </div>
                </div>

                <div className={`${reviews.length > 0 ? 'flex flex-col' : 'hidden'}`}>
                    <h2 className='text-xl font-semibold'>
                        Product Reviews
                    </h2>

                    <div className='py-4 flex flex-wrap md:flex-nowrap'>
                        { reviews.map((review) => (
                            <div key={review.id} className="w-full md:w-1/3 bg-transparent p-3 border mr-2 rounded-md min-h-48 space-y-2">
                                <div className='space-y-1.5'>
                                    <h2 className="text-sm dark:text-white text-gray-600 font-semibold mb-2">{ review?.user?.name }</h2>
                                    <p className="text-xs capitalize space-x-1.5">
                                        <span className='underline'>Rating:</span>
                                        <p className='font-medium'>{ review?.rating || 'N/A' }</p>
                                    </p>
                                    <p className="text-xs capitalize space-x-1.5">
                                        <span className='underline'>Comment:</span>
                                        <p className='font-medium'>{ review?.comment || 'N/A' }</p>
                                    </p>
                                    <p className="text-xs capitalize space-x-1.5">
                                        <span className='underline'>Date:</span>
                                        <p className='font-medium'>{ formatDate(review?.created_at || '') }</p>
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>

        </AppLayout>
    )
}