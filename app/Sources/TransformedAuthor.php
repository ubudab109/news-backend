<?php

namespace App\Sources;

use App\Models\Author;
use App\Models\Source;

class TransformedAuthor
{
    public $externalId;
    public $name;
    public $email;

    /**
     * Transformed Author Constructor
     * @param string|null $externalId - main identifier from external source
     * @param string $name
     * @param string|null $email
     */
    public function __construct($externalId, $name, $email)
    {
        $this->externalId = $externalId;
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Transform the author data from external source then save to database
     * 
     * @param Source $source
     * @throws \Exception
     * @return Author
     */
    public function createOrUpdateAuthor(Source $source)
    {
        $data = [
            'source_id'   => $source->id,
        ];

        if (!is_null($this->externalId)) {
            $data['external_id'] = $this->externalId;
        }

        if (!is_null($this->email)) {
            $data['email'] = $this->email;
        }
        
        $savedAuthor = $source->authors()->updateOrCreate($data, array_merge($data, ['name' => $this->name]));
        if (is_bool($savedAuthor)) {
            if (!$savedAuthor) {
                throw new \Exception('Failed to create or update authors data');
            }
            $author = $source->authors()->where($data);
        } else {
            $author = $savedAuthor;
        }

        return $author;
    }
}