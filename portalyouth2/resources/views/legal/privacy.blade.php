<x-landing-layout
    title="Privacy Policy"
    description="How the Youth Portal Zimbabwe collects, uses and protects your personal information."
>
    <section id="about" class="scroll-mt-section py-20 lg:py-28">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Legal"
                title="Privacy Policy"
                description="How we collect, use and protect your personal information."
            />

            <div class="prose prose-slate mt-12 max-w-none">
                <h2>Introduction</h2>
                <p>
                    The Ministry of Youth Empowerment, Development and Vocational Training (MYEDVT) operates this portal
                    as part of its mandate to connect young Zimbabweans with programmes, opportunities and support
                    services. This policy explains what personal information we collect and how we use it.
                </p>

                <h2>Information we collect</h2>
                <p>When you register an account or subscribe to updates, we collect information you provide, including your name, date of birth, contact details and, where applicable, education and employment information.</p>

                <h2>How we use your information</h2>
                <ul>
                    <li>To create and manage your portal account.</li>
                    <li>To process and manage applications to programmes and opportunities.</li>
                    <li>To send you updates you have subscribed to.</li>
                    <li>To improve portal services and report anonymised statistics.</li>
                </ul>

                <h2>Sharing and security</h2>
                <p>
                    Your information is shared only with authorised Ministry officials and programme partners on a
                    need-to-know basis. We apply appropriate technical and organisational measures to safeguard your
                    data.
                </p>

                <h2>Your rights</h2>
                <p>
                    You may request access to, correction of, or deletion of your personal information by contacting us
                    at {{ config('portal.email') }}. You can opt out of communications at any time.
                </p>

                <h2>Contact</h2>
                <p>
                    For privacy enquiries, email {{ config('portal.email') }} or write to
                    {{ config('portal.address') }}.
                </p>
            </div>
        </div>
    </section>
</x-landing-layout>
