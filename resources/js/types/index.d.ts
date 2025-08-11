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
    role: string;
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
    address: AddressItem;
    user: User | null;
    user_id: string;
    payment_method: string | null;
    payment_status: string | null;
    total_amount: number | null;
    delivery_cost: number | null;
    created_at: string | null;
    order_items: []
}

export interface OrderType {
    prev_page_url: string;
    next_page_url: string;
    last_page: string;
    current_page: string;
    data: OrderItem[];
}

export interface AddressItem {
    id: string;
    user_id: string;
    phone: string | null;
    street: string | null;
    city: string | null;
    state: string | null;
    country: string | null;
    postal_code: string | null;
    is_default: boolean;
    created_at: string;
}

export interface OrderItemsType {
    id: number,
    order_id: string;
    product_id: string;
    quantity: number;
    unit_price: number;
    created_at: string;
    product: ProductItem;
}

export interface UserType {
    prev_page_url: string;
    next_page_url: string;
    last_page: string;
    current_page: string;
    data: User[];
}