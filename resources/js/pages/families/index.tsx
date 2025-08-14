import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface Family {
    id: number;
    name: string;
    description?: string;
    members_count: number;
    creator: {
        name: string;
    };
    created_at: string;
    [key: string]: unknown;
}

interface Props {
    families: Family[];
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Families',
        href: '/families',
    },
];

export default function FamiliesIndex({ families }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="All Families" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">👨‍👩‍👧‍👦 All Families</h1>
                        <p className="text-gray-600 mt-1">
                            Manage all families you have access to
                        </p>
                    </div>
                    <Link href="/families/create">
                        <Button>
                            ➕ Create Family
                        </Button>
                    </Link>
                </div>

                {/* Stats */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Total Families</CardTitle>
                            <div className="text-2xl">👥</div>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{families.length}</div>
                            <p className="text-xs text-muted-foreground">
                                Families you have access to
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Total Members</CardTitle>
                            <div className="text-2xl">👤</div>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">
                                {families.reduce((total, family) => total + family.members_count, 0)}
                            </div>
                            <p className="text-xs text-muted-foreground">
                                Across all families
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Your Role</CardTitle>
                            <div className="text-2xl">🔑</div>
                        </CardHeader>
                        <CardContent>
                            <div className="text-sm">
                                <div className="font-semibold">Mixed roles</div>
                                <p className="text-muted-foreground">
                                    Owner, Admin, Editor
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Families Grid */}
                <div>
                    {families.length === 0 ? (
                        <Card className="text-center py-12">
                            <CardContent>
                                <div className="text-6xl mb-4">👨‍👩‍👧‍👦</div>
                                <h3 className="text-lg font-semibold mb-2">No families yet</h3>
                                <p className="text-gray-600 mb-4">
                                    Get started by creating your first family to begin managing member profiles and information.
                                </p>
                                <Link href="/families/create">
                                    <Button>
                                        🚀 Create Your First Family
                                    </Button>
                                </Link>
                            </CardContent>
                        </Card>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {families.map((family) => (
                                <Card key={family.id} className="hover:shadow-lg transition-shadow">
                                    <CardHeader>
                                        <div className="flex items-center justify-between">
                                            <CardTitle className="text-lg">{family.name}</CardTitle>
                                            <div className="text-2xl">👨‍👩‍👧‍👦</div>
                                        </div>
                                        {family.description && (
                                            <CardDescription>
                                                {family.description}
                                            </CardDescription>
                                        )}
                                    </CardHeader>
                                    <CardContent>
                                        <div className="space-y-2">
                                            <div className="flex items-center justify-between text-sm">
                                                <span className="text-gray-600">Members:</span>
                                                <span className="font-medium">{family.members_count}</span>
                                            </div>
                                            <div className="flex items-center justify-between text-sm">
                                                <span className="text-gray-600">Created by:</span>
                                                <span className="font-medium">{family.creator.name}</span>
                                            </div>
                                            <div className="flex items-center justify-between text-sm">
                                                <span className="text-gray-600">Created:</span>
                                                <span className="font-medium">
                                                    {new Date(family.created_at).toLocaleDateString()}
                                                </span>
                                            </div>
                                            <div className="pt-4 flex space-x-2">
                                                <Link href={`/families/${family.id}`} className="flex-1">
                                                    <Button className="w-full" size="sm">
                                                        📋 View
                                                    </Button>
                                                </Link>
                                                <Link href={`/families/${family.id}/members`} className="flex-1">
                                                    <Button variant="outline" className="w-full" size="sm">
                                                        👥 Members
                                                    </Button>
                                                </Link>
                                            </div>
                                        </div>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}