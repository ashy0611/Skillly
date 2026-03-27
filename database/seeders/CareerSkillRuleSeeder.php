<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CareerDomain;
use App\Models\Skill;
use App\Models\CareerSkillRule;

class CareerSkillRuleSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedBackendDeveloper();
        $this->seedFrontendDeveloper();
        $this->seedFullStackDeveloper();
        $this->seedQaEngineer();
        $this->seedAutomationTestEngineer();
        $this->seedMobileAppDeveloper();
        $this->seedDataAnalyst();
        $this->seedDataScientist();
        $this->seedMachineLearningEngineer();
        $this->seedAIEngineer();
        $this->seedBIDeveloper();
        $this->seedDevOpsEngineer();
        $this->seedCloudEngineer();
        $this->seedSiteReliabilityEngineer();
        $this->seedSystemAdministrator();
        $this->seedNetworkEngineer();
        $this->seedCybersecurityAnalyst();
        $this->seedSecurityEngineer();
        $this->seedEthicalHacker();
        $this->seedEthicalHacker();
        $this->seedInformationSecurityAnalyst();
        $this->seedProjectManager();
        $this->seedBusinessAnalyst();
        $this->seedTechnicalLead();
        $this->seedScrumMaster();
        $this->seedUIDesigner();
        $this->seedGraphicDesigner();
        $this->seedDigitalMarketingSpecialist();
        $this->seedMarketingManager();
        $this->seedSEOSpecialist();
        $this->seedContentStrategist();
        $this->seedAccountant();
        $this->seedFinancialAnalyst();
        $this->seedInvestmentAnalyst();
        $this->seedAuditor();
        $this->seedFinanceManager();
        $this->seedHRExecutive();
        $this->seedTalentAcquisitionSpecialist();
        $this->seedOperationsManager();
        $this->seedAdministrativeOfficer();
        $this->seedCustomerSuccessManager();
        $this->seedBlockchainDeveloper();
        $this->seedARVRDeveloper();
        $this->seedIoTEngineer();

    }
    //phase 1s
    private function seedBackendDeveloper(): void
    {
        $career = CareerDomain::where('career_name', 'Backend Developer')->first();

        if (!$career) {
            $this->command->warn('Backend Developer domain not found.');
            return;
        }

        $skills = [

            /*
            * Core Mandatory Skills
            * These are essential backend skills most employers expect
            */
            'PHP'        => ['mandatory' => true, 'weight' => 5, 'alternatives' => ['Node.js', 'Python', 'Java']],
            'Laravel'    => ['mandatory' => true, 'weight' => 5, 'alternatives' => ['Django', 'Spring Boot', 'Express']],
            'MySQL'      => ['mandatory' => true, 'weight' => 5, 'alternatives' => ['PostgreSQL', 'MongoDB']],
            'REST API'   => ['mandatory' => true, 'weight' => 5, 'alternatives' => ['GraphQL']],
            'OOP'        => ['mandatory' => true, 'weight' => 5, 'alternatives' => []],
            'Git'        => ['mandatory' => true, 'weight' => 5, 'alternatives' => []],

            /*
            * Popular Optional Skills
            * Candidate may have these but not required
            */
            'Node.js'       => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'Express'       => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'Python'        => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'Django'        => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'Flask'         => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'Java'          => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'Spring Boot'   => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'PostgreSQL'    => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'MongoDB'       => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'Redis'         => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'Docker'        => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'Kubernetes'    => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'AWS'           => ['mandatory' => false, 'weight' => 2, 'alternatives' => ['Azure', 'GCP']],
            'Linux'         => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'CI/CD'         => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'Unit Testing'  => ['mandatory' => false, 'weight' => 2, 'alternatives' => ['PHPUnit', 'Jest']],
            'GraphQL'       => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'JWT'           => ['mandatory' => false, 'weight' => 2, 'alternatives' => ['OAuth']],
            'OAuth'         => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'Microservices' => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'gRPC'          => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'WebSockets'    => ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
            'API Integration'=> ['mandatory' => false, 'weight' => 2, 'alternatives' => []],
        ];

        foreach ($skills as $skillName => $config) {

            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            // Save main skill
            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id' => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight' => $config['weight'],
                ]
            );

            // Save alternative skills if any
            if (!empty($config['alternatives'])) {
                foreach ($config['alternatives'] as $altName) {
                    $altSkill = Skill::where('skill_name', $altName)->first();
                    if ($altSkill) {
                        CareerSkillRule::updateOrCreate(
                            [
                                'career_domain_id' => $career->id,
                                'skill_id' => $altSkill->id,
                            ],
                            [
                                'is_mandatory' => $config['mandatory'],
                                'weight' => $config['weight'],
                            ]
                        );
                    } else {
                        $this->command->warn("Alternative skill not found: $altName");
                    }
                }
            }
        }

        $this->command->info('Backend Developer rules (modern + alternatives) seeded successfully.');
    }
    private function seedFrontendDeveloper(): void
    {
        $career = CareerDomain::where('career_name', 'Frontend Developer')->first();

        if (!$career) {
            $this->command->warn('Frontend Developer domain not found.');
            return;
        }

        $skills = [

            // Core Skills
            'HTML'              => ['mandatory' => true,  'weight' => 5],
            'CSS'               => ['mandatory' => true,  'weight' => 5],
            'JavaScript'        => ['mandatory' => true,  'weight' => 5],
            'React'             => ['mandatory' => true,  'weight' => 5],
            'Git'               => ['mandatory' => true,  'weight' => 5],
            'Responsive Design' => ['mandatory' => true,  'weight' => 5],

            // Optional Skills
            'TypeScript'        => ['mandatory' => false, 'weight' => 2],
            'Next.js'           => ['mandatory' => false, 'weight' => 2],
            'Vue.js'            => ['mandatory' => false, 'weight' => 2],
            'Bootstrap'         => ['mandatory' => false, 'weight' => 2],
            'Tailwind CSS'      => ['mandatory' => false, 'weight' => 2],
            'Webpack'           => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {

            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id' => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight' => $config['weight'],
                ]
            );
        }

        $this->command->info('Frontend Developer rules seeded successfully.');
    }
    private function seedFullStackDeveloper(): void
    {
        $career = CareerDomain::where('career_name', 'Full Stack Developer')->first();

        if (!$career) {
            $this->command->warn('Full Stack Developer domain not found.');
            return;
        }

        $skills = [

            // Core Skills
            'PHP'        => ['mandatory' => true,  'weight' => 5],
            'Laravel'    => ['mandatory' => true,  'weight' => 5],
            'MySQL'      => ['mandatory' => true,  'weight' => 5],
            'JavaScript' => ['mandatory' => true,  'weight' => 5],
            'React'      => ['mandatory' => true,  'weight' => 5],
            'HTML'       => ['mandatory' => true,  'weight' => 5],
            'CSS'        => ['mandatory' => true,  'weight' => 5],

            // Supporting Skills
            'REST API'   => ['mandatory' => false, 'weight' => 3],
            'Git'        => ['mandatory' => false, 'weight' => 3],
            'Node.js'    => ['mandatory' => false, 'weight' => 3],

            // Optional Skills
            'Docker'     => ['mandatory' => false, 'weight' => 2],
            'AWS'        => ['mandatory' => false, 'weight' => 2],
            'TypeScript' => ['mandatory' => false, 'weight' => 2],
            'Next.js'    => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {

            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id' => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight' => $config['weight'],
                ]
            );
        }

        $this->command->info('Full Stack Developer rules seeded successfully.');
    }
    private function seedQaEngineer(): void
    {
        $career = CareerDomain::where('career_name', 'QA Engineer')->first();

        if (!$career) {
            $this->command->warn('QA Engineer domain not found.');
            return;
        }

        $skills = [

            // Core Skills
            'Manual Testing'      => ['mandatory' => true,  'weight' => 5],
            'Test Cases'          => ['mandatory' => true,  'weight' => 5],
            'Bug Tracking'        => ['mandatory' => true,  'weight' => 5],
            'SDLC'                => ['mandatory' => true,  'weight' => 5],
            'STLC'                => ['mandatory' => true,  'weight' => 5],

            // Supporting Skills
            'Jira'                => ['mandatory' => false, 'weight' => 3],
            'Regression Testing'  => ['mandatory' => false, 'weight' => 3],
            'Functional Testing'  => ['mandatory' => false, 'weight' => 3],
            'API Testing'         => ['mandatory' => false, 'weight' => 3],

            // Optional Skills
            'Selenium'            => ['mandatory' => false, 'weight' => 2],
            'Postman'             => ['mandatory' => false, 'weight' => 2],
            'Cypress'             => ['mandatory' => false, 'weight' => 2],
            'Test Documentation'  => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {

            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id' => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight' => $config['weight'],
                ]
            );
        }

        $this->command->info('QA Engineer rules seeded successfully.');
    }
    private function seedAutomationTestEngineer(): void
    {
        $career = CareerDomain::where('career_name', 'Automation Test Engineer')->first();

        if (!$career) {
            $this->command->warn('Automation Test Engineer domain not found.');
            return;
        }

        $skills = [

            // Core Skills
            'Selenium'           => ['mandatory' => true,  'weight' => 5],
            'Automation Testing' => ['mandatory' => true,  'weight' => 5],
            'TestNG'             => ['mandatory' => true,  'weight' => 5],
            'JUnit'              => ['mandatory' => true,  'weight' => 5],
            'Java'               => ['mandatory' => true,  'weight' => 5],

            // Supporting Skills
            'API Testing'        => ['mandatory' => false, 'weight' => 3],
            'Postman'            => ['mandatory' => false, 'weight' => 3],
            'Cypress'            => ['mandatory' => false, 'weight' => 3],
            'Regression Testing' => ['mandatory' => false, 'weight' => 3],
            'Git'                => ['mandatory' => false, 'weight' => 3],

            // Optional Skills
            'Jenkins'            => ['mandatory' => false, 'weight' => 2],
            'CI/CD'              => ['mandatory' => false, 'weight' => 2],
            'Docker'             => ['mandatory' => false, 'weight' => 2],
            'Python'             => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {

            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id' => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight' => $config['weight'],
                ]
            );
        }

        $this->command->info('Automation Test Engineer rules seeded successfully.');
    }
    private function seedMobileAppDeveloper(): void
    {
        $career = CareerDomain::where('career_name', 'Mobile App Developer')->first();

        if (!$career) {
            $this->command->warn('Mobile App Developer domain not found.');
            return;
        }

        $skills = [

            // Core Skills
            'Java'              => ['mandatory' => true,  'weight' => 5],
            'Kotlin'            => ['mandatory' => true,  'weight' => 5],
            'Swift'             => ['mandatory' => true,  'weight' => 5],
            'Flutter'           => ['mandatory' => true,  'weight' => 5],
            'React Native'      => ['mandatory' => true,  'weight' => 5],

            // Supporting Skills
            'Android'           => ['mandatory' => false, 'weight' => 3],
            'iOS'               => ['mandatory' => false, 'weight' => 3],
            'REST API'          => ['mandatory' => false, 'weight' => 3],
            'Firebase'          => ['mandatory' => false, 'weight' => 3],
            'Git'               => ['mandatory' => false, 'weight' => 3],

            // Optional Skills
            'Dart'              => ['mandatory' => false, 'weight' => 2],
            'Objective-C'       => ['mandatory' => false, 'weight' => 2],
            'SQLite'            => ['mandatory' => false, 'weight' => 2],
            'Push Notifications'=> ['mandatory' => false, 'weight' => 2],
            'App Deployment'    => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {

            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id' => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight' => $config['weight'],
                ]
            );
        }

        $this->command->info('Mobile App Developer rules seeded successfully.');
    }
    //phase 2 
    private function seedDataAnalyst(): void
    {
        $career = CareerDomain::where('career_name', 'Data Analyst')->first();

        if (!$career) {
            $this->command->warn('Data Analyst domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'SQL'                => ['mandatory' => true,  'weight' => 5],
            'Excel'              => ['mandatory' => true,  'weight' => 5],
            'Data Visualization' => ['mandatory' => true,  'weight' => 4],
            'Statistics'         => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Python'             => ['mandatory' => false, 'weight' => 3],
            'R'                  => ['mandatory' => false, 'weight' => 3],
            'Power BI'           => ['mandatory' => false, 'weight' => 2],
            'Tableau'            => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Data Analyst rules seeded successfully.');
    }
    private function seedDataScientist(): void
    {
        $career = CareerDomain::where('career_name', 'Data Scientist')->first();

        if (!$career) {
            $this->command->warn('Data Scientist domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Python'           => ['mandatory' => true,  'weight' => 5],
            'Machine Learning' => ['mandatory' => true,  'weight' => 5],
            'Statistics'       => ['mandatory' => true,  'weight' => 5],
            'Data Wrangling'   => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'SQL'              => ['mandatory' => false, 'weight' => 4],
            'R'                => ['mandatory' => false, 'weight' => 3],
            'Deep Learning'    => ['mandatory' => false, 'weight' => 3],
            'Tableau'          => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Data Scientist rules seeded successfully.');
    }
    private function seedMachineLearningEngineer(): void
    {
        $career = CareerDomain::where('career_name', 'Machine Learning Engineer')->first();

        if (!$career) {
            $this->command->warn('Machine Learning Engineer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Python'           => ['mandatory' => true,  'weight' => 5],
            'Machine Learning' => ['mandatory' => true,  'weight' => 5],
            'Deep Learning'    => ['mandatory' => true,  'weight' => 5],
            'TensorFlow'       => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'PyTorch'          => ['mandatory' => false, 'weight' => 3],
            'SQL'              => ['mandatory' => false, 'weight' => 3],
            'Docker'           => ['mandatory' => false, 'weight' => 2],
            'AWS'              => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Machine Learning Engineer rules seeded successfully.');
    }
    private function seedAIEngineer(): void
    {
        $career = CareerDomain::where('career_name', 'AI Engineer')->first();

        if (!$career) {
            $this->command->warn('AI Engineer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Python'           => ['mandatory' => true,  'weight' => 5],
            'Machine Learning' => ['mandatory' => true,  'weight' => 5],
            'Deep Learning'    => ['mandatory' => true,  'weight' => 5],
            'NLP'              => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Computer Vision'  => ['mandatory' => false, 'weight' => 4],
            'TensorFlow'       => ['mandatory' => false, 'weight' => 3],
            'PyTorch'          => ['mandatory' => false, 'weight' => 3],
            'AWS'              => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('AI Engineer rules seeded successfully.');
    }
    private function seedBIDeveloper(): void
    {
        $career = CareerDomain::where('career_name', 'Business Intelligence Developer')->first();

        if (!$career) {
            $this->command->warn('Business Intelligence Developer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'SQL'             => ['mandatory' => true,  'weight' => 5],
            'Data Warehousing' => ['mandatory' => true, 'weight' => 5],
            'Power BI'        => ['mandatory' => true,  'weight' => 4],
            'ETL'             => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Python'          => ['mandatory' => false, 'weight' => 3],
            'Tableau'         => ['mandatory' => false, 'weight' => 3],
            'Excel'           => ['mandatory' => false, 'weight' => 2],
            'AWS'             => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Business Intelligence Developer rules seeded successfully.');
    }
    //phase 3
    private function seedDevOpsEngineer(): void
    {
        $career = CareerDomain::where('career_name', 'DevOps Engineer')->first();

        if (!$career) {
            $this->command->warn('DevOps Engineer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Linux'           => ['mandatory' => true,  'weight' => 5],
            'CI/CD'           => ['mandatory' => true,  'weight' => 5],
            'Docker'          => ['mandatory' => true,  'weight' => 5],
            'Kubernetes'      => ['mandatory' => true,  'weight' => 4],
            'Scripting'       => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'AWS'             => ['mandatory' => false, 'weight' => 3],
            'Azure'           => ['mandatory' => false, 'weight' => 3],
            'Terraform'       => ['mandatory' => false, 'weight' => 3],
            'Ansible'         => ['mandatory' => false, 'weight' => 2],
            'Monitoring Tools'=> ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('DevOps Engineer rules seeded successfully.');
    }
    private function seedCloudEngineer(): void
    {
        $career = CareerDomain::where('career_name', 'Cloud Engineer')->first();

        if (!$career) {
            $this->command->warn('Cloud Engineer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'AWS'             => ['mandatory' => true,  'weight' => 5],
            'Azure'           => ['mandatory' => true,  'weight' => 5],
            'Cloud Architecture' => ['mandatory' => true, 'weight' => 5],
            'Terraform'       => ['mandatory' => true,  'weight' => 4],
            'Scripting'       => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Docker'          => ['mandatory' => false, 'weight' => 3],
            'Kubernetes'      => ['mandatory' => false, 'weight' => 3],
            'CI/CD'           => ['mandatory' => false, 'weight' => 2],
            'Monitoring Tools'=> ['mandatory' => false, 'weight' => 2],
            'Linux'           => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Cloud Engineer rules seeded successfully.');
    }
    private function seedSiteReliabilityEngineer(): void
    {
        $career = CareerDomain::where('career_name', 'Site Reliability Engineer')->first();

        if (!$career) {
            $this->command->warn('Site Reliability Engineer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Linux'           => ['mandatory' => true,  'weight' => 5],
            'Monitoring Tools'=> ['mandatory' => true,  'weight' => 5],
            'CI/CD'           => ['mandatory' => true,  'weight' => 4],
            'Scripting'       => ['mandatory' => true,  'weight' => 4],
            'Cloud Platforms' => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Docker'          => ['mandatory' => false, 'weight' => 3],
            'Kubernetes'      => ['mandatory' => false, 'weight' => 3],
            'Terraform'       => ['mandatory' => false, 'weight' => 3],
            'AWS'             => ['mandatory' => false, 'weight' => 2],
            'Azure'           => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Site Reliability Engineer rules seeded successfully.');
    }
    private function seedSystemAdministrator(): void
    {
        $career = CareerDomain::where('career_name', 'System Administrator')->first();

        if (!$career) {
            $this->command->warn('System Administrator domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Linux'           => ['mandatory' => true,  'weight' => 5],
            'Windows Server'  => ['mandatory' => true,  'weight' => 5],
            'Networking'      => ['mandatory' => true,  'weight' => 4],
            'Scripting'       => ['mandatory' => true,  'weight' => 4],
            'Monitoring Tools'=> ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Docker'          => ['mandatory' => false, 'weight' => 3],
            'AWS'             => ['mandatory' => false, 'weight' => 3],
            'CI/CD'           => ['mandatory' => false, 'weight' => 2],
            'Active Directory'=> ['mandatory' => false, 'weight' => 2],
            'Backup & Recovery'=> ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('System Administrator rules seeded successfully.');
    }
    private function seedNetworkEngineer(): void
    {
        $career = CareerDomain::where('career_name', 'Network Engineer')->first();

        if (!$career) {
            $this->command->warn('Network Engineer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Networking'         => ['mandatory' => true,  'weight' => 5],
            'Routing & Switching'=> ['mandatory' => true,  'weight' => 5],
            'Firewall Management'=> ['mandatory' => true,  'weight' => 4],
            'VPN'                => ['mandatory' => true,  'weight' => 4],
            'Monitoring Tools'   => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Linux'             => ['mandatory' => false, 'weight' => 3],
            'AWS Networking'    => ['mandatory' => false, 'weight' => 3],
            'Cisco Devices'     => ['mandatory' => false, 'weight' => 3],
            'Network Security'  => ['mandatory' => false, 'weight' => 2],
            'Scripting'         => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Network Engineer rules seeded successfully.');
    }
    //Phase 3 
    private function seedCybersecurityAnalyst(): void
    {
        $career = CareerDomain::where('career_name', 'Cybersecurity Analyst')->first();

        if (!$career) {
            $this->command->warn('Cybersecurity Analyst domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Network Security'     => ['mandatory' => true,  'weight' => 5],
            'Vulnerability Assessment' => ['mandatory' => true,  'weight' => 5],
            'Incident Response'    => ['mandatory' => true,  'weight' => 4],
            'SIEM Tools'           => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Python'               => ['mandatory' => false, 'weight' => 3],
            'Penetration Testing'  => ['mandatory' => false, 'weight' => 3],
            'Firewall Management'  => ['mandatory' => false, 'weight' => 2],
            'Cloud Security'       => ['mandatory' => false, 'weight' => 2],
            'Linux'                => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Cybersecurity Analyst rules seeded successfully.');
    }           
    private function seedSecurityEngineer(): void
    {
        $career = CareerDomain::where('career_name', 'Security Engineer')->first();

        if (!$career) {
            $this->command->warn('Security Engineer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Network Security'     => ['mandatory' => true,  'weight' => 5],
            'Secure System Design' => ['mandatory' => true,  'weight' => 5],
            'Firewall Management'  => ['mandatory' => true,  'weight' => 4],
            'Encryption'           => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Python'               => ['mandatory' => false, 'weight' => 3],
            'AWS Security'         => ['mandatory' => false, 'weight' => 3],
            'Cloud Security'       => ['mandatory' => false, 'weight' => 3],
            'Penetration Testing'  => ['mandatory' => false, 'weight' => 2],
            'Linux'                => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Security Engineer rules seeded successfully.');
    }
    private function seedEthicalHacker(): void
    {
        $career = CareerDomain::where('career_name', 'Ethical Hacker')->first();

        if (!$career) {
            $this->command->warn('Ethical Hacker domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Penetration Testing'  => ['mandatory' => true,  'weight' => 5],
            'Network Security'     => ['mandatory' => true,  'weight' => 5],
            'Vulnerability Assessment' => ['mandatory' => true,  'weight' => 4],
            'Scripting'            => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Python'               => ['mandatory' => false, 'weight' => 3],
            'Linux'                => ['mandatory' => false, 'weight' => 3],
            'Web Application Security' => ['mandatory' => false, 'weight' => 3],
            'Social Engineering'   => ['mandatory' => false, 'weight' => 2],
            'Cloud Security'       => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Ethical Hacker rules seeded successfully.');
    }
    private function seedInformationSecurityAnalyst(): void
    {
        $career = CareerDomain::where('career_name', 'Information Security Analyst')->first();

        if (!$career) {
            $this->command->warn('Information Security Analyst domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Risk Assessment'        => ['mandatory' => true,  'weight' => 5],
            'Compliance'             => ['mandatory' => true,  'weight' => 5],
            'Incident Response'      => ['mandatory' => true,  'weight' => 4],
            'Security Policies'      => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Network Security'       => ['mandatory' => false, 'weight' => 3],
            'Vulnerability Assessment'=> ['mandatory' => false, 'weight' => 3],
            'Python'                 => ['mandatory' => false, 'weight' => 2],
            'SIEM Tools'             => ['mandatory' => false, 'weight' => 2],
            'Cloud Security'         => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Information Security Analyst rules seeded successfully.');
    }
    //Phase 4
    private function seedProjectManager(): void
    {
        $career = CareerDomain::where('career_name', 'Project Manager')->first();

        if (!$career) {
            $this->command->warn('Project Manager domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Project Planning'       => ['mandatory' => true,  'weight' => 5],
            'Risk Management'        => ['mandatory' => true,  'weight' => 5],
            'Stakeholder Management' => ['mandatory' => true,  'weight' => 5],
            'Scheduling'             => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Agile Methodologies'    => ['mandatory' => false, 'weight' => 4],
            'Communication'          => ['mandatory' => false, 'weight' => 3],
            'Budgeting'              => ['mandatory' => false, 'weight' => 3],
            'MS Project'             => ['mandatory' => false, 'weight' => 2],
            'Leadership'             => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Project Manager rules seeded successfully.');
    }
    private function seedBusinessAnalyst(): void
    {
        $career = CareerDomain::where('career_name', 'Business Analyst')->first();

        if (!$career) {
            $this->command->warn('Business Analyst domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Requirement Gathering'  => ['mandatory' => true,  'weight' => 5],
            'Business Analysis'      => ['mandatory' => true,  'weight' => 5],
            'Documentation'          => ['mandatory' => true,  'weight' => 4],
            'Stakeholder Communication' => ['mandatory' => true, 'weight' => 4],

            // Optional Skills
            'Agile Methodologies'    => ['mandatory' => false, 'weight' => 4],
            'Data Analysis'          => ['mandatory' => false, 'weight' => 3],
            'Process Modeling'       => ['mandatory' => false, 'weight' => 3],
            'MS Excel'               => ['mandatory' => false, 'weight' => 2],
            'Presentation Skills'    => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Business Analyst rules seeded successfully.');
    }
    private function seedTechnicalLead(): void
    {
        $career = CareerDomain::where('career_name', 'Technical Lead')->first();

        if (!$career) {
            $this->command->warn('Technical Lead domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Technical Architecture' => ['mandatory' => true,  'weight' => 5],
            'Code Review'            => ['mandatory' => true,  'weight' => 5],
            'Team Leadership'        => ['mandatory' => true,  'weight' => 4],
            'Project Planning'       => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Agile Methodologies'    => ['mandatory' => false, 'weight' => 4],
            'Communication'          => ['mandatory' => false, 'weight' => 3],
            'Mentoring'              => ['mandatory' => false, 'weight' => 3],
            'DevOps Knowledge'       => ['mandatory' => false, 'weight' => 2],
            'Problem Solving'        => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Technical Lead rules seeded successfully.');
    }
    private function seedScrumMaster(): void
    {
        $career = CareerDomain::where('career_name', 'Scrum Master')->first();

        if (!$career) {
            $this->command->warn('Scrum Master domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Agile Methodologies'    => ['mandatory' => true,  'weight' => 5],
            'Scrum Framework'        => ['mandatory' => true,  'weight' => 5],
            'Facilitation'           => ['mandatory' => true,  'weight' => 4],
            'Stakeholder Management' => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Communication'          => ['mandatory' => false, 'weight' => 4],
            'Conflict Resolution'    => ['mandatory' => false, 'weight' => 3],
            'Coaching'               => ['mandatory' => false, 'weight' => 3],
            'Jira'                   => ['mandatory' => false, 'weight' => 2],
            'Leadership'             => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Scrum Master rules seeded successfully.');
    }
    //Phase 5
    private function seedUIDesigner(): void
    {
        $career = CareerDomain::where('career_name', 'UI/UX Designer')->first();

        if (!$career) {
            $this->command->warn('UI/UX Designer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'UI Design'             => ['mandatory' => true,  'weight' => 5],
            'UX Research'           => ['mandatory' => true,  'weight' => 5],
            'Wireframing & Prototyping' => ['mandatory' => true, 'weight' => 4],
            'Design Thinking'       => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Figma'                 => ['mandatory' => false, 'weight' => 4],
            'Adobe XD'              => ['mandatory' => false, 'weight' => 3],
            'User Testing'          => ['mandatory' => false, 'weight' => 3],
            'Interaction Design'    => ['mandatory' => false, 'weight' => 2],
            'Communication'         => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('UI/UX Designer rules seeded successfully.');
    }
    private function seedGraphicDesigner(): void
    {
        $career = CareerDomain::where('career_name', 'Graphic Designer')->first();

        if (!$career) {
            $this->command->warn('Graphic Designer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Visual Design'         => ['mandatory' => true,  'weight' => 5],
            'Typography'            => ['mandatory' => true,  'weight' => 5],
            'Color Theory'          => ['mandatory' => true,  'weight' => 4],
            'Branding'              => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Adobe Photoshop'       => ['mandatory' => false, 'weight' => 4],
            'Adobe Illustrator'     => ['mandatory' => false, 'weight' => 4],
            'InDesign'              => ['mandatory' => false, 'weight' => 3],
            'Creativity'            => ['mandatory' => false, 'weight' => 3],
            'Communication'         => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Graphic Designer rules seeded successfully.');
    }
    //Phase 6 
    private function seedDigitalMarketingSpecialist(): void
    {
        $career = CareerDomain::where('career_name', 'Digital Marketing Specialist')->first();

        if (!$career) {
            $this->command->warn('Digital Marketing Specialist domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'SEO'                  => ['mandatory' => true,  'weight' => 5],
            'SEM/PPC'              => ['mandatory' => true,  'weight' => 5],
            'Email Marketing'      => ['mandatory' => true,  'weight' => 4],
            'Analytics'            => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Content Marketing'    => ['mandatory' => false, 'weight' => 3],
            'Social Media Marketing'=> ['mandatory' => false, 'weight' => 3],
            'Google Ads'           => ['mandatory' => false, 'weight' => 2],
            'Facebook Ads'         => ['mandatory' => false, 'weight' => 2],
            'Communication'        => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Digital Marketing Specialist rules seeded successfully.');
    }
    private function seedMarketingManager(): void
    {
        $career = CareerDomain::where('career_name', 'Marketing Manager')->first();

        if (!$career) {
            $this->command->warn('Marketing Manager domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Marketing Strategy'    => ['mandatory' => true,  'weight' => 5],
            'Brand Management'      => ['mandatory' => true,  'weight' => 5],
            'Campaign Planning'     => ['mandatory' => true,  'weight' => 4],
            'Team Leadership'       => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Digital Marketing'     => ['mandatory' => false, 'weight' => 4],
            'Analytics'             => ['mandatory' => false, 'weight' => 3],
            'SEO/SEM'               => ['mandatory' => false, 'weight' => 3],
            'Communication'         => ['mandatory' => false, 'weight' => 2],
            'Social Media Marketing'=> ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Marketing Manager rules seeded successfully.');
    }
    private function seedSEOSpecialist(): void
    {
        $career = CareerDomain::where('career_name', 'SEO Specialist')->first();

        if (!$career) {
            $this->command->warn('SEO Specialist domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'On-Page SEO'           => ['mandatory' => true,  'weight' => 5],
            'Off-Page SEO'          => ['mandatory' => true,  'weight' => 5],
            'Keyword Research'      => ['mandatory' => true,  'weight' => 4],
            'Analytics'             => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Content Optimization'  => ['mandatory' => false, 'weight' => 3],
            'Technical SEO'         => ['mandatory' => false, 'weight' => 3],
            'Google Search Console' => ['mandatory' => false, 'weight' => 2],
            'SEO Tools (Ahrefs/SEMRush)' => ['mandatory' => false, 'weight' => 2],
            'Communication'         => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('SEO Specialist rules seeded successfully.');
    }
    private function seedContentStrategist(): void
    {
        $career = CareerDomain::where('career_name', 'Content Strategist')->first();

        if (!$career) {
            $this->command->warn('Content Strategist domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Content Planning'       => ['mandatory' => true,  'weight' => 5],
            'Content Creation'       => ['mandatory' => true,  'weight' => 5],
            'SEO'                    => ['mandatory' => true,  'weight' => 4],
            'Analytics'              => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Social Media Marketing' => ['mandatory' => false, 'weight' => 3],
            'Copywriting'            => ['mandatory' => false, 'weight' => 3],
            'Email Marketing'        => ['mandatory' => false, 'weight' => 2],
            'Content Management Systems (CMS)' => ['mandatory' => false, 'weight' => 2],
            'Communication'          => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Content Strategist rules seeded successfully.');
    }
    //Phase 7
    private function seedAccountant(): void
    {
        $career = CareerDomain::where('career_name', 'Accountant')->first();

        if (!$career) {
            $this->command->warn('Accountant domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Financial Reporting'   => ['mandatory' => true,  'weight' => 5],
            'Bookkeeping'           => ['mandatory' => true,  'weight' => 5],
            'Accounting Principles' => ['mandatory' => true,  'weight' => 4],
            'Taxation'              => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'MS Excel'              => ['mandatory' => false, 'weight' => 4],
            'ERP Systems'           => ['mandatory' => false, 'weight' => 3],
            'Auditing Basics'       => ['mandatory' => false, 'weight' => 3],
            'Communication'         => ['mandatory' => false, 'weight' => 2],
            'Time Management'       => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Accountant rules seeded successfully.');
    }
    private function seedFinancialAnalyst(): void
    {
        $career = CareerDomain::where('career_name', 'Financial Analyst')->first();

        if (!$career) {
            $this->command->warn('Financial Analyst domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Financial Modeling'    => ['mandatory' => true,  'weight' => 5],
            'Data Analysis'         => ['mandatory' => true,  'weight' => 5],
            'Forecasting'           => ['mandatory' => true,  'weight' => 4],
            'Excel/Spreadsheets'    => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Accounting Principles' => ['mandatory' => false, 'weight' => 3],
            'Presentation Skills'   => ['mandatory' => false, 'weight' => 3],
            'ERP Systems'           => ['mandatory' => false, 'weight' => 2],
            'SQL'                   => ['mandatory' => false, 'weight' => 2],
            'Communication'         => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Financial Analyst rules seeded successfully.');
    }
    private function seedInvestmentAnalyst(): void
    {
        $career = CareerDomain::where('career_name', 'Investment Analyst')->first();

        if (!$career) {
            $this->command->warn('Investment Analyst domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Financial Analysis'    => ['mandatory' => true,  'weight' => 5],
            'Valuation'             => ['mandatory' => true,  'weight' => 5],
            'Investment Research'   => ['mandatory' => true,  'weight' => 4],
            'Portfolio Management'  => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Excel/Spreadsheets'    => ['mandatory' => false, 'weight' => 3],
            'Accounting Principles' => ['mandatory' => false, 'weight' => 3],
            'Financial Modeling'    => ['mandatory' => false, 'weight' => 2],
            'Communication'         => ['mandatory' => false, 'weight' => 2],
            'Presentation Skills'   => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Investment Analyst rules seeded successfully.');
    }
    private function seedAuditor(): void
    {
        $career = CareerDomain::where('career_name', 'Auditor')->first();

        if (!$career) {
            $this->command->warn('Auditor domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Audit Planning'        => ['mandatory' => true,  'weight' => 5],
            'Financial Reporting'   => ['mandatory' => true,  'weight' => 5],
            'Compliance'            => ['mandatory' => true,  'weight' => 4],
            'Internal Controls'     => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Risk Assessment'       => ['mandatory' => false, 'weight' => 3],
            'ERP Systems'           => ['mandatory' => false, 'weight' => 3],
            'MS Excel'              => ['mandatory' => false, 'weight' => 2],
            'Communication'         => ['mandatory' => false, 'weight' => 2],
            'Attention to Detail'   => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Auditor rules seeded successfully.');
    }
    private function seedFinanceManager(): void
    {
        $career = CareerDomain::where('career_name', 'Finance Manager')->first();

        if (!$career) {
            $this->command->warn('Finance Manager domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Financial Planning'     => ['mandatory' => true,  'weight' => 5],
            'Budgeting'              => ['mandatory' => true,  'weight' => 5],
            'Forecasting'            => ['mandatory' => true,  'weight' => 4],
            'Team Leadership'        => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Risk Management'        => ['mandatory' => false, 'weight' => 3],
            'ERP Systems'            => ['mandatory' => false, 'weight' => 3],
            'Accounting Principles'  => ['mandatory' => false, 'weight' => 2],
            'Communication'          => ['mandatory' => false, 'weight' => 2],
            'Decision Making'        => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Finance Manager rules seeded successfully.');
    }
    //Phase 8 
    private function seedHRExecutive(): void
    {
        $career = CareerDomain::where('career_name', 'HR Executive')->first();

        if (!$career) {
            $this->command->warn('HR Executive domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Recruitment'           => ['mandatory' => true,  'weight' => 5],
            'Employee Relations'    => ['mandatory' => true,  'weight' => 5],
            'HR Policies'           => ['mandatory' => true,  'weight' => 4],
            'Onboarding'            => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'HR Software (HRMS)'    => ['mandatory' => false, 'weight' => 3],
            'Communication'         => ['mandatory' => false, 'weight' => 3],
            'Conflict Resolution'   => ['mandatory' => false, 'weight' => 2],
            'Time Management'       => ['mandatory' => false, 'weight' => 2],
            'Training & Development'=> ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('HR Executive rules seeded successfully.');
    }
    private function seedTalentAcquisitionSpecialist(): void
    {
        $career = CareerDomain::where('career_name', 'Talent Acquisition Specialist')->first();

        if (!$career) {
            $this->command->warn('Talent Acquisition Specialist domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Recruitment Strategy'  => ['mandatory' => true,  'weight' => 5],
            'Candidate Sourcing'    => ['mandatory' => true,  'weight' => 5],
            'Interviewing'          => ['mandatory' => true,  'weight' => 4],
            'Onboarding'            => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Employer Branding'     => ['mandatory' => false, 'weight' => 3],
            'HR Software (ATS)'     => ['mandatory' => false, 'weight' => 3],
            'Communication'         => ['mandatory' => false, 'weight' => 2],
            'Negotiation Skills'    => ['mandatory' => false, 'weight' => 2],
            'Networking'            => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Talent Acquisition Specialist rules seeded successfully.');
    }
    private function seedOperationsManager(): void
    {
        $career = CareerDomain::where('career_name', 'Operations Manager')->first();

        if (!$career) {
            $this->command->warn('Operations Manager domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Process Management'     => ['mandatory' => true,  'weight' => 5],
            'Operational Planning'   => ['mandatory' => true,  'weight' => 5],
            'Team Leadership'        => ['mandatory' => true,  'weight' => 4],
            'Problem Solving'        => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Project Management'     => ['mandatory' => false, 'weight' => 3],
            'ERP Systems'            => ['mandatory' => false, 'weight' => 3],
            'Communication'          => ['mandatory' => false, 'weight' => 2],
            'Time Management'        => ['mandatory' => false, 'weight' => 2],
            'Analytics'              => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Operations Manager rules seeded successfully.');
    }
    private function seedAdministrativeOfficer(): void
    {
        $career = CareerDomain::where('career_name', 'Administrative Officer')->first();

        if (!$career) {
            $this->command->warn('Administrative Officer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Office Management'      => ['mandatory' => true,  'weight' => 5],
            'Documentation'          => ['mandatory' => true,  'weight' => 5],
            'Scheduling'             => ['mandatory' => true,  'weight' => 4],
            'Communication'          => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'MS Office'              => ['mandatory' => false, 'weight' => 3],
            'Record Keeping'         => ['mandatory' => false, 'weight' => 3],
            'Time Management'        => ['mandatory' => false, 'weight' => 2],
            'Problem Solving'        => ['mandatory' => false, 'weight' => 2],
            'Customer Service'       => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Administrative Officer rules seeded successfully.');
    }
    private function seedCustomerSuccessManager(): void
    {
        $career = CareerDomain::where('career_name', 'Customer Success Manager')->first();

        if (!$career) {
            $this->command->warn('Customer Success Manager domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Client Relationship Management' => ['mandatory' => true,  'weight' => 5],
            'Communication'                  => ['mandatory' => true,  'weight' => 5],
            'Problem Solving'                => ['mandatory' => true,  'weight' => 4],
            'Customer Retention'             => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'CRM Software'                   => ['mandatory' => false, 'weight' => 3],
            'Analytics'                      => ['mandatory' => false, 'weight' => 3],
            'Negotiation'                    => ['mandatory' => false, 'weight' => 2],
            'Time Management'                => ['mandatory' => false, 'weight' => 2],
            'Team Collaboration'             => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Customer Success Manager rules seeded successfully.');
    }
    //Phase 9
    private function seedBlockchainDeveloper(): void
    {
        $career = CareerDomain::where('career_name', 'Blockchain Developer')->first();

        if (!$career) {
            $this->command->warn('Blockchain Developer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Solidity'              => ['mandatory' => true,  'weight' => 5],
            'Smart Contracts'       => ['mandatory' => true,  'weight' => 5],
            'Ethereum'              => ['mandatory' => true,  'weight' => 4],
            'Cryptography'          => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Web3.js'               => ['mandatory' => false, 'weight' => 3],
            'Blockchain Architecture'=> ['mandatory' => false, 'weight' => 3],
            'Node.js'               => ['mandatory' => false, 'weight' => 2],
            'APIs'                  => ['mandatory' => false, 'weight' => 2],
            'Problem Solving'       => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('Blockchain Developer rules seeded successfully.');
    }
    private function seedARVRDeveloper(): void
    {
        $career = CareerDomain::where('career_name', 'AR/VR Developer')->first();

        if (!$career) {
            $this->command->warn('AR/VR Developer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Unity3D'               => ['mandatory' => true,  'weight' => 5],
            'Unreal Engine'         => ['mandatory' => true,  'weight' => 5],
            '3D Modeling'           => ['mandatory' => true,  'weight' => 4],
            'C# / C++ Programming'  => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'ARKit / ARCore'        => ['mandatory' => false, 'weight' => 3],
            'VR Hardware Integration'=> ['mandatory' => false, 'weight' => 3],
            'Shaders & Graphics'    => ['mandatory' => false, 'weight' => 2],
            'UX for AR/VR'          => ['mandatory' => false, 'weight' => 2],
            'Problem Solving'       => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('AR/VR Developer rules seeded successfully.');
    }
    private function seedIoTEngineer(): void
    {
        $career = CareerDomain::where('career_name', 'IoT Engineer')->first();

        if (!$career) {
            $this->command->warn('IoT Engineer domain not found.');
            return;
        }

        $skills = [
            // Core Skills
            'Embedded Systems'       => ['mandatory' => true,  'weight' => 5],
            'IoT Protocols (MQTT, CoAP)' => ['mandatory' => true,  'weight' => 5],
            'Sensor Integration'     => ['mandatory' => true,  'weight' => 4],
            'Microcontrollers (Arduino/Raspberry Pi)' => ['mandatory' => true,  'weight' => 4],

            // Optional Skills
            'Cloud IoT Platforms'    => ['mandatory' => false, 'weight' => 3],
            'Networking'             => ['mandatory' => false, 'weight' => 3],
            'Data Analytics'         => ['mandatory' => false, 'weight' => 2],
            'Programming (Python/C)' => ['mandatory' => false, 'weight' => 2],
            'Problem Solving'        => ['mandatory' => false, 'weight' => 2],
        ];

        foreach ($skills as $skillName => $config) {
            $skill = Skill::where('skill_name', $skillName)->first();

            if (!$skill) {
                $this->command->warn("Skill not found: $skillName");
                continue;
            }

            CareerSkillRule::updateOrCreate(
                [
                    'career_domain_id' => $career->id,
                    'skill_id'         => $skill->id,
                ],
                [
                    'is_mandatory' => $config['mandatory'],
                    'weight'       => $config['weight'],
                ]
            );
        }

        $this->command->info('IoT Engineer rules seeded successfully.');
    }

}
