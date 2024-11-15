## Utilisation
Créer une nouvelle offre sur le forem avec
`new ForemPositionOpening($options)`

$options doit être un dictionnaire contenant toutes les informations nécessaires à l'envoi de l'offre :
```
$options = [
    'partnerCode' => 'code_partenaire', # Code unique de partenaire reçu du Forem
    'idOffre' => 'id_offre', # Cet ID doit être unique au sein de l'entité partenaire
    'validFrom' => '2023-09-15', # date de début de la validité de l'offre
    'validTo' => '2024-01-15', # date de fin de validité
    'entityName' => "Nom de société",
    'telephone' => [
        'internationalCountryCode' => '32', # Optionnel, code international
        'areaCityCode' => '1', # Optionnel, de 0 à 9
        'formattedNumber' => '+32 056 06513' # Optionnel, numéro formatté
        'subscriberNumber' => '046510561', # Obligatoire, Uniquement des numéros
    ]
]
```