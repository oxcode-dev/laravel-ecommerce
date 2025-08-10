import Pager from '@/components/Pager';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, User as UserItem, UserType } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { Link } from '@inertiajs/react'
import { Tab, TabList, TabGroup } from '@headlessui/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/users',
    },
];

export default function Dashboard() {
    // @ts-ignore
    const users: UserType = usePage().props.users
    const usersData: UserItem[] = users?.data || {}

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Users - Vendors" />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex flex-wrap md:flex-nowrap justify-between px-4">

                    <div>
                        <nav className='inline-flex space-x-4'>
                            <Link href='/users'>
                                Vendors
                            </Link>
                            <Link href='/users/customers'>
                                Customers
                            </Link>
                        </nav>
                    </div>
                    <Link href="/products/create" className="bg-blue-600 text-white rounded-lg px-4 py-2">
                        Create
                    </Link>
                </div>
                <div className="relative min-h-[100vh] rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    
                    <div>
                        <table className="min-w-full bg-transparent">
                            <thead>
                                <tr className="bg-gray-500 text-white border-b">
                                    <th className="py-3 px-4 text-left">User</th>
                                    <th className="py-3 px-4 text-left">Email</th>
                                    <th className="py-3 px-4 text-left">Date</th>
                                    <th className="py-3 px-4 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody className="">
                                {
                                    usersData.map((user, key) => (
                                        <tr key={key} className="border-b border-blue-gray-200 capitalize">
                                            <td className="py-3 px-4">{ user?.name || '' }</td>
                                            <td className="py-3 px-4 lowercase">{ user?.email || '' }</td>
                                            <td className="py-3 px-4">{ user?.created_at }</td>
                                            <td className="py-3 px-4">
                                                <Link href={`/users/${user.id}`} className="font-medium text-blue-600 hover:text-blue-800">
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
                            prev_page_url={users?.prev_page_url}
                            next_page_url={users?.next_page_url}
                            last_page={users?.last_page}
                            current_page={users?.current_page}
                        />
                    </div>
                </div>
            </div>
        </AppLayout>
    )
};