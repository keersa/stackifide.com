<x-admin-layout>
    <x-admin-website-header :website="$website" title="Website Dashboard" :showStats="true" />

    <div class="py-4 space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Details Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="px-8 py-5 border-b border-gray-50 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ __('URL Details') }}</h3>
                        <span class="text-[10px] font-bold text-gray-400 bg-gray-50 dark:bg-gray-900 px-2 py-1 rounded">Website ID: {{ $website->id }}</span>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-12">
                            <div>
                                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-1">Live URL</label>
                                @if($current_active_uri)
                                    <a href="{{ $current_active_uri }}" target="_blank" class="text-sm font-bold text-gray-900 dark:text-white hover:text-indigo-600 transition-colors break-all">
                                        {{ $current_active_uri }}
                                    </a>
                                @else
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">—</p>
                                @endif
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-1">Custom Domain</label>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $website->domain ?: '—' }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-1">Description</label>
                                <div class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed italic border-l-4 border-gray-100 dark:border-gray-700 pl-4 py-1">
                                    {{ $website->description ?: 'No description available for this restaurant.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shortcuts -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('admin.websites.images.index', $website) }}" class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-indigo-500 dark:hover:border-indigo-500 group transition-all">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white">Manage Logos</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>

            <!-- Meta/Sidebar Column -->
            <div class="space-y-6">
                <!-- Owner Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 text-white dark:text-gray-300">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-6">Website Owner</h3>
                    @if($website->user)
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-12 w-12 rounded-xl bg-indigo-500 flex items-center justify-center font-black text-white shadow-lg shadow-indigo-500/20">
                                {{ substr($website->user->first_name, 0, 1) }}{{ substr($website->user->last_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold leading-none">{{ $website->user->full_name }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $website->user->email }}</p>
                            </div>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4 flex justify-between items-center">
                            <span class="text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase">Access Level</span>
                            <span class="text-xs font-black text-indigo-400 uppercase tracking-tighter">{{ str_replace('_', ' ', $website->user->role) }}</span>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">Unassigned</p>
                    @endif
                </div>

                <!-- Subscription Management Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-6">Subscription</h3>
                    
                    @if($website->hasCurrentSubscription())
                        <!-- Has subscription (active or Canceled but still in period) -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Current Plan</p>
                                    <p class="text-lg font-black text-gray-900 dark:text-white uppercase">{{ ucfirst($website->plan) }}</p>
                                </div>
                                @if($website->isSubscriptionCanceled())
                                    @php
                                        $activeUntil = $website->stripe_ends_at ?? $website->subscription_ends_at;
                                    @endphp
                                    <span class="px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 text-xs font-bold rounded-full uppercase">
                                        Active until {{ $activeUntil?->format('M j, Y') ?? 'period end' }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold rounded-full uppercase">
                                        {{ ucfirst($website->stripe_status) }}
                                    </span>
                                @endif
                            </div>

                            @if($website->isSubscriptionCanceled())
                            @php
                                $subscriptionEndDate = $website->stripe_ends_at ?? $website->subscription_ends_at;
                            @endphp
                            <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4 mb-4">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <div class="space-y-2">
                                            <p class="text-sm font-bold text-amber-800 dark:text-amber-300">Subscription Canceled</p>
                                            <p class="text-xs text-amber-700 dark:text-amber-400">
                                                You've Canceled this subscription. It will not renew.
                                            </p>
                                            @if($subscriptionEndDate)
                                            <div class="pt-2 border-t border-amber-200/50 dark:border-amber-700/50">
                                                <p class="text-xs font-bold text-amber-800 dark:text-amber-300 uppercase mb-0.5">Site remains active until</p>
                                                <p class="text-sm font-black text-amber-900 dark:text-amber-200">{{ $subscriptionEndDate->format('l, F j, Y') }}</p>
                                                <p class="text-xs text-amber-700 dark:text-amber-400 mt-1">
                                                    Your site will stay live and fully accessible until this date. After that, it will become inactive until you subscribe again.
                                                </p>
                                            </div>
                                            @else
                                            <p class="text-xs text-amber-700 dark:text-amber-400">
                                                Your site will remain active until the end of the current billing period.
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('admin.websites.subscriptions.resume', $website) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-4 rounded transition">
                                        Resume Subscription
                                    </button>
                                </form>
                            </div>
                            @else
                            @if($website->subscription_ends_at)
                            <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Next Billing Date</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white mb-2">{{ $website->subscription_ends_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Your subscription will automatically renew on this date. You can cancel anytime before then.
                                </p>
                            </div>
                            @endif
                            <div class="pt-4 space-y-2">
                                @if(strtolower($website->plan) === 'basic')
                                <button type="button" onclick="openUpgradeModal()" class="w-full bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold py-2 px-4 rounded transition mb-2">
                                    Upgrade to Pro
                                </button>
                                @endif
                                <button type="button" onclick="openCancelModal()" class="w-full border border-gray-300 dark:border-black text-gray-500 dark:text-gray-400 text-xs font-bold py-2 px-4 rounded transition">
                                    Cancel Subscription
                                </button>
                            </div>
                            @endif
                        </div>
                    @else
                        <!-- No Active Subscription -->
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-3">Select a Plan</p>
                                <div class="space-y-2">
                                    <a href="{{ route('admin.websites.subscriptions.create', [$website, 'plan' => 'basic']) }}" 
                                       class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-3 px-4 rounded transition text-left flex items-center justify-between">
                                        <span>Basic Plan</span>
                                        <span class="font-normal">$99/month</span>
                                    </a>
                                    <a href="{{ route('admin.websites.subscriptions.create', [$website, 'plan' => 'pro']) }}" 
                                       class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold py-3 px-4 rounded transition text-left flex items-center justify-between">
                                        <span>Pro Plan</span>
                                        <span class="font-normal">$169/month</span>
                                    </a>
                                </div>
                            </div>

                            @if($website->trial_ends_at)
                            <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                                <p class="text-[10px] font-bold text-blue-400 uppercase mb-1">Trial End</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $website->trial_ends_at->format('M d, Y') }}
                                    @if($website->trial_ends_at->isPast())
                                        <span class="text-[8px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded-full font-black uppercase ml-2">Ended</span>
                                    @endif
                                </p>
                            </div>
                            @endif

                            <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Registered</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $website->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Upgrade to Pro Modal -->
    <div id="upgradeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-black text-gray-900 dark:text-white">Upgrade to Pro</h3>
                <button type="button" onclick="closeUpgradeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    You're currently on the <strong class="text-gray-900 dark:text-white">Basic</strong> plan. Upgrading to <strong class="text-gray-900 dark:text-white">Pro</strong> will change your monthly rate:
                </p>
                <div class="bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-4 mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600 dark:text-gray-400">Basic (current)</span>
                        <span class="font-bold text-gray-900 dark:text-white">$99/month</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Pro (new)</span>
                        <span class="font-bold text-purple-600 dark:text-purple-400">$169/month</span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                        You may be charged a prorated amount for the remainder of your current billing period.
                    </p>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Do you want to upgrade to Pro?
                </p>
            </div>

            <form method="POST" action="{{ route('admin.websites.subscriptions.upgrade', $website) }}" id="upgradeForm">
                @csrf
                <div class="flex gap-3">
                    <button type="button" onclick="closeUpgradeModal()" class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-bold py-3 px-4 rounded transition">
                        Keep Basic
                    </button>
                    <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold py-3 px-4 rounded transition">
                        Confirm Upgrade
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cancel Subscription Modal -->
    <div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-black text-gray-900 dark:text-white">Cancel Subscription</h3>
                <button onclick="closeCancelModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    Are you sure you want to cancel your <strong class="text-gray-900 dark:text-white">{{ ucfirst($website->plan) }}</strong> subscription?
                </p>
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <p class="text-sm font-bold text-amber-800 dark:text-amber-300 mb-1">Important Information</p>
                            <p class="text-xs text-amber-700 dark:text-amber-400">
                                Your subscription will remain active until the end of the current billing period.
                                @if($website->subscription_ends_at)
                                    You'll continue to have access until <strong>{{ $website->subscription_ends_at->format('M d, Y') }}</strong>.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.websites.subscriptions.cancel', $website) }}" id="cancelForm">
                @csrf
                <div class="flex gap-3">
                    <button type="button" onclick="closeCancelModal()" class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-bold py-3 px-4 rounded transition">
                        Keep Subscription
                    </button>
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-3 px-4 rounded transition">
                        Cancel Subscription
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openUpgradeModal() {
            var el = document.getElementById('upgradeModal');
            if (el) { el.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
        }

        function closeUpgradeModal() {
            var el = document.getElementById('upgradeModal');
            if (el) { el.classList.add('hidden'); document.body.style.overflow = ''; }
        }

        document.getElementById('upgradeModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeUpgradeModal();
        });

        function openCancelModal() {
            document.getElementById('cancelModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        document.getElementById('cancelModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeCancelModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key !== 'Escape') return;
            var upgradeEl = document.getElementById('upgradeModal');
            var cancelEl = document.getElementById('cancelModal');
            if (upgradeEl && !upgradeEl.classList.contains('hidden')) {
                closeUpgradeModal();
            } else if (cancelEl && !cancelEl.classList.contains('hidden')) {
                closeCancelModal();
            }
        });
    </script>
</x-admin-layout>