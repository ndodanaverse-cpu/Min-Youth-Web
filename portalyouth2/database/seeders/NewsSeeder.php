<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $stories = [
            [
                'title' => 'Manicaland youths to benefit from US$1 million empowerment fund',
                'image' => '/img/news/manicaland-youth-fund.jpg',
                'date' => '2026-07-31',
                'author' => 'Chikomborero Kanyemba',
                'summary' => 'Government has launched the Youth Economic Empowerment Fund in Manicaland Province, expanding access to loans through EmpowerBank to help young entrepreneurs establish and grow businesses.',
                'body' => <<<'MD'
Story by Chikomborero Kanyemba

GOVERNMENT has launched the Youth Economic Empowerment Fund in Manicaland Province, expanding access to loans through EmpowerBank to help young entrepreneurs establish and grow businesses under the Second Republic's youth empowerment programme.

The provincial rollout follows the launch of the national US$1 million fund during the Zimbabwe International Trade Fair (ZITF) in April. Young entrepreneurs in Manicaland are already benefiting from the facility, using the loans to expand operations, create jobs and invest in new business opportunities.

Director of Fries Agricultural Enterprises, Mr Raymond Nyamuzinga, said the funding had enabled him to scale up his poultry business. "I started my company in 2019 after receiving funding from EmpowerBank. This year, following the launch of the Youth Economic Empowerment Fund, I secured another loan to expand my poultry business. So far this year, I have sold a cumulative total of 20 000 layers in different batches. I currently have 6 000 layers in production and have employed 22 young people," he said.

Mac Fencing Chief Executive Officer and loan beneficiary, Ms Kundai Mumera, said the funding had strengthened the company's production capacity. "The loan has enabled us to expand our fencing manufacturing and supply business. We have increased our raw material stocks, improved production and are pleased to see the business continuing to grow," she said.

Another beneficiary, Mr Alfred Chimwata, Director of Chimwata A Investments, said the fund had enabled him to turn an idea into a viable business. "I had the vision but lacked the capital to get started. When I heard about the Youth Economic Empowerment Fund, I applied through EmpowerBank and received funding. My goal is to install Starlink kits in schools so that children in rural areas have the same access to the internet and learning opportunities as those in urban areas," he said.

EmpowerBank Board Chairperson, Mr William Chaitezvi, said the facility has generated strong demand from young entrepreneurs nationwide. "To date, EmpowerBank has received 537 applications nationally, valued at approximately US$1.39 million. Of these, 202 applications have been approved, resulting in loan disbursements of more than US$510 000. In Manicaland Province alone, we have received 124 applications. So far, 53 loans have been disbursed, amounting to approximately US$141 900," he said.

Launching the provincial programme, Minister of Youth Empowerment, Development and Vocational Training, Honourable Tino Machakaire, said the initiative is designed to unlock the economic potential of young Zimbabweans. "The Government has committed US$1 million to the Youth Economic Empowerment Fund, which will be distributed across all ten provinces. Across the country, many young people have innovative ideas, valuable skills and the determination to succeed. What has often been missing is access to capital to turn those ideas into successful businesses. This fund is more than financial assistance. It is an investment in productivity, inclusion and the future of Zimbabwe's young people," he said.

Minister of State for Manicaland Provincial Affairs and Devolution, Advocate Misheck Mugadza, urged beneficiaries to make productive use of the facility. "Where opportunities exist, let us maximise them together. Our objective is to ensure that this fund delivers measurable and lasting benefits throughout the province. I urge young people to embrace this opportunity with discipline, commitment and a strong sense of responsibility," he said.

The Youth Economic Empowerment Fund targets Zimbabweans aged 18 to 35 with viable business proposals and is being rolled out nationwide through EmpowerBank to increase youth participation in economic development.
MD,
                'featured' => true,
            ],
            [
                'title' => 'Youthful population our greatest asset: Minister',
                'image' => '/img/news/youthful-population-asset.jpg',
                'date' => '2026-07-31',
                'summary' => 'Zimbabwe\'s youthful population should be regarded as the country\'s greatest asset, said Minister Tinoda Machakaire at the launch of the 2026 Demographic Futures Survey during World Population Day commemorations.',
                'body' => <<<'MD'
Zimbabwe's youthful population should be regarded as the country's greatest asset, Youth Empowerment, Development and Vocational Training Minister Tinoda Machakaire said yesterday.

Speaking at the launch of the 2026 Demographic Futures Survey during World Population Day commemorations in Harare, Minister Machakaire said: "Today, Zimbabwe joins the global community to commemorate World Population Day 2026. We meet at a unique intersection of history. The global conversation shifts from merely counting numbers to making every individual count. For Zimbabwe, population metrics are not sterile figures on a balance sheet. Our population of over 17,2 million people carries a distinct, powerful signature: a median age of just 18,3 years. Over 60 percent of our citizens are young people. This is our demographic dividend," he said.

The Minister said Government remained committed to investing in young people through the recently approved National Youth Policy, which promotes economic empowerment, skills development, innovation, health and participation in national development. "Our youthful population is not a challenge to be managed; it is our greatest asset to be developed. We want young people to move from job seekers to job creators, from consumers of technology to innovators, and from beneficiaries of development to leaders of development," he said.

Minister Machakaire said Government was expanding vocational training centres, strengthening youth empowerment programmes and tackling drug and substance abuse while improving access to quality reproductive health information and services.

The survey said young Zimbabweans remain optimistic about marriage and parenthood. It found that while most young Zimbabweans still desire to marry and have children, many cite challenges such as financial insecurity. The survey, conducted among more than 108 000 young adults aged 18 to 39 across 73 countries, was launched jointly by the Government of Zimbabwe and UNFPA under the theme: "Realising the hopes and aspirations of young people – today and for the future."

Presenting the findings, UNFPA Zimbabwe representative Ms Miranda Tabifor said the report provided unprecedented insight into how young people view their future and the factors influencing decisions on marriage and parenthood. "In Zimbabwe, as elsewhere, the path to a resilient and prosperous future lies in our ability to listen to young people and create the conditions where they can thrive. The Demographic Futures Survey confirms that young people value partnership and parenthood, but their ability to realise these aspirations is hampered by systemic barriers. We must move beyond simply managing demographic shifts to actively investing in the capabilities, health and rights of our youth," she said.

The survey indicated that for the majority of young adults, financial security, stable employment, and emotional readiness are the top preconditions for becoming parents. It found that while 68 percent of respondents still regard marriage as an ideal and 80 percent desire to have children, economic realities are delaying those aspirations.

According to the report, economic and housing constraints emerged as the biggest obstacle to parenthood, followed by a lack of a suitable partner and health and reproductive concerns. The report further revealed that financial security was the most important condition for parenthood, with 88 percent of respondents citing it as essential, followed by stable employment (87 percent) and emotional readiness (85 percent).

Ms Tabifor said the findings should guide governments, policymakers, employers and development partners in designing policies that respond to the realities facing young people.

United Nations Resident Coordinator Ms Rosemary Kalapurakal said Zimbabwe stood at a defining demographic moment and urged policymakers to use the survey findings to shape investments in young people. "When we talk about numbers and population, we are actually talking about people. We are talking about their dreams, opportunities, choices and indeed the future of this nation. If we are serious about realising the hopes and aspirations of young people, we must first listen to them, understand their concerns and allow that evidence to shape the decisions we make."
MD,
            ],
            [
                'title' => 'YSZ Graduate Trainees Support Repatriation at Beitbridge',
                'image' => '/img/news/ysz-beitbridge.jpg',
                'date' => '2026-07-24',
                'summary' => 'Youth Service Zimbabwe (YSZ) graduate trainees are providing assistance at the Beitbridge Border Reception Centre for individuals returning to Zimbabwe, as part of the Repatriation Programme.',
                'body' => <<<'MD'
Youth Service Zimbabwe (YSZ) graduate trainees are providing assistance at the Beitbridge Border Reception Centre for individuals returning to Zimbabwe. This support forms part of the Repatriation Programme and aims to ensure a smooth, safe, and well-coordinated reception process.

The YSZ graduate trainees are working alongside relevant officials and partner teams to carry out various duties during the programme. Their duties include offering assistance to returning persons, supporting reception and orientation, assisting with documentation and coordination where required, and promoting order and effective service delivery at the reception point.

In addition, the Ministry has an information desk at the border entry point, where young people can access information about the Ministry and its programmes. Registration is also open for empowerment opportunities.
MD,
            ],
            [
                'title' => 'Government fast-tracks reintegration of youth returnees',
                'image' => '/img/news/youth-returnee-reintegration.jpg',
                'date' => '2026-07-24',
                'author' => 'Ray Bande',
                'summary' => 'The Government is carrying out a registration and training needs assessment for young Zimbabweans returning from South Africa to facilitate their reintegration and link them to youth empowerment opportunities.',
                'body' => <<<'MD'
Ray Bande Senior Reporter

THE Government is carrying out a registration and training needs assessment for young Zimbabweans returning from South Africa as part of efforts to facilitate their reintegration and link them to youth empowerment opportunities across the country.

Permanent Secretary in the Ministry of Youth Empowerment, Development and Vocational Training, Mr Solomon Mhlanga, revealed this on the sidelines of the ministry's senior management workshop held in Mutare last Friday. Mr Mhlanga said the exercise was designed to identify the skills, qualifications and support needs of returning youths so that they can be effectively incorporated into existing Government programmes aimed at enhancing livelihoods and economic participation.

"Currently, the registration and training needs analysis is being undertaken as youth returnees enter the country. The ministry has recognised the importance of reintegrating young Zimbabweans returning from South Africa, and is doing so through existing youth empowerment programmes," he said.

He explained that returning youths are eligible to participate in the same development and empowerment initiatives available to other young Zimbabweans, provided they satisfy the relevant criteria. "Young returnees are generally eligible to participate in the same youth programmes as their local counterparts, subject to meeting the prescribed requirements," said Mr Mhlanga.

Among the programmes available are the Youth Service in Zimbabwe, vocational skills training and access to funding for youth-led enterprises. Mr Mhlanga said participation in the Youth Service programme will help returning youths reconnect with their communities while creating valuable social and professional networks. He added that the country's vocational training centres offer opportunities for returnees to acquire new skills or upgrade existing competencies, thereby improving their prospects for employment or self-employment.

"Eligible young returnees with viable business proposals can also access support through the Youth Empowerment Fund to establish or expand income-generating projects and facilitate their economic reintegration," he said.

Meanwhile, Zimbabwe is preparing a bid to host the 2027 YouthConnekt Africa Summit, one of the continent's premier youth development platforms. Mr Mhlanga said the proposed bid reflects Zimbabwe's growing commitment to youth empowerment and its readiness to host a major continental gathering dedicated to entrepreneurship, innovation, skills development and employment creation.

Mr Mhlanga said hosting the 2027 summit will position Zimbabwe as a continental leader in youth empowerment, entrepreneurship, innovation and skills development. The event is expected to attract more than 6 000 delegates from across Africa and beyond, including Heads of State and Government, ministers responsible for youth affairs, development partners, investors, academics and young entrepreneurs.
MD,
                'source_name' => 'The Herald',
                'source_url' => 'https://www.herald.co.zw',
            ],
            [
                'title' => 'Junior Parliament celebrates over three decades of youth engagement, advocacy',
                'image' => '/img/news/junior-parliament.jpg',
                'date' => '2026-07-22',
                'summary' => 'Zimbabwe\'s Junior Parliament has become a significant force, going beyond legislative engagement in combating pressing social issues such as drug and substance abuse.',
                'body' => <<<'MD'
ZIMBABWE's Junior Parliament has become a significant force having gone far beyond legislative engagement in combating pressing social issues such as drug and substance abuse, an official has said.

This is because the young parliamentarians are regarded as opinion leaders within their communities and schools, capable of influencing behavioural change among their peers through various projects and advocacy initiatives.

In a statement, the Ministry of Youth Empowerment, Development and Vocational Training director of communication and advocacy Mr Ranson Madzamba says Junior Parliament addresses various social ills affecting young people. He said Zimbabwe Junior Parliament Session and commemoration of the Day of the African Child are set to be held at the new Parliament building.

The two events are expected to bring together young people, policymakers, development partners, community leaders, civil society organisations and other stakeholders. "Junior Parliament aims to address a range of issues affecting the youth, offering a space where their voices can be heard and their concerns can influence policy decisions. As one senior member remarked, 'Anything for the youths without the youths is not for the youths,' emphasising the importance of youth participation in matters that directly impact their lives," he said.

Since its establishment in 1991, the Junior Parliament of Zimbabwe has played a vital role in empowering young people across the nation to participate actively in shaping their future. Serving as a replica of the national Parliament, this platform provides a unique avenue for youth involvement in governance, community issues and national development.

This initiative aligns with several national and international frameworks, including Zimbabwe's Constitution, the National Youth Policy 2020-25, the United Nations Convention on the Rights of the Child, and the African Charter on the Rights and Welfare of the Child. It enables representatives from all 210 constituencies to share their thoughts, experiences, and ideas with Government officials, fostering a culture of inclusivity and responsiveness.

Mr Madzamba said the platform also invites stakeholders including Government agencies, non-governmental organisations and international partners to reflect on investments in children's rights and well-being. It presents a crucial opportunity to evaluate progress made and identify the challenges that remain in ensuring young people's rights are fully realised in Zimbabwe.

He said Junior Parliamentarians are tasked with bringing forward youth concerns, participating in policy development and spearheading community projects aimed at addressing children's issues. They're also instrumental in raising awareness, conducting education programmes and establishing clubs that promote leadership and social responsibility.

"June 16 holds special significance for Africans, commemorating the brave students of Soweto who, in 1976, lost their lives protesting against racial discrimination and poor education standards. Over 700 children were massacred during the Soweto uprising, symbolising the fight for quality education and equality. In Zimbabwe's history, the sacrifices of young people include the tragic loss of over 6,000 women and children at Chimoio in 1977 and 1,028 lives at Nyadzonia in 1976. These young heroes and heroines fought tirelessly for a free, democratic Zimbabwe where liberty, fraternity and equality prevail. The Day of the African Child honours their memory and calls for ongoing commitment to address the challenges facing children across the continent," he said.

Mr Madzamba said as Zimbabwe continues to nurture its young leaders through platforms like the Junior Parliament, the nation reaffirms its dedication to creating a supportive environment where youth can thrive, participate and lead.
MD,
            ],
            [
                'title' => 'US$61 000 solar investment powers new era for Kaguvi VTC',
                'image' => '/img/news/kaguvi-vtc-solar.jpg',
                'date' => '2026-07-22',
                'summary' => 'A US$61,000 investment in renewable energy has positioned Kaguvi Vocational Training Centre as home to the largest solar power installation at any vocational training centre in Midlands Province.',
                'body' => <<<'MD'
A US$61,000 investment in renewable energy has positioned Kaguvi Vocational Training Centre (VTC) as home to the largest solar power installation at any vocational training centre in Midlands Province following the commissioning of an 80kVA solar system expected to improve practical training, reduce electricity costs and boost the institution's capacity to host national events.

The project, commissioned during the closing of the 2026 National Vocational Training Centres Sports Gala, was financed through an EmpowerBank loan facility of US$58,500, with an additional US$2,500 invested in security fencing.

Speaking during the commissioning ceremony, the Provincial Centre Head of Kaguvi VTC, Benson Peter Mazani, said the project demonstrates Government's commitment to developing skills through improved infrastructure. "Hosting nine provincial teams while commissioning a major infrastructure project speaks to the vision of His Excellency the President: 'Skills, Sport and Infrastructure for National Development.' Nyika inovakwa nevene vayo," he said.

The Mazani said the solar installation would address one of the institution's biggest challenges by ensuring uninterrupted electricity supply for practical lessons. "Power outages have been our biggest cost and training disruptor. With 80kVA, we can now run workshops, ICT laboratories and refrigeration for Hospitality without interruption. That means more practical hours for our students," said Mazani.

He added that the project would also ease the institution's operational costs. "The system will cut our ZETDC bill by an estimated 60 percent monthly. Those savings are being redirected to student consumables, sports equipment and maintenance. The loan is therefore an investment that pays itself," he said.

Beyond reducing costs, the Mazani said the installation would serve as a practical learning facility for students studying electrical and solar technologies. "Our Electrical and Solar students witnessed the installation and will be involved in maintaining and monitoring this system. We are producing graduates who can be deployed in rural schools, clinics and mines," he said.

He said the reliable power supply, together with support from Vungu Rural District Council in upgrading roads and assistance from Conhse Mine with water supplies, had strengthened Kaguvi VTC's ability to host major events.

Minister of Youth Empowerment, Development and Vocational Training, Tinoda Machakaire, commended Kaguvi VTC for the achievement, describing it as a demonstration of the important role vocational training institutions play in Zimbabwe's development. "I commend Kaguvi Vocational Training Centre for the successful commissioning of its solar plant. This milestone is a shining example of innovation, self-reliance and sustainability in action, values that are at the very heart of vocational training, and a demonstration of how our VTCs continue to lead in practical, forward-looking development," said Machakaire.

Reporting by Mbekezeli Ncube
MD,
                'author' => 'Mbekezeli Ncube',
            ],
            [
                'title' => 'VISA Games reach business end',
                'image' => '/img/news/visa-games.jpg',
                'date' => '2026-07-22',
                'summary' => 'The 2026 Vocational Institutions Sports Association moved a gear up with provincial sides clashing at Kaguvi Vocational Training Centre in the Midlands Province.',
                'body' => <<<'MD'
THE 2026 Vocational Institutions Sports Association moved a gear up with provincial sides clashing at Kaguvi Vocational Training Centre in the Midlands Province.

With all provinces represented in various disciplines, the VISA games have taken a national outlook amid excitement that has been building up ahead of the official opening ceremony, expected to be presided over by the Minister of Youth Empowerment, Development and Vocational Training Tino Machakaire.

The Ministry's director of communication and advocacy Ranson Madzamba, is satisfied with the manner the games, which are also being used as a vehicle to fight drug and substance abuse, have gone. "The games will be running until July 3, under the theme 'From play to purpose, shaping future drug-free champions through sports in Vocational Training Centres'."

Organisers confirmed a 100 percent turnout, with every provincial delegation arriving safely for the annual multi-sport competition, underlining the growing importance of the games in promoting sport and youth development within vocational training institutions.

The opening day was devoted entirely to track and field events, where student athletes competed across a range of disciplines. Attention has, however, since shifted to the ball games, with matches underway in football, netball and volleyball.

Madzamba said the tournament extends beyond sporting competition by contributing to the holistic development of students. "The VISA Games play an important role in supporting students' personal growth, strengthening institutions and fostering community engagement. The tournaments bring together students from different Vocational Training Centres, promoting friendship, mutual respect and national cohesion. They also create opportunities for cultural exchange and networking beyond the classroom," said Madzamba.

He added that the qualities acquired through sport, including resilience, problem-solving, teamwork and time management, improve students' employability while providing a platform for talented athletes to earn recognition beyond the vocational training system.

Competition continues throughout the week, with teams battling for honours across the various sporting disciplines. By late yesterday, Midlands were leading with eight gold medals, followed by Mashonaland Central with six gold medals.
MD,
            ],
            [
                'title' => 'Government Intensifies Use of Sport to Keep Youth Off Drugs',
                'image' => '/img/news/sport-against-drugs.jpg',
                'date' => '2026-07-22',
                'summary' => 'Government is stepping up efforts to use sport as a weapon against drug and substance abuse among young people, with vocational training institutions at the centre of that campaign.',
                'body' => <<<'MD'
Government is stepping up efforts to use sport as a weapon against drug and substance abuse among young people, with vocational training institutions being positioned at the centre of that campaign.

Speaking at the official opening of the 11th Vocational Institutions Sports Association (VISA) National Tournament at Kaguvi Vocational Training Centre in Gweru, Minister of Youth Empowerment, Development and Vocational Training Tinoda Machakaire said the integration of sport into vocational education is helping shape responsible and productive citizens.

He said the tournament's theme reflects Government's commitment to ensuring young people channel their energy into positive activities that promote healthy living and personal growth. "Sport occupies our young people's time and energy productively, builds their self-esteem, and provides a positive alternative to the destructive path of drug and substance abuse that continues to threaten the future of our nation," said Machakaire.

The Minister said vocational training is about more than equipping young people with technical and entrepreneurial skills, stressing that institutions must also produce graduates with strong values and leadership qualities. "Sport plays an equally important role in shaping character. It teaches discipline, respect, leadership, perseverance, teamwork and integrity, qualities that every successful artisan, entrepreneur, employee and community leader must possess," he said.

Machakaire said Government will continue modernising vocational training centres to nurture innovation, entrepreneurship and holistic youth development in line with Vision 2030. He added that the country's economic transformation depends on young people who are not only technically skilled but also physically fit, mentally resilient and socially responsible.

"As we continue investing in vocational education, let us also continue nurturing sporting excellence and reinforcing the fight against drug and substance abuse among our youth. Zimbabwe needs young people who can innovate in the workshop, compete on the field of play, create businesses, generate employment, and contribute to building a prosperous nation," said Machakaire.

Reporting by Mbekezeli Ncube
MD,
                'author' => 'Mbekezeli Ncube',
            ],
            [
                'title' => 'Beware of fraudsters, youths urged to consult official empowerment agencies',
                'image' => '/img/news/fraudsters-warning.png',
                'date' => '2026-07-22',
                'author' => 'Kimberley Chitambara',
                'summary' => 'Young Zimbabweans have been encouraged to take advantage of youth empowerment funding opportunities while remaining vigilant against fraudsters masquerading as ministry officials and agents.',
                'body' => <<<'MD'
Kimberley Chitambara, Sunday News Reporter

YOUNG Zimbabweans have been encouraged to take advantage of youth empowerment funding opportunities being offered by Government while remaining vigilant against fraudsters masquerading as ministry officials and agents.

Speaking in an interview, the Ministry of Youth Empowerment, Development and Vocational Training's Director of Communication and Advocacy, Mr Ranson Madzamba, said young entrepreneurs and aspiring business owners aged below 35 years should approach official Government structures for assistance in accessing empowerment funding.

He said ministry officials stationed at district, provincial and national offices were available to guide young people through the application process and provide information on available funding opportunities. "To all the young entrepreneurs and also to all those who would want to be young entrepreneurs, I am talking of those young people who are below the age of 35 years. They are free to visit our offices at district, provincial and national level and they are people who are ready to help them out on how best they can access these funds. They are also free to visit our EmpowerBank branches," said Mr Madzamba. "Definitely they will be assisted."

Mr Madzamba, however, warned young people to be on high alert for fraudsters who are circulating misleading information and falsely claiming to represent the ministry or EmpowerBank. He said the ministry had become aware of individuals distributing flyers and presenting themselves as agents or messengers of the Ministry of Youth Empowerment, Development and Vocational Training or EmpowerBank in an effort to defraud unsuspecting youths.

"On another note, we would want the young people to be vigilant. They are supposed to have their eyes open because there are some fraudsters who are now flighting various flyers purporting to be messengers if not agents of the Ministry of Youth Empowerment, Development and Vocational Training as well as the EmpowerBank," he said.

Mr Madzamba urged young people to verify all information through official channels and to seek assistance directly from ministry offices or EmpowerBank branches. "Please, please take note. As a ministry, we are available at every district, at every province and feel free to be helped at our offices. Feel free as well to be helped at our EmpowerBank branches," he said.

Government has in recent years intensified efforts to promote youth entrepreneurship and economic empowerment through funding initiatives, vocational training programmes and support for youth-led enterprises aimed at improving livelihoods and creating employment opportunities.
MD,
                'source_name' => 'Sunday News',
            ],
            [
                'title' => 'The Launch of Hope, Youth Employment and Entrepreneurship Project',
                'image' => '/img/news/yee-project-launch.jpeg',
                'date' => '2025-07-17',
                'summary' => 'The official launch of the Youth Employment and Entrepreneurship (YEE) Project at Newlands Country Club, aimed at empowering the youth of Zimbabwe by creating sustainable job opportunities and fostering entrepreneurship.',
                'body' => <<<'MD'
On a bright morning in Harare, excitement filled the air as the Newlands Country Club prepared for a significant event — the official launch of the Youth Employment and Entrepreneurship (YEE) Project. The initiative aimed to empower the youth of Zimbabwe by creating sustainable job opportunities and fostering entrepreneurship.

As guests began to arrive, the atmosphere buzzed with anticipation. Among them was Mr. Solomon Mhlanga, the Permanent Secretary of the Ministry of Youth Empowerment Development and Vocational Training, who was invited to be the Guest of Honour. He understood the importance of this project, especially in a country where over 2.3 million young people were not in education, employment, or training.

As Mr. Mhlanga took the stage, he reflected on the challenges faced by young Zimbabweans. "Today's launch is not merely a project event; it is a strategic milestone in our journey to create inclusive and decent work opportunities for our youth," he stated.

He spoke of the government's Vision 2030 and the National Development Strategy, emphasizing the need for actionable solutions that empower youth as job creators and leaders. He acknowledged the critical partnership with SNV Zimbabwe, whose support had been instrumental in reviewing national policies and promoting youth-responsive planning.

The YEE project, now in its second phase, aimed to reach 13,000 youth and create 7,000 green jobs. As he shared the successes of Phase I where thousands of youths were trained and many enterprises flourished, the audience erupted in applause.

The program featured a documentary showcasing success stories from the previous phase. Young entrepreneurs shared their journeys, highlighting how the initiative had equipped them with skills and confidence.

The event concluded with a call to action. Mr. Mhlanga urged all stakeholders to collaborate and ensure the successful implementation of the YEE project. "Empowered youth are the foundation of Zimbabwe's prosperity. Together, we will realize that vision," he declared.

As the guests mingled during the exhibition tour, conversations sparked between young entrepreneurs and potential investors. The YEE project was more than a program; it was a movement toward a brighter future for the youth of Zimbabwe.
MD,
            ],
            [
                'title' => 'Youth for Peace: Fully funded UNESCO Intercultural Leadership Programme — Apply Now',
                'image' => '/img/news/unesco-intercultural.jpg',
                'date' => '2025-06-11',
                'summary' => 'Applications are open for the fully funded UNESCO Intercultural Leadership Programme for peace, bringing young leaders together across cultures.',
                'body' => 'Applications are open for the Youth for Peace fully funded UNESCO Intercultural Leadership Programme. The programme brings together young leaders to build intercultural understanding, leadership skills and peacebuilding capacity. Visit the programme page for eligibility and application details.',
                'source_name' => 'Opportunities for Youth',
                'source_url' => 'https://opportunitiesforyouth.org/2025/05/29/youth-for-peace-fully-funded-unesco-intercultural-leadership-programme-apply-now/',
            ],
            [
                'title' => 'Ministry and CAMFED Zim engage to empower young people',
                'image' => '/img/news/camfed-partnership.jpg',
                'date' => '2025-05-14',
                'summary' => 'The Ministry engaged CAMFED Zimbabwe to strengthen support for young women\'s education, leadership and enterprise development.',
                'body' => 'The Ministry of Youth Empowerment, Development and Vocational Training engaged CAMFED Zimbabwe in discussions to empower young people — with a focus on young women — through education, mentorship and enterprise support. Follow the Ministry\'s social media pages for updates on the partnership.',
                'source_name' => 'Facebook',
                'source_url' => 'https://www.facebook.com/myedvt',
            ],
            [
                'title' => 'Mbire Boer Goats Project Handover Ceremony',
                'image' => '/img/news/mbire-boer-goats.jpg',
                'date' => '2025-03-28',
                'summary' => 'Hon. Minister T. Machakaire distributed purebred Boer goats to 30 youth clubs in Mbire District, supported by the Chinese Embassy through its Youth Maker program.',
                'body' => <<<'MD'
In a significant move to empower the youth of Zimbabwe, Hon. Minister T. Machakaire distributed purebred Boer goats to 30 youth clubs in Mbire District, Mashonaland Central. This initiative, supported by the Chinese Embassy through its Youth Maker program, aims to enhance the livelihoods of young people by providing them with high-quality livestock that can improve goat genetics and increase carcass weight, ultimately boosting their income.

Addressing youths at Gonono Business Centre, the Deputy Chinese Ambassador, Me Cheng Yan, said, "We just hope the donation will serve as a catalyst or trigger to unleash the immense energy and potential of youth in Mashonaland Central and to boost the local livestock industry."

The event was attended by Permanent Secretary Mr. S. Mhlanga; Chinese Embassy officials; UNDP Country Representative Dr. A. Odusola; and Mbire Constituency Member of Parliament Hon. D. Butau. Together, they toured local sesame fields, where Mbire youths are actively engaged in farming this cash crop.

During the handover ceremony, Hon. Minister Machakaire was thrilled with the projects and how determined the youths in Mbire district were. "I am pleased to note that some of the youth in Ward 4 have already surpassed the lower threshold of this economic classification, earning over $4,000 per year. This is a pure testament to the power of determination, organization, and strategic economic engagement."

"I was happy to receive reports that the youth of Mbire are fully engaged in goat and sesame farming clubs. In addition, the youth groups were strategically organized into clubs, and this structured approach fosters efficiency and makes it easier for the ministry and its stakeholders to introduce impactful interventions that can scale up youth operations," the Hon. Minister said.

Furthermore, the Hon. Minister stated that, "Our vision is to establish Mbire as a hub for purebred goats, and for this we are actively working to secure additional resources to continue the transition from F1 crossbreeds to purebred stock. Furthermore, as we strengthen the goat and sesame value chains, we plan to construct a standard abattoir for goats in this district. This facility will ensure value addition and improved market access for goat products."

In addition to the goat distribution, the Hon. Minister provided mobile gadgets to Junior Parliamentarians present to enhance their technological capabilities and facilitate effective communication. Furthermore, twelve youth ward officers from Mbire District received motorbikes to improve their mobility and engagement with the youth in their respective wards.
MD,
            ],
            [
                'title' => 'Performance Contracts Signing And Awards Ceremony for Ministers and Heads of Public Sector Agencies',
                'image' => '/img/news/performance-contracts.png',
                'date' => '2025-03-24',
                'summary' => 'All is set for the signing of performance contracts and awards ceremony at State House in Harare, where President Mnangagwa is expected to lead the process in line with Vision 2030.',
                'body' => <<<'MD'
All is set for the signing of performance contracts and awards ceremony at State House in Harare today, where President Mnangagwa is expected to lead the process.

Cabinet ministers and senior public sector officials will sign performance contracts in line with Vision 2030, which demands that leaders provide sustainable economic growth, employment, wealth creation, national development and poverty alleviation for the people.

So far, 6 000 projects across 14 thematic areas have been implemented. The projects have been closely monitored, evaluated and awarded since 2021 when the performance contracts were implemented. This comes as some Government officials have recorded major successes in their portfolios.
MD,
            ],
            [
                'title' => 'Presidential Empowerments Youth launched',
                'image' => '/img/news/presidential-empowerments.jpg',
                'date' => '2025-03-24',
                'summary' => 'The Presidential Empowerments Youth programme was launched to support young people\'s participation in empowerment initiatives across Zimbabwe.',
                'body' => 'The Presidential Empowerments Youth programme was officially launched, connecting young Zimbabweans to empowerment initiatives, skills development and enterprise opportunities under the Second Republic.',
                'source_name' => 'Facebook',
                'source_url' => 'https://www.facebook.com/myedvt',
            ],
            [
                'title' => 'Ministry and CZA Church in partnership to empower young people',
                'image' => '/img/news/cza-church-partnership.jpg',
                'date' => '2025-03-24',
                'summary' => 'The Ministry partnered with CZA Church to empower young people through mentorship, skills and community-based programmes.',
                'body' => 'The Ministry of Youth Empowerment, Development and Vocational Training entered into a partnership with CZA Church to empower young people through mentorship, skills development and community programmes. Follow the Ministry\'s social media pages for updates.',
                'source_name' => 'Facebook',
                'source_url' => 'https://www.facebook.com/myedvt',
            ],
            [
                'title' => 'Ministry, UNICEF partner to launch Tech Innovation Hub',
                'image' => '/img/news/unicef-tech-hub.jpg',
                'date' => '2025-03-14',
                'summary' => 'The Ministry partnered with UNICEF to launch a Tech Innovation Hub giving young people access to digital skills and innovation support.',
                'body' => 'The Ministry of Youth Empowerment, Development and Vocational Training partnered with UNICEF to launch a Tech Innovation Hub, providing young Zimbabweans with access to digital skills training, mentorship and innovation support.',
                'source_name' => 'Facebook',
                'source_url' => 'https://www.facebook.com/myedvt',
            ],
            [
                'title' => 'Parliamentary Portfolio Committee on VTCs fact finding mission',
                'image' => '/img/news/vtc-fact-finding.jpg',
                'date' => '2025-03-14',
                'summary' => 'The Parliamentary Portfolio Committee conducted a fact-finding mission on Vocational Training Centres to assess infrastructure and training delivery.',
                'body' => 'The Parliamentary Portfolio Committee responsible for Vocational Training Centres conducted a fact-finding mission to assess the state of VTCs, their infrastructure and the delivery of vocational training to young people across the country.',
                'source_name' => 'Facebook',
                'source_url' => 'https://www.facebook.com/myedvt',
            ],
            [
                'title' => 'Ministry partners with Gold Youth Development Agency',
                'image' => '/img/news/gold-youth-agency.jpg',
                'date' => '2025-03-13',
                'summary' => 'The Ministry partnered with the Gold Youth Development Agency to scale up youth empowerment and life-skills programmes.',
                'body' => 'The Ministry of Youth Empowerment, Development and Vocational Training partnered with the Gold Youth Development Agency to expand youth empowerment, life-skills and peer-mentorship programmes for young Zimbabweans.',
                'source_name' => 'Facebook',
                'source_url' => 'https://www.facebook.com/myedvt',
            ],
            [
                'title' => 'Hon Minister Cde Tino Machakaire hosts empowerment program and a graduation ceremony',
                'image' => '/img/news/machakaire-graduation.jpg',
                'date' => '2025-03-13',
                'summary' => 'Hon Minister Cde Tino Machakaire hosted an empowerment programme and a graduation ceremony for young trainees.',
                'body' => 'Hon Minister Cde Tino Machakaire hosted an empowerment programme and a graduation ceremony, celebrating young people who completed vocational and empowerment training under Ministry programmes.',
                'source_name' => 'Facebook',
                'source_url' => 'https://www.facebook.com/myedvt',
            ],
            [
                'title' => '2025 National Youth Day in pictures. ZITF Grounds, Bulawayo',
                'image' => '/img/news/national-youth-day.jpg',
                'date' => '2025-03-13',
                'summary' => 'The 2025 National Youth Day celebrations took place at the ZITF Grounds in Bulawayo, bringing together young people from across the country.',
                'body' => 'The 2025 National Youth Day celebrations were held at the ZITF Grounds in Bulawayo, bringing together thousands of young people from across Zimbabwe for a day of empowerment, exhibitions and celebration of youth contributions to national development.',
                'source_name' => 'Facebook',
                'source_url' => 'https://www.facebook.com/myedvt',
            ],
            [
                'title' => 'Up-Close with the Youth Service in Zimbabwe Dadaya Training Centre Commandant',
                'image' => '/img/news/dadaya-commandant.jpg',
                'date' => '2025-03-13',
                'summary' => 'An up-close interview with the Youth Service in Zimbabwe Dadaya Training Centre Commandant on the programme\'s impact.',
                'body' => 'An up-close feature with the Youth Service in Zimbabwe Dadaya Training Centre Commandant, discussing the role of the Youth Service programme in developing disciplined, skilled and patriotic young citizens.',
                'source_name' => 'Sunday News',
                'source_url' => 'https://www.sundaynews.co.zw',
            ],
            [
                'title' => 'Youth service nurtures responsible, resilient citizens',
                'image' => '/img/news/youth-service-citizens.jpg',
                'date' => '2025-02-04',
                'summary' => 'The Youth Service in Zimbabwe is nurturing responsible and resilient citizens through disciplined training and national values.',
                'body' => 'The Youth Service in Zimbabwe continues to nurture responsible, resilient citizens, instilling national values, discipline and a spirit of service among young people through its structured training programme.',
                'source_name' => 'The Sunday Mail',
                'source_url' => 'https://www.sundaymail.co.zw',
            ],
            [
                'title' => 'The Ministry conducted a significant Youth Empowerment Strategy workshop in Mutare',
                'image' => '/img/news/empowerment-workshop-mutare.jpg',
                'date' => '2025-02-04',
                'summary' => 'The Ministry conducted a significant Youth Empowerment Strategy workshop in Mutare to shape the National Youth Empowerment Strategy.',
                'body' => 'The Ministry conducted a significant Youth Empowerment Strategy workshop in Mutare, bringing together stakeholders to shape the National Youth Empowerment Strategy and strengthen youth economic participation.',
                'source_name' => 'Facebook',
                'source_url' => 'https://www.facebook.com/myedvt',
            ],
        ];

        foreach ($stories as $story) {
            News::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($story['title'])],
                [
                    'title' => $story['title'],
                    'summary' => $story['summary'],
                    'body' => $story['body'],
                    'cover_image' => $story['image'],
                    'source_name' => $story['source_name'] ?? null,
                    'source_url' => $story['source_url'] ?? null,
                    'author' => $story['author'] ?? null,
                    'status' => 'published',
                    'is_featured' => $story['featured'] ?? false,
                    'published_at' => $story['date'],
                ]
            );
        }
    }
}
