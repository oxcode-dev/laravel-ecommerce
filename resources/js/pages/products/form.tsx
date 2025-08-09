import AppLayout from '@/layouts/app-layout';
import { ProductItem, type BreadcrumbItem, CategoryItem } from '@/types';
import { Head, router, useForm, usePage } from '@inertiajs/react';
import { Link } from '@inertiajs/react'
import { Switch } from '@headlessui/react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { FormEventHandler } from 'react';
import { LoaderCircle } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
];

type ProductForm = {
    title: string;
    description: string;
    summary: string;
    category_id: string;
    id: string | null;
    stock: number | null;
    price: number | null;
    is_active: boolean;
};

export default function Dashboard() {
    // @ts-ignore
    const product: ProductItem = usePage().props.product
    // @ts-ignore
    const categories: CategoryItem[] = usePage().props.categories
    const { data, setData, post, processing, errors, reset } = useForm<Required<ProductForm>>({
        title: product?.title || '',
        description: product?.description || '',
        summary: product?.summary || '',
        stock: product?.stock || null,
        price: product?.price || null,
        is_active: product?.is_active || false,
        category_id: product?.category?.id || '',
        id: product?.id || null,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('products.store'), {
            onSuccess: () => {
                alert('Product Saved Successfully!!!')
                router.visit('/products ')
            } 
        });
    };


    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Products" />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="bg-transparent shadow-sm overflow-hidden sm:rounded-lg my-4">
                    <div className="px-4 py-5 w-full md:max-w-lg">
                        <form onSubmit={submit} className="space-y-4">
                            <div className="grid gap-2">
                                <Label htmlFor="title">Title</Label>
                                <Input
                                    id="title"
                                    type="text"
                                    required
                                    autoFocus
                                    autoComplete="title"
                                    value={data.title}
                                    onChange={(e) => setData('title', e.target.value)}
                                    placeholder="Product title..."
                                />
                                <InputError message={errors.title} />
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="category_id">Category</Label>
                                <select
                                    id="category_id"
                                    required
                                    value={data?.category_id}
                                    onChange={(e) => setData('category_id', e.target.value)}
                                    className="block w-full pl-2 pr-10 py-2 text-base border focus:border-gray-300 focus:outline-hidden sm:text-sm rounded-md capitalize"
                                >
                                    {
                                        categories.map((category) => (
                                            <option key={category.id} value={category.id}>
                                                { category.name }
                                            </option>
                                        ))
                                    }
                                </select>
                                <InputError message={errors.category_id} />
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="price">Price ($)</Label>
                                <Input
                                    id="price"
                                    type="number"
                                    required
                                    autoFocus
                                    autoComplete="price"
                                    value={data?.price || 0}
                                    onChange={(e) => setData('price', Number(e.target.value))}
                                    placeholder="Product price..."
                                />
                                <InputError message={errors.price} />
                            </div>
                        
                            <div className="grid gap-2">
                                <Label htmlFor="stock">Stock</Label>
                                <Input
                                    id="stock"
                                    type="number"
                                    required
                                    autoFocus
                                    autoComplete="stock"
                                    value={data?.stock || 0}
                                    onChange={(e) => setData('stock', Number(e.target.value))}
                                    placeholder="Product stock..."
                                />
                                <InputError message={errors.stock} />
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="summary">Summary</Label>
                                <textarea
                                    id="summary"
                                    required
                                    v-model="form.summary"
                                    value={data.summary}
                                    onChange={(e) => setData('summary', e.target.value)}
                                    rows={6}
                                    className="block w-full pl-2 pr-10 py-2 text-base border focus:border-gray-300 focus:outline-hidden sm:text-sm rounded-md capitalize"
                                    placeholder="summary..."
                                ></textarea>
                                <p className='text-xs'>
                                    Note: Characters must not exceed 200
                                </p>
                                <InputError message={errors.summary} />
                            </div>
                        
                            <div className="grid gap-2">
                                <Label htmlFor="description">Description</Label>
                                <textarea
                                    id="description"
                                    required
                                    v-model="form.description"
                                    value={data.description}
                                    onChange={(e) => setData('description', e.target.value)}
                                    rows={6}
                                    className="block w-full pl-2 pr-10 py-2 text-base border focus:border-gray-300 focus:outline-hidden sm:text-sm rounded-md capitalize"
                                    placeholder="Description..."
                                ></textarea>
                                <InputError message={errors.description} />
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="is_active">Activate Product</Label>
                                <div className='inline-flex items-center space-x-4'>
                                    <Switch
                                        checked={data.is_active}
                                        onChange={(e) => setData('is_active', !data.is_active)}
                                        className="group relative flex h-7 w-14 cursor-pointer border rounded-full bg-gray-600 dark:bg-white/10 p-1 ease-in-out focus:not-data-focus:outline-none dark:data-checked:bg-white/10 data-focus:outline data-focus:outline-white"
                                    >
                                        <span
                                        aria-hidden="true"
                                        className="pointer-events-none inline-block size-5 translate-x-0 rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out group-data-checked:translate-x-7"
                                        />
                                    </Switch>

                                    <span>{ data.is_active ? 'Yes' : 'No'}</span>
                                </div>
                                <InputError message={errors.description} />
                            </div>

    

                            <div>
                                <Button type="submit" className="mt-4" disabled={processing}>
                                    {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                                    Submit
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </AppLayout>
    )
}