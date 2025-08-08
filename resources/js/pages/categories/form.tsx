import AppLayout from '@/layouts/app-layout';
import { CategoryItem, type BreadcrumbItem } from '@/types';
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
        title: 'Categories',
        href: '/categories',
    },
];

type CategoryForm = {
    name: string;
    description: string;
    id: string | null;
};

export default function Dashboard() {
    // @ts-ignore
    const category: CategoryItem = usePage().props.category

    const { data, setData, post, processing, errors, reset } = useForm<Required<CategoryForm>>({
        name: category?.name || '',
        description: category?.description || '',
        id: category?.id || null,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('categories.store'), {
            onSuccess: () => {
                alert('Category Saved Successfully!!!')
                router.visit('/categories ')
            } 
        });
    };


    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Categories" />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="bg-transparent shadow-sm overflow-hidden sm:rounded-lg my-4">
                    <div className="px-4 py-5 w-full md:max-w-lg">
                        <form onSubmit={submit} className="space-y-2">
                            <div className="grid gap-2">
                                <Label htmlFor="name">Name</Label>
                                <Input
                                    id="name"
                                    type="text"
                                    required
                                    autoFocus
                                    autoComplete="name"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    placeholder="category name..."
                                />
                                <InputError message={errors.name} />
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