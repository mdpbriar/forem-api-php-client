## Introduction

Ce paquet est conçu pour faciliter la création et l'envoi d'un XML pour la publication d'une offre d'emploi sur le site du Forem.

La documentation technique fournie par le Forem est indispensable pour comprendre les spécificités des options indiquées.

## Utilisation

#### Valider les options
`ForemPositionOpening::validate($options);`

#### Initialiser une nouvelle offre
`$offre = new ForemPositionOpening($options)`

#### Obtenir le XML nécessaire à la publication de l'offre
`$xml = $offre->buildXml()`

## Options
$options doit être un dictionnaire contenant toutes les informations nécessaires à l'envoi de l'offre :
```
$options = [
    'partnerCode' => 'code_partenaire', # Code unique de partenaire reçu du Forem
    'idOffre' => 'id_offre', # Cet ID doit être unique au sein de l'entité partenaire
    'validFrom' => '2023-09-15', # date de début de la validité de l'offre
    'validTo' => '2024-01-15', # date de fin de validité
    
    # Les informations suivantes sont relatives à l’entité responsable de l'envoi du fichier contenant l’offre d’emploi.
    'entityName' => "Nom de société",
    'telephone' => [
        'internationalCountryCode' => '32', # Facultatif, code international
        'areaCityCode' => '1', # Facultatif, de 0 à 9
        'formattedNumber' => '+32 056 06513' # Facultatif, numéro formatté
        'subscriberNumber' => '046510561', # Obligatoire, Uniquement des numéros
    ],
    'internetEmailAddress' => company@web.be, # Adresse email publique de la société 
    'internetWebAddress' => "https://company.be", # Site web public de la société
    'postalAddress' => [
        'countryCode' => 'BE', # Le code pays
        'postalCode' => '5100', # Code postal
        'municipality' => "Jambes", # Commune
        'deliveryAddress' => [
            "addressLine" => "Avenue Prince de Liège, 137", # Facultatif, si appliqué, remplace le contenu des autres balises adresses
            "streetName" => "Avenue Prince de Liège", # Facultatif, préciser le nom de la rue de l’adresse
            "buildingNumber" => "137", # Facultatif, permet de préciser le numéro de l’adresse
            "unit" => "Bloc A", # Facultatif, permet de préciser le nom de l’immeuble de l’adresse
            "postOfficeBox" => "", # Facultatif, permet de préciser la boîte postale de l’adresse.
        ],
        'recipient' => [ # permet de préciser le nom d’une personne de contact.
            'organizationName' => 'The Company', # permet de préciser le nom de l’employeur légal
            'personName' => [ # Facultatif,  permet de préciser les informations sur l’identité de la personne de contact.
                'formattedName' => "John DOE", # Facultatif, permet de préciser le nom de la personne de contact.
                'preferredGivenName' => "John", # Facultatif, permet de préciser le prénom de la personne de contact.
                'familyName' => "Doe", # Facultatif, permet de préciser le nom de famille de la personne de contact.
                'affix' => "Mx", # Facultatif, permet de préciser la salutation de la personne de contact.
            ],
        ],
    ],
    
    # permet de préciser les informations structurées et détaillées relatives à l'offre d’emploi.
    'positionProfile' => [ 
        'startDate' => '2025-01-01', # Facultatif, permet de préciser la date de début du contrat de travail contenu dans l’offre d’emploi
        'expectedEndDate' => '2025-12-31', # Facultatif, permet de préciser la date de fin du contrat de travail contenu dans l’offre d’emploi.
        'asSoonAsPossible' => false, # Facultatif, permet de préciser si le candidat doit commencer ou pas le travail dès que possible.
        
        # permet de préciser les informations sur l'employeur de l’offre d’emploi, ce qui comprend les informations du site de travail. L'organisation mentionnée dans cette balise est l'employeur légal
        'organization' => [ # Facultatif, 
            'organizationName' => "The Company", # Facultatif, permet de préciser le nom de l’employeur légal
            'contactMethod' => [
                'telephone' => [
                    'internationalCountryCode' => '32', # Facultatif, code international
                    'areaCityCode' => '1', # Facultatif, de 0 à 9
                    'formattedNumber' => '+32 056 06513' # Facultatif, numéro formatté
                    'subscriberNumber' => '046510561', # Obligatoire, Uniquement des numéros
                ],
                'internetEmailAddress' => company@web.be, # Adresse email publique de la société 
                'internetWebAddress' => "https://company.be", # Site web public de la société
                'postalAddress' => [
                    'countryCode' => 'BE', # Le code pays
                    'postalCode' => '5100', # Code postal
                    'municipality' => "Jambes", # Commune
                    'deliveryAddress' => [
                        "addressLine" => "Avenue Prince de Liège, 137", # Facultatif, si appliqué, remplace le contenu des autres balises adresses
                        "streetName" => "Avenue Prince de Liège", # Facultatif, préciser le nom de la rue de l’adresse
                        "buildingNumber" => "137", # Facultatif, permet de préciser le numéro de l’adresse
                        "unit" => "Bloc A", # Facultatif, permet de préciser le nom de l’immeuble de l’adresse
                        "postOfficeBox" => "", # Facultatif, permet de préciser la boîte postale de l’adresse.
                    ],
                ],
            ],
        ],
        
        # permet de préciser les informations structurées et détaillées relatives à l'offre d’emploi. Elle
        # contient des informations sur le lieu de travail, la catégorie d'emploi, la description des compétences
        # nécessaires, la rémunération globale, ...
        'positionDetail' => [
            'industryCode' => '98200', # permet de préciser le secteur d’activité de l’offre d’emploi, doit correspondre à un ID définit dans les nomenclatures nacebel2008
            
            # permet de préciser les informations sur l'endroit où le salarié va travailler.
            # Accepte une liste, plusieurs lieux peuvent être définis
            'physicalLocations' => [ 
                [
                    'countryCode' => 'BE', # Le code pays
                    'postalCode' => '5100', # Code postal
                    'municipality' => "Jambes", # Commune
                    'deliveryAddress' => [
                        "addressLine" => "Avenue Prince de Liège, 137", # Facultatif, si appliqué, remplace le contenu des autres balises adresses
                        "streetName" => "Avenue Prince de Liège", # Facultatif, préciser le nom de la rue de l’adresse
                        "buildingNumber" => "137", # Facultatif, permet de préciser le numéro de l’adresse
                        "unit" => "Bloc A", # Facultatif, permet de préciser le nom de l’immeuble de l’adresse
                        "postOfficeBox" => "", # Facultatif, permet de préciser la boîte postale de l’adresse.
                    ],
                ];
            ],
            # permet de préciser les informations sur le type de fonction proposée.
            'jobCategories' => [
                [
                    'taxonomyName' => 'ROMEV3', # permet de préciser la nomenclature à laquelle appartient le code fonction spécifié dans la balise « CategoryCode »
                    'categoryCode' => 'A110101', # Code correspondant à la nomenclature
                ],
                [
                    'taxonomyName' => 'DIMECO',
                    'categoryCode' => 'N410301-2',
                ]
            ],
            'positionTitle' => 'Assistant RH', # permet de préciser le titre du poste proposé dans l’offre d’emploi.
            # permet de préciser le type de contrat pour l’offre d’emploi, doit contenir un code type de contrat connu, voir nomenclatures contrattravail
            'positionClassification' => 'G', 
            'positionSchedule' => [ # permet de préciser le régime de travail du poste proposé au niveau de l’offre d’emploi.
                # Voir nomenclature tempstravail
                'positionRegime' => 'Part Time', # Régime de travail
                'positionHoraire' => 'x:Weekend', # Facultatif, horaire
            ],
            
            # Facultatif, permet de préciser les informations sur l’horaire de travail.
            # Accepte une liste
            'shifts' => [ 
                [
                    'shiftPeriod' => 'Semaine', # permet de préciser le nombre d’heure de travail.
                    'hours' => 38, # préciser le nombre d’heure de travail.
                    'startTime' => '08:00', # permet de préciser l’heure de début de travail.
                    'endTime' => '17:00', # permet de préciser l'heure de fin.
                ]
            ],
            
            # Facultatif, permet de préciser les informations sur les connaissances et les compétences nécessaires
            # Accepte une liste
            'competencies' => [
                [
                    'name' => 'Language', # Le type de compétence, doit être défini dans Enums/CompetencyType
                    'id' => 'bn', # Le code de la compétence, doit être dans la liste des nomenclatures définies correspondant au nom
                    'value' => 5, # Facultatif sauf si Language, pour Language, permet de définir le niveau requis, 1 pour A1, jusqu'à 6 pour C2
                ],
            ],
            
            #Facultatif, permet de préciser les informations sur le salaire et les avantages associés à l'offre d’emploi.
            'remunerationPackage' => [
                'basePayAmountMin' => 2000, # permet de préciser le salaire minimum proposé dans l’offre d’emploi
                'basePayAmountMax' => 2500, # permet de préciser le salaire maximum proposé dans l’offre d’emploi.
                'benefits' => [
                    'insurances' => ['Hospitalisation', 'Dentaire'], # permet de préciser si une assurance groupe est offerte en avantages par l’employeur.
                    'companyVehicle' => true, # permet de préciser si une voiture de société est offerte en avantages par l’employeur.
                    'otherBenefits' => ['13eme Mois', 'Régime de congés scolaires'] # permet de préciser si d’autres avantages sont offerts par l’employeur.
                ]
            ],
            
            # Facultatif, permet de préciser si la personne devra effectuer des voyages pour le travail
            'travel' => [
                'applicable' => true, # permet de préciser si le poste offert dans l’offre d’emploi nécessite de voyager
                'travelFrequency' => "3 fois par mois", # permet de préciser la fréquence des voyages
                'travelConsiderations' => "Voyages possibles en Europe" # permet de préciser des informations complémentaires concernant les éventuels voyages à réaliser
            ],
            
            # Facultatif, permet de préciser si une relocalisation est nécessaire
            'relocation' => [
                'relocationConsidered' => true, # permet de préciser si une relocalisation est nécessaire pour le poste
                'comments' => "Un déménagement sur Namur pourrait être envisageable" # permet de préciser des informations complémentaires sur la relocalisation
            ],
            
            # Obligatoire, permet de préciser des informations supplémentaires sur la durée de l’expérience demandée
            'userArea' => [
                'experience' => 2, # Nombre d'année ou de mois d'expérience requise, entier positif
                'unitOfMeasure' => 'Years', # 'Years' ou 'Months' 
            ],
        ],
        
        # Obligatoire, permet de préciser les informations concernant la description de la fonction, la description libre
        # de l’offre d’emploi, les outils spécifiques, les formations, la description salariale, la description des
        # avantages.
        'formattedDescriptions' => [
            [
                # permet de préciser l’identifiant de l’information concernée
                # accepte les valeurs, 'jobDescription', 'contractInformation', 'companyPromotionalText'
                'name' => 'jobDescription',
                'value' => $this->description, # permet de préciser la valeur de l’information concernée, peut contenir du texte libre.
            ],
        ],
        
        # Obligatoire, permet de préciser les informations utiles aux candidats afin de pouvoir postuler
        'howToApply' => [
            'personName' => [ # Facultatif,  permet de préciser les informations sur l’identité de la personne de contact.
                'formattedName' => "John DOE", # Facultatif, permet de préciser le nom de la personne de contact.
                'preferredGivenName' => "John", # Facultatif, permet de préciser le prénom de la personne de contact.
                'familyName' => "Doe", # Facultatif, permet de préciser le nom de famille de la personne de contact.
                'affix' => "Mx", # Facultatif, permet de préciser la salutation de la personne de contact.
            ],
            'applicationMethod' => [
                'internetEmailAddress' => company@web.be, # Adresse email pour candidatures de la société 
                'internetWebAddress' => "https://company.be/jobs", # Site web public de la société où la postulation est possible
                'postalAddress' => [
                    'countryCode' => 'BE', # Le code pays
                    'postalCode' => '5100', # Code postal
                    'municipality' => "Jambes", # Commune
                    'deliveryAddress' => [
                        "addressLine" => "Avenue Prince de Liège, 137", # Facultatif, si appliqué, remplace le contenu des autres balises adresses
                        "streetName" => "Avenue Prince de Liège", # Facultatif, préciser le nom de la rue de l’adresse
                        "buildingNumber" => "137", # Facultatif, permet de préciser le numéro de l’adresse
                        "unit" => "Bloc A", # Facultatif, permet de préciser le nom de l’immeuble de l’adresse
                        "postOfficeBox" => "", # Facultatif, permet de préciser la boîte postale de l’adresse.
                    ],
                ],
                
                # permet de préciser des informations complémentaires concernant l’entrevue que devra réaliser
                # le demandeur d’emploi pour l’offre d’emploi (lieux, moyen de locomotions disponibles, ...)
                'inPerson' => [ 
                    # Facultatif, permet de préciser les instructions sur l’endroit où le demandeur d’emploi devra se rendre
                    # pour une entrevue. Fournit des instructions sur le site, inclus les directions par bus, avion, voiture, marche,
                    'travelDirections' => "",
                    
                    # Facultatif, permet de préciser l’adresse où aura lieu l’entrevue du demandeur d’emploi
                    'additionalInstructions' => "",
                ],
            ],
            # Facultatif, permet de préciser les informations supplémentaires pour le demandeur d’emploi sur les
            # modalités de contact
            'userArea' => [
                # permet de préciser des commentaires sur la section « HowToApply ». Cette balise sera
                # principalement utilisée en conjonction avec l'adresse de la balise « PostalAddress ».
                'comments' => "",
                
                # permet de préciser des informations supplémentaires demandé par l’employeur concernant la
                # méthode de contact entre le demandeur et l’employeur (ex : une lettre de motivation, un cv,...).
                'contentPostedInformation' => "",
            ],
        ],
        
        # Facultatif, permet de préciser les informations supplémentaires pour le demandeur d’emploi sur les
        # modalités de contact
        'userArea' => [
            
            'selectionProcedure' => 'CV, entretiens, etc.', # Facultatif, permet de décrire la procédure de sélection.
            # Facultatif, permet de spécifier les modes de publication de l’offre.
            'publicationSubsets' => [
                [
                    'name'=> 'Presse locale',
                    'value' => false,
                ],
                [
                    'name' => 'Site web',
                    'value' => true,
                ]
            ],
            # Facultatif, permet de déterminer la région du lieu de travail concernant les offres pour lesquelles une
            # gestion active est demandée
            'activeMediation' => ['region' => 'C'],
            
            # Facultatif, permet de préciser des commentaires sur la section « PositionProfile ».
            'comments' => "Ce poste est fait pour vous !"
        ]
    ],
    
    # Facultatif, permet de préciser le nombre de postes qu’il reste à pourvoir pour l’offre d’emploi. 
    'userArea' => [
        'totalNumberOfJobs' => 5,
    ]

];

```