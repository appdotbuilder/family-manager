import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface Family {
    id: number;
    name: string;
    description?: string;
    members: FamilyMember[];
    users: Array<{
        id: number;
        name: string;
        email: string;
        pivot: {
            role: string;
        };
    }>;
    [key: string]: unknown;
}

interface FamilyMember {
    id: number;
    first_name: string;
    last_name: string;
    full_name: string;
    age: number;
    relationship?: string;
    email?: string;
    phone?: string;
    medical_conditions: Array<{
        id: number;
        condition_name: string;
        severity?: string;
    }>;
    medications: Array<{
        id: number;
        medication_name: string;
        dosage?: string;
    }>;
    [key: string]: unknown;
}

interface Props {
    family: Family;
    userRole: string;
    canEdit: boolean;
    [key: string]: unknown;
}

export default function ShowFamily({ family, userRole, canEdit }: Props) {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Dashboard',
            href: '/dashboard',
        },
        {
            title: family.name,
            href: `/families/${family.id}`,
        },
    ];

    const getRoleBadgeColor = (role: string) => {
        switch (role) {
            case 'owner':
                return 'bg-red-100 text-red-800';
            case 'admin':
                return 'bg-orange-100 text-orange-800';
            case 'editor':
                return 'bg-blue-100 text-blue-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`${family.name} - Family Details`} />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">👨‍👩‍👧‍👦 {family.name}</h1>
                        {family.description && (
                            <p className="text-gray-600 mt-1">{family.description}</p>
                        )}
                        <div className="mt-2">
                            <Badge className={getRoleBadgeColor(userRole)}>
                                Your role: {userRole}
                            </Badge>
                        </div>
                    </div>
                    <div className="flex items-center space-x-2">
                        {canEdit && (
                            <>
                                <Link href={`/families/${family.id}/members/create`}>
                                    <Button>
                                        ➕ Add Member
                                    </Button>
                                </Link>
                                <Link href={`/families/${family.id}/edit`}>
                                    <Button variant="outline">
                                        ✏️ Edit Family
                                    </Button>
                                </Link>
                            </>
                        )}
                    </div>
                </div>

                {/* Stats */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Total Members</CardTitle>
                            <div className="text-xl">👤</div>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{family.members.length}</div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Family Users</CardTitle>
                            <div className="text-xl">👥</div>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{family.users.length}</div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Medical Conditions</CardTitle>
                            <div className="text-xl">🏥</div>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">
                                {family.members.reduce((total, member) => total + member.medical_conditions.length, 0)}
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Medications</CardTitle>
                            <div className="text-xl">💊</div>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">
                                {family.members.reduce((total, member) => total + member.medications.length, 0)}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Family Members */}
                <div>
                    <div className="flex items-center justify-between mb-4">
                        <h2 className="text-xl font-semibold">Family Members</h2>
                        <Link href={`/families/${family.id}/members`}>
                            <Button variant="outline" size="sm">
                                View All Members
                            </Button>
                        </Link>
                    </div>
                    
                    {family.members.length === 0 ? (
                        <Card className="text-center py-12">
                            <CardContent>
                                <div className="text-6xl mb-4">👤</div>
                                <h3 className="text-lg font-semibold mb-2">No family members yet</h3>
                                <p className="text-gray-600 mb-4">
                                    Start by adding your first family member to begin tracking their information.
                                </p>
                                {canEdit && (
                                    <Link href={`/families/${family.id}/members/create`}>
                                        <Button>
                                            ➕ Add First Member
                                        </Button>
                                    </Link>
                                )}
                            </CardContent>
                        </Card>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            {family.members.slice(0, 6).map((member) => (
                                <Card key={member.id} className="hover:shadow-lg transition-shadow">
                                    <CardHeader>
                                        <div className="flex items-center justify-between">
                                            <CardTitle className="text-lg">{member.full_name}</CardTitle>
                                            <div className="text-2xl">
                                                {member.relationship === 'child' ? '👶' : 
                                                 member.relationship === 'parent' ? '👨‍👩' :
                                                 member.relationship === 'sibling' ? '👫' : '👤'}
                                            </div>
                                        </div>
                                        <CardDescription>
                                            {member.age} years old
                                            {member.relationship && ` • ${member.relationship}`}
                                        </CardDescription>
                                    </CardHeader>
                                    <CardContent>
                                        <div className="space-y-2">
                                            {member.email && (
                                                <div className="text-sm">
                                                    <span className="text-gray-600">📧 </span>
                                                    {member.email}
                                                </div>
                                            )}
                                            {member.phone && (
                                                <div className="text-sm">
                                                    <span className="text-gray-600">📞 </span>
                                                    {member.phone}
                                                </div>
                                            )}
                                            <div className="flex items-center justify-between text-sm">
                                                <span>🏥 Conditions: {member.medical_conditions.length}</span>
                                                <span>💊 Medications: {member.medications.length}</span>
                                            </div>
                                            <div className="pt-2">
                                                <Link href={`/families/${family.id}/members/${member.id}`}>
                                                    <Button size="sm" className="w-full">
                                                        View Details
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

                {/* Family Access */}
                <div>
                    <h2 className="text-xl font-semibold mb-4">Family Access</h2>
                    <Card>
                        <CardHeader>
                            <CardTitle>Users with Access</CardTitle>
                            <CardDescription>
                                People who can view and manage this family's information
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-3">
                                {family.users.map((user) => (
                                    <div key={user.id} className="flex items-center justify-between">
                                        <div>
                                            <div className="font-medium">{user.name}</div>
                                            <div className="text-sm text-gray-600">{user.email}</div>
                                        </div>
                                        <Badge className={getRoleBadgeColor(user.pivot.role)}>
                                            {user.pivot.role}
                                        </Badge>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}