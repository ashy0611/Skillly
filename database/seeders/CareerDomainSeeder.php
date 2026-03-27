<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CareerDomain;

class CareerDomainSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | SOFTWARE DEVELOPMENT
        |--------------------------------------------------------------------------
        */

        $softwareRoles = [
            ['Backend Developer', 'Builds server-side applications and APIs.'],
            ['Frontend Developer', 'Develops user interfaces and client-side applications.'],
            ['Full Stack Developer', 'Handles both frontend and backend systems.'],
            ['Mobile App Developer', 'Builds Android and iOS applications.'],
            ['Software Engineer', 'Designs scalable software systems.'],
            ['QA Engineer', 'Performs software testing and quality assurance.'],
            ['Automation Test Engineer', 'Develops automated testing frameworks.'],
        ];

        /*
        |--------------------------------------------------------------------------
        | DATA & AI
        |--------------------------------------------------------------------------
        */

        $dataRoles = [
            ['Data Analyst', 'Analyzes and interprets complex datasets.'],
            ['Data Scientist', 'Builds predictive models and ML systems.'],
            ['Machine Learning Engineer', 'Deploys ML models into production.'],
            ['AI Engineer', 'Develops intelligent AI-based solutions.'],
            ['Business Intelligence Developer', 'Creates dashboards and BI reports.'],
        ];

        /*
        |--------------------------------------------------------------------------
        | DEVOPS & INFRASTRUCTURE
        |--------------------------------------------------------------------------
        */

        $devopsRoles = [
            ['DevOps Engineer', 'Manages CI/CD and infrastructure automation.'],
            ['Cloud Engineer', 'Designs and manages cloud environments.'],
            ['Site Reliability Engineer', 'Ensures system reliability and uptime.'],
            ['System Administrator', 'Maintains servers and operating systems.'],
            ['Network Engineer', 'Designs and manages network systems.'],
        ];

        /*
        |--------------------------------------------------------------------------
        | CYBERSECURITY
        |--------------------------------------------------------------------------
        */

        $securityRoles = [
            ['Cybersecurity Analyst', 'Protects systems from cyber threats.'],
            ['Security Engineer', 'Implements secure system architecture.'],
            ['Ethical Hacker', 'Performs penetration testing.'],
            ['Information Security Analyst', 'Analyzes security risks and compliance.'],
        ];

        /*
        |--------------------------------------------------------------------------
        | PRODUCT & MANAGEMENT
        |--------------------------------------------------------------------------
        */

        $managementRoles = [
            ['Project Manager', 'Manages project timelines and delivery.'],
            ['Product Manager', 'Defines product vision and roadmap.'],
            ['Business Analyst', 'Analyzes business requirements.'],
            ['Technical Lead', 'Leads technical architecture decisions.'],
            ['Scrum Master', 'Facilitates Agile development processes.'],
        ];

        /*
        |--------------------------------------------------------------------------
        | DESIGN & CREATIVE
        |--------------------------------------------------------------------------
        */

        $designRoles = [
            ['UI/UX Designer', 'Designs user experiences and interfaces.'],
            ['Graphic Designer', 'Creates visual and branding materials.'],
        ];

        /*
        |--------------------------------------------------------------------------
        | MARKETING
        |--------------------------------------------------------------------------
        */

        $marketingRoles = [
            ['Digital Marketing Specialist', 'Executes digital marketing campaigns.'],
            ['Marketing Manager', 'Leads marketing strategies and branding.'],
            ['SEO Specialist', 'Optimizes websites for search engines.'],
            ['Social Media Manager', 'Manages social media platforms and engagement.'],
            ['Content Strategist', 'Develops content strategies and campaigns.'],
        ];

        /*
        |--------------------------------------------------------------------------
        | FINANCE & ACCOUNTING
        |--------------------------------------------------------------------------
        */

        $financeRoles = [
            ['Accountant', 'Manages financial records and reporting.'],
            ['Financial Analyst', 'Analyzes financial data and forecasting.'],
            ['Investment Analyst', 'Evaluates investment opportunities.'],
            ['Auditor', 'Performs financial audits and compliance checks.'],
            ['Finance Manager', 'Oversees financial operations and planning.'],
        ];

        /*
        |--------------------------------------------------------------------------
        | HR & OPERATIONS
        |--------------------------------------------------------------------------
        */

        $hrRoles = [
            ['HR Executive', 'Manages recruitment and HR operations.'],
            ['Talent Acquisition Specialist', 'Handles hiring and talent sourcing.'],
            ['Operations Manager', 'Oversees operational processes.'],
            ['Administrative Officer', 'Manages office administration tasks.'],
            ['Customer Success Manager', 'Maintains client relationships and retention.'],
        ];

        /*
        |--------------------------------------------------------------------------
        | EMERGING TECHNOLOGIES
        |--------------------------------------------------------------------------
        */

        $emergingRoles = [
            ['Blockchain Developer', 'Develops decentralized applications.'],
            ['AR/VR Developer', 'Builds augmented and virtual reality applications.'],
            ['IoT Engineer', 'Develops Internet of Things systems.'],
        ];

        /*
        |--------------------------------------------------------------------------
        | MERGE ALL DOMAINS
        |--------------------------------------------------------------------------
        */

        $allCareers = array_merge(
            $softwareRoles,
            $dataRoles,
            $devopsRoles,
            $securityRoles,
            $managementRoles,
            $designRoles,
            $marketingRoles,
            $financeRoles,
            $hrRoles,
            $emergingRoles
        );

        foreach ($allCareers as $career) {
            CareerDomain::updateOrCreate(
                ['career_name' => $career[0]],
                ['description' => $career[1]]
            );
        }
    }
}
