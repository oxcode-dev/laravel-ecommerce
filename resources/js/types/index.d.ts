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