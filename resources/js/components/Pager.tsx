import { Link } from "@inertiajs/react"

export interface PagerType {
    prev_page_url: string;
    next_page_url: string;
    last_page: string;
    current_page: string;
}

export default function Pager({prev_page_url, next_page_url, last_page, current_page}: PagerType) {
    return (
        <>
            <div className='flex items-center justify-center'>
                <div className="flex justify-center items-center space-x-4">
                    <div className="border rounded-md bg-gray-100 px-2 py-1 text-3xl leading-6 text-slate-400 transition hover:bg-gray-200 hover:text-slate-500 cursor-pointer shadow-sm">
                        <Link href="prev_page_url">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" className="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                            </svg>
                        </Link>
                    </div>
                    <div className="text-slate-500">
                        <span className="font-bold text-lg">{ `${current_page} ` }</span>
                        <span>{ ` / ${last_page}` }</span>
                        
                    </div>
                    <div className="border rounded-md bg-gray-100 px-2 py-1 text-3xl leading-6 text-slate-400 transition hover:bg-gray-200 hover:text-slate-500 cursor-pointer shadow-sm">
                        <Link href="next_page_url">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" className="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </>
    )
};