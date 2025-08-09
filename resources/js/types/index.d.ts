import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    categories: CategoryType;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}


export interface CategoryItem {
    id: string;
    name: string;
    slug: string;
    description: string | null;
    created_at: string | null;
}

export interface CategoryType {
    prev_page_url: string;
    next_page_url: string;
    last_page: string;
    current_page: string;
    data: CategoryItem[];
}

export interface ProductItem {
    id: string;
    title: string;
    slug: string;
    category: CategoryItem;
    user: User | null;
    description: string | null;
    summary: string | null;
    images: string | null;
    status: string | null;
    price: number | null;
    stock: number | null;
    created_at: string | null;
    is_active: boolean;
}

export interface ProductType {
    prev_page_url: string;
    next_page_url: string;
    last_page: string;
    current_page: string;
    data: ProductItem[];
}

export interface OrderItem {
    id: string;
    address_id: string;
    status: string;
    // category: CategoryItem;
    user: User | null;
    user_id: string;
    summary: string | null;
    payment_method: string | null;
    payment_status: string | null;
    total_amount: number | null;
    delivery_cost: number | null;
    created_at: string | null;
    is_active: boolean;
}
    //   "address_id" => "5c51f8e1-de9b-3948-9d46-5c283131dc5c"
    //   "address" => array:10 [▼
    //     "id" => "5c51f8e1-de9b-3948-9d46-5c283131dc5c"
    //     "user_id" => "01988fab-6bcd-7082-9827-213d98bdb54b"
    //     "street" => "8763 Randy Parkways Apt. 093"
    //     "city" => "Jazmynton"
    //     "state" => "Lake Roscoe"
    //     "country" => "United States of America"
    //     "postal_code" => "50234-1078"
    //     "is_default" => false
    //     "created_at" => "2025-08-09T16:30:32.000000Z"
    //     "updated_at" => "2025-08-09T16:30:32.000000Z"
    //   ]

export interface OrderType {
    prev_page_url: string;
    next_page_url: string;
    last_page: string;
    current_page: string;
    data: OrderItem[];
}