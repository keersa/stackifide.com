<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="px-4 py-8 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Left column: section links -->
                <aside class="lg:w-56 flex-shrink-0 order-2 lg:order-1">
                    <div class="lg:sticky lg:top-24">
                        <nav class="flex lg:flex-col gap-2 overflow-x-auto pb-2 lg:pb-0 lg:overflow-visible" aria-label="About sections">
                            <a href="#our-origins"
                               class="about-section-link flex-shrink-0 lg:flex-shrink px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 dark:bg-black dark:bg-opacity-40 dark:text-white hover:text-gray-900 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-opacity-10 transition-colors duration-200 border border-gray-200 dark:border-black">
                                Our Origins
                            </a>
                            <a href="#our-mission"
                               class="about-section-link flex-shrink-0 lg:flex-shrink px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 dark:bg-black dark:bg-opacity-40 dark:text-white hover:text-gray-900 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-opacity-10 transition-colors duration-200 border border-gray-200 dark:border-black">
                                Our Mission
                            </a>
                            <a href="#our-process"
                               class="about-section-link flex-shrink-0 lg:flex-shrink px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 dark:bg-black dark:bg-opacity-40 dark:text-white hover:text-gray-900 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-opacity-10 transition-colors duration-200 border border-gray-200 dark:border-black">
                                Our Process
                            </a>
                        </nav>
                    </div>
                </aside>

                <!-- Main content: sections -->
                <main class="flex-1 min-w-0 order-1 lg:order-2 scroll-mt-24">
                    <section id="our-origins" class="scroll-mt-28 mb-12 first:mt-0">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                            Our Origins
                        </h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                            We're a team of designers and developers with years of experience in marketing agency world. Over that time we've built hundreds of restaurant websites—and along the way we cracked the code on what actually works. Not just what looks good, but what gets found, builds trust, and turns searchers into customers.
                        </p>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            Our sites make sure your business is represented the way it deserves online: professional, on-brand, and built to convert. We focus on the details that matter—clear menus, strong calls to action, and a presence that makes people want to walk through your door or place an order.
                        </p>
                    </section>

                    <section id="our-mission" class="scroll-mt-28 mb-12">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                            Our Mission
                        </h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                            You've been there: hungry, out and about, searching for a place to eat. You find a spot that looks promising—but there's no website. No menu to check, no hours, no way to see if they're open or how to order. So you skip them and pick somewhere that actually shows up online. That restaurant just lost a customer they never knew they had. Countless great places have no web presence at all, and when people search for food, they're simply invisible.
                        </p>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            Our mission is to connect restaurants with the customers they're missing. We build sites that are clear, fast, and built for the way people actually search and decide—so when someone looks for food near them, your restaurant shows up and delivers. No more lost tables, no more lost orders. Just a bridge between people who want to eat and the places that are ready to serve them.
                        </p>
                    </section>

                    <section id="our-process" class="scroll-mt-28 mb-12">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                            Our Process
                        </h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                            We start with domain name selection and work with you until the site is live. Our designers and developers are involved from day one through launch—no handoffs to a different team, no generic templates. We deliver a design for your approval within two weeks, and we always go live within four weeks. When everything moves smoothly, we can have your website live in as little as two weeks.
                        </p>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                            Your approval is built into the process. We present the design, you review it, and we refine until you're happy. Once you sign off, we get the site live on schedule so you can start reaching the customers you've been missing.
                        </p>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            After launch, we handle all updates and maintenance. Your site runs on our Stackifide CMS, so you can update content yourself whenever you like—or we can do it for you. Just send us an email with your request and we'll take care of it. You stay in control; we stay in your corner.
                        </p>
                    </section>
                </main>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.about-section-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var targetId = this.getAttribute('href').slice(1);
                var target = document.getElementById(targetId);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</x-app-layout>
