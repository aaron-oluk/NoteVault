<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NoteVault, academic publishing for university communities</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .fade-in-up { opacity: 0; transform: translateY(16px); animation: fadeInUp 0.7s ease-out forwards; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        .mobile-menu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; }
        .mobile-menu.open { max-height: 420px; }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; }
        .faq-item.open .faq-answer { max-height: 240px; }
        .faq-item.open .faq-icon { transform: rotate(45deg); }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- ==================== HERO ==================== -->
        <section class="relative overflow-hidden rounded-3xl mt-4 bg-gradient-to-br from-blue-700 via-blue-600 to-cyan-600">
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>

            <!-- Navigation -->
            <nav class="relative z-20 flex items-center justify-between px-6 sm:px-10 py-6">
                <a href="{{ route('index') }}" class="flex items-center gap-2 text-white">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <i class="bx bx-book-open text-blue-700 text-lg"></i>
                    </div>
                    <span class="text-lg font-semibold tracking-tight">NoteVault</span>
                </a>

                <div class="hidden md:flex items-center gap-1">
                    <a href="#features" class="px-4 py-2 text-sm text-white/80 hover:text-white rounded-full hover:bg-white/10 transition-colors">Features</a>
                    <a href="#how-it-works" class="px-4 py-2 text-sm text-white/80 hover:text-white rounded-full hover:bg-white/10 transition-colors">How it works</a>
                    <a href="#browse" class="px-4 py-2 text-sm text-white/80 hover:text-white rounded-full hover:bg-white/10 transition-colors">Browse</a>
                    <a href="#faq" class="px-4 py-2 text-sm text-white/80 hover:text-white rounded-full hover:bg-white/10 transition-colors">FAQ</a>
                </div>

                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-medium text-white border border-white/30 rounded-full hover:bg-white/10 transition-colors">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-medium text-blue-700 bg-white rounded-full hover:shadow-lg transition-all">
                        Get started
                    </a>
                </div>

                <button id="menuBtn" class="md:hidden w-10 h-10 flex items-center justify-center text-white rounded-full hover:bg-white/10 transition-colors">
                    <i class="bx bx-menu text-xl"></i>
                </button>
            </nav>

            <div id="mobileMenu" class="mobile-menu relative z-20 md:hidden px-6">
                <div class="bg-black/20 backdrop-blur-md rounded-2xl p-4 space-y-1 mb-4">
                    <a href="#features" class="block px-4 py-2.5 text-sm text-white/80 hover:text-white rounded-xl hover:bg-white/10">Features</a>
                    <a href="#how-it-works" class="block px-4 py-2.5 text-sm text-white/80 hover:text-white rounded-xl hover:bg-white/10">How it works</a>
                    <a href="#browse" class="block px-4 py-2.5 text-sm text-white/80 hover:text-white rounded-xl hover:bg-white/10">Browse</a>
                    <a href="#faq" class="block px-4 py-2.5 text-sm text-white/80 hover:text-white rounded-xl hover:bg-white/10">FAQ</a>
                    <div class="border-t border-white/10 pt-2 mt-2 flex gap-2">
                        <a href="{{ route('login') }}" class="flex-1 text-center px-4 py-2.5 text-sm font-medium text-white border border-white/30 rounded-xl">Log in</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center px-4 py-2.5 text-sm font-medium text-blue-700 bg-white rounded-xl">Get started</a>
                    </div>
                </div>
            </div>

            <!-- Hero content -->
            <div class="relative z-10 px-6 sm:px-10 lg:px-16 pt-8 pb-16 sm:pb-24">
                <div class="max-w-2xl">
                    <span class="fade-in-up inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/10 rounded-full text-xs font-medium text-white/90 uppercase tracking-wider mb-6">
                        <span class="w-1.5 h-1.5 bg-emerald-300 rounded-full"></span>
                        Built for university communities
                    </span>
                    <h1 class="fade-in-up delay-100 text-4xl sm:text-5xl lg:text-6xl font-semibold text-white leading-[1.1] tracking-tight mb-6">
                        Where course notes and research find their audience
                    </h1>
                    <p class="fade-in-up delay-200 text-lg font-light text-white/80 leading-relaxed max-w-xl mb-8">
                        Publish, discover, and engage with course notes, research papers, and postgraduate work,
                        organized by institution, department, course, and field of study.
                    </p>
                    <div class="fade-in-up delay-300 flex flex-wrap gap-3">
                        <a href="{{ route('register') }}" class="px-8 py-3.5 text-sm font-medium text-blue-700 bg-white rounded-full hover:shadow-lg transition-all">
                            Create your account
                        </a>
                        <a href="{{ route('login') }}" class="group px-8 py-3.5 text-sm font-medium text-white border border-white/30 rounded-full hover:bg-white/10 transition-colors flex items-center gap-2">
                            Log in to explore
                            <i class="bx bx-right-arrow-alt group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== LIVE COUNTS ==================== -->
        <section class="py-14 px-4 sm:px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl font-semibold text-gray-900 tracking-tight mb-1">{{ number_format($institutionCount) }}</p>
                    <p class="text-sm text-gray-500 font-light">{{ Str::plural('institution', $institutionCount) }} onboard</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl font-semibold text-gray-900 tracking-tight mb-1">{{ number_format($courseUnitCount) }}</p>
                    <p class="text-sm text-gray-500 font-light">course {{ Str::plural('unit', $courseUnitCount) }}</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl font-semibold text-gray-900 tracking-tight mb-1">{{ number_format($resourceCount) }}</p>
                    <p class="text-sm text-gray-500 font-light">{{ Str::plural('resource', $resourceCount) }} shared</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl font-semibold text-gray-900 tracking-tight mb-1">{{ number_format($researchWorkCount) }}</p>
                    <p class="text-sm text-gray-500 font-light">research {{ Str::plural('work', $researchWorkCount) }}</p>
                </div>
            </div>
        </section>

        <!-- ==================== FEATURES ==================== -->
        <section id="features" class="py-16 px-4 sm:px-6">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="inline-block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Platform features</span>
                <h2 class="text-3xl sm:text-4xl font-medium tracking-tight mb-4">Built for how academic work actually happens</h2>
                <p class="text-lg font-light text-gray-500 leading-relaxed">Three pillars that make academic content easy to publish, find, and build on.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="group bg-white rounded-3xl p-8 border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-6 group-hover:scale-105 transition-transform">
                        <i class="bx bx-upload text-2xl text-blue-600"></i>
                    </div>
                    <span class="inline-block px-3 py-1 bg-gray-100 rounded-full text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">Publish</span>
                    <h3 class="text-xl font-semibold mb-2">Share your work</h3>
                    <p class="text-gray-500 font-light leading-relaxed">Upload course notes, past papers, and research works with structured metadata: course unit, semester, field of study, and tags.</p>
                </div>

                <div class="group bg-white rounded-3xl p-8 border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-6 group-hover:scale-105 transition-transform">
                        <i class="bx bx-search-alt text-2xl text-blue-600"></i>
                    </div>
                    <span class="inline-block px-3 py-1 bg-gray-100 rounded-full text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">Discover</span>
                    <h3 class="text-xl font-semibold mb-2">Find what matters</h3>
                    <p class="text-gray-500 font-light leading-relaxed">Browse by institution, department, course, or field of study. Search across titles, tags, and course codes.</p>
                </div>

                <div class="group bg-white rounded-3xl p-8 border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-6 group-hover:scale-105 transition-transform">
                        <i class="bx bx-comment text-2xl text-blue-600"></i>
                    </div>
                    <span class="inline-block px-3 py-1 bg-gray-100 rounded-full text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">Engage</span>
                    <h3 class="text-xl font-semibold mb-2">Build on each other's work</h3>
                    <p class="text-gray-500 font-light leading-relaxed">Comment, upvote, and follow lecturers, researchers, and courses to hear about new content as it is published.</p>
                </div>
            </div>
        </section>

        <!-- ==================== HOW IT WORKS ==================== -->
        <section id="how-it-works" class="py-16 px-4 sm:px-6">
            <div class="bg-gray-900 rounded-3xl p-8 sm:p-12 lg:p-16 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full blur-[80px] opacity-20 pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="text-center max-w-2xl mx-auto mb-14">
                        <span class="inline-block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">How it works</span>
                        <h2 class="text-3xl sm:text-4xl font-medium tracking-tight text-white mb-4">From draft to discovery in three steps</h2>
                        <p class="text-lg font-light text-white/60 leading-relaxed">Whether you are sharing lecture notes or submitting a thesis, the path is the same.</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-white/10 border border-white/10 flex items-center justify-center text-white font-semibold text-lg mb-6">1</div>
                            <h3 class="text-xl font-semibold text-white mb-3">Verify your institution</h3>
                            <p class="text-white/60 font-light leading-relaxed">Sign up with your institutional email. We match it against your institution so your account and content are correctly scoped from the start.</p>
                        </div>
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-white/10 border border-white/10 flex items-center justify-center text-white font-semibold text-lg mb-6">2</div>
                            <h3 class="text-xl font-semibold text-white mb-3">Choose your context</h3>
                            <p class="text-white/60 font-light leading-relaxed">Attach your upload to a department, course, and course unit, or file a research work under a field of study. This is what makes it findable.</p>
                        </div>
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-white/10 border border-white/10 flex items-center justify-center text-white font-semibold text-lg mb-6">3</div>
                            <h3 class="text-xl font-semibold text-white mb-3">Publish and track engagement</h3>
                            <p class="text-white/60 font-light leading-relaxed">Your work becomes discoverable to your institution. Track upvotes, downloads, and comments from your profile.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== CONTENT TYPES ==================== -->
        <section class="py-16 px-4 sm:px-6">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="inline-block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Content types</span>
                <h2 class="text-3xl sm:text-4xl font-medium tracking-tight mb-4">Casual notes and formal research, kept separate</h2>
                <p class="text-lg font-light text-gray-500 leading-relaxed">Student contributed notes and reputationally sensitive research live in clearly separated sections, not one blended feed.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-3xl p-8">
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center mb-6 shadow-sm">
                        <i class="bx bx-edit-alt text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Course resources</h3>
                    <p class="text-gray-500 font-light leading-relaxed mb-4">Lecture notes, past papers, and study guides organized by course unit and semester. Peer driven, relies on upvotes and downloads.</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-white rounded-full text-xs font-medium text-gray-500">Notes</span>
                        <span class="px-3 py-1 bg-white rounded-full text-xs font-medium text-gray-500">Past papers</span>
                        <span class="px-3 py-1 bg-white rounded-full text-xs font-medium text-gray-500">Study guides</span>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-3xl p-8">
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center mb-6 shadow-sm">
                        <i class="bx bx-history text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Lecturer versioned content</h3>
                    <p class="text-gray-500 font-light leading-relaxed mb-4">Lecturer maintained notes carry a full version history, with a changelog and timestamp on every revision.</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-white rounded-full text-xs font-medium text-gray-500">Authoritative</span>
                        <span class="px-3 py-1 bg-white rounded-full text-xs font-medium text-gray-500">Versioned</span>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-3xl p-8">
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center mb-6 shadow-sm">
                        <i class="bx bx-certification text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Research and postgraduate work</h3>
                    <p class="text-gray-500 font-light leading-relaxed mb-4">Papers and theses tracked separately from course resources, with field of study, license, structured review, and supervisor endorsement before publication.</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-white rounded-full text-xs font-medium text-gray-500">Reviewed</span>
                        <span class="px-3 py-1 bg-white rounded-full text-xs font-medium text-gray-500">Endorsed</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== BROWSE STRUCTURE ==================== -->
        <section id="browse" class="py-16 px-4 sm:px-6">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <div>
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Hierarchical browse</span>
                    <h2 class="text-3xl sm:text-4xl font-medium tracking-tight mb-6">Organized the way your institution already works</h2>
                    <p class="text-lg font-light text-gray-500 leading-relaxed mb-8">Navigate content through a natural hierarchy, from institution down to a specific course.</p>

                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                <i class="bx bx-buildings text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Institution</h4>
                                <p class="text-sm text-gray-500 font-light">Every account and every piece of content traces back to one institution.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                <i class="bx bx-layer text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Department</h4>
                                <p class="text-sm text-gray-500 font-light">Browse content by department, from Computer Science to Law.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                <i class="bx bx-book-bookmark text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Course and course unit</h4>
                                <p class="text-sm text-gray-500 font-light">Find materials for a specific course code and semester.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                <i class="bx bx-hash text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Field of study</h4>
                                <p class="text-sm text-gray-500 font-light">Cross cutting research topics, filtered independently of course structure.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Live demo card, pulled from real data -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-gray-200"></div>
                            <div class="w-3 h-3 rounded-full bg-gray-200"></div>
                            <div class="w-3 h-3 rounded-full bg-gray-200"></div>
                        </div>
                        <span class="text-xs text-gray-400 font-medium">notevault.app/courses</span>
                    </div>

                    @if($demoCourse)
                        <div class="flex items-center gap-2 text-xs text-gray-400 mb-6 flex-wrap">
                            <span>{{ $demoCourse->institution->name }}</span>
                            <i class="bx bx-chevron-right text-xs"></i>
                            <span>{{ $demoCourse->department->name }}</span>
                            <i class="bx bx-chevron-right text-xs"></i>
                            <span class="text-gray-900 font-medium">{{ $demoCourse->code }}, {{ $demoCourse->name }}</span>
                        </div>

                        <div class="space-y-3">
                            @forelse($demoCourse->courseUnits->flatMap->resources->take(4) as $resource)
                                <div class="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-50 transition-colors">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                                        <i class="bx bx-file text-lg text-blue-500"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium truncate">{{ $resource->title }}</p>
                                        <p class="text-xs text-gray-400">{{ ucfirst(str_replace('_', ' ', $resource->type)) }} &middot; {{ $resource->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400 py-6 text-center">No resources published for this course yet.</p>
                            @endforelse
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-400">Live preview from a seeded course</span>
                            <a href="{{ route('login') }}" class="text-xs font-medium text-gray-900 hover:underline">Log in to browse &rarr;</a>
                        </div>
                    @else
                        <p class="text-sm text-gray-400 py-6 text-center">Course structure will appear here once an institution is onboarded.</p>
                    @endif
                </div>
            </div>
        </section>

        <!-- ==================== FOR DIFFERENT USERS ==================== -->
        <section class="py-16 px-4 sm:px-6">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">For everyone</span>
                <h2 class="text-3xl sm:text-4xl font-medium tracking-tight mb-4">One platform, three roles</h2>
                <p class="text-lg font-light text-gray-500 leading-relaxed">NoteVault adapts to your role in the academic community.</p>
            </div>

            <div class="flex justify-center mb-12">
                <div class="inline-flex bg-gray-100 rounded-2xl p-1.5 gap-1">
                    <button data-tab="students" class="tab-btn active px-6 py-2.5 text-sm font-medium rounded-xl transition-colors bg-white shadow-sm text-gray-900">Students</button>
                    <button data-tab="lecturers" class="tab-btn px-6 py-2.5 text-sm font-medium rounded-xl transition-colors text-gray-500 hover:text-gray-900">Lecturers</button>
                    <button data-tab="researchers" class="tab-btn px-6 py-2.5 text-sm font-medium rounded-xl transition-colors text-gray-500 hover:text-gray-900">Researchers</button>
                </div>
            </div>

            <div class="max-w-4xl mx-auto">
                <div id="tab-students" class="tab-content">
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="bg-white rounded-3xl p-8 border border-gray-100">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-6"><i class="bx bx-search text-2xl"></i></div>
                            <h3 class="text-lg font-semibold mb-2">Find study materials fast</h3>
                            <p class="text-gray-500 font-light leading-relaxed text-sm">Search notes from students in your course, filtered by course unit and semester.</p>
                        </div>
                        <div class="bg-white rounded-3xl p-8 border border-gray-100">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-6"><i class="bx bx-upvote text-2xl"></i></div>
                            <h3 class="text-lg font-semibold mb-2">Build a contribution record</h3>
                            <p class="text-gray-500 font-light leading-relaxed text-sm">Every resource you publish adds to a visible record of your upvotes and downloads.</p>
                        </div>
                        <div class="bg-white rounded-3xl p-8 border border-gray-100">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-6"><i class="bx bx-comment text-2xl"></i></div>
                            <h3 class="text-lg font-semibold mb-2">Collaborate with classmates</h3>
                            <p class="text-gray-500 font-light leading-relaxed text-sm">Comment on resources and ask questions directly on the notes you are studying.</p>
                        </div>
                        <div class="bg-white rounded-3xl p-8 border border-gray-100">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-6"><i class="bx bx-wallet text-2xl"></i></div>
                            <h3 class="text-lg font-semibold mb-2">Free to read and publish</h3>
                            <p class="text-gray-500 font-light leading-relaxed text-sm">No paywalls for students. Read, publish, and engage without a subscription.</p>
                        </div>
                    </div>
                </div>

                <div id="tab-lecturers" class="tab-content hidden">
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="bg-white rounded-3xl p-8 border border-gray-100">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-6"><i class="bx bx-history text-2xl"></i></div>
                            <h3 class="text-lg font-semibold mb-2">Maintain versioned notes</h3>
                            <p class="text-gray-500 font-light leading-relaxed text-sm">Publish authoritative course notes with a full changelog on every revision.</p>
                        </div>
                        <div class="bg-white rounded-3xl p-8 border border-gray-100">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-6"><i class="bx bx-badge-check text-2xl"></i></div>
                            <h3 class="text-lg font-semibold mb-2">Endorse postgraduate work</h3>
                            <p class="text-gray-500 font-light leading-relaxed text-sm">As a supervisor, review and endorse research works before they become publicly visible.</p>
                        </div>
                        <div class="bg-white rounded-3xl p-8 border border-gray-100">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-6"><i class="bx bx-upload text-2xl"></i></div>
                            <h3 class="text-lg font-semibold mb-2">Publish your own resources</h3>
                            <p class="text-gray-500 font-light leading-relaxed text-sm">Share lecture notes and supplementary materials directly to your courses.</p>
                        </div>
                        <div class="bg-white rounded-3xl p-8 border border-gray-100">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-6"><i class="bx bx-line-chart text-2xl"></i></div>
                            <h3 class="text-lg font-semibold mb-2">See what students engage with</h3>
                            <p class="text-gray-500 font-light leading-relaxed text-sm">Upvotes and downloads on your course unit show which materials are used most.</p>
                        </div>
                    </div>
                </div>

                <div id="tab-researchers" class="tab-content hidden">
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="bg-white rounded-3xl p-8 border border-gray-100">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-6"><i class="bx bx-globe text-2xl"></i></div>
                            <h3 class="text-lg font-semibold mb-2">Reach your institution first</h3>
                            <p class="text-gray-500 font-light leading-relaxed text-sm">Your work is indexed and searchable within your academic community from day one.</p>
                        </div>
                        <div class="bg-white rounded-3xl p-8 border border-gray-100">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-6"><i class="bx bx-check-shield text-2xl"></i></div>
                            <h3 class="text-lg font-semibold mb-2">Structured peer review</h3>
                            <p class="text-gray-500 font-light leading-relaxed text-sm">Assign reviewers who leave structured comments and a status, with an optional blind review flag.</p>
                        </div>
                        <div class="bg-white rounded-3xl p-8 border border-gray-100">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-6"><i class="bx bx-git-compare text-2xl"></i></div>
                            <h3 class="text-lg font-semibold mb-2">License and citation control</h3>
                            <p class="text-gray-500 font-light leading-relaxed text-sm">Choose your license type and provide your own citation, kept alongside your published work.</p>
                        </div>
                        <div class="bg-white rounded-3xl p-8 border border-gray-100">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-6"><i class="bx bx-link text-2xl"></i></div>
                            <h3 class="text-lg font-semibold mb-2">Connect across departments</h3>
                            <p class="text-gray-500 font-light leading-relaxed text-sm">Find researchers in your field of study and follow their published work.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== FAQ ==================== -->
        <section id="faq" class="py-16 px-4 sm:px-6">
            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-14">
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">FAQ</span>
                    <h2 class="text-3xl sm:text-4xl font-medium tracking-tight">Common questions</h2>
                </div>

                <div class="space-y-3">
                    <div class="faq-item bg-white rounded-2xl overflow-hidden border border-gray-100">
                        <button class="faq-toggle w-full flex items-center justify-between p-6 text-left">
                            <span class="font-medium pr-4">Is NoteVault free to use?</span>
                            <i class="bx bx-plus text-gray-400 shrink-0 faq-icon transition-transform"></i>
                        </button>
                        <div class="faq-answer px-6">
                            <p class="text-gray-500 font-light leading-relaxed pb-6">Reading, publishing, and engaging with content carries no charge for students, lecturers, or researchers.</p>
                        </div>
                    </div>
                    <div class="faq-item bg-white rounded-2xl overflow-hidden border border-gray-100">
                        <button class="faq-toggle w-full flex items-center justify-between p-6 text-left">
                            <span class="font-medium pr-4">Who can sign up?</span>
                            <i class="bx bx-plus text-gray-400 shrink-0 faq-icon transition-transform"></i>
                        </button>
                        <div class="faq-answer px-6">
                            <p class="text-gray-500 font-light leading-relaxed pb-6">Anyone signing up with an email address matching an onboarded institution's domain is verified and linked to that institution automatically. Accounts covering students, lecturers, researchers, and administrators are all supported.</p>
                        </div>
                    </div>
                    <div class="faq-item bg-white rounded-2xl overflow-hidden border border-gray-100">
                        <button class="faq-toggle w-full flex items-center justify-between p-6 text-left">
                            <span class="font-medium pr-4">How is content quality maintained?</span>
                            <i class="bx bx-plus text-gray-400 shrink-0 faq-icon transition-transform"></i>
                        </button>
                        <div class="faq-answer px-6">
                            <p class="text-gray-500 font-light leading-relaxed pb-6">Course resources rely on community upvotes and downloads. Lecturer maintained notes carry an authoritative version history. Research works go through structured review and require supervisor endorsement before they are publicly visible.</p>
                        </div>
                    </div>
                    <div class="faq-item bg-white rounded-2xl overflow-hidden border border-gray-100">
                        <button class="faq-toggle w-full flex items-center justify-between p-6 text-left">
                            <span class="font-medium pr-4">Do I need to log in to browse content?</span>
                            <i class="bx bx-plus text-gray-400 shrink-0 faq-icon transition-transform"></i>
                        </button>
                        <div class="faq-answer px-6">
                            <p class="text-gray-500 font-light leading-relaxed pb-6">Yes. Resources, research works, departments, courses, and people are only visible once you are signed in with a verified institutional account, so content stays scoped to your academic community.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== FINAL CTA ==================== -->
        <section class="py-16 px-4 sm:px-6">
            <div class="bg-gradient-to-br from-blue-700 via-blue-600 to-cyan-600 rounded-3xl p-10 sm:p-16 text-center">
                <h2 class="text-3xl sm:text-4xl font-medium tracking-tight text-white mb-4">Bring your institution's notes and research into one place</h2>
                <p class="text-lg font-light text-white/80 max-w-xl mx-auto mb-8">Sign up with your institutional email to get started.</p>
                <a href="{{ route('register') }}" class="inline-block px-8 py-3.5 text-sm font-medium text-blue-700 bg-white rounded-full hover:shadow-lg transition-all">
                    Create your account
                </a>
            </div>
        </section>

        <!-- ==================== FOOTER ==================== -->
        <footer class="py-10 px-4 sm:px-6 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('index') }}" class="flex items-center gap-2 text-gray-900">
                    <div class="w-7 h-7 bg-gray-900 rounded-lg flex items-center justify-center">
                        <i class="bx bx-book-open text-white text-sm"></i>
                    </div>
                    <span class="font-semibold tracking-tight">NoteVault</span>
                </a>
                <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm text-gray-500">
                    <a href="#features" class="hover:text-gray-900 transition-colors">Features</a>
                    <a href="#how-it-works" class="hover:text-gray-900 transition-colors">How it works</a>
                    <a href="#faq" class="hover:text-gray-900 transition-colors">FAQ</a>
                    <a href="{{ route('login') }}" class="hover:text-gray-900 transition-colors">Log in</a>
                    <a href="{{ route('register') }}" class="hover:text-gray-900 transition-colors">Get started</a>
                </div>
            </div>
        </footer>
    </div>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        menuBtn?.addEventListener('click', () => mobileMenu.classList.toggle('open'));

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('active', 'bg-white', 'shadow-sm', 'text-gray-900');
                    b.classList.add('text-gray-500');
                });
                btn.classList.add('active', 'bg-white', 'shadow-sm', 'text-gray-900');
                btn.classList.remove('text-gray-500');

                document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
                document.getElementById('tab-' + btn.dataset.tab).classList.remove('hidden');
            });
        });

        document.querySelectorAll('.faq-toggle').forEach(toggle => {
            toggle.addEventListener('click', () => {
                toggle.closest('.faq-item').classList.toggle('open');
            });
        });
    </script>
</body>
</html>
