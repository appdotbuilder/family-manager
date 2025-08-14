import React from 'react';
import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

export default function Welcome() {
    const features = [
        {
            icon: '👥',
            title: 'Family Profiles',
            description: 'Create detailed profiles for each family member with contact information, relationships, and personal details.'
        },
        {
            icon: '🏥',
            title: 'Medical Records',
            description: 'Track medical conditions, medications, and important health information for your loved ones.'
        },
        {
            icon: '🔒',
            title: 'Role-Based Access',
            description: 'Control who can view and edit family information with granular permission settings.'
        },
        {
            icon: '📱',
            title: 'Emergency Contacts',
            description: 'Store emergency contact information and medical alerts for quick access when needed.'
        }
    ];

    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
            {/* Header */}
            <header className="bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center py-4">
                        <div className="flex items-center space-x-2">
                            <div className="text-2xl">👨‍👩‍👧‍👦</div>
                            <h1 className="text-xl font-bold text-gray-900">FamilyHub</h1>
                        </div>
                        <div className="flex items-center space-x-4">
                            <Link href="/login">
                                <Button variant="ghost">
                                    Sign In
                                </Button>
                            </Link>
                            <Link href="/register">
                                <Button>
                                    Get Started
                                </Button>
                            </Link>
                        </div>
                    </div>
                </div>
            </header>

            {/* Hero Section */}
            <section className="py-20 px-4">
                <div className="max-w-4xl mx-auto text-center">
                    <h2 className="text-5xl font-bold text-gray-900 mb-6">
                        👨‍👩‍👧‍👦 Keep Your Family Connected & Safe
                    </h2>
                    <p className="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                        Manage family member profiles, medical records, and emergency information 
                        all in one secure, easy-to-use platform.
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                        <Link href="/register">
                            <Button size="lg" className="w-full sm:w-auto">
                                🚀 Start Free Today
                            </Button>
                        </Link>
                        <Link href="/login">
                            <Button variant="outline" size="lg" className="w-full sm:w-auto">
                                🔑 Sign In
                            </Button>
                        </Link>
                    </div>
                </div>
            </section>

            {/* Features Grid */}
            <section className="py-16 px-4">
                <div className="max-w-6xl mx-auto">
                    <h3 className="text-3xl font-bold text-center text-gray-900 mb-12">
                        Everything You Need to Manage Your Family
                    </h3>
                    <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        {features.map((feature, index) => (
                            <Card key={index} className="text-center hover:shadow-lg transition-shadow">
                                <CardHeader>
                                    <div className="text-4xl mb-4">{feature.icon}</div>
                                    <CardTitle className="text-lg">{feature.title}</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <CardDescription>{feature.description}</CardDescription>
                                </CardContent>
                            </Card>
                        ))}
                    </div>
                </div>
            </section>

            {/* Benefits Section */}
            <section className="py-16 px-4 bg-white/50">
                <div className="max-w-4xl mx-auto">
                    <div className="text-center mb-12">
                        <h3 className="text-3xl font-bold text-gray-900 mb-4">
                            Why Choose FamilyHub?
                        </h3>
                        <p className="text-gray-600">
                            Trusted by families worldwide to keep their information organized and secure
                        </p>
                    </div>
                    
                    <div className="grid md:grid-cols-3 gap-8">
                        <div className="text-center">
                            <div className="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <span className="text-2xl">🛡️</span>
                            </div>
                            <h4 className="text-lg font-semibold mb-2">Secure & Private</h4>
                            <p className="text-gray-600">Your family's information is encrypted and protected with enterprise-grade security.</p>
                        </div>
                        
                        <div className="text-center">
                            <div className="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <span className="text-2xl">⚡</span>
                            </div>
                            <h4 className="text-lg font-semibold mb-2">Easy to Use</h4>
                            <p className="text-gray-600">Intuitive interface designed for all family members, regardless of tech experience.</p>
                        </div>
                        
                        <div className="text-center">
                            <div className="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <span className="text-2xl">🌟</span>
                            </div>
                            <h4 className="text-lg font-semibold mb-2">Always Available</h4>
                            <p className="text-gray-600">Access your family information anytime, anywhere, from any device.</p>
                        </div>
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="py-20 px-4">
                <div className="max-w-3xl mx-auto text-center">
                    <h3 className="text-3xl font-bold text-gray-900 mb-4">
                        Ready to Get Started?
                    </h3>
                    <p className="text-xl text-gray-600 mb-8">
                        Join thousands of families who trust FamilyHub to keep their loved ones' information safe and organized.
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                        <Link href="/register">
                            <Button size="lg" className="w-full sm:w-auto bg-blue-600 hover:bg-blue-700">
                                🎯 Create Your Family Hub
                            </Button>
                        </Link>
                        <Link href="/login">
                            <Button variant="outline" size="lg" className="w-full sm:w-auto">
                                Already have an account? Sign In
                            </Button>
                        </Link>
                    </div>
                </div>
            </section>

            {/* Footer */}
            <footer className="bg-gray-50 py-8 px-4">
                <div className="max-w-4xl mx-auto text-center">
                    <div className="flex items-center justify-center space-x-2 mb-4">
                        <div className="text-2xl">👨‍👩‍👧‍👦</div>
                        <span className="text-lg font-semibold text-gray-900">FamilyHub</span>
                    </div>
                    <p className="text-gray-600">
                        Keeping families connected, organized, and secure.
                    </p>
                </div>
            </footer>
        </div>
    );
}