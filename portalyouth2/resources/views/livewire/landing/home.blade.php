<div>
    @include('partials.landing.hero', ['stats' => $stats])

    <livewire:landing.search />

    <div class="bg-white">
        @include('partials.landing.programmes')
    </div>

    <div class="bg-mist-50">
        @include('partials.landing.opportunities')
    </div>

    <div class="bg-white">
        @include('partials.landing.activities')
    </div>

    <div class="bg-gov-950">
        @include('partials.landing.campaigns')
    </div>

    <div class="bg-white">
        @include('partials.landing.success-stories')
    </div>

    <div class="bg-mist-50">
        @include('partials.landing.news')
    </div>

    <div class="bg-white">
        @include('partials.landing.faq')
    </div>

    @include('partials.landing.cta')
</div>
