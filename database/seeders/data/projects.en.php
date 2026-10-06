<?php

/*
|--------------------------------------------------------------------------
| English version of the initial projects
|--------------------------------------------------------------------------
|
| Keyed by project slug. Every field is optional: a missing field falls
| back to the French text. "tasks" follows the order of the French tasks.
|
*/

return [
    'smartschools' => [
        'title' => 'SmartSchools',
        'summary' => 'Multi-school management SaaS: enrolment, student records, grades and report cards, tuition fees, timetables and communication with parents.',
        'context' => 'SIGP SC Cameroon, team project',
        'role' => 'Full stack developer: features, testing, documentation and user training',
        'period' => 'Since February 2024',
        'tags' => "Education\nSaaS",
        'case_study' => '<p>SmartSchools is the school management platform published by SIGP SC. A single workspace runs several schools, each with its own isolated data and configuration.</p>'
            .'<p>The product covers the whole student life cycle:</p>'
            .'<ul><li>online and on-site enrolment, class assignment and status tracking;</li>'
            .'<li>student records: academic history, absences, late arrivals and disciplinary actions;</li>'
            .'<li>grades, report cards and timetables;</li>'
            .'<li>tuition fees and the Treasury module;</li>'
            .'<li>parent portal with SMS and email notifications;</li>'
            .'<li>role-based access and an audit log of sensitive actions.</li></ul>'
            .'<p>The product evolves continuously: every new feature has to fit in without disrupting the school staff who use it every day.</p>',
        'tasks' => [
            ['Feature development', 'New Angular screens and .NET API services, following the existing architecture.'],
            ['Testing and fixes', 'Acceptance testing of new features, reproducing and fixing issues reported by schools.'],
            ['Documentation', 'User guides written for the schools\' administrative staff.'],
            ['Training and Treasury video', 'User training and the script of a presentation video for the Treasury module.'],
        ],
    ],
    'exbilcore' => [
        'title' => 'ExbilCore',
        'summary' => 'Unified API platform for African businesses: Mobile Money payments, multichannel messaging and multi-factor authentication.',
        'context' => 'SIGP SC Cameroon, team project',
        'role' => 'Full stack developer: REST APIs, services, webhooks, scheduled jobs and back office',
        'period' => 'Since 2024',
        'tags' => "Fintech\nAPI",
        'case_study' => '<p>ExbilCore brings together, behind a single API, three services that businesses need to operate in Cameroon and Central Africa:</p>'
            .'<ul><li><strong>Payments</strong>: Orange Money and MTN Mobile Money aggregation, collections and payouts;</li>'
            .'<li><strong>Messaging</strong>: SMS, WhatsApp, Telegram and email, including bulk campaigns with click tracking;</li>'
            .'<li><strong>Security</strong>: one-time codes by email or SMS, authenticator apps (TOTP) and token verification.</li></ul>'
            .'<p>A .NET SDK published on NuGet lets developers plug it into an ASP.NET Core application in a few lines. Payment notifications are delivered through signed webhooks.</p>',
        'tasks' => [
            ['REST API design and evolution', 'Endpoints, business services and documented API contracts for integrators.'],
            ['Webhooks and scheduled jobs', 'Asynchronous processing of payment notifications and bulk sending.'],
            ['Back office', 'Angular admin and monitoring interfaces.'],
            ['Unit tests', 'Coverage of critical services (payments, authentication).'],
        ],
    ],
    'sportbetafrica' => [
        'title' => 'SportBetAfrica',
        'summary' => 'Cameroonian online sports betting platform in production: live betting, deposits and withdrawals through Mobile Money or in agencies.',
        'context' => 'SIGP SC Cameroon, in production',
        'role' => 'Features and fixes on the platform and the back office',
        'period' => 'Since 2024',
        'tags' => "Sports betting\nReal time",
        'case_study' => '<p>SportBetAfrica offers sports betting, mainly on national and international football, as well as live betting with odds updated in real time.</p>'
            .'<p>Players deposit and withdraw money through MTN Mobile Money, Orange Money or in the network\'s agencies, which requires reliable cash management in the back office.</p>'
            .'<p>The platform is offered as a white-label product, with a multi-platform back office, a cashier module and a mobile app.</p>',
        'tasks' => [
            ['Real time', 'Pushing updates (odds, results) to clients over WebSocket.'],
            ['Back office', 'New features in the admin and cashier tools.'],
            ['Production maintenance', 'Fixes and improvements on a platform used around the clock.'],
        ],
    ],
    'payool' => [
        'title' => 'PayOol',
        'summary' => 'Money transaction app: Visa and Mastercard virtual cards, Mobile Money top-ups, a marketplace and admin interfaces.',
        'context' => 'Fintech assignment, January to May 2024',
        'role' => 'Full stack Laravel developer (front end and back end)',
        'period' => 'January – May 2024',
        'tags' => "Fintech\nVirtual cards",
        'case_study' => '<p>PayOol lets individuals and businesses in Africa create Visa and Mastercard virtual cards to pay online anywhere in the world, and top them up with MTN Mobile Money or Orange Money.</p>'
            .'<p>The main technical challenge was to let several virtual card and payment providers coexist without duplicating the business logic.</p>',
        'tasks' => [
            ['Multi-API architecture', 'An abstraction layer to integrate several virtual card providers side by side.'],
            ['Payment integrations', 'Integration of the SoleasPay, Eversend and Strowallet APIs (Mobile Money collection, card issuing).'],
            ['Marketplace', 'A marketplace built into the application.'],
            ['Interfaces', 'User and admin areas.'],
        ],
    ],
    'prismcard' => [
        'title' => 'PrismCard',
        'summary' => 'Virtual debit card platform for online payments, subscriptions and international payments, with a marketplace.',
        'context' => 'PayOol ecosystem, January to May 2024',
        'role' => 'Full stack Laravel developer',
        'period' => 'January – May 2024',
        'tags' => "Fintech\nVirtual cards",
        'case_study' => '<p>PrismCard is the second transaction app built during the PayOol assignment. It issues secure virtual debit cards for online shopping, subscriptions and international payments.</p>'
            .'<p>It shares PayOol\'s multi-provider architecture and payment integrations, and adds a marketplace.</p>',
        'tasks' => [
            ['Laravel back end', 'Cards, top-ups and transactions management.'],
            ['Marketplace', 'Purchase flow and related interfaces.'],
        ],
    ],
    'aladjhub' => [
        'title' => 'AladjHub',
        'summary' => 'Subscription-based financial management platform: branches, cash deposits and withdrawals, treasury, loans and mobile wallet.',
        'context' => 'SIGP SC Cameroon, team project',
        'role' => 'Full stack developer',
        'period' => 'Since 2024',
        'tags' => "Fintech\nSaaS",
        'case_study' => '<p>AladjHub is built for organisations that handle money operations every day. It covers branch and staff management, cash deposits and withdrawals, treasury, loans and the integration of mobile and bank wallets.</p>'
            .'<p>It comes in several subscription plans, with Android, iOS and Windows apps depending on the plan.</p>',
    ],
    'site-sigp-sc' => [
        'title' => 'SIGP SC corporate website',
        'summary' => 'SIGP SC Cameroon\'s website: services, cloud solutions, digital transformation and product catalogue.',
        'context' => 'SIGP SC Cameroon, team project',
        'role' => 'Full stack developer',
        'period' => 'Since 2024',
        'tags' => 'Corporate website',
        'case_study' => '<p>The website presents the company, its engineering and consulting services, and its products, including SmartSchools and ExbilCore, each with its own page.</p>',
    ],
    'mikrotek-network' => [
        'title' => 'MikroTek Network',
        'summary' => 'Wi-Fi ticket sales app: front-end redesign and a real-time notification server.',
        'context' => 'MikrotekNetwork, February to June 2023',
        'role' => 'Front-end developer',
        'period' => 'February – June 2023',
        'tags' => "Telecom\nReal time",
        'case_study' => '<p>MikroTek Network sells Wi-Fi access tickets for MikroTik hotspots. The existing app needed a clearer interface and real-time information.</p>',
        'tasks' => [
            ['Front-end redesign', 'A new interface for the existing application.'],
            ['Real-time notifications', 'A Node.js server pushing notifications to clients over WebSocket.'],
        ],
    ],
    'plateforme-saas-hotspot' => [
        'title' => 'SaaS platform for Wi-Fi hotspot operators',
        'summary' => 'Sign-up portal that deploys an isolated container for each customer, with a customer area and a super-admin console.',
        'context' => 'Personal project',
        'role' => 'End-to-end design: portal, per-customer deployment, super-admin',
        'tags' => "SaaS\nDevOps",
        'case_study' => '<p>Every hotspot operator who signs up gets their own instance, automatically deployed in an isolated Docker container. A customer area tracks the subscription, and a super-admin console supervises all instances.</p>',
        'tasks' => [
            ['Sign-up portal', 'Account creation and automatic provisioning.'],
            ['Per-customer deployment', 'One isolated container per customer, driven from the application.'],
            ['Super-admin', 'Supervision of customers and instances.'],
        ],
    ],
    'plugin-revendeurs-hotspot' => [
        'title' => 'Hotspot reseller plugin',
        'summary' => 'Wi-Fi plan resale module: prepaid wallet, commissions, allowed routers and plans, data isolated per reseller.',
        'context' => 'Personal project',
        'role' => 'Design and development',
        'tags' => "Telecom\nWallet",
        'case_study' => '<p>The plugin lets a hotspot operator delegate plan sales to resellers. Each reseller has a prepaid wallet, earns commissions and only sees their own routers, plans and sales.</p>',
    ],
    'africaexchanges' => [
        'title' => 'AfricaExchanges',
        'summary' => 'Exchange platform. Description to be completed.',
        'context' => 'SIGP SC Cameroon',
        'role' => 'Full stack developer',
        'period' => 'Since 2024',
        'tags' => 'Fintech',
    ],
    'ssmp' => [
        'title' => 'SSMP',
        'summary' => 'Application from the SIGP SC suite (ssmp.sigpsc.com). Description to be completed.',
        'context' => 'SIGP SC Cameroon',
        'role' => 'Full stack developer',
        'period' => 'Since 2024',
    ],
    'ancestri' => [
        'title' => 'Ancestri',
        'summary' => 'Family tree app designed for African markets: Mobile Money payments, local languages and offline mode.',
        'context' => 'Personal project',
        'role' => 'Design and development',
        'tags' => 'PWA',
    ],
    'signalement-patients-isoles' => [
        'title' => 'Unidentified patient reporting',
        'summary' => 'Platform for hospitals to report unidentified patients, designed around data protection.',
        'context' => 'Personal project',
        'role' => 'Design',
        'tags' => 'Health',
    ],
];
