<?php

namespace Mdpbriar\ForemApiPhpClient\Models;

use Symfony\Component\Translation\Exception\NotFoundResourceException;

class BaseModel
{
    /**
     * Le nom du fichier des nomenclatures
     *
     * @var string
     */
    protected static string $file = 'file';
    protected static string $directory = 'Nomenclatures';


    public function __construct(
        public int|string $id,
        public string $description
    ){}

    /**
     * @priority low
     *
     */
    public static function getJson(): array
    {
        $path = dirname(__DIR__). DIRECTORY_SEPARATOR. static::$directory. DIRECTORY_SEPARATOR . static::$file;
//        dd($path);
        $file_content = file_get_contents($path);
        return json_decode($file_content, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Retourne la version associée au modèle, définit dans le json associé
     *
     * @priority high
     * @return string|null*
     */
    public static function getVersion(): ?string
    {
        $json = static::getJson();
        return $json['version'] ?? null;
    }

    /**
     * Retourne la description associée au modèle, définit dans le json associé
     *
     * @priority high
     * @return string|null*
     */
    public static function getFieldDescription(): ?string
    {
        $json = static::getJson();
        if (!isset($json['taxonomy'])){
            return null;
        }
        return $json['taxonomy']['description'] ?? null;
    }

    /**
     *
     * Retourne toutes les valeurs possibles sous forme d'array
     *
     * @return array
     * @throws \JsonException
     */
    public static function getValues(): array
    {
        return self::getJson()['values'];
    }

    /**
     *
     * Retourne toutes les valeurs possibles sous forme d'array d'instances de la classe
     *
     * @return array
     * @throws \JsonException
     */
    public static function getAll(): array
    {
        return array_map(function($item){
            return new static($item['id'], $item['description']);
        }, self::getValues());
    }

    /**
     * Retourne tous les éléments de la nomenclature sour forme d'array [ id => description ]
     *
     * @priority high
     * @return array
     */
    public static function getOptions(?array $ids = null): array
    {
        $values = static::getValues();
        if ($ids){
            $values = array_filter($values, fn($value) => in_array($value['id'], $ids, false));
        }
        return array_column($values, 'description', 'id');
    }

    /**
     * Retourne un array contenant les valeurs associées à l'id en paramètre
     *
     * @param int $id
     * @return array
     * @throws \JsonException
     */
    public static function filterValuesFromId(string|int $id): array
    {
        $values = self::getValues();
        return array_filter($values, function($value) use ($id){
            return $value['id'] === $id;
        });
    }

    /**
     * Retourne un array contenant les valeurs associées aux ids en paramètre
     *
     * @param array $ids
     * @return array
     * @throws \JsonException
     */
    public static function filterValuesInIds(array $ids): array
    {
        $values = self::getValues();
        return array_filter($values, function($value) use ($ids){
            return in_array((int)$value['id'], $ids, true);
        });
    }

    /**
     * Retourne un array ne contenant pas les valeurs associées aux ids en paramètre
     *
     * @param array $ids
     * @return array
     * @throws \JsonException
     */
    public static function filterValuesNotInIds(array $ids): array
    {
        $values = self::getValues();
        return array_filter($values, function($value) use ($ids){
            return !in_array((int)$value['id'], $ids, true);
        });
    }


    /**
     *
     * Retourne true si l'id est bien dans la liste des nomenclatures
     *
     * @priority high
     * @param int $id
     * @return bool
     * @throws \JsonException
     */
    public static function isValidId(string|int $id): bool
    {
        return !empty(static::filterValuesFromId($id));
    }

    /**
     *
     * Retourne une instance de la classe selon l'id
     *
     * @param int $id
     * @return static
     * @throws \JsonException
     */
    public static function getFromId(string|int $id): static
    {
        $result = static::filterValuesFromId($id);
        if (empty($result)){
            throw new NotFoundResourceException("The id {$id} does not exists in ". static::$file);
        }
        $unique = array_slice($result, 0, 1)[0];
        return new static($unique['id'], $unique['description']);
    }

}