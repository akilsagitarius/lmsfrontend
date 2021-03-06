<?php

namespace App\Repositories;

use App\Models\FlashcardSubject;
use App\Repositories\BaseRepository;

/**
 * Class FlashcardSubjectRepository
 * @package App\Repositories
 * @version June 21, 2021, 6:09 am UTC
*/

class FlashcardSubjectRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'subject',
        'files',
        'subject_type',
        'reference',
        'external_link'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FlashcardSubject::class;
    }
}
