import AppLayout from '@/layouts/app-layout';
import { ProductItem, type BreadcrumbItem } from '@/types';
import { Head, router, useForm, usePage } from '@inertiajs/react';
import { Link } from '@inertiajs/react'

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
    status: string;
    id: string | null;
    stock: number;
    price: number;
    is_active: boolean;
};

export default function Dashboard() {
    // @ts-ignore
    const product: ProductItem = usePage().props.product
    const { data, setData, post, processing, errors, reset } = useForm<Required<ProductForm>>({
        title: product?.title || '',
        description: product?.description || '',
        summary: product?.description || '',
        status: product?.description || '',
        stock: product?.stock || 0,
        price: product?.price || 0,
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
                        <form onSubmit={submit} className="space-y-2">
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