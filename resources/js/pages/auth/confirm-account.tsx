import { Head, useForm, usePage } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import ErrorPage from '@/components/errors';

type ConfirmAccountForm = {
    otp: string;
    email: string;
    password: string;
    // password_confirmation: string;
};

export default function ConfirmAccount() {
    const { data, setData, post, processing, errors, reset } = useForm<Required<ConfirmAccountForm>>({
        otp: '',
        email: '',
        password: '',
        // password_confirmation: '',
    });

    const serverError = usePage().props.errors?.error
    
    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('confirm_account'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <AuthLayout title="Confirm Your Account" description="Please enter your new password below">
            <Head title="Confirm Your Account" />

            <form onSubmit={submit}>
                {
                    serverError?.message && (
                        <div className='text-red-600 py-4 capitalize font-medium'>
                            { serverError?.message }
                        </div>
                    )
                }
                
                <div className="grid gap-6">
                    <div className="grid gap-2">
                        <Label htmlFor="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            autoComplete="email"
                            autoFocus
                            value={data.email}
                            className="mt-1 block w-full"
                            onChange={(e) => setData('email', e.target.value)}
                        />
                        <InputError message={errors.email} className="mt-2" />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="otp">OTP Token</Label>
                        <Input
                            id="otp"
                            type="text"
                            name="otp"
                            autoComplete="otp"
                            value={data.otp}
                            className="mt-1 block w-full"
                            onChange={(e) => setData('otp', e.target.value)}
                        />
                        <InputError message={errors.otp} className="mt-2" />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="password">Password</Label>
                        <Input
                            id="password"
                            type="password"
                            name="password"
                            autoComplete="new-password"
                            value={data.password}
                            className="mt-1 block w-full"
                            onChange={(e) => setData('password', e.target.value)}
                            placeholder="Password"
                        />
                        <InputError message={errors.password} />
                    </div>

                    <Button type="submit" className="mt-4 w-full" disabled={processing}>
                        {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                        Confirm Your Account
                    </Button>
                </div>
            </form>
        </AuthLayout>
    );
}
