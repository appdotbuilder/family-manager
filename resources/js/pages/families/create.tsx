import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import InputError from '@/components/input-error';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, Link } from '@inertiajs/react';

type FamilyFormData = {
    name: string;
    description: string;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Create Family',
        href: '/families/create',
    },
];

export default function CreateFamily() {
    const { data, setData, post, processing, errors } = useForm<FamilyFormData>({
        name: '',
        description: ''
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/families');
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Family" />
            
            <div className="max-w-2xl mx-auto">
                <div className="mb-6">
                    <h1 className="text-3xl font-bold text-gray-900">👨‍👩‍👧‍👦 Create New Family</h1>
                    <p className="text-gray-600 mt-1">
                        Start managing your family members and their information
                    </p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Family Details</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSubmit} className="space-y-6">
                            <div>
                                <Label htmlFor="name">Family Name *</Label>
                                <Input
                                    id="name"
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    placeholder="e.g., The Smith Family"
                                    className="mt-1"
                                />
                                <InputError message={errors.name} className="mt-2" />
                            </div>

                            <div>
                                <Label htmlFor="description">Description</Label>
                                <Textarea
                                    id="description"
                                    value={data.description}
                                    onChange={(e) => setData('description', e.target.value)}
                                    placeholder="Optional description about your family..."
                                    className="mt-1"
                                    rows={3}
                                />
                                <InputError message={errors.description} className="mt-2" />
                                <p className="text-sm text-gray-500 mt-1">
                                    This helps identify the family group and its purpose.
                                </p>
                            </div>

                            <div className="flex items-center justify-between pt-4">
                                <Link href="/dashboard">
                                    <Button type="button" variant="outline">
                                        Cancel
                                    </Button>
                                </Link>
                                <Button type="submit" disabled={processing}>
                                    {processing ? 'Creating...' : '✅ Create Family'}
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>

                {/* Info Card */}
                <Card className="mt-6">
                    <CardContent className="pt-6">
                        <div className="flex items-start space-x-3">
                            <div className="text-2xl">💡</div>
                            <div>
                                <h3 className="font-medium text-gray-900 mb-2">What happens next?</h3>
                                <ul className="text-sm text-gray-600 space-y-1">
                                    <li>• You'll be set as the family owner with full permissions</li>
                                    <li>• You can start adding family members and their information</li>
                                    <li>• Invite other family members with different access levels</li>
                                    <li>• Manage medical records and emergency contacts</li>
                                </ul>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}