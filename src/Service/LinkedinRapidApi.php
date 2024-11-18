<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class LinkedinRapidApi implements RapidApiInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string              $rapidApiKey,
        private readonly string              $rapidApiLinkedinHost,
        private readonly string              $rapidApiLinkedinGetProfileUrl
    )
    {
    }

    public function getProfile(string $username)
    {
        $response = $this->httpClient->request('GET', sprintf($this->rapidApiLinkedinGetProfileUrl, $username), [
            'headers' => [
                'x-rapidapi-host' => $this->rapidApiLinkedinHost,
                'x-rapidapi-key' => $this->rapidApiKey,
            ],
        ]);

        dd(json_encode($response->toArray()));
        // TODO: Implement getPosts() method.
    }

    public function getPosts(string $username)
    {
        // TODO: Implement getPosts() method.
    }

    private function mockGetProfile()
    {
        return [
            "connection" => 1107,
            "data" => [
                "id" => 303301290,
                "urn" => "ACoAABIUAqoB5Gd28npUvy9HgfH1d4W0-uXUjto",
                "username" => "clementgoubier",
                "firstName" => "Clément",
                "lastName" => "Goubier",
                "isCreator" => false,
                "isOpenToWork" => false,
                "isHiring" => false,
                "profilePicture" => "https://media.licdn.com/dms/image/v2/C4E03AQG7iiaVSURYMQ/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1516970121170?e=1737590400&v=beta&t=0HF2ZhiC5Figk4_z17cm8H9X6Aeq9MNxrK2iviTD6us",
                "backgroundImage" => null,
                "summary" => "",
                "headline" => "Back-end Developer chez Display",
                "geo" => [
                    "country" => "France",
                    "city" => "Chevilly-Larue, Île-de-France",
                    "full" => "Chevilly-Larue, Île-de-France, France"
                ],
                "languages" => [
                    [
                        "name" => "Allemand",
                        "proficiency" => "ELEMENTARY"
                    ],
                    [
                        "name" => "Anglais",
                        "proficiency" => "PROFESSIONAL_WORKING"
                    ],
                    [
                        "name" => "Français",
                        "proficiency" => "NATIVE_OR_BILINGUAL"
                    ]
                ],
                "educations" => [
                    [
                        "start" => [
                            "year" => 2014,
                            "month" => 0,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2016,
                            "month" => 0,
                            "day" => 0
                        ],
                        "fieldOfStudy" => "Développement Web et E-Business",
                        "degree" => "Master",
                        "grade" => "",
                        "schoolName" => "ESGI",
                        "description" => "La spécialisation en Ingénierie du Web et e-Business vise à répondre à la demande des industriels en profils double compétence, capables de développer des projets et de créer de la valeur grâce à la technologie. Elle permet d'acquérir des compétences d'expertise dans trois grands secteurs: technologies innovantes et d'intégration de l'Internet, conduite de projets (interfaces avec les prestataires spécialisés, travail en équipes interdisciplinaire) et e-Commerce et gestion de l'activité de site (stratégie marketing, communication, suivi de trafic, référencement, gestion de bases de données, maintenance technique, ergonomie de navigation).",
                        "activities" => "",
                        "url" => "",
                        "schoolId" => ""
                    ],
                    [
                        "start" => [
                            "year" => 2013,
                            "month" => 0,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2014,
                            "month" => 0,
                            "day" => 0
                        ],
                        "fieldOfStudy" => "Web",
                        "degree" => "DEES",
                        "grade" => "",
                        "schoolName" => "OiiO Formation",
                        "description" => "Le Diplôme Européen d'Etudes Supérieures Webmaster (DEESWEB) est une formation complète permettant d'accéder aux fonctions de Webmaster et Webdesigner grâce à l'étude de l'environement numérique et l'apprentissage des techniques de création de sites internet, de la gestion de projet au développement web. ",
                        "activities" => "",
                        "url" => "",
                        "schoolId" => ""
                    ],
                    [
                        "start" => [
                            "year" => 2010,
                            "month" => 0,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2012,
                            "month" => 0,
                            "day" => 0
                        ],
                        "fieldOfStudy" => "Ingénierie informatique",
                        "degree" => "BTS IRIS",
                        "grade" => "",
                        "schoolName" => "Lycée Louis Jouvet",
                        "description" => "Le BTS informatique IRIS forme des professionnels capables de créer et gérer des applications et des systèmes informatiques lourds et complexes destinés à la production de biens d'équipements ou de services techniques. Depuis la conception matérielle et logicielle de systèmes informatiques à l'installation, maintenance et suivi des installations informatiques. Les travaux informatiques sont caractérisés par un lien étroit entre le matériel et le logiciel, une interaction avec un environnement industriel et/ou technique (robotique, Conception assistée par ordinateur CAO mais aussi télécommunication et réseaux...)",
                        "activities" => "",
                        "url" => "",
                        "schoolId" => ""
                    ]
                ],
                "position" => [
                    [
                        "companyId" => 486906,
                        "companyName" => "Display Interactive",
                        "companyUsername" => "display-interactive",
                        "companyURL" => "https://www.linkedin.com/company/display-interactive/",
                        "companyLogo" => "https://media.licdn.com/dms/image/v2/D4E0BAQH7biUwkIGEog/company-logo_400_400/company-logo_400_400/0/1700233490950/display_interactive_logo?e=1740009600&v=beta&t=TGTDEpK-RbPIy89X7_w8MRtPmZ3i4fxWh6Ejzu6YnI0",
                        "companyIndustry" => "Aviation & Aerospace",
                        "companyStaffCountRange" => "11 - 50",
                        "title" => "Back-end Developer",
                        "multiLocaleTitle" => [
                            "fr_FR" => "Back-end Developer"
                        ],
                        "multiLocaleCompanyName" => [
                            "fr_FR" => "Display Interactive"
                        ],
                        "location" => "Montrouge, Île-de-France, France",
                        "description" => "• Develop and maintain websites, back-offices for airline clients
• Install our solution on Board
• Contribute to the maintenance and evolution of existing projects
• Set up the processes necessary for a constant quality of the code
• Organize sprints and apply agile principles

Stack technique
• PHP 8, Symfony (API Platform), React, Python
• Mysql
• Docker, RabbitMQ, AWS, SSO, Ansible
• PHPUnit, Behat",
                        "employmentType" => "Permanent",
                        "start" => [
                            "year" => 2022,
                            "month" => 3,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 0,
                            "month" => 0,
                            "day" => 0
                        ]
                    ],
                    [
                        "companyId" => 124080,
                        "companyName" => "Webcentric-Fanaticalhelp",
                        "companyUsername" => "webcentric",
                        "companyURL" => "https://www.linkedin.com/company/webcentric/",
                        "companyLogo" => "https://media.licdn.com/dms/image/v2/D4E0BAQHy2N2Tx8NWLQ/company-logo_400_400/company-logo_400_400/0/1682669429110/webcentric_logo?e=1740009600&v=beta&t=XetwtSyaUkcGL33QgUGKc-V06U9M67tF8yIlvMkbXB4",
                        "companyIndustry" => "Information Technology & Services",
                        "companyStaffCountRange" => "11 - 50",
                        "title" => "Back-end Developer",
                        "multiLocaleTitle" => [
                            "fr_FR" => "Back-end Developer"
                        ],
                        "multiLocaleCompanyName" => [
                            "fr_FR" => "Webcentric-Fanaticalhelp"
                        ],
                        "location" => "Région de Paris, France",
                        "description" => "Depuis 2002, Webcentric intervient dans quatre domaines de compétence auprès de ses clients B2b : ventes de matériels, systèmes et réseaux, hébergement & développement web. Sur ce dernier volet, Webcentric travaille en mode projet et développe des sites, back-offices et applications à forte charge. Les projets durent en moyenne entre 3 et 6 mois et concernent des secteurs très variés comme l’industrie ou l’événementiel.

Missions
• Développer de sites web, back-offices et applications mobiles pour les clients
• Tester et déployer lecode
• Contribuer à la maintenance et à l’évolution des projets existants
• Mettre en place les process nécessaires à une qualité constante du code
• Organiser les sprints et appliquer les principes agiles

Stack technique
• PHP 7, Symfony (API Platform)
• MySQL / MariaDB
• Docker, Kubernetes
• API REST
• RabbitMQ
• Git / Gitlab
• Architecture micro-services",
                        "employmentType" => "Permanent",
                        "start" => [
                            "year" => 2021,
                            "month" => 10,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2022,
                            "month" => 3,
                            "day" => 0
                        ]
                    ],
                    [
                        "companyId" => 913165,
                        "companyName" => "Castelis",
                        "companyUsername" => "castelis",
                        "companyURL" => "https://www.linkedin.com/company/castelis/",
                        "companyLogo" => "https://media.licdn.com/dms/image/v2/C4E0BAQHmFsVQsKCh1g/company-logo_400_400/company-logo_400_400/0/1669904071911/castelis_logo?e=1740009600&v=beta&t=5nPT8RgIR0tKUrFzS9rTEozyBjPdUKsxM06rfief6EI",
                        "companyIndustry" => "Computer Software",
                        "companyStaffCountRange" => "51 - 200",
                        "title" => "Back-end Developer",
                        "multiLocaleTitle" => [
                            "fr_FR" => "Back-end Developer"
                        ],
                        "multiLocaleCompanyName" => [
                            "fr_FR" => "Castelis"
                        ],
                        "location" => "Ivry-sur-Seine, Île-de-France, France",
                        "description" => "Castelis conçoit, développe, déploie et exploite des solutions digitales innovantes et sur mesure pour le compte de clients issus de tous secteurs d’activité : industriel, tertiaire, etc. Fort de ses 85 collaborateurs, ingénieurs d’études et développement, ingénieurs cloud, data scientists, chefs de projets, architectes et consultants.

Stack technique
• PHP 5.4
• MySQL
• Docker
• API REST
• RabbitMQ
• Git / Gitlab",
                        "employmentType" => "",
                        "start" => [
                            "year" => 2020,
                            "month" => 2,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2021,
                            "month" => 9,
                            "day" => 0
                        ]
                    ],
                    [
                        "companyId" => 2541908,
                        "companyName" => "Mention",
                        "companyUsername" => "mention",
                        "companyURL" => "https://www.linkedin.com/company/mention/",
                        "companyLogo" => "https://media.licdn.com/dms/image/v2/C560BAQEBGRZlcccKew/company-logo_400_400/company-logo_400_400/0/1631386740343?e=1740009600&v=beta&t=TGdenv1uTXsE11KkYueWTkXWJ4--euFS8O5ExWXRUrk",
                        "companyIndustry" => "Computer Software",
                        "companyStaffCountRange" => "51 - 200",
                        "title" => "Back-end Developer",
                        "multiLocaleTitle" => [
                            "fr_FR" => "Back-end Developer"
                        ],
                        "multiLocaleCompanyName" => [
                            "fr_FR" => "Mention"
                        ],
                        "location" => "Région de Paris, France",
                        "description" => "Mention changes the way companies monitor their online presence. Monitor your company name, brand, competitors, or industry trends for real­time updates on any mentions over the web and social networks. Take action to react, collaborate, and analyze your online presence ! 

With over 750,000 professionals using the app in 125+ countries from companies such as Spotify, Airbnb, MIT, Microsoft, Lamborghini and Etsy, Mention is focused on helping companies of any size to know what’s being said about their brand, competitors, industry, etc

Stack technique
• PHP 7, Symfony
• MySQL
• Docker
• API REST, GraphQL
• RabbitMQ",
                        "employmentType" => "Full-time",
                        "start" => [
                            "year" => 2019,
                            "month" => 4,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2020,
                            "month" => 2,
                            "day" => 0
                        ]
                    ],
                    [
                        "companyId" => 2903499,
                        "companyName" => "Youmiam",
                        "companyUsername" => "dubruitdanslesrecettes",
                        "companyURL" => "https://www.linkedin.com/company/dubruitdanslesrecettes/",
                        "companyLogo" => "https://media.licdn.com/dms/image/v2/D4E0BAQFVDdXoNzAH2w/company-logo_400_400/company-logo_400_400/0/1711009684164/dubruitdanslesrecettes_logo?e=1740009600&v=beta&t=GSNlWHhqgzAAuzcNCC23k2hVKRoawOaCNNZtudL5GbI",
                        "companyIndustry" => "Computer Software",
                        "companyStaffCountRange" => "2 - 10",
                        "title" => "Back-end Developer",
                        "multiLocaleTitle" => [
                            "fr_FR" => "Back-end Developer"
                        ],
                        "multiLocaleCompanyName" => [
                            "fr_FR" => "Youmiam"
                        ],
                        "location" => "Région de Paris, France",
                        "description" => "• Gestion de l'API REST en liaison avec l'équipe mobile pour les applications IOS & Android
• Développer et intégrer de nouvelles fonctionnalités-clés en partenariat avec Franprix, Auchan, Frichti, etc ...
• Identifier les pistes d’optimisations pour proposer un service toujours plus rapide et robuste.
• Livrer du code de qualité et testé
• Participer aux tâches de développement Front.
• Création de fichiers techniques pour la mise en place des features",
                        "employmentType" => "",
                        "start" => [
                            "year" => 2018,
                            "month" => 1,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2019,
                            "month" => 2,
                            "day" => 0
                        ]
                    ],
                    [
                        "companyId" => 9370762,
                        "companyName" => "TWIL - The Wine I Love",
                        "companyUsername" => "twil---the-wine-i-love",
                        "companyURL" => "https://www.linkedin.com/company/twil---the-wine-i-love/",
                        "companyLogo" => "https://media.licdn.com/dms/image/v2/C4E0BAQHcGv_c2MlO_g/company-logo_400_400/company-logo_400_400/0/1657281460170/twil___the_wine_i_love_logo?e=1740009600&v=beta&t=dpMBcUQto_fVFqj7MJ99dXMCrc8k7QwU3aWzSlfq9Xk",
                        "companyIndustry" => "Wine & Spirits",
                        "companyStaffCountRange" => "11 - 50",
                        "title" => "Back-end Developer",
                        "multiLocaleTitle" => [
                            "fr_FR" => "Back-end Developer"
                        ],
                        "multiLocaleCompanyName" => [
                            "fr_FR" => "TWIL - The Wine I Love"
                        ],
                        "location" => "Saint-Ouen, Île-de-France, France",
                        "description" => "• Assurer le développement de nouvelles fonctionnalités du BackOffice SF2, du site Magento et de l’API REST pour l'application mobile.
• Assurer les intégrations avec les systèmes tiers (Mirakl, UPELA, SMoney, UPS, etc ...) en s'appuyant sur le Webservice REST.
• Assurer la gestion des serveurs et des mises en production.
• Renforcer la fiabilité en améliorant les tests unitaires et la qualité générale du code.
• Participer aux tâches de développement Front.",
                        "employmentType" => "Full-time",
                        "start" => [
                            "year" => 2016,
                            "month" => 9,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2018,
                            "month" => 1,
                            "day" => 0
                        ]
                    ]
                ],
                "fullPositions" => [
                    [
                        "companyId" => 486906,
                        "companyName" => "Display Interactive",
                        "companyUsername" => "display-interactive",
                        "companyURL" => "https://www.linkedin.com/company/display-interactive/",
                        "companyLogo" => "https://media.licdn.com/dms/image/v2/D4E0BAQH7biUwkIGEog/company-logo_400_400/company-logo_400_400/0/1700233490950/display_interactive_logo?e=1740009600&v=beta&t=TGTDEpK-RbPIy89X7_w8MRtPmZ3i4fxWh6Ejzu6YnI0",
                        "companyIndustry" => "Aviation & Aerospace",
                        "companyStaffCountRange" => "11 - 50",
                        "title" => "Back-end Developer",
                        "multiLocaleTitle" => [
                            "fr_FR" => "Back-end Developer"
                        ],
                        "multiLocaleCompanyName" => [
                            "fr_FR" => "Display Interactive"
                        ],
                        "location" => "Montrouge, Île-de-France, France",
                        "description" => "• Develop and maintain websites, back-offices for airline clients
• Install our solution on Board
• Contribute to the maintenance and evolution of existing projects
• Set up the processes necessary for a constant quality of the code
• Organize sprints and apply agile principles

Stack technique
• PHP 8, Symfony (API Platform), React, Python
• Mysql
• Docker, RabbitMQ, AWS, SSO, Ansible
• PHPUnit, Behat",
                        "employmentType" => "Permanent",
                        "start" => [
                            "year" => 2022,
                            "month" => 3,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 0,
                            "month" => 0,
                            "day" => 0
                        ]
                    ],
                    [
                        "companyId" => 124080,
                        "companyName" => "Webcentric-Fanaticalhelp",
                        "companyUsername" => "webcentric",
                        "companyURL" => "https://www.linkedin.com/company/webcentric/",
                        "companyLogo" => "https://media.licdn.com/dms/image/v2/D4E0BAQHy2N2Tx8NWLQ/company-logo_400_400/company-logo_400_400/0/1682669429110/webcentric_logo?e=1740009600&v=beta&t=XetwtSyaUkcGL33QgUGKc-V06U9M67tF8yIlvMkbXB4",
                        "companyIndustry" => "Information Technology & Services",
                        "companyStaffCountRange" => "11 - 50",
                        "title" => "Back-end Developer",
                        "multiLocaleTitle" => [
                            "fr_FR" => "Back-end Developer"
                        ],
                        "multiLocaleCompanyName" => [
                            "fr_FR" => "Webcentric-Fanaticalhelp"
                        ],
                        "location" => "Région de Paris, France",
                        "description" => "Depuis 2002, Webcentric intervient dans quatre domaines de compétence auprès de ses clients B2b : ventes de matériels, systèmes et réseaux, hébergement & développement web. Sur ce dernier volet, Webcentric travaille en mode projet et développe des sites, back-offices et applications à forte charge. Les projets durent en moyenne entre 3 et 6 mois et concernent des secteurs très variés comme l’industrie ou l’événementiel.

Missions
• Développer de sites web, back-offices et applications mobiles pour les clients
• Tester et déployer lecode
• Contribuer à la maintenance et à l’évolution des projets existants
• Mettre en place les process nécessaires à une qualité constante du code
• Organiser les sprints et appliquer les principes agiles

Stack technique
• PHP 7, Symfony (API Platform)
• MySQL / MariaDB
• Docker, Kubernetes
• API REST
• RabbitMQ
• Git / Gitlab
• Architecture micro-services",
                        "employmentType" => "Permanent",
                        "start" => [
                            "year" => 2021,
                            "month" => 10,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2022,
                            "month" => 3,
                            "day" => 0
                        ]
                    ],
                    [
                        "companyId" => 913165,
                        "companyName" => "Castelis",
                        "companyUsername" => "castelis",
                        "companyURL" => "https://www.linkedin.com/company/castelis/",
                        "companyLogo" => "https://media.licdn.com/dms/image/v2/C4E0BAQHmFsVQsKCh1g/company-logo_400_400/company-logo_400_400/0/1669904071911/castelis_logo?e=1740009600&v=beta&t=5nPT8RgIR0tKUrFzS9rTEozyBjPdUKsxM06rfief6EI",
                        "companyIndustry" => "Computer Software",
                        "companyStaffCountRange" => "51 - 200",
                        "title" => "Back-end Developer",
                        "multiLocaleTitle" => [
                            "fr_FR" => "Back-end Developer"
                        ],
                        "multiLocaleCompanyName" => [
                            "fr_FR" => "Castelis"
                        ],
                        "location" => "Ivry-sur-Seine, Île-de-France, France",
                        "description" => "Castelis conçoit, développe, déploie et exploite des solutions digitales innovantes et sur mesure pour le compte de clients issus de tous secteurs d’activité : industriel, tertiaire, etc. Fort de ses 85 collaborateurs, ingénieurs d’études et développement, ingénieurs cloud, data scientists, chefs de projets, architectes et consultants.

Stack technique
• PHP 5.4
• MySQL
• Docker
• API REST
• RabbitMQ
• Git / Gitlab",
                        "employmentType" => "",
                        "start" => [
                            "year" => 2020,
                            "month" => 2,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2021,
                            "month" => 9,
                            "day" => 0
                        ]
                    ],
                    [
                        "companyId" => 2541908,
                        "companyName" => "Mention",
                        "companyUsername" => "mention",
                        "companyURL" => "https://www.linkedin.com/company/mention/",
                        "companyLogo" => "https://media.licdn.com/dms/image/v2/C560BAQEBGRZlcccKew/company-logo_400_400/company-logo_400_400/0/1631386740343?e=1740009600&v=beta&t=TGdenv1uTXsE11KkYueWTkXWJ4--euFS8O5ExWXRUrk",
                        "companyIndustry" => "Computer Software",
                        "companyStaffCountRange" => "51 - 200",
                        "title" => "Back-end Developer",
                        "multiLocaleTitle" => [
                            "fr_FR" => "Back-end Developer"
                        ],
                        "multiLocaleCompanyName" => [
                            "fr_FR" => "Mention"
                        ],
                        "location" => "Région de Paris, France",
                        "description" => "Mention changes the way companies monitor their online presence. Monitor your company name, brand, competitors, or industry trends for real­time updates on any mentions over the web and social networks. Take action to react, collaborate, and analyze your online presence ! 

With over 750,000 professionals using the app in 125+ countries from companies such as Spotify, Airbnb, MIT, Microsoft, Lamborghini and Etsy, Mention is focused on helping companies of any size to know what’s being said about their brand, competitors, industry, etc

Stack technique
• PHP 7, Symfony
• MySQL
• Docker
• API REST, GraphQL
• RabbitMQ",
                        "employmentType" => "Full-time",
                        "start" => [
                            "year" => 2019,
                            "month" => 4,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2020,
                            "month" => 2,
                            "day" => 0
                        ]
                    ],
                    [
                        "companyId" => 2903499,
                        "companyName" => "Youmiam",
                        "companyUsername" => "dubruitdanslesrecettes",
                        "companyURL" => "https://www.linkedin.com/company/dubruitdanslesrecettes/",
                        "companyLogo" => "https://media.licdn.com/dms/image/v2/D4E0BAQFVDdXoNzAH2w/company-logo_400_400/company-logo_400_400/0/1711009684164/dubruitdanslesrecettes_logo?e=1740009600&v=beta&t=GSNlWHhqgzAAuzcNCC23k2hVKRoawOaCNNZtudL5GbI",
                        "companyIndustry" => "Computer Software",
                        "companyStaffCountRange" => "2 - 10",
                        "title" => "Back-end Developer",
                        "multiLocaleTitle" => [
                            "fr_FR" => "Back-end Developer"
                        ],
                        "multiLocaleCompanyName" => [
                            "fr_FR" => "Youmiam"
                        ],
                        "location" => "Région de Paris, France",
                        "description" => "• Gestion de l'API REST en liaison avec l'équipe mobile pour les applications IOS & Android
• Développer et intégrer de nouvelles fonctionnalités-clés en partenariat avec Franprix, Auchan, Frichti, etc ...
• Identifier les pistes d’optimisations pour proposer un service toujours plus rapide et robuste.
• Livrer du code de qualité et testé
• Participer aux tâches de développement Front.
• Création de fichiers techniques pour la mise en place des features",
                        "employmentType" => "",
                        "start" => [
                            "year" => 2018,
                            "month" => 1,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2019,
                            "month" => 2,
                            "day" => 0
                        ]
                    ],
                    [
                        "companyId" => 9370762,
                        "companyName" => "TWIL - The Wine I Love",
                        "companyUsername" => "twil---the-wine-i-love",
                        "companyURL" => "https://www.linkedin.com/company/twil---the-wine-i-love/",
                        "companyLogo" => "https://media.licdn.com/dms/image/v2/C4E0BAQHcGv_c2MlO_g/company-logo_400_400/company-logo_400_400/0/1657281460170/twil___the_wine_i_love_logo?e=1740009600&v=beta&t=dpMBcUQto_fVFqj7MJ99dXMCrc8k7QwU3aWzSlfq9Xk",
                        "companyIndustry" => "Wine & Spirits",
                        "companyStaffCountRange" => "11 - 50",
                        "title" => "Back-end Developer",
                        "multiLocaleTitle" => [
                            "fr_FR" => "Back-end Developer"
                        ],
                        "multiLocaleCompanyName" => [
                            "fr_FR" => "TWIL - The Wine I Love"
                        ],
                        "location" => "Saint-Ouen, Île-de-France, France",
                        "description" => "• Assurer le développement de nouvelles fonctionnalités du BackOffice SF2, du site Magento et de l’API REST pour l'application mobile.
• Assurer les intégrations avec les systèmes tiers (Mirakl, UPELA, SMoney, UPS, etc ...) en s'appuyant sur le Webservice REST.
• Assurer la gestion des serveurs et des mises en production.
• Renforcer la fiabilité en améliorant les tests unitaires et la qualité générale du code.
• Participer aux tâches de développement Front.",
                        "employmentType" => "Full-time",
                        "start" => [
                            "year" => 2016,
                            "month" => 9,
                            "day" => 0
                        ],
                        "end" => [
                            "year" => 2018,
                            "month" => 1,
                            "day" => 0
                        ]
                    ]
                ],
                "skills" => [
                    [
                        "name" => "Symfony",
                        "passedSkillAssessment" => false,
                        "endorsementsCount" => 3
                    ],
                    [
                        "name" => "MySQL",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "PHP",
                        "passedSkillAssessment" => false,
                        "endorsementsCount" => 6
                    ],
                    [
                        "name" => "E-commerce",
                        "passedSkillAssessment" => false,
                        "endorsementsCount" => 2
                    ],
                    [
                        "name" => "Programmation web",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "SEO",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "Node.js",
                        "passedSkillAssessment" => false,
                        "endorsementsCount" => 3
                    ],
                    [
                        "name" => "SQL",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "HTML 5",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "jQuery",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "JavaScript",
                        "passedSkillAssessment" => false,
                        "endorsementsCount" => 4
                    ],
                    [
                        "name" => "CSS3",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "C++",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "WordPress",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "Photoshop",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "Illustrator",
                        "passedSkillAssessment" => false,
                        "endorsementsCount" => 2
                    ],
                    [
                        "name" => "InDesign",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "Flash",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "Bash",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "UML",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "JSON",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "CSS",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "Linux",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "HTML",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "Anglais",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "Gantt",
                        "passedSkillAssessment" => false
                    ],
                    [
                        "name" => "PERT",
                        "passedSkillAssessment" => false
                    ]
                ],
                "givenRecommendation" => null,
                "givenRecommendationCount" => 0,
                "receivedRecommendation" => null,
                "receivedRecommendationCount" => 0,
                "courses" => null,
                "certifications" => null,
                "honors" => null,
                "projects" => [
                    "total" => 0,
                    "items" => null
                ],
                "volunteering" => null,
                "supportedLocales" => [
                    [
                        "country" => "FR",
                        "language" => "fr"
                    ]
                ],
                "multiLocaleFirstName" => [
                    "fr" => "Clément"
                ],
                "multiLocaleLastName" => [
                    "fr" => "Goubier"
                ],
                "multiLocaleHeadline" => [
                    "fr" => "Back-end Developer chez Display"
                ]
            ],
            "follower" => 1101,
            "posts" => [
                [
                    "text" => "ENCORE MERCI A TOUS, je n’ai plus besoin de partage 🤍


Il y a 3 semaines, on m’a congédié en periode d’essai. En plein divorce. Pourtant on m’avait dit “ne t’en fait pas, on sera la” il y a 1 semaine j’ai fait confiance à ma mère qui m’a dit de venir chez elle et de quitter mon logement. Sauf qu’elle n’a pas supporté mon fils, qui est trop vivant trop elle. 
 depuis dimanche soir, je loge chez des amis. 
Je n’ai pas le droit au chomage car mon dernier boss à préféré arrêter la période d’essai avant. 
Se montrer aussi vulnérable n’est pas dans mes habitudes. Mais j’ai pas le choix, j’ai un enfant à nourrir et une vie à retrouver
Comment retrouver de la dignité maintenant? Que quelqu’un me fasse confiance pour un poste. Je travaille bien. Peut etre un peu trop. Et surtout je dis les choses et ça dans une société ou tout le monde fait semblant, ça gene. 
Alors pour ceux qui seront content de ce qui m’arrive, oubliez pas qu’on peut très facilement tomber. 
Pour les bienveillants, merci. Pour ceux qui peuvent m’aider. Hesitez pas. Je peux travailler de n’importe ou dans le monde. J’ai rien qui me retient, le petit suit.",
                    "totalReactionCount" => 30278,
                    "likeCount" => 17289,
                    "appreciationCount" => 11305,
                    "empathyCount" => 431,
                    "InterestCount" => 20,
                    "praiseCount" => 1231,
                    "funnyCount" => 2,
                    "commentsCount" => 1767,
                    "repostsCount" => 6240,
                    "postUrl" => "https://www.linkedin.com/feed/update/urn:li:activity:7218523421406605312/",
                    "postedAt" => "4mo",
                    "postedDate" => "2024-07-15 07:54:57.343 +0000 UTC",
                    "postedDateTimestamp" => 1721030097343,
                    "reposted" => true,
                    "urn" => "7218523421406605312",
                    "author" => [
                        "firstName" => "Charlotte",
                        "lastName" => "Ballouard ",
                        "username" => "charlotte-ballouard-144620a0",
                        "url" => "https://www.linkedin.com/in/charlotte-ballouard-144620a0"
                    ],
                    "image" => [
                        [
                            "url" => "https://media.licdn.com/dms/image/v2/D4E22AQEDDSKFuq2Fkg/feedshare-shrink_2048_1536/feedshare-shrink_2048_1536/0/1720702244040?e=1734566400&v=beta&t=P0HdKeGQ-JHfETVS0GMiwBPFQmh9r_6Wt2ZpwR-sZaU"
                        ]
                    ],
                    "company" => [
                    ],
                    "document" => [
                    ],
                    "celebration" => [
                    ],
                    "poll" => [
                    ],
                    "article" => [
                    ],
                    "entity" => [
                    ]
                ],
                [
                    "text" => "#Recrutement 🔎

GVA recrute en #CDI sur 📍#Paris :
💠Auditeur Senior (H/F)
💠Responsable de Mission Expertise Conseil TPE/PME (H/F)
💠Collaborateur Expertise Comptable et Conseil PME/ETI - Senior (H/F)
💠Collaborateur Comptable Junior (H/F)

Découvrez toutes nos offres disponibles ➡️ https://lnkd.in/g2aJbC6U

Vous correspondez à l’un des profils recherchés ? N'attendez plus pour postuler !

#GVArecrute #avoscv #expertise #expertscomptables #consultant #conseil
#audit #Auditeur #Senior #Junior #Comptable #Responsable #TPE #PME #ETI #expertcomptable #responsabledemission

GROUPE ALPHA SEMAPHORES TH Conseil Lafayette 
Philippe Bonnin Emmanuel Gayte",
                    "totalReactionCount" => 37,
                    "likeCount" => 36,
                    "appreciationCount" => 1,
                    "repostsCount" => 16,
                    "postUrl" => "https://www.linkedin.com/feed/update/urn:li:activity:7202410191470903296/",
                    "postedAt" => "5mo",
                    "postedDate" => "2024-05-31 20:46:43.957 +0000 UTC",
                    "postedDateTimestamp" => 1717188403957,
                    "reposted" => true,
                    "urn" => "7202410191470903296",
                    "author" => [
                    ],
                    "image" => [
                        [
                            "url" => "https://media.licdn.com/dms/image/v2/D5622AQEY2RQGQmcbWg/feedshare-shrink_2048_1536/feedshare-shrink_2048_1536/0/1717075660087?e=1734566400&v=beta&t=MKt7eESV7rUPOuNkPAX2ozrQ29o_1tv_SmyKnOjEee4"
                        ]
                    ],
                    "company" => [
                        "name" => "GVA",
                        "url" => "https://www.linkedin.com/company/gva-fr/",
                        "urn" => "urn:li:fsd_company:1672703"
                    ],
                    "document" => [
                    ],
                    "celebration" => [
                    ],
                    "poll" => [
                    ],
                    "article" => [
                    ],
                    "entity" => [
                    ]
                ],
                [
                    "text" => "Display is #hiring ! There are many open positions ! Join us and help planes communicate with clouds.",
                    "totalReactionCount" => 4,
                    "likeCount" => 4,
                    "repostsCount" => 6,
                    "postUrl" => "https://www.linkedin.com/feed/update/urn:li:activity:7113436646083018752/",
                    "postedAt" => "1yr",
                    "postedDate" => "2023-09-29 08:17:37.688 +0000 UTC",
                    "postedDateTimestamp" => 1695975457688,
                    "reposted" => true,
                    "urn" => "7113436646083018752",
                    "author" => [
                        "firstName" => "Julien",
                        "lastName" => "Bennamias",
                        "username" => "julien-bennamias-1a63b13",
                        "url" => "https://www.linkedin.com/in/julien-bennamias-1a63b13"
                    ],
                    "company" => [
                    ],
                    "document" => [
                    ],
                    "celebration" => [
                    ],
                    "poll" => [
                    ],
                    "article" => [
                    ],
                    "entity" => [
                    ]
                ],
                [
                    "text" => "Display is #hiring ! There are many open positions ! Join us and help planes communicate with clouds.",
                    "totalReactionCount" => 10,
                    "likeCount" => 10,
                    "repostsCount" => 6,
                    "postUrl" => "https://www.linkedin.com/feed/update/urn:li:activity:7112738043555405824/",
                    "postedAt" => "1yr",
                    "postedDate" => "2023-09-27 10:01:37.866 +0000 UTC",
                    "postedDateTimestamp" => 1695808897866,
                    "reposted" => true,
                    "urn" => "7112738043555405824",
                    "author" => [
                        "firstName" => "Julien",
                        "lastName" => "Bennamias",
                        "username" => "julien-bennamias-1a63b13",
                        "url" => "https://www.linkedin.com/in/julien-bennamias-1a63b13"
                    ],
                    "company" => [
                    ],
                    "document" => [
                    ],
                    "celebration" => [
                    ],
                    "poll" => [
                    ],
                    "article" => [
                    ],
                    "entity" => [
                    ]
                ],
                [
                    "text" => "Display is #hiring ! There are many open positions ! Join us and help planes communicate with clouds.",
                    "totalReactionCount" => 3,
                    "likeCount" => 3,
                    "repostsCount" => 7,
                    "postUrl" => "https://www.linkedin.com/feed/update/urn:li:activity:7110282325120143360/",
                    "postedAt" => "1yr",
                    "postedDate" => "2023-09-20 15:23:28.966 +0000 UTC",
                    "postedDateTimestamp" => 1695223408966,
                    "reposted" => true,
                    "urn" => "7110282325120143360",
                    "author" => [
                        "firstName" => "Julien",
                        "lastName" => "Bennamias",
                        "username" => "julien-bennamias-1a63b13",
                        "url" => "https://www.linkedin.com/in/julien-bennamias-1a63b13"
                    ],
                    "company" => [
                    ],
                    "document" => [
                    ],
                    "celebration" => [
                    ],
                    "poll" => [
                    ],
                    "article" => [
                    ],
                    "entity" => [
                    ]
                ],
                [
                    "resharedPost" => [
                        "text" => "[NEW] 🔥We analyzed how the top universities👩‍🎓 use social media and put our key learning points in a free guidebook! Get it here ➡️ https://lnkd.in/gCjdk2V",
                        "author" => [
                        ],
                        "company" => [
                            "name" => "Mention",
                            "url" => "https://www.linkedin.com/company/mention/",
                            "urn" => "urn:li:fsd_company:2541908"
                        ],
                        "document" => [
                        ],
                        "celebration" => [
                        ],
                        "poll" => [
                        ],
                        "article" => [
                        ],
                        "entity" => [
                        ]
                    ],
                    "text" => "",
                    "totalReactionCount" => 1,
                    "likeCount" => 1,
                    "postUrl" => "https://www.linkedin.com/feed/update/urn:li:activity:6579697324174516224/",
                    "postedAt" => "5yr",
                    "postedDate" => "2019-09-17 12:08:06.948 +0000 UTC",
                    "postedDateTimestamp" => 1568722086948,
                    "reposted" => true,
                    "urn" => "6579697324174516224",
                    "author" => [
                        "firstName" => "Clément",
                        "lastName" => "Goubier",
                        "username" => "clementgoubier",
                        "url" => "https://www.linkedin.com/in/clementgoubier"
                    ],
                    "company" => [
                    ],
                    "document" => [
                    ],
                    "celebration" => [
                    ],
                    "poll" => [
                    ],
                    "article" => [
                    ],
                    "entity" => [
                    ]
                ],
                [
                    "resharedPost" => [
                        "text" => "Bonjour / Bonsoir à mon réseau

Malgré qu'il ne me reste plus beaucoup de temps et la fin d'année 2018, je ne renonce pas à trouver mon entreprise. 

Je suis toujours a la recherche d'une #entreprise pour effectuer ma formation actuel, BTS Services Informatiques aux Organisations option Développement, dans les meilleurs conditions, au poste de #Développeur #web ou d'Assistant Développeur Web en #alternance, contrat d'#apprentissage ou #professionnalisation.

Au rythme de 2 jours en formation et 3 jours en entreprise, pour une durée d'1 an et demi. De préférence en région Île-de-France.

N'hésitez pas a m'appeler ou m'envoyer un message au : 06 75 27 50 32 
Ou par e-mail : isagna95490@gmail.com pour toutes éventuelles questions. 

Je remercie également toutes les personnes aimant ou partageant ce poste, cela me permettra d'accroître la visibilité de ce poste et augmente mes chances de trouver l'entreprise.

Bonne journée / soirée à vous ! (et fêtes de fin d’année) 
#cv #it #bts",
                        "author" => [
                            "firstName" => "Ibrahima",
                            "lastName" => "Sagna",
                            "username" => "ibrahima-sagna",
                            "url" => "https://www.linkedin.com/in/ibrahima-sagna"
                        ],
                        "image" => [
                            [
                                "url" => "https://media.licdn.com/dms/image/v2/C5122AQHHBEaOedanbw/feedshare-shrink_2048_1536/feedshare-shrink_2048_1536/0/1580299552427?e=1734566400&v=beta&t=c428QJVfM6kEClSTJNtwcIoaKH-7VtH13QhvoRVDeyg"
                            ]
                        ],
                        "company" => [
                        ],
                        "document" => [
                        ],
                        "celebration" => [
                        ],
                        "poll" => [
                        ],
                        "article" => [
                        ],
                        "entity" => [
                        ]
                    ],
                    "text" => "",
                    "totalReactionCount" => 1,
                    "likeCount" => 1,
                    "postUrl" => "https://www.linkedin.com/feed/update/urn:li:activity:6483987774402887680/",
                    "postedAt" => "5yr",
                    "postedDate" => "2018-12-27 09:32:32.085 +0000 UTC",
                    "postedDateTimestamp" => 1545903152085,
                    "reposted" => true,
                    "urn" => "6483987774402887680",
                    "author" => [
                        "firstName" => "Clément",
                        "lastName" => "Goubier",
                        "username" => "clementgoubier",
                        "url" => "https://www.linkedin.com/in/clementgoubier"
                    ],
                    "company" => [
                    ],
                    "document" => [
                    ],
                    "celebration" => [
                    ],
                    "poll" => [
                    ],
                    "article" => [
                    ],
                    "entity" => [
                    ]
                ],
                [
                    "text" => "",
                    "postUrl" => "https://www.linkedin.com/feed/update/urn:li:activity:6407897236642033664/",
                    "postedAt" => "6yr",
                    "postedDate" => "2018-05-31 10:15:54.189 +0000 UTC",
                    "postedDateTimestamp" => 1527761754189,
                    "urn" => "6407897236642033664",
                    "author" => [
                        "firstName" => "Clément",
                        "lastName" => "Goubier",
                        "username" => "clementgoubier",
                        "url" => "https://www.linkedin.com/in/clementgoubier"
                    ],
                    "company" => [
                    ],
                    "document" => [
                    ],
                    "celebration" => [
                    ],
                    "poll" => [
                    ],
                    "article" => [
                        "title" => "Key Account Manager - Foodtech - STAGE : Youmiam recrute !",
                        "subtitle" => "welcometothejungle.co",
                        "link" => "https://www.welcometothejungle.co/companies/youmiam/jobs/key-account-manager-stage_paris_YOUMI_7aRM6g"
                    ],
                    "entity" => [
                    ]
                ],
                [
                    "resharedPost" => [
                        "text" => "Quand un client a mal choisi l'emplacement de ses locaux et qu'il essaie de convaincre un de mes devs de venir chez lui :D",
                        "author" => [
                            "firstName" => "Sébastien",
                            "lastName" => "Bianchi",
                            "username" => "bianchis1",
                            "url" => "https://www.linkedin.com/in/bianchis1"
                        ],
                        "image" => [
                            [
                                "url" => "https://media.licdn.com/dms/image/v2/C4E22AQHGBtzKet2Ufw/feedshare-shrink_2048_1536/feedshare-shrink_2048_1536/0/1583565207001?e=1734566400&v=beta&t=DkuCvgOejklIAwIwV3bDlV6w7JPYN-EVAMUUxKBIfcw"
                            ]
                        ],
                        "company" => [
                        ],
                        "document" => [
                        ],
                        "celebration" => [
                        ],
                        "poll" => [
                        ],
                        "article" => [
                        ],
                        "entity" => [
                        ]
                    ],
                    "text" => "",
                    "postUrl" => "https://www.linkedin.com/feed/update/urn:li:activity:6155122762923941888/",
                    "postedAt" => "8yr",
                    "postedDate" => "2016-07-02 21:40:23.332 +0000 UTC",
                    "postedDateTimestamp" => 1467495623332,
                    "reposted" => true,
                    "urn" => "6155122762923941888",
                    "author" => [
                        "firstName" => "Clément",
                        "lastName" => "Goubier",
                        "username" => "clementgoubier",
                        "url" => "https://www.linkedin.com/in/clementgoubier"
                    ],
                    "company" => [
                    ],
                    "document" => [
                    ],
                    "celebration" => [
                    ],
                    "poll" => [
                    ],
                    "article" => [
                    ],
                    "entity" => [
                    ]
                ]
            ]
        ];
    }
}